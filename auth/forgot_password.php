<?php
session_start();
require_once '../config/db.php';
$auth_config = require_once '../config/auth_config.php';

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        $update = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
        $update->execute([$token, $expiry, $user['id']]);

        $reset_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/kafetani/auth/reset_password.php?token=" . $token;

        if ($auth_config['smtp']['simulate']) {
            // Simulate sending email
            $log_dir = '../logs';
            if (!is_dir($log_dir)) mkdir($log_dir, 0777, true);
            $log_file = $log_dir . '/mail_sim.log';
            $mail_content = "To: $email\nSubject: Reset Your Password - Kafetani\nContent: Klik link berikut untuk meriset password Anda: $reset_link\n---\n";
            file_put_contents($log_file, $mail_content, FILE_APPEND);
            $message = "Instruksi reset password telah dikirim ke email Anda (Disimulasikan ke logs/mail_sim.log).";
        } else {
            // Real mail sending logic would go here
            $message = "Instruksi reset password telah dikirim ke email Anda.";
        }
    } else {
        $error = "Email tidak terdaftar!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lupa Password — Kafetani</title>
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
        <h1 class="auth-title">Lupa Password</h1>
        
        <?php if($message): ?>
            <div class="alert-success"><?= $message ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" required>
            </div>
            <button type="submit" class="auth-btn">Kirim Link Reset</button>
        </form>

        <a href="login.php" class="auth-link">Kembali ke Login</a>
    </div>
</body>
</html>
