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
   FILTER STATUS
   =============================== */
$status = $_GET['status'] ?? 'all';
$where  = "";

if ($status !== 'all') {
    $status = mysqli_real_escape_string($conn, $status);
    $where  = "WHERE o.status = '$status'";
}

/* ===============================
   QUERY PESANAN (SUDAH BENAR)
   =============================== */
$sql = "
    SELECT 
        o.order_id,
        o.total_amount,
        o.status,
        o.created_at,
        u.name
    FROM orders o
    JOIN users u ON u.user_id = o.user_id
    $where
    ORDER BY o.created_at DESC
";

$orders = mysqli_query($conn, $sql);

if (!$orders) {
    die("Query error: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin – Pesanan</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="admin-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="admin-header">
        <h2>Pesanan</h2>

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

    <!-- ===== TAB STATUS ===== -->
    <div class="admin-tabs">
        <a href="?status=all"      class="<?= $status==='all' ? 'active' : '' ?>">Semua</a>
        <a href="?status=dikemas"  class="<?= $status==='dikemas' ? 'active' : '' ?>">Dikemas</a>
        <a href="?status=dikirim"  class="<?= $status==='dikirim' ? 'active' : '' ?>">Dikirim</a>
        <a href="?status=selesai"  class="<?= $status==='selesai' ? 'active' : '' ?>">Selesai</a>
    </div>

    <!-- ===== LIST PESANAN ===== -->
    <?php if (mysqli_num_rows($orders) == 0): ?>
        <div class="empty-state">
            <i class="fa-regular fa-clipboard"></i>
            <p>Belum ada pesanan</p>
        </div>
    <?php endif; ?>

    <?php while ($o = mysqli_fetch_assoc($orders)): ?>
        <div class="admin-order-card">

            <div>
                <strong>Order #<?= $o['order_id'] ?></strong>
                <p><?= htmlspecialchars($o['name']) ?></p>
                <small><?= date('d M Y H:i', strtotime($o['created_at'])) ?></small>
            </div>

            <div>
                <strong>Rp <?= number_format($o['total_amount'], 0, ',', '.') ?></strong>
                <span class="status <?= $o['status'] ?>">
                    <?= strtoupper($o['status']) ?>
                </span>
            </div>

            <!-- ===== AKSI ADMIN ===== -->
            <?php if ($o['status'] === 'dikemas'): ?>
                <form action="../../backend/update_status.php" method="POST">
                    <input type="hidden" name="order_id" value="<?= $o['order_id'] ?>">
                    <input type="hidden" name="status" value="dikirim">
                    <button class="btn-primary">Kirim</button>
                </form>
            <?php endif; ?>

        </div>
    <?php endwhile; ?>

</div>

</body>
</html>
