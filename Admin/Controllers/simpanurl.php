<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $url = $_POST['url'];
    $conn = include "../../koneksi.php";
    $query = "INSERT INTO video (url) VALUES ('" . $url . "')";
    if (mysqli_query($conn, $query)) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "Data berhasil ditambkan";
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "data gagal ditambahkan";
    }
}
// echo "<script>window.location.replace('../../tambahgaleri.php');</script>";
echo "<script>window.location.replace('".$_SERVER['HTTP_REFERER']."');</script>";