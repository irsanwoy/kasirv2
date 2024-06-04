<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Product.php';
$product = new Product(); // Inisialisasi objek Product

// Handle delete request
if (isset($_GET['delete'])) {
    $product->id = $_GET['delete'];
    if ($product->delete()) {
        header("Location: manage_products.php"); // Redirect to refresh the page
        exit();
    } else {
        $message = "Gagal menghapus barang.";
    }
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10; // Number of records per page
$offset = ($page - 1) * $limit;

$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$products = $product->searchWithPagination($search_term, $limit, $offset);

$total_rows = $product->countSearchResults($search_term);
$total_pages = ceil($total_rows / $limit);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Barang</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <div class="container">
        <h2>Kelola Barang</h2>
        <a href="add_product.php" class="button">Tambah Barang</a>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
        <form method="GET">
            <input type="text" name="search" placeholder="Cari Barang" value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit">Cari</button>
        </form>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
            <?php while ($row = $products->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama_barang']; ?></td>
                <td><?php echo $row['deskripsi']; ?></td>
                <td><?php echo $row['harga']; ?></td>
                <td><?php echo $row['stok']; ?></td>
                <td>
                    <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Hapus</a>
                </td>
            </tr>
            <?php } ?>
        </table>
        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <a href="?search=<?php echo htmlspecialchars($search_term); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
            <?php } ?>
        </div>
    </div>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
