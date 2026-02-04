<?php 
require 'middleware/auth.php';
require 'config.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$q_anggota = mysqli_query($conn, "SELECT nis, kelas, alamat, no_telp FROM anggota WHERE user_id = '$user_id'");
$anggota = mysqli_fetch_assoc($q_anggota);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>

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
            <div class="row justify-content-center">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="mb-0"><?= $user['nama'] ?></h4>
                        <span><?= $user['username'] ?></span>
                        <div class="d-flex flex-column mt-3">
                            <table class="table table-border text-start">
                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td><?= $anggota['nis'] ?></td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td><?= $anggota['kelas'] ?></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td><?= $anggota['alamat'] ?></td>
                                </tr>
                                <tr>
                                    <td>Telp</td>
                                    <td>:</td>
                                    <td><?= $anggota['no_telp'] ?></td>
                                </tr>
                            </table>
                        </div>
                        <div>
                            <a href="profile/edit.php" class="btn btn-primary">Edit</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </main>
    </div>

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
