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

$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE username='$username'";
$result = mysqli_query($kon, $sql);
$row = mysqli_fetch_assoc($result);

$id_pengguna = $row['id'];
$id_produk = $_GET['id'];
$nama = $_GET['nama'];
$harga = $_GET['harga'];

if (isset($_POST['beli_produk'])) {
    $jumlah = $_POST['jumlah'];

    $sql = "INSERT INTO orders (user_id, product_id, jumlah, harga) VALUES ($id_pengguna, $id_produk, $jumlah, $harga*$jumlah)";
    $result = mysqli_query($kon, $sql);

    if ($result) {
        echo "<script>alert('Selamat, beli produk berhasil!')</script>";
        header('Location: checkout.php');
    } else {
        echo "<script>alert('" . mysqli_error($kon) . "')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <!-- {{-- Bootstrap Icons --}} -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.3/font/bootstrap-icons.css">

    <link rel="stylesheet" type="text/css" href="style.css">
    <title>SITAK | BELI PRODUK</title>
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
                        <a class="nav-link" href="./index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./checkout.php">Checkout</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php echo "Selamat Datang, " . $_SESSION['username']; ?>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="./customer.php"><i class="bi bi-layout-text-sidebar-reverse"></i> My
                                    Dashboard</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="" method="POST">
                                    <a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <h4 class="text-center" style="margin: 32px 0;">Form Beli Produk</h4>
    <div class="container" style="width: 320px;">
        <form action="" method="POST">
            <div class="mb-3">
                <label class="form-label">ID Produk : <?php echo $id_produk; ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label">Nam aProduk : <?php echo $nama ?></label>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga Produk : Rp. <?php echo $harga; ?> / pcs</label>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah Produk</label>
                <input type="number" id="jumlah" name="jumlah">
            </div>
            <button name="beli_produk" class="btn btn-primary">Beli Produk</button>
        </form>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

</body>

</html>