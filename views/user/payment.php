<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pembayaran | Toymart</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>
<body>

<?php include '../partials/header.php'; ?>

<div class="payment-wrapper">
    <div class="payment-card">

        <h3>Pilih metode pembayaran</h3>

        <form method="POST" action="order_create.php">

            <label class="payment-option">
                <input type="radio" name="payment_method" value="bank" required>
                <span class="radio"></span>
                <div>
                    <strong>Transfer Bank</strong>
                    <small>ATM / M-Banking</small>
                </div>
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="ewallet">
                <span class="radio"></span>
                <div>
                    <strong>E-Wallet</strong>
                    <small>QR E-Wallet</small>
                </div>
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="cod">
                <span class="radio"></span>
                <div>
                    <strong>COD</strong>
                    <small>Bayar saat diterima</small>
                </div>
            </label>

            <button type="submit" class="checkout-btn">
                Buat Pesanan
            </button>

        </form>
    </div>
</div>


</body>
</html>
