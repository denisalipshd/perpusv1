<?php
if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

$user = $_SESSION['user'];
?>

<nav class="navbar bg-white shadow-sm px-4 d-flex justify-content-between flex-nowrap">
  <div class="d-flex align-items-center">
    <!-- Toggle Mobile -->
    <button class="btn btn-outline-primary d-md-none me-2"
      type="button"
      data-bs-toggle="offcanvas"
      data-bs-target="#offcanvasSidebar">
      <i class="bi bi-list"></i>
    </button>

    <span class="navbar-brand fw-semibold mb-0">PERBALI</span>
  </div>

   <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
            <span class="text-muted">
              <?= $user['role'] === 'admin' ? 'Admin' : 'Anggota'?>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
          </ul>
        </li>
    </ul>
</nav>


<!-- offcanvas -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header d-flex justify-content-between align-items-center">
    <h5 class="text-white"><i class="bi bi-book-fill"></i> Perpustakaan</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
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
  </div>
</div>
