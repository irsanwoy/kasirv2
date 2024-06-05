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
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <div style="background: #333; color: white; padding: 10px 0; text-align: center; font-size: 24px;">
        <header>
            <h1>Dashboard</h1>
        </header>
    </div>
    <div class="container" style="max-width: 800px; margin: 20px auto; padding: 20px; background: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="text-align: center; color: #333; margin-bottom: 40px;">Dashboard</h2>
        <div class="card-container" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 20px;">
            <div class="card" style="width: 200px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h3 style="margin-bottom: 10px;"><a href="manage_products.php" style="text-decoration: none; color: #333;">Kelola Barang</a></h3>
                <p style="color: #666;">Tambahkan, ubah, atau hapus barang.</p>
            </div>
            <div class="card" style="width: 200px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h3 style="margin-bottom: 10px;"><a href="manage_sales.php" style="text-decoration: none; color: #333;">Kelola Penjualan</a></h3>
                <p style="color: #666;">Kelola transaksi penjualan.</p>
            </div>
            <div class="card" style="width: 200px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h3 style="margin-bottom: 10px;"><a href="manage_customers.php" style="text-decoration: none; color: #333;">Kelola Pelanggan</a></h3>
                <p style="color: #666;">Tambahkan, ubah, atau hapus pelanggan.</p>
            </div>
            <div class="card" style="width: 200px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h3 style="margin-bottom: 10px;"><a href="riwayat_pelanggan.php" style="text-decoration: none; color: #333;">Riwayat Pelanggan</a></h3>
                <p style="color: #666;">Lihat riwayat transaksi pelanggan.</p>
            </div>
            <div class="card" style="width: 200px; padding: 20px; background: #fff; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center;">
                <h3 style="margin-bottom: 10px;"><a href="logout.php" style="text-decoration: none; color: #333;">Logout</a></h3>
                <p style="color: #666;">Keluar dari aplikasi.</p>
            </div>
        </div>
    </div>
    <div style="background: #333; color: white; padding: 10px 0; text-align: center; font-size: 14px; position: fixed; width: 100%; bottom: 0;">
        <footer>
            <p>&copy; 2024 Dashboard</p>
        </footer>
    </div>
</body>
</html>
