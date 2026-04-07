<?php
session_start();
require_once 'config/db.php';

$farmer_filter = $_GET['farmer'] ?? 'all';
$query = "SELECT p.*, f.name as farmer_name, f.location as farmer_loc, f.avatar as farmer_avatar 
          FROM products p 
          JOIN farmers f ON p.farmer_id = f.id 
          WHERE p.type = 'market'";

if ($farmer_filter !== 'all') {
    $query .= " AND f.id = " . intval($farmer_filter);
}
$query .= " ORDER BY p.created_at DESC";

$market_items = $pdo->query($query)->fetchAll();
$farmers = $pdo->query("SELECT * FROM farmers")->fetchAll();

include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="page" id="page-market">
  <div class="page-header" style="background:var(--brown)">
    <div class="page-header-label">Kafetani · Marketplace</div>
    <h1 class="page-header-title">Marketplace Petani</h1>
    <p class="page-header-sub">Beli langsung dari petani lokal — biji kopi, gula aren, dan produk segar pilihan</p>
  </div>

  <div class="market-layout">
    <div class="market-sidebar">
      <div class="sidebar-title">Petani Mitra</div>
      <div id="farmer-list">
        <a href="marketplace.php" class="farmer-card <?= $farmer_filter == 'all' ? 'active' : '' ?>" style="text-decoration:none;">
            <div class="farmer-avatar" style="background:var(--cream2);font-size:1.2rem;">All</div>
            <div>
                <div class="farmer-info-name">Semua Petani</div>
                <div class="farmer-info-loc">📍 Semua Wilayah</div>
            </div>
        </a>
        <?php foreach($farmers as $f): ?>
            <a href="marketplace.php?farmer=<?= $f['id'] ?>" class="farmer-card <?= $farmer_filter == $f['id'] ? 'active' : '' ?>" style="text-decoration:none;">
                <div class="farmer-avatar" style="background:var(--green-light);">
                    <?php if($f['avatar']): ?>
                        <img src="assets/img/farmers/<?= $f['avatar'] ?>" style="width:100%;height:100%;border-radius:50%;object-fit:cover;">
                    <?php else: ?>
                        👨‍🌾
                    <?php endif; ?>
                </div>
                <div>
                    <div class="farmer-info-name"><?= $f['name'] ?></div>
                    <div class="farmer-info-loc">📍 <?= $f['location'] ?></div>
                </div>
            </a>
        <?php endforeach; ?>
      </div>
    </div>
    
    <div class="market-products">
      <div class="market-banner">
        <div class="market-banner-text">
          <h3>Langsung dari Kebun</h3>
          <p>Setiap produk dikirim segar, tanpa perantara</p>
        </div>
        <div class="market-banner-icon">🌿</div>
      </div>

      <div class="market-grid" id="market-grid">
        <?php foreach($market_items as $item): ?>
        <div class="product-card">
          <div class="product-thumb green">
            <?php if($item['image']): ?>
                <img src="assets/img/products/<?= $item['image'] ?>" style="width:100%;height:100%;object-fit:cover;">
            <?php else: ?>
                📦
            <?php endif; ?>
          </div>
          <div class="product-body">
            <div class="product-cat"><?= $item['farmer_name'] ?> · <?= $item['unit'] ?></div>
            <div class="product-name"><?= $item['name'] ?></div>
            <div class="product-desc"><?= $item['description'] ?></div>
            <div class="product-footer">
              <span class="product-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
              <button class="add-btn" onclick="addToCart({id:<?= $item['id'] ?>, name:'<?= addslashes($item['name']) ?>', price:<?= $item['price'] ?>, icon:'🌿'}, this)">+</button>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
        <?php if(empty($market_items)): ?>
            <p style="grid-column:1/-1;text-align:center;padding:4rem;color:var(--text-light);">Belum ada produk untuk petani ini.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
