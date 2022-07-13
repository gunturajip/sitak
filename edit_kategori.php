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

    $sql = "UPDATE categories SET nama='$namaku' where id=$idku";
    $result = mysqli_query($kon, $sql);

    if ($result) {
        echo "<script>alert('Selamat, edit kategori berhasil!')</script>";
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
    <title>SITAK | EDIT KATEGORI</title>
</head>

<body>
    <?php
    $id = $_GET['id'];
    $nama = $_GET['nama'];
    ?>
    <h1>Halaman Edit Kategori</h1>
    <form action="" method="POST">
        <table>
            <tr>
                <td>Nama </td>
                <td>:</td>
                <td><input type="text" id="nama" name="nama" value="<?php echo $nama; ?>"></td>
                <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
            </tr>
            <tr>
                <td colspan="3"><button name="submit">Ubah</button></td>
            </tr>
        </table>
    </form>
</body>

</html>