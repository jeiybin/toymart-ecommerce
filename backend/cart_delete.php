<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    exit;
}

$cart_id = (int) ($_POST['cart_id'] ?? 0);

if ($cart_id <= 0) {
    http_response_code(400);
    exit;
}

mysqli_query($conn, "
    DELETE FROM cart_items 
    WHERE cart_id = $cart_id
");

echo "deleted";
