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
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="admin-header">
        <h2>Tambah Produk</h2>
    </div>

    <!-- ===== FORM TAMBAH ===== -->
    <div class="form-wrapper">

        <form action="../../backend/add_product.php" method="POST">

            <div class="form-group">
                <label>Nama Produk</label>
                <input type="text" name="name" placeholder="Nama produk" required>
            </div>

            <div class="form-group">
                <label>Brand</label>
                <input type="text" name="brand" placeholder="Brand produk" required>
            </div>

            <div class="form-group">
                <label>Jenis Mainan</label>
                <input type="text" name="toy_type" placeholder="Contoh: Action Figure">
            </div>

            <div class="form-group">
                <label>Karakter</label>
                <input type="text" name="character_name" placeholder="Contoh: Iron Man">
            </div>

            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="price" placeholder="Harga produk" required>
            </div>

            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stock" placeholder="Jumlah stok" required>
            </div>

            <div class="form-group">
                <label>Image URL</label>
                <input type="text" name="image_url" placeholder="https://...">
            </div>

            <div class="form-action">
                <a href="products.php" class="btn-secondary">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-plus"></i> Tambah Produk
                </button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
