<?php
require 'config.php';
require 'middleware/auth.php';

$sql = "SELECT buku.judul, buku.slug, buku.cover, buku.penulis, buku.penerbit, buku.tahun_terbit, buku.stok, kategori.nama_kategori FROM buku
        JOIN kategori ON buku.kategori_id = kategori.id";
$result = mysqli_query($conn, $sql);

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
            <a href="buku/tambah.php" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Tambah Buku </a>
          </div>

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
        </div>
      </main>
    </div>

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
