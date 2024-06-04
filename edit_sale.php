<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Sale.php';
$sale = new Sale();

if (isset($_GET['id'])) {
    $sale->id = $_GET['id'];
    $sale_data = $sale->readOne();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sale->id = $_POST['id'];
    $sale->id_pengguna = $_POST['id_pengguna'];
    $sale->id_pelanggan = $_POST['id_pelanggan'];
    $sale->total = $_POST['total'];

    if ($sale->update()) {
        header("Location: manage_sales.php");
        exit();
    } else {
        $message = "Terjadi kesalahan saat memperbarui penjualan.";
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
    <h2>Edit Penjualan</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $sale_data['id']; ?>">
        ID Pengguna: <input type="text" name="id_pengguna" value="<?php echo $sale_data['id_pengguna']; ?>" required><br>
        ID Pelanggan: <input type="text" name="id_pelanggan" value="<?php echo $sale_data['id_pelanggan']; ?>" required><br>
        Total: <input type="number" step="0.01" name="total" value="<?php echo $sale_data['total']; ?>" required><br>
        <button type="submit">Update Penjualan</button>
    </form>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
