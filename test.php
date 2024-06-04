<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'classes/Database.php';

$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Koneksi berhasil";
} else {
    echo "Koneksi gagal";
}
?>
