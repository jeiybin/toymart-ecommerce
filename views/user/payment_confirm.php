<?php
session_start();

if (!isset($_SESSION['payment_method'])) {
    header('Location: payment.php');
    exit;
}

$method = $_SESSION['payment_method'];

switch ($method) {
    case 'bank':
        $text = 'Transfer Bank';
        $desc = 'Silakan lakukan pembayaran via ATM / M-Banking.';
        break;
    case 'ewallet':
        $text = 'E-Wallet';
        $desc = 'Silakan scan QR E-Wallet.';
        break;
    case 'cod':
        $text = 'COD';
        $desc = 'Bayar saat barang diterima.';
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pembayaran</title>
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="payment-wrapper">
    <div class="payment-card info">

        <h2>Silakan lakukan pembayaran</h2>
        <p>Metode pembayaran: <strong><?= $text ?></strong></p>

        <div class="payment-desc"><?= $desc ?></div>

        <button class="checkout-btn" onclick="finishOrder()">
            Konfirmasi Pembayaran
        </button>

    </div>
</div>

<script>
function finishOrder(){
    alert("Pesanan telah dibuat");
    window.location.href = "home.php";
}
</script>

</body>
</html>
