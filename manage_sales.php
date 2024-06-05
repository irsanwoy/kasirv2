<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Sale.php';
$sale = new Sale();

if (isset($_GET['delete'])) {
    $sale->id = $_GET['delete'];
    if ($sale->delete()) {
        header("Location: manage_sales.php");
        exit();
    } else {
        $message = "Gagal menghapus penjualan.";
    }
}

$sales = $sale->readAllWithNames();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Penjualan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Kelola Penjualan</h2>
        <a href="add_sale.php" class="button" style="display: inline-block; padding: 10px 20px; font-size: 16px; font-weight: bold; text-align: center; text-decoration: none; background-color: green; color: white; border: none; border-radius: 5px; cursor: pointer; margin-bottom: 10px;">Tambah Penjualan</a>

        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
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
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus penjualan ini?');">Hapus</a>
                    <a href="print_receipt.php?id=<?php echo $row['id']; ?>" target="_blank">Cetak Struk</a>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
