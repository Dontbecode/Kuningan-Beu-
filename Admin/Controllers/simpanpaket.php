<?php
session_start();
// simpan data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $paket_camping = $_POST['paket_camping'];
    $obyek_wisata_id = $_POST['obyek_wisata_id'];
    $harga_paket = $_POST['harga_paket'];
    $area_camping = $_POST['area_camping'];
    $kapasitas = $_POST['kapasitas'];
    $bonus_peralatan = $_POST['bonus_peralatan'];
    $diskon = $_POST['diskon'];
    $gambar = $_FILES['gambar']['name'];
    $tmp_gambar = $_FILES['gambar']['tmp_name'];

    $conn = include "../../koneksi.php";

    // Perbaiki upload gambar
    $target_dir = "../../IMG/";
    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $check = getimagesize($tmp_gambar);

    if ($check !== false) {
        if (move_uploaded_file($tmp_gambar, $target_file)) {
            $query = "INSERT INTO paket_camping (obyek_wisata_id, paket_camping, harga_paket, area_camping, kapasitas, bonus_peralatan, diskon, gambar) VALUES ('$obyek_wisata_id', '$paket_camping', '$harga_paket', '$area_camping', '$kapasitas', '$bonus_peralatan', '$diskon', '$gambar')";
            if (mysqli_query($conn, $query)) {
                $_SESSION['alert'] = "success";
                $_SESSION['message'] = "Data berhasil ditambahkan";
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "Data gagal ditambahkan";
            }
        } else {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "Gagal mengupload gambar";
        }
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "File yang diupload bukan gambar";
    }
} else {
    $_SESSION['alert'] = "danger";
    $_SESSION['message'] = "Terjadi Kesalahan";
}

echo "<script>window.location.replace('" . $_SERVER['HTTP_REFERER'] . "');</script>";