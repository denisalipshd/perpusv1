<?php
require '../middleware/auth.php';
require '../config.php';

$id = $_GET['id'];

$sql = "UPDATE peminjaman SET 
        status = 'dikembalikan'
        WHERE id = '$id'";
$query = mysqli_query($conn, $sql);

if($query) {
    echo "<script>alert('Buku berhasil dikembalikan'); window.location.href = '../profile.php';</script>";
} else {
    echo "<script>alert('Buku gagal dikembalikan'); window.location.href = '../profile.php';</script>";
}

