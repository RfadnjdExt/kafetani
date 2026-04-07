<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav>
  <a href="index.php" class="nav-logo">Kafe<span>tani</span></a>
  <div class="nav-links">
    <a href="index.php" class="nav-link <?= ($current_page == 'index.php') ? 'active' : '' ?>">Beranda</a>
    <a href="menu.php" class="nav-link <?= ($current_page == 'menu.php') ? 'active' : '' ?>">Menu Kafe</a>
    <a href="marketplace.php" class="nav-link <?= ($current_page == 'marketplace.php') ? 'active' : '' ?>">Marketplace</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <?php if ($_SESSION['role'] == 'admin'): ?>
            <a href="admin/dashboard.php" class="nav-link">Admin</a>
        <?php endif; ?>
        <a href="auth/logout.php" class="nav-link">Logout</a>
    <?php else: ?>
        <a href="auth/login.php" class="nav-link">Login</a>
    <?php endif; ?>
  </div>
  <button class="nav-cart" onclick="openCart()">
    🛒 Keranjang <span class="cart-badge" id="cart-badge">0</span>
  </button>
</nav>
