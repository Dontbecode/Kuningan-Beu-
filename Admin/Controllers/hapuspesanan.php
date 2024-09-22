<?php
session_start();
$conn = include "../../koneksi.php"; // Pastikan jalur ke file koneksi benar

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = mysqli_real_escape_string($conn, $_POST['id']); // Lindungi dari injeksi SQL
    $table = mysqli_real_escape_string($conn, $_POST['table']); // Lindungi dari injeksi SQL

    // Validasi nama tabel
    if ($table === 'pemesanan_camping') {
        // Query untuk menghapus data
        $query = "DELETE FROM $table WHERE id='$id'";
        if (mysqli_query($conn, $query)) {
            $_SESSION['alert'] = "success";
            $_SESSION['message'] = "Berhasil menghapus data";
        } else {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "Gagal menghapus data: " . mysqli_error($conn);
        }
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Tabel tidak valid";
    }
}

// Redirect kembali ke halaman sebelumnya
header("Location: " . $_SERVER['HTTP_REFERER']);
exit;
?>
