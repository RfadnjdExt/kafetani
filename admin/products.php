<?php
require_once '../config/db.php';
require_once '../includes/auth_check.php';
checkAdmin();

$action = $_GET['action'] ?? 'list';
$error = '';
$success = '';

// Handle Delete
if ($action == 'delete' && isset($_GET['id'])) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    if ($stmt->execute([$_GET['id']])) {
        $success = "Produk berhasil dihapus!";
    } else {
        $error = "Gagal menghapus produk.";
    }
    $action = 'list';
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($action == 'add' || $action == 'edit')) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $stock = $_POST['stock'];
    $category_id = $_POST['category_id'];
    $type = $_POST['type'];
    $farmer_id = !empty($_POST['farmer_id']) ? $_POST['farmer_id'] : null;
    $id = $_POST['id'] ?? null;

    // Handle Image Upload
    $image_path = $_POST['existing_image'] ?? null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../assets/img/products/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $new_filename = uniqid() . '.' . $file_ext;
        $target_file = $target_dir . $new_filename;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image_path = $new_filename;
        }
    }

    if ($action == 'add') {
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, unit, stock, category_id, type, farmer_id, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $description, $price, $unit, $stock, $category_id, $type, $farmer_id, $image_path])) {
            $success = "Produk berhasil ditambahkan!";
            $action = 'list';
        }
    } else {
        $stmt = $pdo->prepare("UPDATE products SET name=?, description=?, price=?, unit=?, stock=?, category_id=?, type=?, farmer_id=?, image=? WHERE id=?");
        if ($stmt->execute([$name, $description, $price, $unit, $stock, $category_id, $type, $farmer_id, $image_path, $id])) {
            $success = "Produk berhasil diupdate!";
            $action = 'list';
        }
    }
}

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
$farmers = $pdo->query("SELECT * FROM farmers")->fetchAll();
$products = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC")->fetchAll();

