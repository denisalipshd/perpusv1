<?php
require 'config.php';
require 'middleware/guest.php';

if (isset($_POST['register'])) {
  $nama = htmlspecialchars($_POST['nama']);
  $username = htmlspecialchars($_POST['username']);
  $password = password_hash(htmlspecialchars($_POST['password']), PASSWORD_DEFAULT);

  $sql = "INSERT INTO users (nama, username, password) VALUES ('$nama', '$username', '$password')";
  $query = mysqli_query($conn, $sql);

  if($query) {
    echo '<script>alert("Registrasi Berhasil"); window.location.href = "login.php"</script>';
  } else {
    echo '<script>alert("Registrasi Gagal") window.location.href = "register.php"</script>';
  }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-6">
          <h2 class="text-center">Register</h2>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="nama" class="mb-1">Nama</label>
              <input type="text" name="nama" id="nama" class="form-control" required/>
            </div>

            <div class="mb-3">
              <label for="username" class="mb-1">Username</label>
              <input type="text" name="username" id="username" class="form-control" required/>
            </div>

            <div class="mb-3">
              <label for="password" class="mb-1">Password</label>
              <input type="password" name="password" id="password" class="form-control" required/>
            </div>

            <button class="btn btn-primary w-100" name="register">Register</button>
            <p class="text-center mt-3">Sudah punya akun? <a href="login.php">Login</a></p>
          </form>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
