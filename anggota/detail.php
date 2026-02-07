<?php
require '../middleware/auth.php';
require '../config.php';

$username = $_GET['username'];

$sql = "SELECT u.nama, u.username, a.nis, a.kelas, a.alamat, a.no_telp
        FROM users u JOIN anggota a ON u.id = a.user_id
        WHERE u.username = '$username'";
$query = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($query);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Anggota</title>

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
            <h5 class="mb-0">Detail Anggota</h5>
            <a href="../anggota.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <div class="row">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= $data['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><?= $data['username'] ?></td>
                        </tr>
                        <tr>
                            <td>NIS</td>
                            <td>:</td>
                            <td><?= $data['nis'] ?></td>
                        </tr>
                        <tr>
                            <td>Kelas</td>
                            <td>:</td>
                            <td><?= $data['kelas'] ?></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td><?= $data['alamat'] ?></td>
                        </tr>
                        <tr>
                            <td>No. Telp</td>
                            <td>:</td>
                            <td><?= $data['no_telp'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </main>
    </div>

    <script src="../js/main.js"></script>
    <script src="../js/bootstrap.bundle.min.js"></script>
  </body>
</html>