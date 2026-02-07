<?php
require '../middleware/auth.php';
require '../config.php';

$username = $_GET['username'];

$sql_a = "SELECT a.id, a.nis, a.kelas, a.alamat, a.no_telp, u.nama, u.username FROM anggota AS a
        JOIN users AS u ON a.user_id = u.id
        WHERE username = '$username'
        ";
$anggota = mysqli_fetch_assoc(mysqli_query($conn, $sql_a));

$anggota_id = $anggota['id'];

$sql_dp = "SELECT p.tgl_pinjam, p.tgl_kembali, p.status, b.judul, b.cover
        FROM detail_peminjaman AS dp
        JOIN peminjaman AS p ON dp.peminjaman_id = p.id
        JOIN buku AS b ON dp.buku_id = b.id
        WHERE p.anggota_id = '$anggota_id'
        ORDER BY p.tgl_pinjam DESC";

$dp = mysqli_query($conn, $sql_dp);

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Detail Peminjaman</title>

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
            <h5 class="mb-0">Detail Peminjaman</h5>
            <a href="../peminjaman.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <div class="row">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td><?= $anggota['nama'] ?></td>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td>:</td>
                            <td><?= $anggota['username'] ?></td>
                        </tr>
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
                            <td>No. Telp</td>
                            <td>:</td>
                            <td><?= $anggota['no_telp'] ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <h5 class="mt-4 mb-3">Daftar Buku yang Dipinjam</h5>
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cover</th>
                                <th>Judul Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Tgl Kembali</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($dp) > 0) : ?>
                                <?php while($row = mysqli_fetch_assoc($dp)) : ?>
                                <tr class="align-middle">
                                    <td>
                                        <img src="../utils/uploads/buku/<?= $row['cover'] ?>" width="60" class="rounded">
                                    </td>
                                    <td><strong><?= $row['judul'] ?></strong></td>
                                    <td><?= date('d M Y', strtotime($row['tgl_pinjam'])) ?></td>
                                    <td><?= date('d M Y', strtotime($row['tgl_kembali'])) ?></td>
                                    <td>
                                        <?php if($row['status'] == 'dipinjam') : ?>
                                            <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                        <?php else : ?>
                                            <span class="badge bg-success">Sudah Kembali</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Anggota ini belum pernah meminjam buku.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
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