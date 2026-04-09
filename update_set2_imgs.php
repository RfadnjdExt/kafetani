<?php
require_once 'config/db.php';

$updates = [
    'americano_arabica.webp' => 'Americano Arabica',
    'cappuccino.webp' => 'Cappuccino',
    'roti_gandum.webp' => 'Roti Gandum',
    'chocolate_cake.webp' => 'Chocolate Cake'
];

foreach ($updates as $img => $name) {
    $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE name = ?");
    $stmt->execute([$img, $name]);
    echo "Updated $name: " . $stmt->rowCount() . " rows affected.\n";
}
?>
