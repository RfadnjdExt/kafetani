<?php
session_start();
require_once 'config/db.php';

$cat_filter = $_GET['cat'] ?? 'all';
$query = "SELECT p.*, c.slug as cat_slug 
          FROM products p 
          LEFT JOIN categories c ON p.category_id = c.id 
          WHERE p.type = 'cafe'";

if ($cat_filter !== 'all') {
    $query .= " AND c.slug = " . $pdo->quote($cat_filter);
}
$query .= " ORDER BY p.created_at DESC";

$menu_items = $pdo->query($query)->fetchAll();
$categories = $pdo->query("SELECT * FROM categories WHERE slug != 'bahan-baku'")->fetchAll();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="page" id="page-menu">
  <div class="page-header">
    <div class="page-header-label">Kafetani · Menu</div>
    <h1 class="page-header-title">Menu Kafe</h1>
    <p class="page-header-sub">Minuman, bakeri, dan camilan buatan sendiri dari bahan lokal</p>
  </div>
  
  <div class="filter-bar">
    <a href="menu.php" class="filter-tab <?= $cat_filter == 'all' ? 'active' : '' ?>">Semua</a>
    <?php foreach($categories as $cat): ?>
        <a href="menu.php?cat=<?= $cat['slug'] ?>" class="filter-tab <?= $cat_filter == $cat['slug'] ? 'active' : '' ?>">
            <?= $cat['name'] ?>
        </a>
    <?php endforeach; ?>
  </div>

  <div class="products-grid" id="menu-grid">
    <?php foreach($menu_items as $item): ?>
    <div class="product-card">
      <div class="product-thumb">
        <?php if($item['image']): ?>
            <img src="assets/img/products/<?= $item['image'] ?>" style="width:100%;height:100%;object-fit:cover;">
        <?php else: ?>
            ☕
        <?php endif; ?>
      </div>
      <div class="product-body">
        <div class="product-cat"><?= htmlspecialchars($item['cat_slug']) ?></div>
        <div class="product-name"><?= htmlspecialchars($item['name']) ?></div>
        <div class="product-desc"><?= htmlspecialchars($item['description']) ?></div>
        <div class="product-footer">
          <span class="product-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
          <button class="add-btn" onclick="addToCart({id:<?= $item['id'] ?>, name:'<?= addslashes(htmlspecialchars($item['name'])) ?>', price:<?= $item['price'] ?>, image:'<?= $item['image'] ?>', icon:'☕'}, this)">+</button>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
    <?php if(empty($menu_items)): ?>
        <p style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-light);">Belum ada menu di kategori ini.</p>
    <?php endif; ?>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
