<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Customer.php';
$customer = new Customer();

$customers = $customer->readAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Riwayat Transaksi Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Riwayat Transaksi Pelanggan</h2>
        <form method="GET">
            <select name="customer_id">
                <?php while ($row = $customers->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
                <?php } ?>
            </select>
            <button type="submit">Lihat Riwayat</button>
        </form>
        <?php if (isset($_GET['customer_id'])) { 
            $customer->id = $_GET['customer_id'];
            $transactions = $customer->getCustomerHistory();
        ?>
        <h3>Riwayat Transaksi untuk <?php echo $customer->getName(); ?></h3>
        <table border="1">
            <tr>
                <th>ID Penjualan</th>
                <th>Tanggal</th>
                <th>Total</th>
            </tr>
            <?php while ($row = $transactions->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['tanggal_penjualan']; ?></td>
                <td><?php echo $row['total']; ?></td>
            </tr>
            <?php } ?>
        </table>
        <?php } ?>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
