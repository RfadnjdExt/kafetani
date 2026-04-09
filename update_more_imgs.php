<?php
require_once 'config/db.php';

$updates = [
    'gula_aren.webp' => '%Gula Aren%',
    'bakeri_segar.webp' => '%Croissant%'
];

foreach ($updates as $img => $name) {
    $stmt = $pdo->prepare("UPDATE products SET image = ? WHERE name LIKE ?");
    $stmt->execute([$img, $name]);
    echo "Updated $name: " . $stmt->rowCount() . " rows affected.\n";
}
?>
