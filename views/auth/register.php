<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register | Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="auth-page">

<!-- HEADER -->
<div class="login-header">
    <a href="/webtoymart/index.php" class="login-logo">
        <i class="fa-solid fa-bag-shopping"></i>
        <span>TOYMART</span>
    </a>
</div>


<!-- CARD -->
<div class="auth-container">
    <div class="auth-card">

        <h2>Buat Akun Baru</h2>

        <!-- ALERT (DISIMPAN, TIDAK LANGSUNG MUNCUL) -->
        <div id="errorBox" class="alert-error">
            Password dan konfirmasi password tidak sama
        </div>

        <form id="registerForm" method="POST" action="../../backend/register.php">
            <input type="text" name="name" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Nomor Telepon" required>

            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm" placeholder="Konfirmasi Password" required>

            <button type="submit">Daftar</button>
        </form>

        <p class="register-text">
            Sudah punya akun? <a href="login.php">Login</a>
        </p>

    </div>
</div>

<script>
document.getElementById('registerForm').addEventListener('submit', function (e) {
    const pass = document.getElementById('password').value;
    const confirm = document.getElementById('confirm').value;
    const errorBox = document.getElementById('errorBox');

    if (pass !== confirm) {
        e.preventDefault();              // STOP submit
        errorBox.style.display = 'block';
    } else {
        errorBox.style.display = 'none';
    }
});
</script>

</body>
</html>
