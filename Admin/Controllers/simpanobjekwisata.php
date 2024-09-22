<?php
session_start();
// simpan data
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $uploadedOK = 1;
    $target_folder = "../../IMG/";
    $target_name = rand(1, 10000) . date("ymdHis") . ".";
    $target_type = "";

    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];


    if ($_FILES['img']['error'] == 0) {
        $target_type = strtolower(pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION));
        $check = getimagesize($_FILES['img']['tmp_name']);
        if ($check !== false) {
            $uploadedOK = 1;
        } else {
            $uploadedOK = 0;
            $_SESSION['alert'] = "danger";
            $_SESSION['message']= "File bukan image";
        }

        $target_file = $target_folder . $target_name . $target_type;
        if (file_exists($target_file)) {
            $uploadedOK = 0;
            $_SESSION['alert'] = "danger";
            $_SESSION['message']= " File sudah ada";
        }

        if ($uploadedOK == 0) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message']= " File gagal updaload";
        } else {
            if (move_uploaded_file($_FILES['img']['tmp_name'], $target_file)) {
                $conn = include "../../koneksi.php";
                $query = "INSERT INTO objek_wisata (nama,alamat,deskripsi,gambar) VALUES ('" . $nama . "','" . $alamat . "','" . $deskripsi . "','" . $target_name . $target_type . "')";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['alert'] = "success";
                    $_SESSION['message'] = "Data berhasil ditambkan";
                } else {
                    $_SESSION['alert'] = "danger";
                    $_SESSION['message'] = "data gagal ditambahkan";
                }
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message']= "File gagal updaload";
            }
        }
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message']= "Terjadi Kesalahan";
    }
}
echo "<script>window.location.replace('".$_SERVER['HTTP_REFERER']."');</script>";