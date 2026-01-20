<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = (int) $_SESSION['user_id'];

$user = mysqli_query($conn, "SELECT name, address FROM users WHERE user_id = $user_id");
$data = mysqli_fetch_assoc($user);

$isEdit = isset($_GET['edit']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Alamat Saya | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="page-wrapper">

    <!-- SIDEBAR -->
    <div class="profile-sidebar">
        <a href="profile.php">
            <i class="fa-regular fa-user"></i> Akun Saya
        </a>
        <a href="orders.php">
            <i class="fa-regular fa-clipboard"></i> Pesanan Saya
        </a>
        <a href="../../backend/logout.php">
            <i class="fa-solid fa-right-from-bracket"></i> Log out
        </a>
    </div>

    <div class="content">
        <h2>Alamat Saya</h2>

        <div class="address-box">

            <?php if (!$isEdit): ?>
                <!-- VIEW MODE -->
                <i class="fa-solid fa-location-dot"></i>

                <div class="address-info">
                    <strong><?= htmlspecialchars($data['name']) ?></strong>
                    <p>
                        <?= $data['address'] 
                            ? nl2br(htmlspecialchars($data['address'])) 
                            : 'Alamat belum diisi' ?>
                    </p>
                </div>

                <a href="?edit=1" class="address-btn">Ubah</a>

            <?php else: ?>
                <!-- EDIT MODE -->
                <form method="POST" action="../../backend/address_update.php" class="address-form">
                    <label>Alamat Lengkap</label>
                    <textarea name="address" rows="5" required><?= htmlspecialchars($data['address']) ?></textarea>
                    <button type="submit" class="address-btn">Simpan Alamat</button>
                </form>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>
