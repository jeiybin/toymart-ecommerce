<?php
session_start();
include '../config/database.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../views/auth/login.php');
    exit;
}

$name      = $_POST['name'];
$brand     = $_POST['brand'];
$toy_type  = $_POST['toy_type'];
$character = $_POST['character_name'];
$price     = $_POST['price'];
$stock     = $_POST['stock'];
$image     = $_POST['image_url'];

mysqli_query($conn, "
    INSERT INTO products (name, brand, toy_type, character_name, price, stock, image_url)
    VALUES ('$name','$brand','$toy_type','$character','$price','$stock','$image')
");

header("Location: ../views/admin/products.php");
exit;
