<?php
// File: kafetani/admin/dashboard.php

session_start();
require_once '../includes/auth_check.php';
checkAdmin();

// Panggil Controller dari folder app
require_once '../../app/Controller/dashboardController.php';

// Jalankan aplikasi via MVC
$controller = new DashboardController();
$controller->index();
?>