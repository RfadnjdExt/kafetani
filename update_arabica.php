<?php
require_once 'config/db.php';
$stmt = $pdo->prepare("UPDATE products SET image = 'arabica_gayo.webp' WHERE name LIKE '%Arabica Gayo%'");
$stmt->execute();
echo "Update successful: " . $stmt->rowCount() . " rows affected.\n";
?>
