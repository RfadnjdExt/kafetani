<?php
require_once '../config/db.php';
require_once '../includes/auth_check.php';
checkAdmin();

// Fetch summary stats
$total_orders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$total_products = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$total_farmers = $pdo->query("SELECT COUNT(*) FROM farmers")->fetchColumn();
$total_revenue = $pdo->query("SELECT SUM(total) FROM orders WHERE status = 'completed'")->fetchColumn() ?: 0;

include '../includes/header.php';
?>
<div class="admin-layout" style="display:grid;grid-template-columns:240px 1fr;min-height:100vh;">
    <aside style="background:var(--brown);color:#fff;padding:2rem;display:flex;flex-direction:column;gap:1rem;">
        <h2 style="font-family:var(--ff-display);font-size:1.5rem;margin-bottom:1rem;">Admin Panel</h2>
        <a href="dashboard.php" style="color:var(--amber);text-decoration:none;font-size:.9rem;">Dashboard</a>
        <a href="products.php" style="color:#fff;text-decoration:none;font-size:.9rem;opacity:.8;">Produk</a>
        <a href="farmers.php" style="color:#fff;text-decoration:none;font-size:.9rem;opacity:.8;">Petani</a>
        <a href="orders.php" style="color:#fff;text-decoration:none;font-size:.9rem;opacity:.8;">Pesanan</a>
        <hr style="opacity:.2;margin:1rem 0;">
        <a href="../index.php" style="color:#fff;text-decoration:none;font-size:.9rem;opacity:.8;">← Lihat Situs</a>
    </aside>
    
    <main style="padding:3rem;background:var(--cream);">
        <header style="margin-bottom:3rem;">
            <h1 style="font-family:var(--ff-display);font-size:2.5rem;color:var(--brown);font-weight:300;">Ringkasan Bisnis</h1>
            <p style="color:var(--text-mid);font-size:.9rem;">Selamat datang, <?= $_SESSION['name'] ?>. Berikut statistik hari ini.</p>
        </header>

        <section style="display:grid;grid-template-columns:repeat(4,1fr);gap:1.5rem;margin-bottom:3rem;">
            <div style="background:#fff;padding:1.5rem;border:1px solid var(--border);">
                <div style="font-size:.7rem;color:var(--text-light);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;">Total Pendapatan</div>
                <div style="font-family:var(--ff-display);font-size:1.8rem;color:var(--green);">Rp <?= number_format($total_revenue, 0, ',', '.') ?></div>
            </div>
            <div style="background:#fff;padding:1.5rem;border:1px solid var(--border);">
                <div style="font-size:.7rem;color:var(--text-light);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;">Total Pesanan</div>
                <div style="font-family:var(--ff-display);font-size:1.8rem;color:var(--brown);"><?= $total_orders ?></div>
            </div>
            <div style="background:#fff;padding:1.5rem;border:1px solid var(--border);">
                <div style="font-size:.7rem;color:var(--text-light);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;">Produk Tersedia</div>
                <div style="font-family:var(--ff-display);font-size:1.8rem;color:var(--brown);"><?= $total_products ?></div>
            </div>
            <div style="background:#fff;padding:1.5rem;border:1px solid var(--border);">
                <div style="font-size:.7rem;color:var(--text-light);text-transform:uppercase;letter-spacing:.1em;margin-bottom:.5rem;">Petani Mitra</div>
                <div style="font-family:var(--ff-display);font-size:1.8rem;color:var(--brown);"><?= $total_farmers ?></div>
            </div>
        </section>

        <section>
            <h3 style="font-family:var(--ff-display);font-size:1.5rem;color:var(--brown);margin-bottom:1.5rem;font-weight:300;">Aksi Cepat</h3>
            <div style="display:flex;gap:1rem;">
                <a href="products.php?action=add" class="add-btn" style="text-decoration:none;padding:.8rem 1.5rem;font-size:.85rem;display:inline-block;width:auto;height:auto;border-radius:2px;">+ Tambah Produk Baru</a>
                <a href="farmers.php?action=add" class="btn-outline" style="text-decoration:none;padding:.8rem 1.5rem;font-size:.85rem;display:inline-block;border-radius:2px;">+ Daftarkan Petani</a>
            </div>
        </section>
    </main>
</div>
<?php include '../includes/footer.php'; ?>
