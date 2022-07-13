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

$sql = "SELECT * FROM categories";
$kategori = mysqli_query($kon, $sql);

$sql = "SELECT * FROM products";
$produk = mysqli_query($kon, $sql);

$sql = "SELECT * FROM users";
$pengguna = mysqli_query($kon, $sql);


if (isset($_POST['submit_produk'])) {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $category_id = $_POST['category_id'];

    $sql = "INSERT INTO products (nama, harga, category_id) VALUES ('$nama', $harga, $category_id)";
    $result = mysqli_query($kon, $sql);

    if ($result) {
        echo "<script>alert('Selamat, tambah produk berhasil!')</script>";
        header('Location: admin.php');
    } else {
        echo "<script>alert('" . mysqli_error($kon) . "')</script>";
    }
}

if (isset($_POST['submit_kategori'])) {
    $nama = $_POST['nama'];

    $sql = "INSERT INTO categories (nama) VALUES ('$nama')";
    $result = mysqli_query($kon, $sql);

    if ($result) {
        echo "<script>alert('Selamat, tambah kategori berhasil!')</script>";
        header('Location: admin.php');
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

    <link rel="stylesheet" type="text/css" href="style.css">
    <title>SITAK | ADMIN</title>
</head>

<body>
    <div class="container">
        <form action="" method="POST">
            <?php echo "<h1>Selamat Datang, " . $_SESSION['username'] . "!" . "(admin)</h1>"; ?>
            <div>
                <a href="logout.php">Logout</a>
            </div>
        </form>
    </div>
    <h2>Form Tambah Produk</h2>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama </td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama"></td>
                <input type="hidden" id="id" name="id">
            </tr>
            <tr>
                <td>Harga </td>
                <td>:</td>
                <td><input type="text" id="harga" name="harga"></td>
            </tr>
            <tr>
                <td>Kategori </td>
                <td>:</td>
                <td><input type="text" name="category_id"></td>
            </tr>
            <tr>
                <td colspan="3"><button name="submit_produk">Tambah Produk</button></td>
            </tr>
        </table>
    </form>
    <h2>Form Tambah Kategori</h2>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama </td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama"></td>
                <input type="hidden" id="id" name="id">
            </tr>
            <tr>
                <td colspan="3"><button name="submit_kategori">Tambah Kategori</button></td>
            </tr>
        </table>
    </form>
    <h2>Tabel Kategori</h2>
    <table border="1">
        <tr>
            <td>No </td>
            <td>Nama</td>
            <td>Aksi</td>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($kategori, MYSQLI_ASSOC)) {
        ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><a href="edit_kategori.php?id=<?php echo $row['id']; ?>&nama=<?php echo $row['nama']; ?>"> Edit </a> / <a href="hapus_kategori.php?id=<?php echo $row['id']; ?>"> Hapus </a></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <h2>Tabel Produk</h2>
    <table border="1">
        <tr>
            <td>No </td>
            <td>Nama</td>
            <td>Harga</td>
            <td>Kategori</td>
            <td>Aksi</td>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($produk, MYSQLI_ASSOC)) {
        ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td>Rp. <?php echo $row['harga'] ?></td>
                <td><?php echo $row['category_id'] ?></td>
                <td><a href="edit_produk.php?id=<?php echo $row['id']; ?>&nama=<?php echo $row['nama']; ?>&harga=<?php echo $row['harga']; ?>&category_id=<?php echo $row['category_id']; ?>"> Edit </a> / <a href="hapus_produk.php?id=<?php echo $row['id']; ?>"> Hapus </a></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <h2>Tabel Pengguna</h2>
    <table border="1">
        <tr>
            <td>No </td>
            <td>Username</td>
            <td>Email</td>
            <td>Password</td>
            <td>Tanggal Lahir</td>
            <td>Tempat Tinggal</td>
            <td>Alamat</td>
            <td>Jenis Kelamin</td>
            <td>No.Telepon</td>
            <td>ID Paypal</td>
            <td>Nama Bank</td>
            <td>Peran</td>
        </tr>
        <?php
        while ($row = mysqli_fetch_array($pengguna, MYSQLI_ASSOC)) {
        ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['password'] ?></td>
                <td><?php echo $row['tanggal_lahir'] ?></td>
                <td><?php echo $row['tempat_tinggal'] ?></td>
                <td><?php echo $row['alamat'] ?></td>
                <td><?php echo $row['jenis_kelamin'] ?></td>
                <td><?php echo $row['no_telp'] ?></td>
                <td><?php echo $row['id_paypal'] ?></td>
                <td><?php echo $row['nama_bank'] ?></td>
                <td><?php echo ($row['level_otorisasi'] == 1) ? "Admin" : "Customer" ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</body>

</html>