<?php
session_start();
require_once 'config/db.php';
include 'includes/header.php';
include 'includes/navbar.php';
?>

<div class="page" id="page-home">
  <div class="hero">
    <div class="hero-left">
      <div class="hero-tag">Farm to Table · Sejak Panen</div>
      <h1 class="hero-title">Dari <em>ladang</em><br>ke cangkirmu</h1>
      <p class="hero-desc">Kafetani menghubungkan petani lokal langsung ke meja kamu — kopi, bakeri, dan bahan segar pilihan tanpa perantara.</p>
      <div class="hero-actions">
        <a href="menu.php" class="btn-primary">Pesan Sekarang</a>
        <a href="marketplace.php" class="btn-outline">Lihat Marketplace</a>
      </div>
    </div>
    <div class="hero-right">
      <svg class="hero-pattern" viewBox="0 0 500 600" fill="none">
        <circle cx="250" cy="300" r="200" stroke="white" stroke-width="1"/>
        <circle cx="250" cy="300" r="150" stroke="white" stroke-width="0.5"/>
        <circle cx="250" cy="300" r="100" stroke="white" stroke-width="0.5"/>
        <line x1="50" y1="300" x2="450" y2="300" stroke="white" stroke-width="0.5"/>
        <line x1="250" y1="100" x2="250" y2="500" stroke="white" stroke-width="0.5"/>
        <line x1="109" y1="159" x2="391" y2="441" stroke="white" stroke-width="0.4"/>
        <line x1="391" y1="159" x2="109" y2="441" stroke="white" stroke-width="0.4"/>
      </svg>
      <div class="hero-visual">
        <div class="hero-circle">
          <div class="hero-circle-icon">☕</div>
          <div class="hero-circle-label">Kopi Lokal</div>
        </div>
        <div class="hero-pills">
          <span class="hero-pill">🌿 Arabica Gayo</span>
          <span class="hero-pill">🍯 Gula Aren</span>
          <span class="hero-pill">🥐 Bakeri Segar</span>
        </div>
      </div>
    </div>
  </div>

  <div class="home-stats">
    <div class="stat"><span class="stat-num">12+</span><div class="stat-label">Petani Mitra</div></div>
    <div class="stat"><span class="stat-num">38</span><div class="stat-label">Produk Tersedia</div></div>
    <div class="stat"><span class="stat-num">2 Kota</span><div class="stat-label">Jangkauan Pengiriman</div></div>
  </div>

  <div class="home-section">
    <div class="section-header">
      <h2 class="section-title">Pilihan Unggulan</h2>
      <a href="menu.php" class="section-link">Lihat semua menu →</a>
    </div>
    <div class="featured-grid">
      <div class="feat-card" onclick="location.href='menu.php'">
        <div class="feat-thumb feat-thumb-cafe">☕</div>
        <div class="feat-body">
          <div class="feat-tag">Menu Kafe</div>
          <div class="feat-name">Kopi Susu Gula Aren</div>
          <div class="feat-price">Rp 28.000</div>
        </div>
      </div>
      <div class="feat-card" onclick="location.href='menu.php'">
        <div class="feat-thumb feat-thumb-cafe">🥐</div>
        <div class="feat-body">
          <div class="feat-tag">Bakeri</div>
          <div class="feat-name">Croissant Butter</div>
          <div class="feat-price">Rp 22.000</div>
        </div>
      </div>
      <div class="feat-card" onclick="location.href='marketplace.php'">
        <div class="feat-thumb feat-thumb-market">🌿</div>
        <div class="feat-body">
          <div class="feat-tag">Produk Petani</div>
          <div class="feat-name">Biji Kopi Arabica Gayo</div>
          <div class="feat-price">Rp 85.000 / 250g</div>
        </div>
      </div>
    </div>
  </div>

  <div class="home-section" style="background:var(--green);margin:0;padding:3.5rem">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center">
      <div>
        <div style="font-size:.72rem;letter-spacing:.18em;text-transform:uppercase;color:rgba(255,255,255,.55);margin-bottom:.8rem">Tentang Kafetani</div>
        <h2 style="font-family:var(--ff-display);font-size:2.2rem;font-weight:300;color:#fff;margin-bottom:1rem;line-height:1.2">Kafe yang terhubung<br>langsung ke kebun</h2>
        <p style="color:rgba(255,255,255,.7);font-size:.9rem;line-height:1.8;font-weight:300">Setiap biji kopi dan butiran gula aren yang kamu nikmati berasal dari petani lokal yang sudah kami kenal namanya. Kafetani bukan sekadar kafe — ini adalah etalase langsung dari ladang ke cangkir.</p>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem">
        <div style="background:rgba(255,255,255,.08);padding:1.5rem;border:1px solid rgba(255,255,255,.1)">
          <div style="font-size:1.8rem;margin-bottom:.6rem">🌱</div>
          <div style="font-family:var(--ff-display);font-size:1.1rem;color:#fff;margin-bottom:.3rem">Bahan Segar</div>
          <div style="font-size:.8rem;color:rgba(255,255,255,.6)">Langsung dari petani mitra tanpa rantai distribusi panjang</div>
        </div>
        <div style="background:rgba(255,255,255,.08);padding:1.5rem;border:1px solid rgba(255,255,255,.1)">
          <div style="font-size:1.8rem;margin-bottom:.6rem">🤝</div>
          <div style="font-family:var(--ff-display);font-size:1.1rem;color:#fff;margin-bottom:.3rem">Petani Lokal</div>
          <div style="font-size:.8rem;color:rgba(255,255,255,.6)">Mendukung penghasilan petani Indonesia secara langsung</div>
        </div>
        <div style="background:rgba(255,255,255,.08);padding:1.5rem;border:1px solid rgba(255,255,255,.1)">
          <div style="font-size:1.8rem;margin-bottom:.6rem">📱</div>
          <div style="font-family:var(--ff-display);font-size:1.1rem;color:#fff;margin-bottom:.3rem">Pesan Online</div>
          <div style="font-size:.8rem;color:rgba(255,255,255,.6)">Order dari web, pickup atau dine-in sesuai preferensi</div>
        </div>
        <div style="background:rgba(255,255,255,.08);padding:1.5rem;border:1px solid rgba(255,255,255,.1)">
          <div style="font-size:1.8rem;margin-bottom:.6rem">🏡</div>
          <div style="font-family:var(--ff-display);font-size:1.1rem;color:#fff;margin-bottom:.3rem">Bawa Pulang</div>
          <div style="font-size:.8rem;color:rgba(255,255,255,.6)">Beli bahan baku segar untuk diolah sendiri di rumah</div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; ?>
