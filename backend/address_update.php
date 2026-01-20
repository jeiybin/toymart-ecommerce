<?php
session_start();
include "../config/database.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/auth/login.php");
    exit;
}

$user_id = (int) $_SESSION['user_id'];
$address = mysqli_real_escape_string($conn, $_POST['address']);

mysqli_query($conn, "
    UPDATE users 
    SET address = '$address'
    WHERE user_id = $user_id
");

header("Location: ../views/user/address.php");
exit;
