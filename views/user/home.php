<?php
session_start();
include '../../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$products = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY product_id DESC LIMIT 6"
);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Home - Toymart</title>

    <link rel="stylesheet" href="../../assets/css/style.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include '../partials/header.php'; ?>

<!-- ================= BANNER ================= -->
<div class="banner">

    <a href="../event/register.php">
        <img src="../../assets/img/banner_event.jpg" class="slide active">
    </a>

    <img src="../../assets/img/banner2.jpg" class="slide">
    <img src="../../assets/img/banner3.jpg" class="slide">

    <div class="arrow left" onclick="prevSlide()">❮</div>
    <div class="arrow right" onclick="nextSlide()">❯</div>

    <div class="dots">
        <span class="dot active" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
</div>

<!-- ===== PRODUK ===== -->
<div class="product-grid">
<?php while ($p = mysqli_fetch_assoc($products)): ?>
    <div class="product-card">
        <img src="<?= htmlspecialchars($p['image_url']) ?>">

        <div class="product-info">
            <small><?= strtoupper($p['toy_type']) ?></small>
            <h4><?= htmlspecialchars($p['name']) ?></h4>
            <p class="price">
                Rp <?= number_format($p['price'],0,',','.') ?>
            </p>

            <!-- ADD TO CART -->
            <form method="POST" action="../../backend/cart_add.php">
                <input type="hidden" name="product_id" value="<?= $p['product_id'] ?>">
                <button type="submit" class="btn-add">Tambah</button>
            </form>
        </div>
    </div>
<?php endwhile; ?>
</div>

</body>

<script>
let currentIndex = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.dot');

function showSlide(i) {
    slides.forEach((s, idx) => {
        s.classList.toggle('active', idx === i);
        dots[idx].classList.toggle('active', idx === i);
    });
}
function nextSlide() {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
}
function prevSlide() {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
}
function currentSlide(i) {
    currentIndex = i;
    showSlide(i);
}
</script>
</html>
