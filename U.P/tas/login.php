<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM tb_user WHERE username='$username' AND password='$password'");
    $data = mysqli_fetch_assoc($result);

    if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO tb_user (username, password, role) 
              VALUES ('$username', '$password', 'pelanggan')";
    mysqli_query($conn, $query);

    echo "Registrasi berhasil, silakan login!";
}


    if ($data) {
        $_SESSION['id_user'] = $data['id'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['role'] = $data['role']; // 'admin' atau 'user'

        if ($_SESSION['role'] === 'admin') {
            header("Location: dashboard.php");
        } else {
            header("Location: profil.php");
        }
        exit;
    } else {
        echo "Username / Password salah!";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login</title>  
    <style>
        body {font-family: 'Segoe UI', sans-serif; background: linear-gradient(to right, #f0f4f7, #d9e2ec); height: 100vh; margin: 0; display: flex; align-items: center; justify-content: center;}
        .login-container {background: white; padding: 40px 30px; max-width: 380px; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.08);}
        h2 {text-align: center; margin-bottom: 25px; color: #2c3e50;}
        input {width: 100%; padding: 12px; margin: 8px 0; border: 1px solid #ccc; border-radius: 8px;}
        input[type="submit"] {background: #00c8ff; color: white; border: none; cursor: pointer; font-weight: bold;}
        input[type="submit"]:hover {background: #215488;}
        .error-message {color: red; text-align: center;}
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required autocomplete="off">
            <input type="password" name="password" placeholder="Password" required>
            <input type="submit" name="login" value="Login">
        </form>
        <a href="register.php">Belum punya akun? Daftar di sini</a>
    </div>
</body>
</html>
