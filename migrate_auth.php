<?php
require_once 'config/db.php';

try {
    $queries = [
        "ALTER TABLE users ADD COLUMN google_id VARCHAR(255) DEFAULT NULL UNIQUE AFTER password",
        "ALTER TABLE users ADD COLUMN reset_token VARCHAR(255) DEFAULT NULL AFTER google_id",
        "ALTER TABLE users ADD COLUMN reset_expires DATETIME DEFAULT NULL AFTER reset_token"
    ];

    foreach ($queries as $query) {
        $pdo->exec($query);
        echo "Executed: $query\n";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
