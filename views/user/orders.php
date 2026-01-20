<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$status = $_GET['status'] ?? 'dikemas';

/* ambil order */
$orders = mysqli_query($conn, "
    SELECT * FROM orders
    WHERE user_id = $user_id
    AND status = '$status'
    ORDER BY created_at DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Saya | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="page-wrapper">

    <!-- SIDEBAR -->
    <div class="profile-sidebar">
        <a href="profile.php"><i class="fa-regular fa-user"></i> Akun Saya</a>
        <a class="active"><i class="fa-regular fa-clipboard"></i> Pesanan Saya</a>
        <a href="../../backend/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Log out</a>
    </div>

    <!-- CONTENT -->
    <div class="content">

        <h2>Pesanan Saya</h2>

        <!-- TAB STATUS -->
        <div class="order-tabs">
            <a href="?status=dikemas" class="<?= $status=='dikemas'?'active':'' ?>">Dikemas</a>
            <a href="?status=dikirim" class="<?= $status=='dikirim'?'active':'' ?>">Dikirim</a>
            <a href="?status=selesai" class="<?= $status=='selesai'?'active':'' ?>">Selesai</a>
        </div>

        <?php if (mysqli_num_rows($orders) == 0): ?>
            <div class="empty-order">
                <i class="fa-regular fa-file-lines"></i>
                <p>Belum ada pesanan</p>
            </div>
        <?php endif; ?>

        <?php while ($order = mysqli_fetch_assoc($orders)): ?>

        <?php
            $order_id = $order['order_id'];

            $items = mysqli_query($conn, "
                SELECT 
                    oi.quantity,
                    oi.price,
                    p.name,
                    p.image_url
                FROM order_items oi
                JOIN products p ON p.product_id = oi.product_id
                WHERE oi.order_id = $order_id
            ");
        ?>

        <div class="order-card">

            <div class="order-header">
                <span><?= date('d M Y', strtotime($order['created_at'])) ?></span>
            </div>

            <?php while ($item = mysqli_fetch_assoc($items)): ?>
                <div class="order-item">
                    <img src="<?= htmlspecialchars($item['image_url']) ?>">
                    <div class="order-info">
                        <strong><?= htmlspecialchars($item['name']) ?></strong>
                        <small>
                            Rp <?= number_format($item['price'],0,',','.') ?> × <?= $item['quantity'] ?>
                        </small>
                    </div>
                    <div class="order-subtotal">
                        Rp <?= number_format($item['price'] * $item['quantity'],0,',','.') ?>
                    </div>
                </div>
            <?php endwhile; ?>

            <div class="order-footer">
                <strong>Total Pesanan</strong>
                <span>Rp <?= number_format($order['total_amount'],0,',','.') ?></span>
            </div>

            <?php if ($order['status'] == 'dikirim'): ?>
                <form method="POST" action="../../backend/order_complete.php">
                    <input type="hidden" name="order_id" value="<?= $order_id ?>">
                    <button class="btn-primary">
                        Selesaikan Pesanan
                    </button>
                </form>
            <?php endif; ?>

        </div>

        <?php endwhile; ?>

    </div>
</div>

</body>
</html>
