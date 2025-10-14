<?php
session_start();
include "koneksi.php";

$message = "";

if (isset($_POST['register'])) {
    // Ambil input
    $nama = isset($_POST['nama']) ? trim($_POST['nama']) : '';
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $confirm_password = isset($_POST['confirm_password']) ? trim($_POST['confirm_password']) : '';

    // Validasi
    if ($password !== $confirm_password) {
        $message = "❌ Password dan konfirmasi password tidak sama!";
    } else {
        // Cek username
        $checkUser = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username'");
        if (mysqli_num_rows($checkUser) > 0) {
            $message = "❌ Username sudah digunakan!";
        } else {
            // Simpan ke DB (default role pelanggan)
            $query = "INSERT INTO tb_user (nama, username, email, password, role) 
                      VALUES ('$nama', '$username', '$email', '$password', 'pelanggan')";
            if (mysqli_query($conn, $query)) {
                $message = "✅ Registrasi berhasil! Silakan <a href='login.php'>login di sini</a>.";
            } else {
                $message = "❌ Registrasi gagal: " . mysqli_error($conn);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f0f4f7, #d9e2ec);
            height: 100vh; margin: 0;
            display: flex; align-items: center; justify-content: center;
        }
        .register-container {
            background: white; padding: 40px 30px;
            max-width: 400px; border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        h2 {text-align: center; margin-bottom: 25px; color: #2c3e50;}
        input {
            width: 100%; padding: 12px; margin: 8px 0;
            border: 1px solid #ccc; border-radius: 8px;
        }
        input[type="submit"] {
            background: #00c8ff; color: white;
            border: none; cursor: pointer; font-weight: bold;
        }
        input[type="submit"]:hover {background: #215488;}
        .message {text-align: center; margin-bottom: 15px;}
        .message.success {color: green;}
        .message.error {color: red;}
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Register</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?= strpos($message, 'berhasil') !== false ? 'success' : 'error' ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="text" name="nama" placeholder="Nama Lengkap" required autocomplete="off">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="email" name="email" placeholder="Email" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required>
            <input type="submit" name="register" value="Daftar">
        </form>

        <div style="text-align:center; margin-top:10px;">
            <a href="login.php">Sudah punya akun? Login di sini</a>
        </div>
    </div>
</body>
</html>
