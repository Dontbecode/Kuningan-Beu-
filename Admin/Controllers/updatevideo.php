<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $url = $_POST['url'];
    $video_id = $_POST['video_id'];

    $conn = include "../../koneksi.php";

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE video SET url=? WHERE id=?");
    $stmt->bind_param("si", $url, $video_id);

    if ($stmt->execute()) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "Data berhasil diupdate";
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Data gagal diupdate";
    }

    // Close the statement
    $stmt->close();
}

// Redirect back to the referring page
echo "<script>window.location.replace('" . $_SERVER['HTTP_REFERER'] . "');</script>";
