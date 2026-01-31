<?php
require '../config.php';
require '../middleware/auth.php';

if(isset($_POST['simpan'])) {
  $nama_kategori = $_POST['nama_kategori'];
  $slug = strtolower(str_replace(' ', '-', $nama_kategori));

  $sql = "INSERT INTO kategori (nama_kategori, slug) VALUES ('$nama_kategori', '$slug')";
  $query = mysqli_query($conn, $sql);

  if($query) {
    echo '<script>alert("Kategori berhasil ditambahkan"); window.location.href = "../kategori.php";</script>';
    exit();
  } else {
    echo '<script>alert("Gagal menambahkan kategori");</script>';
    exit();
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tambah Kategori</title>

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
            <h5 class="mb-0">Tambah Kategori</h5>
            <a href="../kategori.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <form action="" method="POST">
            <div class="mb-3">
              <label for="namaKategori" class="form-label">Nama Kategori</label>
              <input type="text" class="form-control" name="nama_kategori" id="namaKategori" placeholder="Masukkan nama kategori" />
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