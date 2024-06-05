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

$products = $product->readAll();
$customers = $customer->readAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale->id_pengguna = $_SESSION['user_id'];
    $sale->id_pelanggan = $_POST['id_pelanggan'];
    $sale->total = 0; // Ini akan diupdate nanti setelah menghitung total dari detail penjualan
    if ($sale->create()) {
        foreach ($_POST['products'] as $item) {
            $sale->addDetail($item['id'], $item['jumlah']);
        }
        header("Location: manage_sales.php");
        exit();
    } else {
        $message = "Gagal menambah penjualan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Tambah Penjualan</h2>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="POST">
            <label for="id_pelanggan">Pelanggan:</label>
            <select name="id_pelanggan" required>
                <?php while ($row = $customers->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select><br>
            <div id="products">
                <div class="product">
                    <label for="id_barang">Barang:</label>
                    <select name="products[0][id]" required>
                        <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama_barang']; ?></option>
                        <?php } ?>
                    </select><br>
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" name="products[0][jumlah]" required><br>
                </div>
            </div>
            <button type="button" onclick="addProduct()">Tambah Barang</button><br>
            <button type="submit">Tambah Penjualan</button>
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
