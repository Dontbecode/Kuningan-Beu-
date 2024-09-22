<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $conn = include "../koneksi.php";
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $user_id = $_POST['user_id'];
    $query = "UPDATE user SET nama='" . $nama . "',no_hp='" . $no_hp . "'";
    if ($_POST['password'] != "") {
        $password = md5($_POST['password']);
        $query .= ",password='" . $password . "'";
    }
    $query .= " WHERE id='" . $user_id . "'";

    $result = mysqli_query($conn, $query);
    if ($result) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "Berhasil melakukan update profile";
        $query = "SELECT * From user WHERE id='" . $user_id . "'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['no_hp'] = $data['no_hp'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id'];
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Gagal melakukan update profile";
    }
}

echo "<script>window.location.replace('" . $_SERVER['HTTP_REFERER'] . "');</script>";
