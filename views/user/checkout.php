<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

/* ambil alamat user */
$user = mysqli_query($conn, "
    SELECT name, address 
    FROM users 
    WHERE user_id = $user_id
");
$userData = mysqli_fetch_assoc($user);

/* ambil item cart */
$cart = mysqli_query($conn, "
    SELECT 
        c.quantity,
        p.name,
        p.price,
        p.image_url
    FROM cart_items c
    JOIN products p ON p.product_id = c.product_id
    WHERE c.user_id = $user_id
");

$total = 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Checkout | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="checkout-wrapper">

    <h2>Checkout</h2>

    <!-- ALAMAT -->
    <div class="checkout-box">
        <h4><i class="fa-solid fa-location-dot"></i> Alamat Pengiriman</h4>
        <strong><?= htmlspecialchars($userData['name']) ?></strong>
        <p>
            <?= $userData['address'] 
                ? nl2br(htmlspecialchars($userData['address'])) 
                : 'Alamat belum diisi' ?>
        </p>
    </div>

    <!-- PESANAN -->
    <div class="checkout-box">
        <h4>Pesanan</h4>

        <?php while ($item = mysqli_fetch_assoc($cart)): ?>
            <?php
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
            ?>
            <div class="checkout-item">
                <img src="<?= htmlspecialchars($item['image_url']) ?>">
                <div class="checkout-info">
                    <strong><?= htmlspecialchars($item['name']) ?></strong>
                    <p>
                        Rp <?= number_format($item['price'],0,',','.') ?>
                        × <?= $item['quantity'] ?>
                    </p>
                </div>
                <div class="checkout-subtotal">
                    Rp <?= number_format($subtotal,0,',','.') ?>
                </div>
            </div>
        <?php endwhile; ?>

        <div class="checkout-total">
            <strong>Total Pesanan</strong>
            <span>Rp <?= number_format($total,0,',','.') ?></span>
        </div>
    </div>

    <!-- BUTTON -->
    <div class="dhkajsdb" style="display: flex; justify-content: flex-end;">   

        <div class="checkout-action" style="width:150px; ">
            <a href="payment.php" class="checkout-btn" style="display: flex; justify-content: center; align-items: center;">
                Pembayaran
            </a>
        </div>
    </div>


    
</div>
</body>
</html>
