<?php
session_start();
include "../config/database.php";

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$query = mysqli_query($conn, "
    SELECT user_id, name, password_hash, role 
    FROM users 
    WHERE email = '$email'
");

$user = mysqli_fetch_assoc($query);

if ($user && password_verify($password, $user['password_hash'])) {

    // simpan session
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['role']    = $user['role'];

    // redirect berdasarkan role
    if ($user['role'] === 'admin') {
        header("Location: ../views/admin/orders.php");
    } else {
        header("Location: ../views/user/home.php");
    }
    exit;

} else {
    echo "<script>
        alert('Email atau password salah');
        window.location.href = '../views/auth/login.php';
    </script>";
}
