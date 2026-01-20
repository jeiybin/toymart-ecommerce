<?php
session_start();
include '../../config/database.php';

/* ===============================
   PROTEKSI ADMIN (KONSISTEN)
   =============================== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

/* ===============================
   AMBIL DATA PRODUK
   =============================== */
$products = mysqli_query($conn, "SELECT * FROM products ORDER BY product_id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="admin-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="admin-header">
        <h2>Produk</h2>

        <!-- titik tiga -->
        <div class="dropdown">
            <button class="dot-btn">⋮</button>
            <div class="dropdown-menu">
                <a href="products.php">
                    <i class="fa-solid fa-box"></i> Produk
                </a>
                <a href="orders.php">
                    <i class="fa-solid fa-clipboard-list"></i> Pesanan
                </a>

                <hr>

                <a href="../../backend/logout.php" class="logout">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </div>

    </div>

    <!-- ===== ACTION ===== -->
    <div class="page-action">
        <a href="add_product.php" class="btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <!-- ===== TABLE PRODUK ===== -->
    <div class="table-wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Brand</th>
                    <th>Jenis</th>
                    <th>Karakter</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($products) == 0): ?>
                    <tr>
                        <td colspan="9" style="text-align:center;">Belum ada produk</td>
                    </tr>
                <?php endif; ?>

                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($products)): ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['brand']) ?></td>
                    <td><?= htmlspecialchars($row['toy_type']) ?></td>
                    <td><?= htmlspecialchars($row['character_name']) ?></td>
                    <td>Rp <?= number_format($row['price'],0,',','.') ?></td>
                    <td><?= $row['stock'] ?></td>
                    <td>
                        <?php if (!empty($row['image_url'])): ?>
                            <img src="<?= $row['image_url'] ?>" class="product-img">
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td class="action-cell">
                        <a href="edit.php?id=<?= $row['product_id'] ?>" class="btn-icon edit">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                        <a href="delete.php?id=<?= $row['product_id'] ?>"
                           class="btn-icon delete"
                           onclick="return confirm('Yakin hapus produk ini?')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</div>

</body>
</html>
