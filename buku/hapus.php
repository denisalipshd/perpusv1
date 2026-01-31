<?php
require '../config.php';
require '../middleware/auth.php';

$slug = $_GET['slug'];

$result = mysqli_query($conn, "SELECT cover FROM buku WHERE slug = '$slug'");
$buku = mysqli_fetch_assoc($result);

if($buku['cover'] != '' && file_exists('../utils/uploads/buku/'.$buku['cover'])) {
    unlink('../utils/uploads/buku/'.$buku['cover']);
}

$query = mysqli_query($conn, "DELETE FROM buku WHERE slug = '$slug'");

if($query) {
    echo "<script>alert('Buku berhasil dihapus'); window.location.href = '../buku.php';</script>";
} else {
    echo "<script>alert('Buku gagal dihapus'); window.location.href = '../buku.php';</script>";
}