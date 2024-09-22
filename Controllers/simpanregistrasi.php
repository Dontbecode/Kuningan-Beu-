<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Cek apakah data POST ada
    if (!isset($_POST['nama']) || !isset($_POST['no_hp']) || !isset($_POST['username']) || !isset($_POST['password'])) {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "All fields are required";
        echo "<script>
            alert('All fields are required');
            window.location.replace(document.referrer);
        </script>";
        exit;
    }

    $conn = include "../koneksi.php";

    // Periksa apakah $conn adalah objek mysqli
    if (!$conn instanceof mysqli) {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Database connection failed";
        echo "<script>
            alert('Database connection failed');
            window.location.replace(document.referrer);
        </script>";
        exit;
    }

    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $query = "INSERT INTO user (nama, no_hp, username, password, is_admin) VALUES (?, ?, ?, ?, 0)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nama, $no_hp, $username, $password);

    if ($stmt->execute()) {
        $_SESSION['alert'] = "success";
        $_SESSION['message'] = "Registration successful";

        // Fetch the newly created user
        $query = "SELECT * FROM user WHERE username=? AND no_hp=? AND password=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $username, $no_hp, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        $_SESSION['nama'] = $data['nama'];
        $_SESSION['no_hp'] = $data['no_hp'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['user_id'] = $data['id'];

        echo "<script>
            alert('Registration successful');
            window.location.replace('../Login.php');
        </script>";
    } else {
        $_SESSION['alert'] = "danger";
        $_SESSION['message'] = "Registration failed";
        echo "<script>
            alert('Registration failed');
            window.location.replace(document.referrer);
        </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
