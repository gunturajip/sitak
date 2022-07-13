<?php

include('kon.php');

session_start();

$sql = "SELECT * FROM categories";
$kategori = mysqli_query($kon, $sql);

$sql = "SELECT * FROM products";
$produk = mysqli_query($kon, $sql);

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
    <title>SITAK | CUSTOMER</title>
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
    <div class="container d-flex" style="margin-top: 32px;">
        <div class="row justify-content-start">
            <?php
            while ($row = mysqli_fetch_array($produk, MYSQLI_ASSOC)) {
            ?>
                <div class="card" style="width: 16rem; margin: 8px;">
                    <img src="img/<?php echo $row['nama']; ?>.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['nama']; ?></h5>
                        <p class="card-text">Rp. <?php echo $row['harga'] ?></p>
                        <p class="card-text">Kategori: <?php echo $row['category_id'] ?></p>
                        <a href="lihat_produk.php?id=<?php echo $row['id']; ?>&nama=<?php echo $row['nama']; ?>&harga=<?php echo $row['harga']; ?>&category_id=<?php echo $row['category_id']; ?>" class="btn btn-primary" style="font-size: 12px;"> Lihat Produk </a>
                        <a href="beli_produk.php?id=<?php echo $row['id']; ?>&nama=<?php echo $row['nama']; ?>&harga=<?php echo $row['harga']; ?>&category_id=<?php echo $row['category_id']; ?>" class="btn btn-primary" style="font-size: 12px;"> Beli Produk </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="justify-content-end">
            <div class="container">
                <h2 style="margin-top: 8px;">Daftar Kategori</h2>
            </div>
            <?php
            while ($row = mysqli_fetch_array($kategori, MYSQLI_ASSOC)) {
            ?>
                <div class="card" style="width: 18rem;">
                    <div class="card-body text-center">
                        <p class="card-text"><?php echo $row['nama']; ?></p>
                        <a href="cari_produk.php?id=<?php echo $row['id']; ?>&nama=<?php echo $row['nama']; ?>" class="card-link"> Cari Produk </a>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

</body>

</html>