<?php
// Menghubungkan ke database
$conn = include "../koneksi.php"; // Pastikan nama file koneksi benar

// Mendapatkan ID dari POST request
$id = isset($_POST['obyek_wisata_id']) ? intval($_POST['obyek_wisata_id']) : 0;

// Menyiapkan dan menjalankan query menggunakan prepared statement
$query = "SELECT * FROM paket_camping WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id); // Bind parameter (integer)
$stmt->execute();
$result = $stmt->get_result();

// Mengambil hasil query sebagai array asosiatif
$data = $result->fetch_assoc();

// Menutup statement dan koneksi
$stmt->close();
$conn->close();

// Mengatur header konten sebagai JSON dan mengeluarkan data
header("Content-Type: application/json");
echo json_encode($data);
?>
