<?php
$kon = mysqli_connect('localhost', 'root', '', 'jwp_sitak');
if (!$kon) {
    die('<script>alert("Gagal terhubung dengan database: ' . mysqli_connect_error() . '")</script>');
}
