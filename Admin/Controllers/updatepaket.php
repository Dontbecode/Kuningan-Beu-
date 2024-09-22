<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $paket_camping_id = $_POST['paket_camping_id'];
    $obyek_wisata_id = $_POST['obyek_wisata_id'];
    $paket_camping = $_POST['paket_camping'];
    $harga_paket = $_POST['harga_paket'];
    $area_camping = $_POST['area_camping'];
    $kapasitas = $_POST['kapasitas'];
    $bonus_peralatan = $_POST['bonus_peralatan'];
    $diskon = $_POST['diskon'];

    $conn = include "../../koneksi.php";

    // Cek apakah file gambar diupload
    $gambar = null;
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "../../IMG/"; // Direktori untuk menyimpan gambar
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
        $upload_ok = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Cek apakah file gambar valid
        $check = getimagesize($_FILES["gambar"]["tmp_name"]);
        if ($check === false) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "File bukan gambar.";
            $upload_ok = 0;
        }

        // Cek ukuran file
        if ($_FILES["gambar"]["size"] > 5000000) { // Maksimal 5MB
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
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                $gambar = basename($_FILES["gambar"]["name"]); // Simpan nama file gambar
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "Terjadi kesalahan saat mengupload file.";
                exit();
            }
        }
    }

    // Prepare and execute the query to update paket_camping data
    if ($gambar) {
        $stmt = $conn->prepare("UPDATE paket_camping SET obyek_wisata_id=?, paket_camping=?, harga_paket=?, area_camping=?, kapasitas=?, bonus_peralatan=?, diskon=?, gambar=? WHERE id=?");
        $stmt->bind_param("isississi", $obyek_wisata_id, $paket_camping, $harga_paket, $area_camping, $kapasitas, $bonus_peralatan, $diskon, $gambar, $paket_camping_id);
    } else {
        $stmt = $conn->prepare("UPDATE paket_camping SET obyek_wisata_id=?, paket_camping=?, harga_paket=?, area_camping=?, kapasitas=?, bonus_peralatan=?, diskon=? WHERE id=?");
        $stmt->bind_param("isissii", $obyek_wisata_id, $paket_camping, $harga_paket, $area_camping, $kapasitas, $bonus_peralatan, $diskon, $paket_camping_id);
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
