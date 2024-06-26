<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Sale.php';
require_once 'classes/Product.php';
require_once 'classes/Customer.php';

$sale = new Sale();
$product = new Product();
$customer = new Customer();

$sale->id = $_GET['id'];
$sale_data = $sale->readOne();
$products = $product->readAll();
$customers = $customer->readAll();
$details = $sale->readDetails();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale->id_pelanggan = $_POST['id_pelanggan'];
    $sale->total = 0; // Ini akan diupdate nanti setelah menghitung total dari detail penjualan
    if ($sale->update()) {
        $sale->deleteDetails(); // Hapus detail lama
        foreach ($_POST['products'] as $item) {
            $sale->addDetail($item['id'], $item['jumlah'], $item['harga']);
        }
        header("Location: manage_sales.php");
        exit();
    } else {
        $message = "Gagal mengubah penjualan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Edit Penjualan</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST">
            <label for="id_pelanggan">Pelanggan:</label>
            <select name="id_pelanggan" required>
                <?php while ($row = $customers->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $sale_data['id_pelanggan']) echo 'selected'; ?>><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select><br>
            <div id="products">
                <?php foreach ($details as $index => $detail) { ?>
                <div class="product">
                    <label for="id_barang">Barang:</label>
                    <select name="products[<?php echo $index; ?>][id]" required>
                        <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $detail['id_barang']) echo 'selected'; ?>><?php echo $row['nama_barang']; ?></option>
                        <?php } ?>
                    </select><br>
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="products[<?php echo $index; ?>][jumlah]" value="<?php echo $detail['jumlah']; ?>" required><br>
                    <label for="harga">Harga:</label>
                    <input type="number" step="0.01" name="products[<?php echo $index; ?>][harga]" value="<?php echo $detail['harga']; ?>" required><br>
                </div>
                <?php } ?>
            </div>
            <button type="submit">Edit Penjualan</button>
        </form>
    </div>
    <script>
        function addProduct() {
            var productDiv = document.createElement('div');
            productDiv.className = 'product';
            productDiv.innerHTML = document.querySelector('.product').innerHTML;
            document.getElementById('products').appendChild(productDiv);
        }
    </script>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
