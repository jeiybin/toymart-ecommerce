<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['user_id'])) exit;

$order_id = (int)$_POST['order_id'];

mysqli_query($conn, "
    UPDATE orders
    SET status = 'selesai'
    WHERE order_id = $order_id
");

header('Location: ../views/user/orders.php?status=selesai');
