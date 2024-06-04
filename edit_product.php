<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Product.php';
$product = new Product();

if (isset($_GET['id'])) {
    $product->id = $_GET['id'];
    $product_data = $product->readOne();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product->id = $_POST['id'];
    $product->nama_barang = $_POST['nama_barang'];
    $product->deskripsi = $_POST['deskripsi'];
    $product->harga = $_POST['harga'];
    $product->stok = $_POST['stok'];

    if ($product->update()) {
        header("Location: manage_products.php");
        exit();
    } else {
        $message = "Terjadi kesalahan saat memperbarui barang.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Barang</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <h2>Edit Barang</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $product_data['id']; ?>">
        Nama Barang: <input type="text" name="nama_barang" value="<?php echo $product_data['nama_barang']; ?>" required><br>
        Deskripsi: <textarea name="deskripsi" required><?php echo $product_data['deskripsi']; ?></textarea><br>
        Harga: <input type="number" step="0.01" name="harga" value="<?php echo $product_data['harga']; ?>" required><br>
        Stok: <input type="number" name="stok" value="<?php echo $product_data['stok']; ?>" required><br>
        <button type="submit">Update Barang</button>
    </form>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
