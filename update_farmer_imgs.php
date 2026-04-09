<?php
require_once 'config/db.php';

$updates = [
    'pak_budi.webp' => 'Pak Budi',
    'bu_sari.webp' => 'Bu Sari',
    'pak_yusuf.webp' => 'Pak Yusuf'
];

foreach ($updates as $img => $name) {
    $stmt = $pdo->prepare("UPDATE farmers SET avatar = ? WHERE name = ?");
    $stmt->execute([$img, $name]);
    echo "Updated $name: " . $stmt->rowCount() . " rows affected.\n";
}
?>
