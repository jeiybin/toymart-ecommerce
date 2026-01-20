<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['payment_method'])) {
    header('Location: payment.php');
    exit;
}

$user_id = (int)$_SESSION['user_id'];
$payment = $_POST['payment_method'];

/* ambil cart */
$cart = mysqli_query($conn, "
    SELECT c.product_id, c.quantity, p.price
    FROM cart_items c
    JOIN products p ON p.product_id = c.product_id
    WHERE c.user_id = $user_id
");

if (mysqli_num_rows($cart) == 0) {
    die("Cart kosong");
}

/* hitung total */
$total = 0;
$items = [];
while ($row = mysqli_fetch_assoc($cart)) {
    $subtotal = $row['price'] * $row['quantity'];
    $total += $subtotal;
    $items[] = $row;
}

/* insert orders */
mysqli_query($conn, "
    INSERT INTO orders (user_id, status, total_amount)
    VALUES ($user_id, 'Dikemas', $total)
");

$order_id = mysqli_insert_id($conn);

/* insert order_items */
foreach ($items as $i) {
    mysqli_query($conn, "
        INSERT INTO order_items (order_id, product_id, quantity, price)
        VALUES (
            $order_id,
            {$i['product_id']},
            {$i['quantity']},
            {$i['price']}
        )
    ");
}

/* hapus cart */
mysqli_query($conn, "DELETE FROM cart_items WHERE user_id = $user_id");

/* simpan payment ke session */
$_SESSION['payment_method'] = $payment;

header("Location: payment_confirm.php");
exit;
