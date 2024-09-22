<?php
include "../../koneksi.php";

// Ambil ID dari form
$id = $_POST['id'] ?? '';
$no_pemesanan = $_POST['no_pemesanan'] ?? '';
$nama = $_POST['nama'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$paket_camping_id = $_POST['paket_camping_id'] ?? '';
$tanggal = $_POST['tanggal'] ?? '';
$durasi = $_POST['durasi'] ?? 1;
$jml_peserta = $_POST['jml_peserta'] ?? 1;
$diskon = $_POST['diskon'] ?? 0;
$jenis_tenda = isset($_POST['pilihTenda']) ? $_POST['pilihTenda'] : null;
$jenis_makanan = isset($_POST['pilihMakanan']) ? $_POST['pilihMakanan'] : null;
$harga_paket = str_replace(['Rp. ', '.'], '', $_POST['harga_paket'] ?? '0'); // Remove 'Rp. ' and '.' for number conversion
$total_tagihan = str_replace(['Rp. ', '.'], '', $_POST['total_tagihan'] ?? '0'); // Remove 'Rp. ' and '.' for number conversion
$status = $_POST['status'] ?? 'Belum Diproses';

// Validasi input
if (empty($id)) {
    die('ID tidak tersedia.');
}

// Query untuk memperbarui data pesanan
$query = "
    UPDATE pemesanan_camping
    SET
        no_pemesanan = ?,
        nama = ?,
        no_hp = ?,
        paket_camping_id = ?,
        tanggal = ?,
        durasi = ?,
        jml_peserta = ?,
        diskon = ?,
        jenis_tenda = ?,
        jenis_makanan = ?,
        harga_paket = ?,
        total_tagihan = ?,
        status = ?
    WHERE id = ?
";

$stmt = $conn->prepare($query);

if (!$stmt) {
    die("Error preparing statement: " . $conn->error);
}

// Bind parameters
$stmt->bind_param(
    'sssssisssssssi',
    $no_pemesanan,
    $nama,
    $no_hp,
    $paket_camping_id,
    $tanggal,
    $durasi,
    $jml_peserta,
    $diskon,
    $jenis_tenda,
    $jenis_makanan,
    $harga_paket,
    $total_tagihan,
    $status,
    $id
);

// Execute query
if ($stmt->execute()) {
    header("Location: ../Dashboard.php"); // Redirect ke halaman sukses
} else {
    echo "Error updating record: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
