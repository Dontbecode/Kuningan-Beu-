<?php
if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'admin') {
        echo "<script>window.location.replace('Admin/Dashboard.php');</script>";
    } else {
        echo "<script>window.location.replace('index.php');</script>";
    }
}
$conn = include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link href="asset/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link href="Public/css/style.css" rel="stylesheet" crossorigin="anonymous">
    <script src="asset/js/jquery-3.7.1.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <style>
        body {
            background: linear-gradient(to right, #007bff, #343434);
        }
        .form-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .form-container h2 {
            margin-bottom: 20px;
            text-align: center;
            color: #007bff;
        }
        .btn-primary {
            width: 100%;
        }
        .toggle-form {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container" id="loginForm">
     
            <h2>Login</h2>
            <form id="login" method="post" action="Controllers/doLogin.php">
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" id="loginUsername" placeholder="Username or Phone" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" required>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="showPassword">
                        <label for="showPassword" class="form-check-label">Show Password</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div class="toggle-form">
                <p>Don't have an account? <a href="#" id="showRegister">Register</a></p>
            </div>
        </div>

        <div class="form-container" id="registerForm" style="display: none;">
            <h2>Register</h2>
            <form id="register" method="post" action="Controllers/simpanregistrasi.php">
                <div class="mb-3">
                    <input type="text" class="form-control" name="nama" id="registerNama" placeholder="Name" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="no_hp" id="registerNoHp" placeholder="Phone Number" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" id="registerUsername" placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="registerPassword" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            <div class="toggle-form">
                <p>Already have an account? <a href="#" id="showLogin">Login</a></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('showRegister').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'block';
        });

        document.getElementById('showLogin').addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('registerForm').style.display = 'none';
            document.getElementById('loginForm').style.display = 'block';
        });

        document.getElementById('showPassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            passwordField.type = this.checked ? 'text' : 'password';
        });
    </script>
</body>
</html>
