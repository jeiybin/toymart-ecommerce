<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/auth/login.php');
    exit;
}

$id = $_POST['product_id'];

$name = $_POST['name'];
$brand = $_POST['brand'];
$toy_type = $_POST['toy_type'];
$character = $_POST['character_name'];
$price = $_POST['price'];
$stock = $_POST['stock'];
$image = $_POST['image_url'];

mysqli_query($conn, "
    UPDATE products SET
        name='$name',
        brand='$brand',
        toy_type='$toy_type',
        character_name='$character',
        price='$price',
        stock='$stock',
        image_url='$image'
    WHERE product_id='$id'
");

header("Location: ../views/admin/products.php");
exit;
