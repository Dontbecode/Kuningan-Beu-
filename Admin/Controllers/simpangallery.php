<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uploadedOK = 1;
    $target_folder = "../../IMG/";
    $target_name = rand(1, 10000) . date("ymdHis") . ".";
    $target_type = "";

    $deskripsi = $_POST['deskripsi'];

    if ($_FILES['img']['error'] == 0) {
        $target_type = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['img']['tmp_name']);
        if ($check !== false) {
            $target_file = $target_folder . $target_name . $target_type;
            if (!file_exists($target_file)) {
                if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                    $conn = include "../../koneksi.php";
                    $query = "INSERT INTO gallery (deskripsi,gambar) VALUES ('" . $deskripsi . "','" . $target_name . $target_type . "')";
                    if (mysqli_query($conn, $query)) {
                        $_SESSION['alert'] = "success";
                        $_SESSION['message'] = "Data berhasil ditambahkan";
                    } else {
                        $_SESSION['alert'] = "danger";
                        $_SESSION['message'] = "Data gagal ditambahkan";
                    }
                } else {
                    $_SESSION['alert'] = "danger";
                    $_SESSION['message'] = "File gagal diupload";
                }
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "File sudah ada";
            }
        } else {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "File bukan image";
        }
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Terjadi Kesalahan";
    }
}
echo "<script>window.location.replace('".$_SERVER['HTTP_REFERER']."');</script>";