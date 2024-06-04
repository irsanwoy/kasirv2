<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("ID penjualan tidak ditemukan.");
}

require_once 'classes/Sale.php';
$sale = new Sale();
$sale->id = $_GET['id'];
$sale_data = $sale->readOneWithDetails();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Struk Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <style>
        .receipt {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background: #fff;
        }
        .receipt h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .receipt table {
            width: 100%;
            margin-bottom: 20px;
        }
        .receipt table, .receipt th, .receipt td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }
        .receipt th, .receipt td {
            padding: 8px;
            text-align: left;
        }
        .receipt th {
            background: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <h2>Struk Penjualan</h2>
        <p>ID Penjualan: <?php echo $sale_data['id']; ?></p>
        <p>Tanggal: <?php echo $sale_data['tanggal_penjualan']; ?></p>
        <p>Nama Pengguna: <?php echo $sale_data['nama_pengguna']; ?></p>
        <p>Nama Pelanggan: <?php echo $sale_data['nama_pelanggan']; ?></p>
        <table>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
            <?php foreach ($sale_data['details'] as $detail) { ?>
            <tr>
                <td><?php echo $detail['nama_barang']; ?></td>
                <td><?php echo $detail['jumlah']; ?></td>
                <td><?php echo $detail['harga']; ?></td>
                <td><?php echo $detail['total']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <p>Total: <?php echo $sale_data['total']; ?></p>
    </div>
</body>
</html>
