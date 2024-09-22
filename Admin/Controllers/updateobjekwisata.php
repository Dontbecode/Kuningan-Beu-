<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Ambil data dari form
    $wisata_id = $_POST['wisata_id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $deskripsi = $_POST['deskripsi'];

    $conn = include "../../koneksi.php";

    // Ambil nama gambar lama dari database
    $stmt = $conn->prepare("SELECT gambar FROM objek_wisata WHERE id = ?");
    $stmt->bind_param("i", $wisata_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $old_gambar = $row['gambar'];
    $stmt->close();

    // Cek apakah file gambar diupload
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
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.";
            $upload_ok = 0;
        }

        if ($upload_ok == 0) {
            $_SESSION['alert'] = "danger";
            $_SESSION['message'] = "File tidak diupload.";
        } else {
            // Hapus gambar lama jika ada
            if ($old_gambar && file_exists($target_dir . $old_gambar)) {
                unlink($target_dir . $old_gambar);
            }

            // Upload gambar baru
            if (move_uploaded_file($_FILES["img"]["tmp_name"], $target_file)) {
                $gambar = basename($_FILES["img"]["name"]); // Simpan nama file gambar
            } else {
                $_SESSION['alert'] = "danger";
                $_SESSION['message'] = "Terjadi kesalahan saat mengupload file.";
                exit();
            }
        }
    } else {
        // Jika tidak ada gambar baru diupload, gunakan gambar lama
        $gambar = $old_gambar;
    }

    // Prepare and execute the query to update objek_wisata data
    $stmt = $conn->prepare("UPDATE objek_wisata SET nama=?, alamat=?, deskripsi=?, gambar=? WHERE id=?");
    $stmt->bind_param("ssssi", $nama, $alamat, $deskripsi, $gambar, $wisata_id);

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
header("Location: " . htmlspecialchars($redirect_url));
exit();
?>
