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

$sql = "SELECT * FROM orders WHERE user_id=(SELECT id FROM users WHERE username='$username')";
$order = mysqli_query($kon, $sql);

require(dirname(__FILE__) . "/fpdf/fpdf.php");

use PHPMailer\PHPMailer\PHPMailer;

require(dirname(__FILE__) . "/PHPMailer/PHPMailer.php");
require(dirname(__FILE__) . "/PHPMailer/SMTP.php");
require(dirname(__FILE__) . "/PHPMailer/Exception.php");

if (isset($_POST['cetak_kirim_pemesanan'])) {

    $total_order = 0;
    $waktu_pembuatan_file = date('Y-m-d_H-i');
    // intance object dan memberikan pengaturan halaman PDF
    $pdf = new FPDF('P', 'mm', 'A4');
    // membuat halaman baru
    $pdf->AddPage();
    // setting jenis font yang akan digunakan
    $pdf->SetFont('Arial', 'B', 16);
    // mencetak string 
    $pdf->Cell(0, 10, 'Data Checkout Pemesanan SITAK', 0, 0, 'C');
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 7, 'User ID : ' . $_SESSION['id'], 0, 1);
    $pdf->Cell(10, 7, 'Username : ' . $_SESSION['username'], 0, 1);
    $pdf->Cell(10, 7, 'Email : ' . $_SESSION['email'], 0, 1);
    $pdf->Cell(10, 7, 'Alamat : ' . $_SESSION['alamat'], 0, 1);
    $pdf->Cell(10, 7, 'Nama Bank : ' . $_SESSION['nama_bank'], 0, 1);
    $pdf->Cell(10, 7, 'Paypal ID : ' . $_SESSION['id_paypal'], 0, 1);
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(10, 6, 'NO', 1, 0, 'C');
    $pdf->Cell(85, 6, 'NAMA PRODUK', 1, 0, 'C');
    $pdf->Cell(27, 6, 'HARGA', 1, 0, 'C');
    $pdf->Cell(25, 6, 'JUMLAH', 1, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $sql = "SELECT * FROM orders WHERE user_id=(SELECT id FROM users WHERE username='$username')";
    $data_order = mysqli_query($kon, $sql);
    while ($row = mysqli_fetch_array($order, MYSQLI_ASSOC)) {
        $total_order += $row['harga'];
        $id_produk = $row['id'];
        $sql = "SELECT * FROM products WHERE id=$id_produk";
        $result = mysqli_query($kon, $sql);
        $nama_produk = mysqli_fetch_assoc($result);
        $pdf->Cell(10, 6, $row['id'], 1, 0, 'C');
        $pdf->Cell(85, 6, $nama_produk['nama'], 1, 0, 'C');
        $pdf->Cell(27, 6, "Rp. " . $row['harga'], 1, 0, 'C');
        $pdf->Cell(25, 6, $row['jumlah'], 1, 1, 'C');
    }
    $pdf->Cell(10, 7, '', 0, 1);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(10, 7, 'Total Harga Pemesanan : Rp. ' . $total_order, 0, 1);
    $file_order = "order_" . $_SESSION['username'] . "_" . $waktu_pembuatan_file . ".pdf";
    $pdf->Output($file_order, "F");

    $mail = new PHPMailer();
    // SMTP Settings
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = $_SESSION['email'];
    $mail->Password = "wingchunisthebe";
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";

    // Email Settings
    $mail->isHTML(true);
    $mail->setFrom("admin@sitak.com", "AdminSITAK");
    $mail->addAddress($_SESSION['email']);
    $mail->Subject = ("admin@sitak.com (Pengiriman Hasil Checkout Pemesanan di SITAK)");
    $mail->Body = "Terima kasih telah melakukan pembelian alat kesehatan di SITAK :)";
    $mail->addAttachment($file_order);

    if ($mail->send()) {
        $status = "Sukses";
        $response = "Email berhasil dikirimkan!";
    } else {
        $status = "Gagal";
        $response = "Ada sesuatu yang salah: <br>" . $mail->ErrorInfo;
    }

    echo "<script>alert('$status . ' ' . $response')</script>";
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
    <title>SITAK | CHECKOUT</title>
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
    <div class="container">
        <h4 class="mt-4">Tabel Customer</h4>
        <table class="table table-striped table-hover">
            <tr>
                <td>User ID</td>
                <td>Username</td>
                <td>Email</td>
                <td>Alamat</td>
                <td>Nama Bank</td>
                <td>ID Paypal</td>
            </tr>
            <tr>
                <td> <?php echo $_SESSION['id']; ?></td>
                <td> <?php echo $_SESSION['username']; ?></td>
                <td> <?php echo $_SESSION['email']; ?></td>
                <td> <?php echo $_SESSION['alamat']; ?></td>
                <td> <?php echo $_SESSION['nama_bank']; ?></td>
                <td> <?php echo $_SESSION['id_paypal']; ?></td>
            </tr>
        </table>
        <h4 class="mt-4">Tabel Pemesanan</h4>
        <form action="" method="POST">
            <table class="table table-striped table-hover">
                <tr>
                    <td>No </td>
                    <td>Nama Produk</td>
                    <td>Harga</td>
                    <td>Jumlah</td>
                    <td>Aksi</td>
                </tr>
                <?php
                while ($row = mysqli_fetch_array($order, MYSQLI_ASSOC)) {
                ?>
                    <tr>
                        <?php
                        $id_produk = $row['id'];
                        $sql = "SELECT * FROM products WHERE id=$id_produk";
                        $result = mysqli_query($kon, $sql);
                        $nama_produk = mysqli_fetch_assoc($result);
                        ?>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $nama_produk['nama']; ?></td>
                        <td>Rp. <?php echo $row['harga']; ?></td>
                        <td><?php echo $row['jumlah'] ?></td>
                        <td><a href="hapus_order.php?id=<?php echo $row['id']; ?>"> Batalkan Pesanan </a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
            <p style="text-decoration: underline;">TANDATANGAN TOKO SITAK</p>

            <button name="cetak_kirim_pemesanan" class="btn btn-primary">Cetak dan Kirim Ke Email</button>
        </form>
    </div>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>

</body>

</html>