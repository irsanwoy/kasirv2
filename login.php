<?php
session_start();
require_once 'classes/User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $user->nama_pengguna = $_POST['nama_pengguna'];
    $user->kata_sandi = $_POST['kata_sandi'];

    if ($user->login()) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['nama_pengguna'] = $user->nama_pengguna;
        $_SESSION['peran'] = $user->peran;
        header("Location: dashboard.php");
        exit();
    } else {
        $error_message = "Nama pengguna atau kata sandi salah.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
    <form method="POST">
        Nama Pengguna: <input type="text" name="nama_pengguna" required><br>
        Kata Sandi: <input type="password" name="kata_sandi" required><br>
        <button type="submit">Login</button>
    </form>
    <p>Belum punya akun? <a href="register.php">Daftar di sini</a>.</p>
</body>
</html>
