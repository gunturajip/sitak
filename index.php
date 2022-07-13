<?php

include('kon.php');

session_start();

if (isset($_SESSION['username']) && $_SESSION['level_otorisasi'] == 1) {
    header("Location: admin.php");
} else if (isset($_SESSION['username']) && $_SESSION['level_otorisasi'] == 2) {
    header("Location: customer.php");
}

if (isset($_POST['submit'])) {
    $user_id = $_POST['user_id'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE id=$user_id AND password='$password'";
    $result = mysqli_query($kon, $sql);
    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['alamat'] = $row['alamat'];
        $_SESSION['id_paypal'] = $row['id_paypal'];
        $_SESSION['nama_bank'] = $row['nama_bank'];
        $_SESSION['level_otorisasi'] = $row['level_otorisasi'];
        $_SESSION['waktu_login_terakhir'] = time();
        if ($_SESSION['level_otorisasi'] == 1) {
            header("Location: admin.php");
        } else {
            header("Location: customer.php");
        }
    } else {
        echo "<script>alert('Username atau password Anda salah. Silahkan coba lagi!')</script>";
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

    <title>SITAK | LOGIN</title>
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
    <h4 class="text-center" style="margin: 32px 0;">SELAMAT DATANG DI TOKO ALAT KESEHATAN SITAK</h4>
    <div class="container" style="width: 320px;">
        <form action="" method="POST">
            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="number" class="form-control" id="user_id" name="user_id" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button name="submit" class="btn btn-primary">Submit</button>
            <a href="./register.php" class="text-center" style="margin: 32px 0;">Sign Up</a>
        </form>
    </div>
</body>

</html>