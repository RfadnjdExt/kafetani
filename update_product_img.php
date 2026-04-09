<?php
require_once 'config/db.php';
$stmt = $pdo->prepare("UPDATE products SET image = 'kopi_lokal.webp' WHERE name LIKE '%Kopi Susu Gula Aren%'");
$stmt->execute();
echo "Update successful: " . $stmt->rowCount() . " rows affected.\n";
?>
