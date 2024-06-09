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
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
            width: 300px;
        }
        .register-container h2 {
            margin-bottom: 20px;
        }
        .register-container input[type="text"],
        .register-container input[type="password"],
        .register-container select {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .register-container button {
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        .register-container button:hover {
            background-color: #218838;
        }
        .register-container p {
            margin-top: 20px;
        }
        .register-container p a {
            color: #007BFF;
            text-decoration: none;
        }
        .register-container p a:hover {
            text-decoration: underline;
        }
        .error-message {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>
        <?php if (isset($error_message)) { echo "<p class='error-message'>$error_message</p>"; } ?>
        <form method="POST">
            <input type="text" name="nama_pengguna" placeholder="Nama Pengguna" required>
            <input type="password" name="kata_sandi" placeholder="Kata Sandi" required>
            <select name="peran">
                <option value="kasir">Kasir</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit">Register</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
    </div>
</body>
</html>
