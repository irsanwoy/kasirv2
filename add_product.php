<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Product.php';
$product = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product->nama_barang = $_POST['nama_barang'];
    $product->deskripsi = $_POST['deskripsi'];
    $product->harga = $_POST['harga'];
    $product->stok = $_POST['stok'];

    if ($product->create()) {
        header("Location: manage_products.php");
        exit();
    } else {
        $message = "Gagal menambah barang.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background-color: #333;
            overflow: hidden;
        }
        .navbar a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
        }
        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
        }
        form input[type="text"],
        form input[type="number"],
        form textarea {
            width: calc(100% - 22px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        form button {
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        form button:hover {
            background-color: #218838;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="dashboard.php">Dashboard</a>
        <a href="manage_products.php">Kelola Barang</a>
        <a href="manage_customers.php">Kelola Pelanggan</a>
        <a href="manage_sales.php">Kelola Penjualan</a>
        <a href="riwayat_pelanggan.php">Riwayat pelanggan</a>
        <a href="logout.php">Logout</a>
    </div>
    <div class="container">
        <h2>Tambah Barang</h2>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form method="POST">
            <input type="text" name="nama_barang" placeholder="Nama Barang" required>
            <textarea name="deskripsi" placeholder="Deskripsi" required></textarea>
            <input type="number" step="0.01" name="harga" placeholder="Harga" required>
            <input type="number" name="stok" placeholder="Stok" required>
            <button type="submit">Tambah Barang</button>
        </form>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
