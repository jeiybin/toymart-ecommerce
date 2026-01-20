<?php
session_start();
include '../../config/database.php';

$q = $_GET['q'] ?? '';
$q_safe = mysqli_real_escape_string($conn, $q);

$products = mysqli_query($conn, "
    SELECT * FROM products
    WHERE
        name LIKE '%$q_safe%' OR
        brand LIKE '%$q_safe%' OR
        toy_type LIKE '%$q_safe%' OR
        character_name LIKE '%$q_safe%'
    ORDER BY name ASC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="page-container">

    <?php if (mysqli_num_rows($products) == 0): ?>
        <p>Tidak ada produk ditemukan.</p>
    <?php endif; ?>

    <div class="product-grid">
        <?php while ($p = mysqli_fetch_assoc($products)): ?>
            <div class="product-card">
                <img src="<?= $p['image_url'] ?>" alt="">
                <h4><?= htmlspecialchars($p['name']) ?></h4>
                <p><?= htmlspecialchars($p['brand']) ?></p>
                <strong>Rp <?= number_format($p['price'],0,',','.') ?></strong>
            </div>
        <?php endwhile; ?>
    </div>
</div>

</body>
</html>
