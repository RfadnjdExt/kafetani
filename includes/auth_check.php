<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkAdmin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
        header('Location: ../auth/login.php');
        exit;
    }
}
?>
