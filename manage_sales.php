<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Sale.php';
$sale = new Sale();

$sales = $sale->readAllWithNames();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script>
        function printReceipt(id) {
            var printWindow = window.open('print_receipt.php?id=' + id, '_blank');
            printWindow.print();
        }
    </script>
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Kelola Penjualan</h2>

        <h3>Daftar Penjualan</h3>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama Pengguna</th>
                <th>Nama Pelanggan</th>
                <th>Total</th>
                <th>Tanggal Penjualan</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $sales->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_pengguna']; ?></td>
                <td><?php echo $row['nama_pelanggan']; ?></td>
                <td><?php echo $row['total']; ?></td>
                <td><?php echo $row['tanggal_penjualan']; ?></td>
                <td>
                    <a href="edit_sale.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <button onclick="printReceipt(<?php echo $row['id']; ?>)">Cetak Struk</button>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
