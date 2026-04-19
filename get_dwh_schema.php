<?php
require_once 'config/db.php';

$tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
$schema = [];

foreach ($tables as $table) {
    $stmt = $pdo->query("DESCRIBE $table");
    $schema[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

echo json_encode($schema, JSON_PRETTY_PRINT);
?>
