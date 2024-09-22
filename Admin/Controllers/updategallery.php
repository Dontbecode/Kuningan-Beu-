<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $gallery_id = $_POST['gallery_id'];
    $deskripsi = $_POST['deskripsi'];

    $conn = include "../../koneksi.php";

    // Cek apakah file gambar diupload
    $img_url = null;
    if (isset($_FILES['img']) && $_FILES['img']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../../IMG/"; // Direktori untuk menyimpan gambar
        $target_file = $target_dir . basename($_FILES["img"]["name"]);
        $upload_ok = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        $check = getimagesize($_FILES["img"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "File bukan gambar.";
            $upload_ok = 0;
        }

        // Cek ukuran file
        if ($_FILES["img"]["size"] > 5000000) { // Maksimal 5MB
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "Ukuran file terlalu besar.";
            $upload_ok = 0;
        }

        // Cek tipe file
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $upload_ok = 0;
        }

        if ($upload_ok == 0) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "File tidak diupload.";
        } else {
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $img_url = basename($_FILES["img"]["name"]); // Simpan nama file gambar
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "Terjadi kesalahan saat mengupload file.";
                exit();
            }
        }
    }

    // Prepare and execute the query to update gallery data
    if ($img_url) {
        $stmt = $conn->prepare("UPDATE gallery SET gambar=?, deskripsi=? WHERE id=?");
        $stmt->bind_param("ssi", $img_url, $deskripsi, $gallery_id);
    } else {
        $stmt = $conn->prepare("UPDATE gallery SET deskripsi=? WHERE id=?");
        $stmt->bind_param("si", $deskripsi, $gallery_id);
    }

    if ($stmt->execute()) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "Data berhasil diupdate";
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Data gagal diupdate: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}

// Redirect back to the referring page
$redirect_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'default_page.php';
echo "<script>window.location.replace('" . htmlspecialchars($redirect_url) . "');</script>";
?>
