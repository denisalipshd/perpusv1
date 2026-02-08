<?php
require 'config.php';
require 'middleware/auth.php';

if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$user = $_SESSION['user'];

$sql = "SELECT buku.id, buku.judul, buku.slug, buku.cover, buku.stok, kategori.nama_kategori FROM buku
        JOIN kategori ON buku.kategori_id = kategori.id";
$result = mysqli_query($conn, $sql);

$user_id = $user['id'];
$isUserId = mysqli_query($conn, "SELECT user_id FROM anggota WHERE user_id = '$user_id'");

if(isset($_POST['simpan_data_diri'])) {
  // data diri
  $nis = htmlspecialchars($_POST['nis']);
  $kelas = htmlspecialchars($_POST['kelas']);
  $alamat = htmlspecialchars($_POST['alamat']);
  $no_telp = htmlspecialchars($_POST['no_telp']);

  $sql = "INSERT INTO anggota (user_id, nis, kelas, alamat, no_telp) VALUES ('$user_id', '$nis', '$kelas', '$alamat', '$no_telp')";
  $query = mysqli_query($conn, $sql);

  if($query) {
    echo "<script>alert('Formulir data diri berhasil diisi!')</script>";
  }
}

if(isset($_POST['simpan_data_pinjam'])) {
  $tgl_pinjam = $_POST['tgl_pinjam'];
  $tgl_kembali = $_POST['tgl_kembali'];
  $buku_id = $_POST['buku_id'];

  $anggota_q = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM anggota WHERE user_id = '$user_id'"));
  $anggota_id = $anggota_q['id'];
  
  $sql_p = "INSERT INTO peminjaman (anggota_id, tgl_pinjam, tgl_kembali) VALUES ('$anggota_id', '$tgl_pinjam', '$tgl_kembali')";
  $query = mysqli_query($conn, $sql_p);
  $peminjaman_id = mysqli_insert_id($conn);

  $sql_dp = "INSERT INTO detail_peminjaman (peminjaman_id, buku_id) VALUES ('$peminjaman_id', '$buku_id')";
  mysqli_query($conn, $sql_dp);

  $buku_q = mysqli_fetch_assoc(mysqli_query($conn, "SELECT stok FROM buku WHERE id = '$buku_id'"));
  $stok_sekarang = $buku_q['stok'];

  if($stok_sekarang > 0) {
    $stok_baru = $stok_sekarang - 1;
    mysqli_query($conn, "UPDATE buku SET stok = '$stok_baru' WHERE id = '$buku_id'");
  } else {
    echo "<script>alert('Maaf, stok buku habis!'); window.location='buku.php';</script>";
  }

  if($query) {
    echo "<script>alert('Buku berhasil dipinjam!')</script>";
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Buku</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="css/style.css" />
  </head>
  <body>
    <div class="d-flex">
      <!-- sidebar -->
      <?php include('includes/sidebar.php')?>

      <!-- main content -->
      <main class="flex-fill">
        <!-- Navbar -->
        <?php include('includes/navbar.php')?>

        <!-- content -->
        <div class="container-fluid p-4">
          <!-- header -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Daftar Buku</h5>
            <?php if($user['role'] === 'admin') : ?>
            <a href="buku/tambah.php" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Tambah Buku </a>
            <?php endif; ?>
          </div>

          <?php if($user['role'] === 'admin') : ?>
          <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Cover</th>
                <th scope="col">Judul Buku</th>
                <th scope="col">Kategori Buku</th>
                <th scope="col">Penulis</th>
                <th scope="col">Penerbit</th>
                <th scope="col">Tahun Terbit</th>
                <th scope="col">Stok</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php while($data = mysqli_fetch_assoc($result)): ?>
              <tr class="align-middle text-center">
                <th scope="row"><?= $no++ ?></th>
                <td><img src="utils/uploads/buku/<?= $data['cover'] ?>" width="100" height="100"></td>
                <td><?= $data['judul'] ?></td>
                <td><?= $data['nama_kategori'] ?></td>
                <td><?= $data['penulis'] ?></td>
                <td><?= $data['penerbit'] ?></td>
                <td><?= $data['tahun_terbit'] ?></td>
                <td><?= $data['stok'] ?></td>
                <td>
                  <a href="buku/edit.php?slug=<?= $data['slug'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                  <a href="buku/hapus.php?slug=<?= $data['slug'] ?>" onclick="return confirm('Yakin hapus buku ini?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
          <?php endif; ?>

          <?php if($user['role'] === 'anggota') : ?>
          <div class="row">
            <?php while($data = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4 mb-3">
              <div class="card h-100">
                <img src="utils/uploads/buku/<?= $data['cover'] ?>" class="card-img-top" alt="..." style="height: 280px; object-fit: cover;">
                <div class="card-body">
                  <h5 class="card-title"><?= $data['judul'] ?></h5>
                  <div class="d-flex align-items-center gap-3">
                    <span class="text-secondary">Stok : <?= $data['stok'] ?></span>
                    <span class="badge text-bg-primary"><?= $data['nama_kategori'] ?></span>
                  </div>
                  <?php if(mysqli_num_rows($isUserId) > 0) : ?>
                    <button type="button" class="btn btn-primary w-100 btn-pinjam mt-2" data-bs-toggle="modal" data-bs-target="#dataPinjam" data-id="<?= $data['id'] ?>">Pinjam</button>
                  <?php endif; ?>
                  <?php if(mysqli_num_rows($isUserId) === 0) : ?>
                    <button type="button" class="btn btn-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#dataDiri">Pinjam</button>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php endwhile; ?>
          </div>
          
          <!-- Modal Pinjam -->
          <div class="modal fade" id="dataPinjam" tabindex="-1" aria-labelledby="dataPinjamLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="dataPinjamLabel">Formulir Peminjaman</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p class="text-danger">Silahkan isi data peminjaman!</p>
                  <form action="" method="POST">
                    <input type="hidden" name="buku_id" id="modal_buku_id">
                    <div class="mb-3">
                      <label for="nis" class="form-label">Tgl Pinjam</label>
                      <input type="date" id="nis" name="tgl_pinjam" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="kelas" class="form-label">Tgl Kembali</label>
                      <input type="date" id="kelas" name="tgl_kembali" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" name="simpan_data_pinjam" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal data diri -->
          <div class="modal fade" id="dataDiri" tabindex="-1" aria-labelledby="dataDiriLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title fs-5" id="dataDiriLabel">Formulir Data Diri</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <p class="text-danger">Silahkan isi data diri terlebih dahulu!</p>
                  <form action="" method="POST">
                    <div class="mb-3">
                      <label for="nis" class="form-label">NIS</label>
                      <input type="text" id="nis" name="nis" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="kelas" class="form-label">Kelas</label>
                      <input type="text" id="kelas" name="kelas" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat</label>
                      <input type="text" id="alamat" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                      <label for="no_telp" class="form-label">No. Telp</label>
                      <input type="number" id="no_telp" name="no_telp" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                      <button type="submit" class="btn btn-primary" name="simpan_data_diri">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>
      </main>
    </div>

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
