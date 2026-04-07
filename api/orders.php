<?php
session_start();
header('Content-Type: application/json');
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please login to place an order']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$cart = $data['cart'] ?? [];
$total = $data['total'] ?? 0;
$type = $data['type'] ?? 'pickup';

if (empty($cart)) {
    echo json_encode(['success' => false, 'message' => 'Cart is empty']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 1. Create order header
    $stmt = $pdo->prepare("INSERT INTO orders (user_id, status, total, type) VALUES (?, 'pending', ?, ?)");
    $stmt->execute([$_SESSION['user_id'], $total, $type]);
    $order_id = $pdo->lastInsertId();

    // 2. Add order items
    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    $stmtStock = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");

    foreach ($cart as $item) {
        $stmtItem->execute([$order_id, $item['id'], $item['qty'], $item['price']]);
        $stmtStock->execute([$item['qty'], $item['id']]);
    }

    $pdo->commit();
    echo json_encode(['success' => true, 'order_id' => $order_id]);
} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
