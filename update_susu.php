<?php
require_once 'config/db.php';
$stmt = $pdo->prepare("UPDATE products SET image = 'susu_sapi_segar.webp' WHERE name LIKE '%Susu Sapi Segar%'");
$stmt->execute();
echo "Update successful: " . $stmt->rowCount() . " rows affected.\n";
?>
