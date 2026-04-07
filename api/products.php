<?php
header('Content-Type: application/json');
require_once '../config/db.php';

$type = $_GET['type'] ?? 'all';
$query = "SELECT p.*, c.name as category_name 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id";

if ($type !== 'all') {
    $query .= " WHERE p.type = " . $pdo->quote($type);
}

$products = $pdo->query($query)->fetchAll();
echo json_encode($products);
?>
