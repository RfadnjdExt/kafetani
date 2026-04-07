<?php
require_once 'config/db.php';

// Categories already seeded in schema

// Seed Farmers
$farmers = [
    ['Pak Budi', 'Gayo, Aceh', '08123456789', 'Petani kopi organik sejak 1990.'],
    ['Bu Sari', 'Temanggung, Jateng', '08129876543', 'Spesialis gula aren dan rempah.'],
    ['Pak Yusuf', 'Pangalengan, Jabar', '08112233445', 'Peternak sapi perah modern.']
];

$stmt = $pdo->prepare("INSERT INTO farmers (name, location, contact, bio) VALUES (?, ?, ?, ?)");
foreach ($farmers as $f) {
    $stmt->execute($f);
}

$farmer_ids = $pdo->query("SELECT id FROM farmers")->fetchAll(PDO::FETCH_COLUMN);

// Seed Products (Cafe)
$cafe_products = [
    ['Kopi Susu Gula Aren', 'Espresso + susu segar + gula aren petani lokal', 28000, 'cup', 50, 1, 'cafe', null],
    ['Americano Arabica', 'Single origin biji kopi Arabica Gayo', 22000, 'cup', 100, 1, 'cafe', null],
    ['Cappuccino', 'Double shot espresso dengan microfoam susu', 26000, 'cup', 40, 1, 'cafe', null],
    ['Croissant Butter', 'Berlapis-lapis, renyah di luar lembut di dalam', 22000, 'pcs', 20, 3, 'cafe', null],
    ['Roti Gandum', 'Roti gandum utuh homemade tanpa pengawet', 16000, 'pcs', 15, 3, 'cafe', null],
    ['Chocolate Cake', 'Kue coklat moist dengan ganache premium', 32000, 'slice', 10, 4, 'cafe', null]
];

$stmtProd = $pdo->prepare("INSERT INTO products (name, description, price, unit, stock, category_id, type, farmer_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
foreach ($cafe_products as $p) {
    $stmtProd->execute($p);
}

// Seed Products (Market)
$market_products = [
    ['Biji Kopi Arabica Gayo', 'Single origin, medium roast', 85000, '250g', 30, 5, 'market', $farmer_ids[0]],
    ['Gula Aren Organik', 'Proses alami tanpa pemutih', 45000, '500g', 50, 5, 'market', $farmer_ids[1]],
    ['Susu Sapi Segar', 'Segar dipanen pagi hari', 28000, '500ml', 20, 5, 'market', $farmer_ids[2]]
];

foreach ($market_products as $p) {
    $stmtProd->execute($p);
}

echo "Seeding completed successfully!\n";
?>
