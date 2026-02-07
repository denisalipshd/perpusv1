<?php
require '../middleware/auth.php';
require '../config.php';

if(session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'];
$id = $user['id'];

$sql = "SELECT nis, kelas, alamat, no_telp FROM anggota WHERE user_id = '$id'";
$anggota = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if(isset($_POST['simpan'])) {
    $user_id = $user['id'];
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $nis = htmlspecialchars($_POST['nis']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_telp = htmlspecialchars($_POST['no_telp']);
    $pass_lama = $_POST['pass_lama'];
    $pass_baru = $_POST['pass_baru'];

    $sql_a = "UPDATE anggota SET
            nis = '$nis',
            kelas = '$kelas',
            alamat = '$alamat',
            no_telp = '$no_telp'
            WHERE user_id = '$user_id'";
    mysqli_query($conn, $sql_a);

    $sql_u = "UPDATE users SET
            nama = '$nama',
            username = '$username'
            WHERE id = '$user_id'";
    mysqli_query($conn, $sql_u);

    if(!empty($pass_lama) && !empty($pass_baru)) {
        $q_pass = mysqli_query($conn, "SELECT password FROM users WHERE id = '$user_id'");
        $data_pass = mysqli_fetch_assoc($q_pass);

        if(password_verify($pass_lama, $data_pass['password'])) {
            $hash_baru = password_hash($pass_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password = '$hash_baru' WHERE id = '$user_id'");
            echo "<script>alert('Profil dan Password berhasil diperbarui!');</script>";
        } else {
            echo "<script>alert('Password lama salah! Data profil tetap disimpan, tapi password gagal diubah.');</script>";
        }
    } else {
        echo "<script>alert('Profil berhasil diperbarui!');</script>";
    }

    $_SESSION['user']['nama'] = $nama;
    $_SESSION['user']['username'] = $username;

    echo "<script>window.location.href = '../profile.php';</script>";
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Edit Profile</title>

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
            <h5 class="mb-0">Edit Profile</h5>
            <a href="../profile.php" class="btn btn-primary"><i class="bi bi-arrow-left"></i> Kembali</a>
          </div>

          <form action="" method="POST">
            <div class="mb-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama" value="<?= $user['nama'] ?>" required/>
            </div>
            <div class="mb-3">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" name="username" id="username" value="<?= $user['username'] ?>" required/>
            </div>
            <div class="mb-3">
              <label for="nis" class="form-label">NIS</label>
              <input type="text" class="form-control" name="nis" id="nis" required value="<?= $anggota['nis'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="kelas" class="form-label">Kelas</label>
              <input type="text" class="form-control" name="kelas" id="kelas" required value="<?= $anggota['kelas'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="alamat" class="form-label">alamat</label>
              <input type="text" class="form-control" name="alamat" id="alamat" required value="<?= $anggota['alamat'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="no_telp" class="form-label">No. telp</label>
              <input type="text" class="form-control" name="no_telp" id="no_telp" required value="<?= $anggota['no_telp'] ?>"/>
            </div>
            <div class="mb-3">
              <label for="passwordLama" class="form-label">Password Lama (optional)</label>
              <input type="password" class="form-control" name="pass_lama" id="passwordLama" />
            </div>
            <div class="mb-3">
              <label for="passwordBaru" class="form-label">Password Baru (optional)</label>
              <input type="password" class="form-control" name="pass_baru" id="passwordBaru" />
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