include '../includes/header.php';
?>
<div class="admin-layout" style="display:grid;grid-template-columns:240px 1fr;min-height:100vh;">
<?php include '../includes/admin_sidebar.php'; ?>

    <main style="padding:3rem;background:var(--cream);">
        <header style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
            <h1 style="font-family:var(--ff-display);font-size:2.2rem;color:var(--brown);">Manajemen Produk</h1>
            <?php if($action == 'list'): ?>
                <a href="?action=add" class="add-btn" style="text-decoration:none;padding:.8rem 1.5rem;width:auto;">+ Produk Baru</a>
            <?php endif; ?>
        </header>

        <?php if($success): ?><div class="alert alert-success" style="background:#edf7ee;color:#2d5016;padding:1rem;margin-bottom:1.5rem;border:1px solid #d4e8d5;"><?= $success ?></div><?php endif; ?>
        <?php if($error): ?><div class="alert alert-error" style="background:#fcebea;color:#c0392b;padding:1rem;margin-bottom:1.5rem;border:1px solid #f5d1cf;"><?= $error ?></div><?php endif; ?>

        <?php if($action == 'list'): ?>
            <table style="width:100%;background:#fff;border-collapse:collapse;border:1px solid var(--border);">
                <thead style="background:var(--cream2);text-align:left;">
                    <tr>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Gambar</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Nama Produk</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Kategori</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Tipe</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Harga</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Stok</th>
                        <th style="padding:1rem;font-size:.85rem;border-bottom:1px solid var(--border);">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($products as $p): ?>
                    <tr style="border-bottom:1px solid var(--border);">
                        <td style="padding:1rem;">
                            <?php if($p['image']): ?>
                                <img src="../assets/img/products/<?= $p['image'] ?>" style="width:40px;height:40px;object-fit:cover;">
                            <?php else: ?>
                                <span style="font-size:1.5rem;">📦</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding:1rem;font-weight:500;"><?= $p['name'] ?></td>
                        <td style="padding:1rem;font-size:.85rem;"><?= $p['category_name'] ?></td>
                        <td style="padding:1rem;font-size:.8rem;text-transform:uppercase;"><?= $p['type'] ?></td>
                        <td style="padding:1rem;font-size:.85rem;">Rp <?= number_format($p['price'], 0, ',', '.') ?></td>
                        <td style="padding:1rem;font-size:.85rem;"><?= $p['stock'] ?> <?= $p['unit'] ?></td>
                        <td style="padding:1rem;">
                            <a href="?action=edit&id=<?= $p['id'] ?>" style="color:var(--green);font-size:.8rem;text-decoration:none;margin-right:.8rem;">Edit</a>
                            <a href="?action=delete&id=<?= $p['id'] ?>" style="color:#c0392b;font-size:.8rem;text-decoration:none;" onclick="return confirm('Hapus produk ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <?php
            $p = ['name'=>'','description'=>'','price'=>'','unit'=>'pcs','stock'=>0,'category_id'=>'','type'=>'cafe','farmer_id'=>'','image'=>''];
            if($action == 'edit' && isset($_GET['id'])) {
                $p_stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                $p_stmt->execute([$_GET['id']]);
                $p = $p_stmt->fetch();
            }
            ?>
            <form method="POST" enctype="multipart/form-data" style="background:#fff;padding:2rem;border:1px solid var(--border);max-width:800px;">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?? '' ?>">
                <input type="hidden" name="existing_image" value="<?= $p['image'] ?>">
                
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">
                    <div>
                        <div class="form-group"><label>Nama Produk</label><input type="text" name="name" value="<?= $p['name'] ?>" required></div>
                        <div class="form-group"><label>Deskripsi</label><textarea name="description" style="width:100%;height:100px;border:1px solid var(--border);padding:.7rem;font-family:var(--ff-body);"><?= $p['description'] ?></textarea></div>
                        <div class="form-group"><label>Harga (Rp)</label><input type="number" name="price" value="<?= $p['price'] ?>" required></div>
                        <div class="form-group"><label>Satuan (misal: pcs, 250g, cup)</label><input type="text" name="unit" value="<?= $p['unit'] ?>" required></div>
                    </div>
                    <div>
                        <div class="form-group"><label>Stok</label><input type="number" name="stock" value="<?= $p['stock'] ?>" required></div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" style="width:100%;padding:.7rem;border:1px solid var(--border);font-family:var(--ff-body);">
                                <?php foreach($categories as $c): ?>
                                    <option value="<?= $c['id'] ?>" <?= $p['category_id'] == $c['id'] ? 'selected' : '' ?>><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tipe Produk</label>
                            <select name="type" style="width:100%;padding:.7rem;border:1px solid var(--border);font-family:var(--ff-body);">
                                <option value="cafe" <?= $p['type'] == 'cafe' ? 'selected' : '' ?>>Menu Kafe</option>
                                <option value="market" <?= $p['type'] == 'market' ? 'selected' : '' ?>>Produk Petani (Market)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Petani (Opsional)</label>
                            <select name="farmer_id" style="width:100%;padding:.7rem;border:1px solid var(--border);font-family:var(--ff-body);">
                                <option value="">-- Pilih Petani --</option>
                                <?php foreach($farmers as $f): ?>
                                    <option value="<?= $f['id'] ?>" <?= $p['farmer_id'] == $f['id'] ? 'selected' : '' ?>><?= $f['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group"><label>Gambar Produk</label><input type="file" name="image" accept="image/*"></div>
                    </div>
                </div>
                <div style="margin-top:2rem;">
                    <button type="submit" class="auth-btn" style="width:auto;padding:1rem 3rem;">Simpan Produk</button>
                    <a href="products.php" style="margin-left:1.5rem;color:var(--text-mid);text-decoration:none;font-size:.9rem;">Batal</a>
                </div>
            </form>
        <?php endif; ?>
    </main>
</div>
<?php include '../includes/footer.php'; ?>
