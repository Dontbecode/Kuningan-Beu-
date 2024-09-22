<?php
session_start();

// Cek apakah sesi sudah ada atau belum
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Kelola Camp | Admin </title>

    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/css/bootstrap.min.css">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        /* Styling header */
        .navbar {
            padding: 0.5rem 1rem; /* Reduce padding */
        }

        .navbar-brand {
            font-size: 1.25rem; /* Reduce font size */
        }

        .navbar-nav {
            display: flex;
            align-items: center;
        }

        .user-greeting {
            margin-right: 1rem; /* Space between greeting and logout */
            overflow: hidden;
            white-space: nowrap;
            position: relative;
        }

        .user-greeting h1 {
            font-size: 1rem; /* Adjust font size */
            margin: 0; /* Remove default margin */
            animation: marquee 10s linear infinite; /* Animation */
            display: inline-block;
        }

        .nav-link-custom {
            color: #fff; /* Text color */
            transition: color 0.3s ease, background-color 0.3s ease;
        }

        .nav-link-custom:hover {
            color: #fff;
            background-color: #28a745; /* Background color on hover */
            border-radius: 0.25rem;
        }

        .navbar-nav .nav-item {
            margin-left: 1rem; /* Space between items */
        }

        /* Marquee Animation */
        @keyframes marquee {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        .alert-custom {
            background-color: #d4edda; /* Green background */
            color: #155724; /* Dark green text */
            border-color: #c3e6cb; /* Light green border */
        }
    </style>


    <!-- Custom styles for this template -->
    <link href="../Public/css/dashboard.css" rel="stylesheet">
    <link rel="stylesheet" href="../asset/icons/font/bootstrap-icons.min.css">
</head>

<body>

    <header class="navbar navbar-dark sticky-top bg-primary flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="#">Camping Palutungan</a>
        
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" onclick="return confirm('Apakah anda yakin akan keluar?')" href="../logout.php">Log Out</a>
            </div>
        </div>
    </header>