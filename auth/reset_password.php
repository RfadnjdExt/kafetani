<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';
$token = $_GET['token'] ?? '';

if (!$token) {
    header("Location: login.php");
    exit;
}

// Verify token
$stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = ? AND reset_expires > NOW()");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    $error = "Token reset tidak valid atau sudah kedaluwarsa.";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $user) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Password konfirmasi tidak cocok!";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        
        $update = $pdo->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_expires = NULL WHERE id = ?");
        $update->execute([$hashed_password, $user['id']]);
        
        $success = "Password Anda telah berhasil diperbarui. Silakan login.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reset Password — Kafetani</title>
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
        .alert-success{ background:#e8f4fd; color:#2980b9; border:1px solid #d1e9f9; padding:.8rem; margin-bottom:1rem; font-size:.85rem; border-radius:4px; }
        .alert-error{ background:#fcebea; color:#c0392b; border:1px solid #f5d1cf; padding:.8rem; margin-bottom:1rem; font-size:.85rem; border-radius:4px; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1 class="auth-title">Reset Password</h1>
        
        <?php if($success): ?>
            <div class="alert-success"><?= $success ?></div>
            <a href="login.php" class="auth-btn" style="text-align:center; text-decoration:none; display:block;">Ke Halaman Login</a>
        <?php else: ?>
            <?php if($error): ?>
                <div class="alert-error"><?= $error ?></div>
            <?php endif; ?>

            <?php if(!$error || $_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                <form method="POST">
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input type="password" name="password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password</label>
                        <input type="password" name="confirm_password" required minlength="6">
                    </div>
                    <button type="submit" class="auth-btn">Update Password</button>
                </form>
            <?php endif; ?>
            <a href="login.php" class="auth-link">Kembali ke Login</a>
        <?php endif; ?>
    </div>
</body>
</html>
