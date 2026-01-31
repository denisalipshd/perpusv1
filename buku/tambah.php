<?php
require '../config.php';
require '../middleware/auth.php';

$query_kategori = mysqli_query($conn, "SELECT id, nama_kategori FROM kategori");

if(isset($_POST['simpan'])) {
  $judul = $_POST['judul'];
  $slug = strtolower(str_replace(' ', '-', $judul));
  $kategori_id = $_POST['kategori_id'];
  $penulis = $_POST['penulis'];
  $penerbit = $_POST['penerbit'];
  $tahun_terbit = $_POST['tahun_terbit'];
  $stok = $_POST['stok'];

  //   Upload cover
  $rand = rand();
  $ekstensi = array('png','jpg','jpeg','gif');
  $filename = $_FILES['cover']['name'];
  $ukuran = $_FILES['cover']['size'];
  $ext = pathinfo($filename, PATHINFO_EXTENSION);

  if(!in_array($ext, $ekstensi)) {
    echo '<script>alert("Ekstensi file tidak diizinkan"); window.location.href = "edit.php";</script>';
    exit();
  }

  if($ukuran < 1044070) {
    $cover = $rand.'_'.$filename;
    move_uploaded_file($_FILES['cover']['tmp_name'], '../utils/uploads/buku/'.$cover);

    // insert to database
    $sql = "INSERT INTO buku (judul, slug, kategori_id, penulis, penerbit, tahun_terbit, stok, cover) VALUES ('$judul', '$slug', '$kategori_id', '$penulis', '$penerbit', '$tahun_terbit', '$stok', '$cover')";
    $query = mysqli_query($conn, $sql);

    echo '<script>alert("Buku berhasil ditambahkan"); window.location.href = "../buku.php";</script>';
    exit();
  } else {
    echo '<script>alert("Ukuran file terlalu besar"); window.location.href = "edit.php";</script>';
    exit();
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Buku</title>

    <link rel="stylesheet" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="../css/style.css" />
  </head>
  <body>
    <div class="d-flex">
      <!-- sidebar -->
      <?php include('../includes/sidebar.php')?>

      <!-- main content -->
      <main class="flex-fill">
        <!-- Navbar -->
        <?php include('../includes/navbar.php')?>

        <!-- content -->
        <div class="container-fluid p-4">
          <!-- header -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="mb-0">Tambah Buku</h5>
            <a href="../buku.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="judulBuku" class="form-label">Judul Buku</label>
              <input type="text" class="form-control" name="judul" id="judulBuku" placeholder="Masukkan judul buku" required/>
            </div>
            <div class="mb-3">
              <label for="kategoriBuku" class="form-label">Kategori Buku</label>
              <select class="form-control" name="kategori_id" id="kategoriBuku" required>
                <option value="">Pilih Kategori</option>
                <?php while($data_kategori = mysqli_fetch_assoc($query_kategori)): ?>
                    <option value="<?= $data_kategori['id'] ?>"><?= $data_kategori['nama_kategori'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="penulisBuku" class="form-label">Penulis</label>
              <input type="text" class="form-control" name="penulis" id="penulisBuku" placeholder="Masukkan penulis buku" required/>
            </div>
            <div class="mb-3">
              <label for="penerbitBuku" class="form-label">Penerbit</label>
              <input type="text" class="form-control" name="penerbit" id="penerbitBuku" placeholder="Masukkan penerbit buku" required/>
            </div>
            <div class="mb-3">
              <label for="tahunTerbit" class="form-label">Tahun Terbit</label>
              <input type="text" class="form-control" name="tahun_terbit" id="tahunTerbit" placeholder="Masukkan tahun terbit buku" required/>
            </div>
            <div class="mb-3">
              <label for="stok" class="form-label">Stok</label>
              <input type="text" class="form-control" name="stok" id="stok" placeholder="Masukkan stok buku" required/>
            </div>
            <div class="mb-3">
              <label for="thumbnail" class="form-label">Cover</label>
              <input type="file" class="form-control" name="cover" id="thumbnail" placeholder="Masukkan cover buku" required/>
            </div>
            <button type="submit" name="simpan" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
          </form>
        </div>
      </main>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
  </body>
</html>