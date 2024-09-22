<?php
session_start();
include "../koneksi.php"; // Pastikan path ini sesuai dengan struktur direktori Anda

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $no_pemesanan = $_POST['no_pemesanan'];
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $paket_camping_id = $_POST['paket_camping_id'];
    $tanggal = $_POST['tanggal'];
    $durasi = $_POST['durasi'];
    $jml_peserta = $_POST['jml_peserta'];
    $diskon = $_POST['diskon'];
    $jenis_tenda = isset($_POST['pilihTenda']) ? $_POST['pilihTenda'] : null;
    $jenis_makanan = isset($_POST['pilihMakanan']) ? $_POST['pilihMakanan'] : null;
    $harga_paket = str_replace(['Rp. ', '.'], '', $_POST['harga_paket']); // Menghapus format mata uang
    $total_tagihan = str_replace(['Rp. ', '.'], '', $_POST['total_tagihan']); // Menghapus format mata uang
    $status = "Belum Diproses";

    // Persiapkan statement
    $stmt = $conn->prepare("INSERT INTO pemesanan_camping 
        (no_pemesanan, nama, no_hp, paket_camping_id, tanggal, durasi, jml_peserta, diskon, jenis_tenda, jenis_makanan, harga_paket, total_tagihan, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameter
    $stmt->bind_param("sssssiiisssss", 
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
        $status
    );

    // Eksekusi query
    if ($stmt->execute()) {
        // Set session success message
        $_SESSION['success_message'] = "Pesanan berhasil disimpan!";
        header("Location:../LihatPesanan.php");
        exit();
    } else {
        // Set session error message
        $_SESSION['error_message'] = "Terjadi kesalahan: " . $stmt->error;
        header("Location:../PemesananCamp.php");
        exit();
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "Metode permintaan tidak valid.";
}
?>
