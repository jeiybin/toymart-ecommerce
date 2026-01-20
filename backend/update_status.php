<?php
session_start();
include '../config/database.php';

/* proteksi admin */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../views/auth/login.php');
    exit;
}

/* validasi data */
if (!isset($_POST['order_id']) || !isset($_POST['status'])) {
    header('Location: ../../views/admin/orders.php');
    exit;
}

$order_id = (int) $_POST['order_id'];
$status   = mysqli_real_escape_string($conn, $_POST['status']);

/* update status pesanan */
mysqli_query($conn, "
    UPDATE orders 
    SET status = '$status'
    WHERE order_id = $order_id
");

/* feedback ke admin */
echo "
<script>
    alert('Pesanan berhasil dikirim');
    window.location.href = '../../webtoymart/views/admin/orders.php?status=dikirim';
</script>
";
