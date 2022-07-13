<?php

include('kon.php');

session_start();

if (!(isset($_SESSION['username']) && $_SESSION['level_otorisasi'] == 2)) {
    header("Location: index.php");
} else {
    if (time() - $_SESSION['waktu_login_terakhir'] > 60) {
        header('Location: logout.php');
    } else {
        $_SESSION['waktu_login_terakhir'] = time();
    }
}

$id = $_GET['id'];

$sql = "DELETE FROM orders WHERE id=$id";

mysqli_query($kon, $sql);

echo "<script>alert('Selamat, hapus pesanan berhasil!')</script>";
header('Location: checkout.php');
