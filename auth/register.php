<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            $error = "Email sudah terdaftar!";
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'customer')");
            if ($stmt->execute([$name, $email, $hashed_password])) {
                $success = "Registrasi berhasil! Silakan <a href='login.php'>Login</a>";
            } else {
                $error = "Terjadi kesalahan saat registrasi.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar — Kafetani</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        :root{ --cream:#F7F3EC; --brown:#3B2A1A; --green:#2D5016; --ff-display:'Cormorant Garamond',serif; --ff-body:'DM Sans',sans-serif; --border:#D9CEBC; --text-mid:#7A6550; }
        body{ background:var(--cream); font-family:var(--ff-body); display:flex; align-items:center; justify-content:center; min-height:100vh; margin:0; }
        .auth-container{ background:#fff; padding:2.5rem; border:1px solid var(--border); width:100%; max-width:400px; }
        .auth-title{ font-family:var(--ff-display); font-size:2.2rem; font-weight:300; color:var(--brown); margin-bottom:1.5rem; text-align:center; }
        .form-group{ margin-bottom:1.2rem; }
        .form-group label{ display:block; font-size:.8rem; color:var(--text-mid); margin-bottom:.4rem; }
        .form-group input{ width:100%; padding:.75rem; border:1px solid var(--border); box-sizing:border-box; font-family:var(--ff-body); }
        .auth-btn{ width:100%; background:var(--green); color:#fff; border:none; padding:.8rem; font-weight:500; cursor:pointer; margin-top:.5rem; }
        .auth-link{ display:block; text-align:center; font-size:.85rem; color:var(--text-mid); margin-top:1.2rem; text-decoration:none; }
        .alert{ padding:.8rem; margin-bottom:1rem; font-size:.85rem; border-radius:4px; }
        .alert-error{ background:#fcebea; color:#c0392b; border:1px solid #f5d1cf; }
        .alert-success{ background:#edf7ee; color:#2d5016; border:1px solid #d4e8d5; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1 class="auth-title">Daftar Akun</h1>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="auth-btn">Daftar Sekarang</button>
        </form>

        <a href="login.php" class="auth-link">Sudah punya akun? Login di sini</a>
        <a href="../index.php" class="auth-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>
