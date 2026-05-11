<?php
/**
 * Authentication Configuration for Google Login and SMTP
 */

return [
    'google' => [
        'client_id' => 'YOUR_GOOGLE_CLIENT_ID.apps.googleusercontent.com',
        'client_secret' => 'YOUR_GOOGLE_CLIENT_SECRET',
        'redirect_uri' => (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/kafetani/auth/google_callback.php",
    ],
    'smtp' => [
        'host' => 'smtp.mailtrap.io', // Placeholder
        'port' => 2525,
        'username' => '',
        'password' => '',
        'encryption' => 'tls',
        'from_email' => 'no-reply@kafetani.com',
        'from_name' => 'Kafetani Support',
        'simulate' => true, // Set to true to log emails to a file instead of sending
    ]
];
?>
