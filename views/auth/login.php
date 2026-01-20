<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="auth-page">

<!-- ===== HEADER ===== -->
<div class="login-header">
    <a href="/webtoymart/index.php" class="login-logo">
        <i class="fa-solid fa-bag-shopping"></i>
        <span>TOYMART</span>
    </a>
</div>

<!-- ===== LOGIN CARD ===== -->
<div class="auth-container">
    <div class="auth-card">

        <!-- ===== ALERT ERROR ===== -->
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert-error">
                <?= $_SESSION['error']; ?>
            </div>
        <?php 
            unset($_SESSION['error']); 
        endif; 
        ?>

        <h2>Log in</h2>

        <form method="POST" action="../../backend/auth.php">
            <input type="email" name="email" placeholder="Masukkan email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Log in</button>
        </form>

        <div class="register-text">
            Belum punya akun?
            <a href="register.php">Daftar</a>
        </div>

    </div>
</div>

</body>
</html>
