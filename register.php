<?php
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $user->nama_pengguna = $_POST['nama_pengguna'];
    $user->kata_sandi = $_POST['kata_sandi'];
    $user->peran = $_POST['peran'];

    if ($user->register()) {
        header("Location: login.php");
        exit();
    } else {
        $error_message = "Terjadi kesalahan saat mendaftarkan pengguna.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Register</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form method="POST">
        Nama Pengguna: <input type="text" name="nama_pengguna" required><br>
        Kata Sandi: <input type="password" name="kata_sandi" required><br>
        Peran:
        <select name="peran">
            <option value="kasir">Kasir</option>
            <option value="admin">Admin</option>
        </select><br>
        <button type="submit">Register</button>
    </form>
    <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
</body>
</html>
