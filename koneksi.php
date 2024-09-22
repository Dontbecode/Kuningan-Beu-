<?php

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'data_camp';

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

return $conn;
?>
