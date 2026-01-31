<?php
require '../config.php';
require '../middleware/auth.php';

$slug = $_GET['slug'];
$query = mysqli_query($conn, "DELETE FROM kategori WHERE slug = '$slug'");

if($query) {
    echo "<script>alert('Kategori berhasil dihapus'); window.location.href = '../kategori.php';</script>";
} else {
    echo "<script>alert('Kategori gagal dihapus'); window.location.href = '../kategori.php';</script>";
}
