<?php
// Batasi akses langsung ke file ini
if (!defined('APP_RUNNING')) {
    die("Direct access not allowed.");
}

$host = 'localhost';
$db   = 'db_sukainfo';
$user = 'root';
$pass = '';

try {
    // Koneksi dengan PDO
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

    // Set error mode ke Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'akses terhubung ke database';

} catch (PDOException $e) {
    // Simpan error ke log, jangan tampilkan ke user
    error_log("Koneksi database gagal: " . $e->getMessage());
    die("Terjadi masalah pada koneksi database.");
}
?>
