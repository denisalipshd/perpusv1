<?php 
require 'middleware/auth.php';

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
                        <h4 class="mb-0">Denis alip</h4>
                        <span>denisalipsahidi</span>
                        <div class="d-flex flex-column mt-3">
                            <table class="table table-border text-start">
                                <tr>
                                    <td>NIS</td>
                                    <td>:</td>
                                    <td>098237364</td>
                                </tr>
                                <tr>
                                    <td>Kelas</td>
                                    <td>:</td>
                                    <td>098237364</td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>:</td>
                                    <td>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nobis officia voluptatem incidunt ex placeat dolorem! Unde pariatur fugit doloribus doloremque.</td>
                                </tr>
                                <tr>
                                    <td>Telp</td>
                                    <td>:</td>
                                    <td>098237364</td>
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
