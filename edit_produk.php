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

if (isset($_POST['submit'])) {
    $idku = $_POST['id'];
    $namaku = $_POST['nama'];
    $hargaku = $_POST['harga'];
    $category_idku = $_POST['category_id'];

    $sql = "UPDATE products SET nama='$namaku', harga=$hargaku, category_id=$category_idku where id=$idku";
    $result = mysqli_query($kon, $sql);

    if ($result) {
        echo "<script>alert('Selamat, edit produk berhasil!')</script>";
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SITAK | EDIT PRODUK</title>
</head>

<body>
    <?php
    $id = $_GET['id'];
    $nama = $_GET['nama'];
    $harga = $_GET['harga'];
    $category_id = $_GET['category_id'];
    ?>
    <h1>Halaman Edit Produk</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama </td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama" value="<?php echo $nama; ?>"></td>
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            </tr>
            <tr>
                <td>Harga </td>
                <td>:</td>
                <td><input type="text" id="harga" name="harga" value="<?php echo $harga; ?>"></td>
            </tr>
            <tr>
                <td>Kategori </td>
                <td>:</td>
                <td><input type="text" name="category_id" value="<?php echo $category_id; ?>"></td>
            </tr>
            <tr>
                <td colspan="3"><button name="submit">Ubah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>