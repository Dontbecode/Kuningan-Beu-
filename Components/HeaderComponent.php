<?php
session_start(); // Ensure session is started

// Get user role from session
$userRole = isset($_SESSION['role']) ? $_SESSION['role'] : null; // Assume the role is stored in the session

// Redirect admins to the admin dashboard if they try to access index.php
if ($userRole == 'admin') {
    echo "<script>window.location.replace('Admin/Dashboard.php');</script>";
    exit();
}

// Continue to load the page
$conn = include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liburan di Kuningan 'Beu'</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="Public/css/style.css" rel="stylesheet" crossorigin="anonymous">
    <script src="asset/js/jquery-3.7.1.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <style>
        .nav-link-custom {
            color: #ffffff; /* Default text color */
            transition: color 0.3s ease, background-color 0.3s ease; /* Smooth transition */
        }

        .nav-link-custom:hover {
            color: #ffffff; /* Text color on hover */
            background-color: #28a745; /* Green background color on hover */
            border-radius: 0.25rem; /* Rounded corners for the hover effect */
        }

        .nav-link-custom.active {
            color: #ffffff; /* Text color for active link */
            background-color: #28a745; /* Green background color for active link */
            border-radius: 0.25rem; /* Rounded corners for the active link */
        }

        .nav-link.disabled {
            pointer-events: none; /* Disable clicking on the link */
            opacity: 0.6; /* Make the link look disabled */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#"><img src="asset/IMG/Icon_Kuda.png" alt="Logo"></a>
            <Navbar.Brand href="#home" class="fs-6 fw-bold text-white" style="font-family: 'Comic Sand', cursive;">Bumi Perkemahan Palutungan</Navbar.Brand>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="margin-left: auto;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Beranda</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="ObjekWisata.php">Spot Objek Wisata</a></li>
                        <li class="nav-item"><a class="nav-link" href="PemesananCamp.php">Pemesanan</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link disabled" href="#">Spot Objek Wisata</a></li>
                        <li class="nav-item"><a class="nav-link disabled" href="#">Pemesanan</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="index.php#image" onclick="scrollToImage()">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#tentang-kami" onclick="scrollToImage()">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#kontak" onclick="scrollToImage()">Kontak</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item">
                            <a href="LihatPesanan.php" class="nav-link nav-link-custom <?= (basename($_SERVER['PHP_SELF']) == 'LihatPesanan.php') ? 'active' : '' ?>">
                                Hai <?= htmlspecialchars($_SESSION['nama']); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href="logout.php" class="btn btn-primary text-white">Logout</a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary text-white">Login</a>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <header class="header">
        <div>
            <h1 class="display-4" style="font-size: 100px; font-family: 'Comic Sand', cursive; color: #17333B; font-size: 5vw;">Camping</h1>    
            <h1 class="display-4" style="font-size: 100px; font-family: 'Comic Sand', cursive; font-size: 5vw;">Di <span style="color: #17333B;">Palutungan</span></h1>
            <h2 class="display-4" style="font-size: 100px; font-family: 'Comic Sand', cursive; font-size: 5vw;">'Beu'.</h2>
        </div>
        <div class="d-block mx-auto text-center">
            <img src="asset/IMG/H1.png" class="img-fluid mx-auto d-block" alt="Gambar Header">
            <?php if (basename($_SERVER['PHP_SELF']) == 'index.php'): ?>
                <button class="btn btn-kunjungi mb-5" style="background-color: black; transition: background-color 0.5s ease;">Kunjungi!</button>
            <?php endif; ?>
        </div>
    </header>
</body>
</html>
