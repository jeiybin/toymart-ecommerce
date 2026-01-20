<?php
session_start();
include '../../config/database.php';

/* ===============================
   PROTEKSI ADMIN
   =============================== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

/* ===============================
   AMBIL ID PRODUK
   =============================== */
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: products.php');
    exit;
}

/* ===============================
   AMBIL DATA PRODUK
   =============================== */
$result = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$id'");
$product = mysqli_fetch_assoc($result);

if (!$product) {
    header('Location: products.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="admin-header">
        <h2>Edit Produk</h2>

        <div class="dropdown">
            <button class="dot-btn">⋮</button>
            <div class="dropdown-menu">
                <a href="products.php">
                    <i class="fa-solid fa-box"></i> Produk
                </a>
                <a href="orders.php">
                    <i class="fa-solid fa-clipboard-list"></i> Pesanan
                </a>
            </div>
        </div>
    </div>

    <!-- ===== FORM EDIT ===== -->
    <div class="form-wrapper">

        <form action="../../backend/update_product.php" method="POST">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
            </div>

            <div class="form-group">
                <label>Jenis Mainan</label>
                <input type="text" name="toy_type" value="<?= htmlspecialchars($product['toy_type']) ?>">
            </div>

            <div class="form-group">
                <label>Karakter</label>
                <input type="text" name="character_name" value="<?= htmlspecialchars($product['character_name']) ?>">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" value="<?= $product['price'] ?>" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" value="<?= $product['stock'] ?>" required>
            </div>

            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url" value="<?= htmlspecialchars($product['image_url']) ?>">
            </div>

            <div class="form-action">
                <a href="products.php" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save"></i> Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
