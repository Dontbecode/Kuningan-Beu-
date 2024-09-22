<?php
session_start();
$conn = include "../../koneksi.php";
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $id = $_POST['id'];
    $table = $_POST['table'];
    $query = "DELETE FROM " . $table . " WHERE id='" . $id . "';";
    $result = mysqli_query($conn,$query);
    if($result){
        $_SESSION['alert']="success";
        $_SESSION['message']="berhasil menghapus data";
    }else {

        $_SESSION['alert']="danger";
        $_SESSION['message']="gagal menghapus data";
    }
}
echo "<script>window.location.replace('".$_SERVER['HTTP_REFERER']."');</script>";