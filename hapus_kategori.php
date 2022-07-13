<?php

include('kon.php');

session_start();

if (!(isset($_SESSION['username']) && $_SESSION['level_otorisasi'] == 1)) {
    header("Location: index.php");
} else {
    if (time() - $_SESSION['waktu_login_terakhir'] > 60) {
        header('Location: logout.php');
    } else {
        $_SESSION['waktu_login_terakhir'] = time();
    }
}

$id = $_GET['id'];

$sql = "DELETE FROM categories WHERE id=$id";

mysqli_query($kon, $sql);

echo "<script>alert('Selamat, hapus kategori berhasil!')</script>";
header('Location: admin.php');
