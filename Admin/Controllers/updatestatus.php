<?php
session_start();
$conn = include "../../koneksi.php";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $query = "UPDATE pemesanan_camping SET status='" . $status . "' WHERE id='" . $id . "';";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "berhasil update data";
    } else {

        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "gagal update data";
    }
}
echo "<script>window.location.replace('" . $_SERVER['HTTP_REFERER'] . "');</script>";
