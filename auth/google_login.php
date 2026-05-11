<?php
session_start();
$config = require_once '../config/auth_config.php';

$params = [
    'client_id' => $config['google']['client_id'],
    'redirect_uri' => $config['google']['redirect_uri'],
    'response_type' => 'code',
    'scope' => 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email',
    'access_type' => 'offline',
    'prompt' => 'select_account'
];

$url = "https://accounts.google.com/o/oauth2/v2/auth?" . http_build_query($params);

header("Location: $url");
exit;
?>
