<?php
require '../config.php';
require '../middleware/auth.php';

$slug = $_GET['slug'];

$result = mysqli_query($conn, "SELECT judul, slug, kategori_id, penulis, penerbit, tahun_terbit, stok, cover FROM buku WHERE slug = '$slug'");
$buku = mysqli_fetch_assoc($result);


if (!$buku) {
  echo "<script>alert('Data buku tidak ditemukan'); window.location.href='../buku.php';</script>";
  exit;
}

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

  if($filename != '') {
    if(!in_array($ext, $ekstensi)) {
      echo '<script>alert("Ekstensi file tidak diizinkan"); window.location.href = "edit.php";</script>';
      exit();
    }

    if($buku['cover'] != '' && file_exists('../utils/uploads/buku/'.$buku['cover'])) {
      unlink('../utils/uploads/buku/'.$buku['cover']);
    }

    if($ukuran < 1044070) {
      $cover = $rand.'_'.$filename;
      move_uploaded_file($_FILES['cover']['tmp_name'], '../utils/uploads/buku/'.$cover);

      // update to database
      $sql = "UPDATE buku SET
              judul = '$judul',
              kategori_id = '$kategori_id',
              penulis = '$penulis',
              penerbit = '$penerbit',
              tahun_terbit = '$tahun_terbit',
              stok = '$stok',
              cover = '$cover'  
              WHERE slug = '$slug'
              ";
      $query = mysqli_query($conn, $sql);

      echo '<script>alert("Buku berhasil diedit"); window.location.href = "../buku.php";</script>';
      exit();
    } else {
      echo '<script>alert("Ukuran file terlalu besar"); window.location.href = "edit.php";</script>';
      exit();
    }
  } else {
    $sql = "UPDATE buku SET
              judul = '$judul',
              kategori_id = '$kategori_id',
              penulis = '$penulis',
              penerbit = '$penerbit',
              tahun_terbit = '$tahun_terbit',
              stok = '$stok'
              WHERE slug = '$slug'
              ";
      $query = mysqli_query($conn, $sql);

      echo '<script>alert("Buku berhasil diedit"); window.location.href = "../buku.php";</script>';
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Buku</title>

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
            <h5 class="mb-0">Edit Buku</h5>
            <a href="../buku.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="judulBuku" class="form-label">Judul Buku</label>
              <input type="text" class="form-control" name="judul" id="judulBuku" value="<?= $buku['judul'] ?>" />
            </div>
            <div class="mb-3">
              <label for="kategoriBuku" class="form-label">Kategori Buku</label>
              <select class="form-control" name="kategori_id" id="kategoriBuku">
                <option value="">Pilih Kategori</option>
                <?php while($data_kategori = mysqli_fetch_assoc($query_kategori)): 
                  $selected = $data_kategori['id'] == $buku['kategori_id'] ? 'selected' : "";
                ?>
                    <option value="<?= $data_kategori['id'] ?>" <?= $selected ?>><?= $data_kategori['nama_kategori'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="penulisBuku" class="form-label">Penulis</label>
              <input type="text" class="form-control" name="penulis" id="penulisBuku" value="<?= $buku['penulis'] ?>"/>    
            </div>
            <div class="mb-3">
              <label for="penerbitBuku" class="form-label">Penerbit</label>
              <input type="text" class="form-control" name="penerbit" id="penerbitBuku" value="<?= $buku['penerbit'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="tahunTerbit" class="form-label">Tahun Terbit</label>
              <input type="text" class="form-control" name="tahun_terbit" id="tahunTerbit" value="<?= $buku['tahun_terbit'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="stok" class="form-label">Stok</label>
              <input type="text" class="form-control" name="stok" id="stok" value="<?= $buku['stok'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="thumbnail" class="form-label">Cover</label>
              <input type="file" class="form-control" name="cover" id="thumbnail"  />
              <!-- <div class="prev-img-container">
                  <img src="../utils/uploads/buku/1784417739_doraemon.jpg" alt="">
              </div> -->
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