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
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Tambah Barang</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST">
            Nama Barang: <input type="text" name="nama_barang" required><br>
            Deskripsi: <textarea name="deskripsi" required></textarea><br>
            Harga: <input type="number" step="0.01" name="harga" required><br>
            Stok: <input type="number" name="stok" required><br>
            <button type="submit">Tambah Barang</button>
        </form>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
