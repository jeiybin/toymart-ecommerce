<?php
session_start();
include '../../config/database.php';

/* PROTEKSI LOGIN */
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

/* AMBIL DATA USER */
$query = mysqli_query(
    $conn,
    "SELECT name, email, phone FROM users WHERE user_id = $user_id LIMIT 1"
);

if (!$query || mysqli_num_rows($query) === 0) {
    die("User tidak ditemukan");
}

$user = mysqli_fetch_assoc($query);

/* DATA */
$name  = $user['name'];
$email = $user['email'];
$phone = $user['phone'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<!-- ===== PROFILE ===== -->
<div class="profile-wrapper">

    <!-- SIDEBAR -->
    <div class="profile-sidebar">
        <a class="active"><i class="fa-regular fa-user"></i> Akun Saya</a>
        <a href="orders.php">
            <i class="fa-regular fa-clipboard"></i> Pesanan Saya
        </a>
        <a href="../../backend/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Log out
        </a>
    </div>

    <!-- CONTENT -->
    <div class="profile-content">
        <h2>Profil Saya</h2>

        <div class="profile-card">

            <div class="profile-right">

                <div class="field">
                    <label>Nama : </label>
                    <span><?= htmlspecialchars($name) ?></span>
                </div>

                <div class="field">
                    <label>Email : </label>
                    <span><?= htmlspecialchars($email) ?></span>
                </div>

                <div class="field">
                    <label>Nomor Telepon : </label>
                    <span><?= htmlspecialchars($phone ?: '-') ?></span>
                </div>

                <div class="address-box">
                    <i class="fa-solid fa-location-dot"></i>

                    <div class="address-info">
                        <strong>Alamat Saya</strong>
                        <p>Kelola alamat pengiriman</p>
                    </div>

                    <a href="address.php" class="address-btn">
                        Kelola
                    </a>
                </div>


            </div>

        </div>
    </div>

</div>

</body>
</html>
