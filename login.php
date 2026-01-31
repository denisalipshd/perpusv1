<?php
require 'config.php';
require 'middleware/guest.php';

if(isset($_POST['login'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  $sql = "SELECT id, nama, username, password, role FROM users WHERE username = '$username'";
  $query = mysqli_query($conn, $sql);
  
  if(mysqli_num_rows($query) > 0) {
    $user = mysqli_fetch_assoc($query);
      if(password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user'] = $user;
        echo '<script>alert("Login Berhasil"); window.location.href = "index.php"</script>';
      } else {
        echo '<script>alert("Password Salah"); window.location.href = "login.php"</script>';
      }
  } else {
      echo '<script>alert("Username Salah"); window.location.href = "login.php"</script>';
  }
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
  </head>
  <body>
    <div class="container">
      <div class="row justify-content-center mt-5">
        <div class="col-md-6">
          <h2 class="text-center">Login</h2>
          <form action="" method="POST">
            <div class="mb-3">
              <label for="username" class="mb-1">Username</label>
              <input type="text" name="username" id="username" class="form-control" required/>
            </div>

            <div class="mb-3">
              <label for="password" class="mb-1">Password</label>
              <input type="password" name="password" id="password" class="form-control" required/>
            </div>

            <button class="btn btn-primary w-100" name="login">Login</button>
            <p class="text-center mt-3">Belum punya akun? <a href="register.php">Register</a></p>
          </form>
        </div>
      </div>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
  </body>
</html>
