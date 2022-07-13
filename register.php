<?php

include('kon.php');

session_start();

if (isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $cpassword = md5($_POST['cpassword']);
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $tempat_tinggal = $_POST['tempat_tinggal'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_telp = $_POST['no_telp'];
    $nama_bank = $_POST['nama_bank'];
    $id_paypal = $_POST['id_paypal'];
    $level_otorisasi = 2;

    // echo "<script>console.log(" . $username . $email . $password . $cpassword . $tanggal_lahir . $tempat_tinggal . $alamat . $jenis_kelamin . $no_telp . $nama_bank . $id_paypal . ")</script>";

    if ($password == $cpassword) {
        $sql = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($kon, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO users (username, email, password, tanggal_lahir, tempat_tinggal, alamat, jenis_kelamin, no_telp, nama_bank, id_paypal, level_otorisasi)
                    VALUES ('$username', '$email', '$password', '$tanggal_lahir', '$tempat_tinggal', '$alamat', '$jenis_kelamin', '$no_telp', '$nama_bank', '$id_paypal', $level_otorisasi)";
            $result = mysqli_query($kon, $sql);
            if ($result) {
                echo "<script>alert('Selamat, registrasi berhasil!')</script>";
                $username = "";
                $email = "";
                $password = "";
                $cpassword = "";
                $tanggal_lahir = "";
                $tempat_tinggal = "";
                $alamat = "";
                $jenis_kelamin = "";
                $no_telp = "";
                $nama_bank = "";
                $id_paypal = "";
                header("Location: index.php");
            } else {
                echo "<script>alert('" . mysqli_error($kon) . "')</script>";
            }
        } else {
            echo "<script>alert('Woops! Username Sudah Terdaftar.')</script>";
        }
    } else {
        echo "<script>alert('Password Tidak Sesuai')</script>";
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- {{-- Bootstrap Icons --}} -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="style.css">

    <title>SITAK | REGISTER</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <div class="container">
            <a class="navbar-brand" href="./index.php">SITAK</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./katalog.php">Katalog Produk</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="./index.php" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h4 class="text-center" style="margin: 32px 0;">FORM REGISTRASI</h4>
    <div class="container" style="width: 320px;">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Re-type Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
            </div>
            <div class="mb-3">
                <label for="tempat_tinggal" class="form-label">Tempat Tinggal</label>
                <input type="text" class="form-control" id="tempat_tinggal" name="tempat_tinggal" required>
            </div>
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <div>
                    <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-Laki" required> Laki-Laki
                    <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required> Perempuan
                </div>
            </div>
            <div class="mb-3">
                <label for="no_telp" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <div class="mb-3">
                <label for="nama_bank" class="form-label">Nama Bank</label>
                <input type="text" class="form-control" id="nama_bank" name="nama_bank" required>
            </div>
            <div class="mb-3">
                <label for="id_paypal" class="form-label">ID Paypal</label>
                <input type="text" class="form-control" id="id_paypal" name="id_paypal" required>
            </div>
            <div class="mb-4">
                <button name="submit" class="btn btn-primary">Submit</button>
                <a href="./register.php" class="text-center" style="margin: 32px 0;">Sign Up</a>
            </div>
        </form>
    </div>
</body>

</html>