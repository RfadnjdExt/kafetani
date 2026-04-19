<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id, name, password, role FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        if ($user['role'] == 'admin') {
            header('Location: ../admin/dashboard.php');
        } else {
            header('Location: ../index.php');
        }
        exit;
    } else {
        $error = "Email atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login — Kafetani</title>
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
        .alert-error{ background:#fcebea; color:#c0392b; border:1px solid #f5d1cf; padding:.8rem; margin-bottom:1rem; font-size:.85rem; border-radius:4px; }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1 class="auth-title">Login</h1>
        
        <?php if($error): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <?php if(isset($_SESSION['auth_error'])): ?>
            <div class="alert-error"><?= $_SESSION['auth_error']; unset($_SESSION['auth_error']); ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:flex-end;">
                  <label>Password</label>
                  <a href="forgot_password.php" style="font-size: .75rem; color: var(--green); text-decoration: none; margin-bottom: .4rem;">Lupa password?</a>
                </div>
                <input type="password" name="password" required>
            </div>
            <button type="submit" class="auth-btn">Masuk</button>
        </form>

        <div style="margin: 1.5rem 0; display: flex; align-items: center; gap: 1rem; color: var(--text-light); font-size: .8rem;">
          <div style="flex: 1; height: 1px; background: var(--border);"></div>
          <span>Atau</span>
          <div style="flex: 1; height: 1px; background: var(--border);"></div>
        </div>

        <a href="google_login.php" class="auth-btn" style="background:#fff; color:var(--brown); border:1px solid var(--border); display:flex; align-items:center; justify-content:center; gap:.8rem; text-decoration:none;">
          <svg width="18" height="18" viewBox="0 0 18 18"><path d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844c-.209 1.125-.843 2.078-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615z" fill="#4285F4"/><path d="M9 18c2.43 0 4.467-.806 5.956-2.184l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z" fill="#34A853"/><path d="M3.964 10.706c-.18-.54-.282-1.117-.282-1.706s.102-1.166.282-1.706V4.962H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.038l3.007-2.332z" fill="#FBBC05"/><path d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.962l3.007 2.332c.708-2.127 2.692-3.711 5.036-3.711z" fill="#EA4335"/></svg>
          Masuk dengan Google
        </a>

        <a href="register.php" class="auth-link">Belum punya akun? Daftar gratis</a>
        <a href="../index.php" class="auth-link">← Kembali ke Beranda</a>
    </div>
</body>
</html>
