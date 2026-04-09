<?php
require_once 'config/db.php';
$items = $pdo->query("SELECT name, image FROM products")->fetchAll(PDO::FETCH_ASSOC);
foreach ($items as $item) {
    echo "Product: {$item['name']} | Image: {$item['image']}\n";
}
?>
