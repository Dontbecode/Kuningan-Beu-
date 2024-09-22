<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    $query = "SELECT * FROM user WHERE (username='" . $username . "' OR no_hp='" . $username . "') AND password='" . $password . "'";

    $conn = include "../koneksi.php";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_array($result, MYSQLI_ASSOC);
    if (isset($user)) {
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['no_hp'] = $user['no_hp'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_id'] = $user['id'];

        // Redirect based on role
        if ($user['is_admin'] == 1) {
            $_SESSION['role'] = 'admin';
            echo "<script>
                alert('Login berhasil sebagai Admin');
                window.location.href = '../Admin/Dashboard.php';
            </script>";
        } else {
            $_SESSION['role'] = 'user';
            echo "<script>
                alert('Login berhasil');
                window.location.href = '../index.php';
            </script>";
        }
    } else {
        $_SESSION['alert'] = 'danger';
        $_SESSION['message'] = "Pengguna tidak ditemukan";
        echo "<script>
            alert('Kredensial tidak valid. Silakan coba lagi.');
            window.location.href = document.referrer;
        </script>";
    }
}


?>
