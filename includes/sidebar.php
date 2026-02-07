<?php
if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$user = $_SESSION['user'];
?>

<aside class="sidebar p-3 d-none d-md-block">
  <h4 class="text-center text-white mb-4"><i class="bi bi-book-fill"></i> Perpustakaan</h4>
  <ul class="nav flex-column gap-2">
    <li><a class="nav-link active" href="index.php">Dashboard</a></li>

    <?php if($user['role'] === "admin") :?>
      <li><a class="nav-link" href="buku.php">Data Buku</a></li>
      <li><a class="nav-link" href="kategori.php">Data Kategori</a></li>
      <li><a class="nav-link" href="anggota.php">Anggota</a></li>
      <li><a class="nav-link" href="peminjaman.php">Peminjaman</a></li>
    <?php endif; ?>

    <?php if($user['role'] === "anggota") :?>
      <li><a class="nav-link" href="buku.php">Daftar Buku</a></li>
    <?php endif; ?>
    
    <li class="mt-3"><a class="nav-link" href="logout.php">Logout</a></li>
  </ul>
</aside>
