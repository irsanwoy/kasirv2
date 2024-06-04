<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Dashboard</h2>
        <div class="card-container">
            <div class="card">
                <h3><a href="manage_products.php">Kelola Barang</a></h3>
                <p>Tambahkan, ubah, atau hapus barang.</p>
            </div>
            <div class="card">
                <h3><a href="manage_sales.php">Kelola Penjualan</a></h3>
                <p>Kelola transaksi penjualan.</p>
            </div>
            <div class="card">
                <h3><a href="manage_customers.php">Kelola Pelanggan</a></h3>
                <p>Tambahkan, ubah, atau hapus pelanggan.</p>
            </div>
            <div class="card">
                <h3><a href="riwayat_pelanggan.php">Riwayat Pelanggan</a></h3>
                <p>Tambahkan, ubah, atau hapus pelanggan.</p>
            </div>
            <div class="card">
                <h3><a href="logout.php">Logout</a></h3>
                <p>Keluar dari aplikasi.</p>
            </div>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
