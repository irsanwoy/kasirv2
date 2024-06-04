<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Customer.php';
$customer = new Customer();

// Create
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create'])) {
    $customer->nama = $_POST['nama'];
    $customer->telepon = $_POST['telepon'];
    $customer->alamat = $_POST['alamat'];

    if ($customer->create()) {
        $message = "Pelanggan berhasil ditambahkan.";
    } else {
        $message = "Terjadi kesalahan saat menambahkan pelanggan.";
    }
}

// Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $customer->id = $_POST['id'];
    $customer->nama = $_POST['nama'];
    $customer->telepon = $_POST['telepon'];
    $customer->alamat = $_POST['alamat'];

    if ($customer->update()) {
        $message = "Pelanggan berhasil diperbarui.";
    } else {
        $message = "Terjadi kesalahan saat memperbarui pelanggan.";
    }
}

// Delete
if (isset($_GET['delete'])) {
    $customer->id = $_GET['delete'];

    if ($customer->delete()) {
        $message = "Pelanggan berhasil dihapus.";
    } else {
        $message = "Terjadi kesalahan saat menghapus pelanggan.";
    }
}

$customers = $customer->readAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Kelola Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <?php include 'templates/header.php'; ?>
    <h2>Kelola Pelanggan</h2>
    <?php if (isset($message)) {
        echo "<p>$message</p>";
    } ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($customer->id) ? $customer->id : ''; ?>">
        Nama: <input type="text" name="nama" required><br>
        Telepon: <input type="text" name="telepon" required><br>
        Alamat: <textarea name="alamat" required></textarea><br>
        <button type="submit" name="<?php echo isset($customer->id) ? 'update' : 'create'; ?>">
            <?php echo isset($customer->id) ? 'Update' : 'Tambah'; ?> Pelanggan
        </button>
    </form>

    <h3>Daftar Pelanggan</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Telepon</th>
            <th>Alamat</th>
            <th>Aksi</th>
        </tr>
        <?php while ($row = $customers->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nama']; ?></td>
                <td><?php echo $row['telepon']; ?></td>
                <td><?php echo $row['alamat']; ?></td>
                <td>
                    <a href="edit_customer.php?id=<?php echo $row['id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $row['id']; ?>">Hapus</a>
                </td>

            </tr>
        <?php } ?>
    </table>
    <?php include 'templates/footer.php'; ?>
</body>

</html>