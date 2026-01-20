<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$cart = mysqli_query($conn, "
    SELECT 
        c.cart_id,
        c.quantity,
        p.name,
        p.price,
        p.image_url
    FROM cart_items c
    JOIN products p ON p.product_id = c.product_id
    WHERE c.user_id = $user_id
");

if (!$cart) {
    die("Query error: " . mysqli_error($conn));
}

$total = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="cart-page">
    <div class="cart-wrapper">

        <h2 class="cart-title">Keranjang</h2>

        <?php if (mysqli_num_rows($cart) === 0): ?>
            <p class="cart-empty">Keranjang masih kosong</p>
        <?php else: ?>

            <?php while ($item = mysqli_fetch_assoc($cart)): ?>
                <?php
                    $subtotal = $item['price'] * $item['quantity'];
                    $total += $subtotal;
                ?>
                <div class="cart-item">

                    <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">

                    <div class="cart-info">
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <p>Total Rp <?= number_format($subtotal,0,',','.') ?></p>

                        <div class="qty">
                            <button onclick="updateQty(<?= $item['cart_id'] ?>,'minus')">−</button>
                            <span><?= $item['quantity'] ?></span>
                            <button onclick="updateQty(<?= $item['cart_id'] ?>,'plus')">+</button>
                        </div>
                    </div>

                    <button class="hapus" onclick="deleteItem(<?= $item['cart_id'] ?>)">
                        Hapus
                    </button>

                </div>
            <?php endwhile; ?>

        <?php endif; ?>

        <div class="cart-footer">
            <strong>Total &nbsp; Rp <?= number_format($total,0,',','.') ?></strong>
            <a href="checkout.php" class="checkout-btn">Checkout</a>
        </div>

    </div>
</div>

<script>
function updateQty(cartId, action) {
    fetch('../../backend/cart_update.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId + '&action=' + action
    }).then(() => location.reload());
}

function deleteItem(cartId) {
    if (!confirm('Hapus item ini?')) return;

    fetch('../../backend/cart_delete.php', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'cart_id=' + cartId
    }).then(() => location.reload());
}
</script>

</body>
</html>
