<?php
require_once 'config/db.php';

$updates = [
    'kopi_susu_gula_aren.webp' => 'Kopi Susu Gula Aren',
    'croissant_butter.webp' => 'Croissant Butter',
    'biji_kopi_arabica_gayo.webp' => 'Biji Kopi Arabica Gayo'
];

foreach ($updates as $img => $name) {
    $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE name = ?");
    $stmt->execute([$img, $name]);
    echo "Updated $name: " . $stmt->rowCount() . " rows affected.\n";
}
?>
