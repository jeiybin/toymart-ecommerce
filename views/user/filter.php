<?php
session_start();
include '../../config/database.php';

if (!isset($_GET['type']) || !isset($_GET['value'])) {
    die('Filter tidak valid');
}

$type  = $_GET['type'];
$value = mysqli_real_escape_string($conn, $_GET['value']);

switch ($type) {
    case 'character':
        $sql = "SELECT * FROM products WHERE character_name = '$value'";
        $title = "Karakter - $value";
        break;

    case 'brand':
        $sql = "SELECT * FROM products WHERE brand = '$value'";
        $title = "Brand - $value";
        break;

    case 'category':
        $sql = "SELECT * FROM products WHERE toy_type = '$value'";
        $title = "Kategori - $value";
        break;

    default:
        die('Filter tidak valid');
}

$products = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<h2 class="section-title" style="margin-left: 2rem;"><?= htmlspecialchars($title) ?></h2>

<div class="product-grid">
<?php if (mysqli_num_rows($products) == 0): ?>
    <p style="padding:30px">Produk tidak ditemukan</p>
<?php else: ?>
    <?php while ($p = mysqli_fetch_assoc($products)): ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($p['image_url']) ?>">

            <div class="product-info">
                <small><?= strtoupper($p['toy_type']) ?></small>
                <h4><?= htmlspecialchars($p['name']) ?></h4>

                <p class="price">
                    Rp <?= number_format($p['price'],0,',','.') ?>
                </p>

                <!-- ADD TO CART -->
                <form method="POST" action="../../backend/cart_add.php">
                    <input type="hidden" name="product_id"
                           value="<?= (int)$p['product_id'] ?>">
                    <button type="submit" class="btn-add">
                        Tambah
                    </button>
                </form>

            </div>
        </div>
    <?php endwhile; ?>
<?php endif; ?>
</div>


</body>
</html>
