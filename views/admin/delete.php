<?php
session_start();
include '../../config/database.php';

/* ===============================
   PROTEKSI ADMIN
   =============================== */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../auth/login.php');
    exit;
}

/* ===============================
   AMBIL ID PRODUK
   =============================== */
$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: products.php');
    exit;
}

/* ===============================
   HAPUS PRODUK
   =============================== */
mysqli_query($conn, "DELETE FROM products WHERE product_id = '$id'");

/* ===============================
   REDIRECT KEMBALI
   =============================== */
header('Location: products.php');
exit;
