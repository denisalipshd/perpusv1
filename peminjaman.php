<?php
require 'config.php';
require 'middleware/auth.php';

$sql = "SELECT a.nis, a.kelas, a.alamat, a.no_telp, u.nama, u.username FROM anggota AS a
        JOIN users AS u ON a.user_id = u.id";
$result = mysqli_query($conn, $sql);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Peminjaman</title>

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
            <h5 class="mb-0">Daftar Peminjaman</h5>
            <!-- <a href="peminjaman/tambah.php" class="btn btn-primary"> <i class="bi bi-plus-circle"></i> Tambah Peminjaman </a> -->
          </div>

          <table class="table table-striped">
            <thead>
              <tr class="text-center">
                <th scope="col">#</th>
                <th scope="col">Nama</th>
                <th scope="col">NIS</th>
                <th scope="col">Kelas</th>
                <!-- <th scope="col">Alamat</th> -->
                <th scope="col">No. Telp</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php while($data = mysqli_fetch_assoc($result)): ?>
              <tr class="align-middle text-center">
                <th scope="row"><?= $no++ ?></th>
                <td><?= $data['nama'] ?></td>
                <td><?= $data['nis'] ?></td>
                <td><?= $data['kelas'] ?></td>
                <!-- <td><?= $data['alamat'] ?></td> -->
                <td><?= $data['no_telp'] ?></td>
                <td>
                  <a href="peminjaman/detail.php?username=<?= $data['username'] ?>" class="btn btn-sm btn-warning"><i class="bi bi-eye"></i></a>
                  <!-- <a href="peminjaman/hapus.php?username=<?= $data['username'] ?>" onclick="return confirm('Yakin hapus peminjaman ini?')" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a> -->
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
