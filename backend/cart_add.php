<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

$user_id    = (int) $_SESSION['user_id'];
$product_id = (int) $_POST['product_id'];

/* CEK PRODUK SUDAH ADA DI CART */
$cek = mysqli_query($conn, "
    SELECT cart_id 
    FROM cart_items 
    WHERE user_id = $user_id 
      AND product_id = $product_id
");

if (!$cek) {
    die("Query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($cek) > 0) {
    // update quantity
    mysqli_query($conn, "
        UPDATE cart_items 
        SET quantity = quantity + 1 
        WHERE user_id = $user_id 
          AND product_id = $product_id
    ");
} else {
    // insert baru
    mysqli_query($conn, "
        INSERT INTO cart_items (user_id, product_id, quantity) 
        VALUES ($user_id, $product_id, 1)
    ");
}

/* REDIRECT KE HALAMAN CART */
header("Location: ../views/user/cart.php");
exit;
