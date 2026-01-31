<?php
require 'config.php';
require 'middleware/auth.php';

$sql = "SELECT nama_kategori, slug FROM kategori";
$result = mysqli_query($conn, $sql);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kategori</title>

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
            <h5 class="mb-0">Kategori Buku</h5>
            <a href="kategori/tambah.php" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Tambah Kategori </a>
          </div>

          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Kategori</th>
                <th scope="col">Slug</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php while($data = mysqli_fetch_assoc($result)): ?>
              <tr>
                <th scope="row"><?= $no++ ?></th>
                <td><?= $data['nama_kategori'] ?></td>
                <td><?= $data['slug'] ?></td>
                <td>
                  <a href="kategori/edit.php?slug=<?= $data['slug'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                  <a onclick="return confirm('Yakin hapus kategori?')" href="kategori/hapus.php?slug=<?= $data['slug'] ?>" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
