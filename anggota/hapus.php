<?php
require '../middleware/auth.php';
require '../config.php';

$username = $_GET['username'];

$query = mysqli_query($conn, "DELETE FROM users WHERE username = '$username'");

if($query) {
    echo "<script>alert('Anggota berhasil dihapus'); window.location.href = '../anggota.php';</script>";
} else {
    echo "<script>alert('Anggota gagal dihapus'); window.location.href = '../anggota.php';</script>";
}