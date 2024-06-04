<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'classes/Customer.php';
$customer = new Customer();

if (isset($_GET['id'])) {
    $customer->id = $_GET['id'];
    $customer_data = $customer->readOne();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer->id = $_POST['id'];
    $customer->nama = $_POST['nama'];
    $customer->telepon = $_POST['telepon'];
    $customer->alamat = $_POST['alamat'];

    if ($customer->update()) {
        header("Location: manage_customers.php");
        exit();
    } else {
        $message = "Terjadi kesalahan saat memperbarui pelanggan.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Pelanggan</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <?php include 'templates/header.php'; ?>
    <h2>Edit Pelanggan</h2>
    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $customer_data['id']; ?>">
        Nama: <input type="text" name="nama" value="<?php echo $customer_data['nama']; ?>" required><br>
        Telepon: <input type="text" name="telepon" value="<?php echo $customer_data['telepon']; ?>" required><br>
        Alamat: <textarea name="alamat" required><?php echo $customer_data['alamat']; ?></textarea><br>
        <button type="submit">Update Pelanggan</button>
    </form>
    <?php include 'templates/footer.php'; ?>
</body>
</html>
