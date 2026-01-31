<?php
session_start();

if (!isset($_SESSION['user'])) {
    echo '<script>alert("Silahkan Login Terlebih Dahulu"); window.location.href = "login.php"</script>';
    exit;
}