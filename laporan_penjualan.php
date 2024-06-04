<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Sale.php';
$sale = new Sale();

$time_period = isset($_GET['period']) ? $_GET['period'] : 'daily';
$sales = $sale->getSalesReport($time_period);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Laporan Penjualan</h2>
        <form method="GET">
            <select name="period">
                <option value="daily" <?php if ($time_period == 'daily') echo 'selected'; ?>>Harian</option>
                <option value="weekly" <?php if ($time_period == 'weekly') echo 'selected'; ?>>Mingguan</option>
                <option value="monthly" <?php if ($time_period == 'monthly') echo 'selected'; ?>>Bulanan</option>
                <option value="yearly" <?php if ($time_period == 'yearly') echo 'selected'; ?>>Tahunan</option>
            </select>
            <button type="submit">Lihat Laporan</button>
        </form>
        <h3><?php echo ucfirst($time_period); ?> Sales Report</h3>
        <table border="1">
            <tr>
                <th>Tanggal</th>
                <th>Total Penjualan</th>
            </tr>
            <?php while ($row = $sales->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['total']; ?></td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
