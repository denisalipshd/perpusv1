<?php 
require 'middleware/auth.php';
require 'config.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$q_anggota = mysqli_query($conn, "SELECT id, nis, kelas, alamat, no_telp FROM anggota WHERE user_id = '$user_id'");
$anggota = mysqli_fetch_assoc($q_anggota);

$anggota_id = $anggota['id'];

$sql_dp = "SELECT p.id, p.tgl_pinjam, p.tgl_kembali, p.status, b.judul, b.cover
        FROM detail_peminjaman AS dp
        JOIN peminjaman AS p ON dp.peminjaman_id = p.id
        JOIN buku AS b ON dp.buku_id = b.id
        WHERE p.anggota_id = '$anggota_id' 
        AND p.status = 'dipinjam'
        ORDER BY p.tgl_pinjam DESC";

$dp = mysqli_query($conn, $sql_dp);


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
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(mysqli_num_rows($dp) > 0) : ?>
                                    <?php while($row = mysqli_fetch_assoc($dp)) : ?>
                                    <tr class="align-middle">
                                        <td>
                                            <img src="utils/uploads/buku/<?= $row['cover'] ?>" width="60" class="rounded">
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
                                        <td>
                                            <a href="peminjaman/kembalikan.php?id=<?= $row['id'] ?>" onclick="return confirm('Kembalikan buku?')" class="btn btn-primary">Kembalikan</a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-4 text-muted">Anda belum pernah meminjam buku.</td>
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

    <script src="js/main.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
