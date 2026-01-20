<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$cart_id = (int) ($_POST['cart_id'] ?? 0);
$action  = $_POST['action'] ?? '';

if ($cart_id <= 0 || !in_array($action, ['plus', 'minus'])) {
    http_response_code(400);
    exit;
}

if ($action === 'plus') {
    mysqli_query($conn, "
        UPDATE cart_items 
        SET quantity = quantity + 1 
        WHERE cart_id = $cart_id
    ");
}

if ($action === 'minus') {
    // kurangi qty tapi jangan sampai < 1
    mysqli_query($conn, "
        UPDATE cart_items 
        SET quantity = GREATEST(quantity - 1, 1)
        WHERE cart_id = $cart_id
    ");
}

echo "ok";
