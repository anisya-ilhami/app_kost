<?php
session_start();
if (isset($_SESSION['admin_login'])) {
    header('Location: ../admin/dashboard.php'); exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['admin_login'] = true;
        header('Location: ../admin/dashboard.php'); exit;
    } else {
        $error = 'Username atau password salah!';
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; }
        .login-container {
            max-width: 350px; margin: 60px auto; background: #fff; border-radius: 8px;
            box-shadow: 0 2px 8px #0001; padding: 32px 28px;
        }
        .login-title { text-align: center; font-size: 22px; font-weight: bold; margin-bottom: 24px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; font-size: 15px; }
        input[type=text], input[type=password] {
            width: 100%; padding: 8px 10px; border: 1px solid #ccc; border-radius: 4px;
            font-size: 15px;
        }
        .btn-login {
            width: 100%; background: #007bff; color: #fff; border: none; padding: 10px 0;
            border-radius: 4px; font-size: 16px; cursor: pointer; font-weight: bold;
        }
        .alert { background: #f8d7da; color: #842029; padding: 10px; border-radius: 4px; margin-bottom: 16px; text-align: center; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-title">Login Admin</div>
        <?php if ($error): ?>
            <div class="alert"><?= $error ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="btn-login">Login</button>
        </form>
    </div>
</body>
</html> 