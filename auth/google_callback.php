<?php
session_start();
require_once '../config/db.php';
$config = require_once '../config/auth_config.php';

if (!isset($_GET['code'])) {
    header("Location: login.php");
    exit;
}

$code = $_GET['code'];

// 1. Exchange code for access token
$token_url = "https://oauth2.googleapis.com/token";
$post_fields = [
    'code' => $code,
    'client_id' => $config['google']['client_id'],
    'client_secret' => $config['google']['client_secret'],
    'redirect_uri' => $config['google']['redirect_uri'],
    'grant_type' => 'authorization_code'
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $token_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (!isset($data['access_token'])) {
    // Handle error - Google might reject if credentials are placeholders
    $_SESSION['auth_error'] = "Gagal mendapatkan token akses dari Google. Pastikan kredensial di config/auth_config.php sudah benar.";
    header("Location: login.php");
    exit;
}

$access_token = $data['access_token'];

// 2. Get user info
$user_info_url = "https://www.googleapis.com/oauth2/v2/userinfo?access_token=" . $access_token;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $user_info_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$user_info_resp = curl_exec($ch);
curl_close($ch);

$user_info = json_decode($user_info_resp, true);

if (!isset($user_info['id'])) {
    $_SESSION['auth_error'] = "Gagal mengambil informasi profil dari Google.";
    header("Location: login.php");
    exit;
}

$google_id = $user_info['id'];
$email = $user_info['email'];
$name = $user_info['name'];

// 3. User synchronization
$stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE google_id = ? OR email = ?");
$stmt->execute([$google_id, $email]);
$user = $stmt->fetch();

if ($user) {
    // Update existing user with google_id if missing
    $update = $pdo->prepare("UPDATE users SET google_id = ? WHERE id = ?");
    $update->execute([$google_id, $user['id']]);
} else {
    // Create new user
    $temp_pass = password_hash(bin2hex(random_bytes(16)), PASSWORD_BCRYPT);
    $insert = $pdo->prepare("INSERT INTO users (name, email, password, google_id, role) VALUES (?, ?, ?, ?, 'customer')");
    $insert->execute([$name, $email, $temp_pass, $google_id]);
    
    $stmt = $pdo->prepare("SELECT id, name, role FROM users WHERE id = ?");
    $stmt->execute([$pdo->lastInsertId()]);
    $user = $stmt->fetch();
}

// 4. Log in
$_SESSION['user_id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['role'] = $user['role'];

header("Location: ../index.php");
exit;
?>
