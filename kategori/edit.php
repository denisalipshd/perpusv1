<?php
require '../config.php';
require '../middleware/auth.php';

$slug = $_GET['slug'];

$result = mysqli_query($conn, "SELECT nama_kategori FROM kategori WHERE slug='$slug'");
$data = mysqli_fetch_assoc($result);

if(isset($_POST['simpan'])) {
  $nama_kategori = $_POST['nama_kategori'];
  $slug_baru = strtolower(str_replace(' ', '-', $nama_kategori));

  $sql = "UPDATE kategori SET nama_kategori='$nama_kategori', slug='$slug_baru' WHERE slug='$slug'";
  $query = mysqli_query($conn, $sql);

  if($query) {
    echo '<script>alert("Kategori berhasil diubah"); window.location.href = "../kategori.php";</script>';
    exit();
  } else {
    echo '<script>alert("Gagal mengubah kategori"); window.location.href = "edit.php";</script>';
    exit();
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Kategori</title>

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
            <h5 class="mb-0">Edit Kategori</h5>
            <a href="../kategori.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <form action="" method="POST">
            <div class="mb-3">
              <label for="namaKategori" class="form-label">Nama Kategori</label>
              <input type="text" class="form-control" name="nama_kategori" id="namaKategori" value="<?= $data['nama_kategori'] ?>" />
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