<?php
session_start();
include 'config/database.php';

$products = mysqli_query(
    $conn,
    "SELECT * FROM products ORDER BY product_id DESC LIMIT 6"
);

$brands     = mysqli_query($conn, "SELECT DISTINCT brand FROM products");
$categories = mysqli_query($conn, "SELECT DISTINCT toy_type FROM products");
$characters = mysqli_query($conn, "SELECT DISTINCT character_name FROM products");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Toymart</title>

    <!-- CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<!-- ================= HEADER ================= -->
<header class="main-header">
    <div class="header-top">

        <!-- LOGO -->
        <div class="logo">
            <a href="index.php">
                <i class="fa-solid fa-bag-shopping"></i> TOYMART
            </a>
        </div>

        <!-- SEARCH -->
        <div class="search-box">
            <form>
                <input type="text" placeholder="Cari mainan / kategori">
                <i class="fa-solid fa-magnifying-glass"></i>
            </form>
        </div>

        <!-- RIGHT -->
        <div class="header-right">
            <a href="views/auth/login.php" class="icon-btn">
                Login
            </a>
            <a href="views/auth/login.php" class="icon-btn">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Keranjang</span>
            </a>
        </div>

    </div>

    <!-- FILTER BAR -->
    <div class="header-bottom">

        <div class="filter-group">
            <span class="filter-item">CHARACTER</span>
            <div class="filter-popup">
                <?php while ($ch = mysqli_fetch_assoc($characters)): ?>
                    <a href="#"><?= htmlspecialchars($ch['character_name']) ?></a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-item">BRAND</span>
            <div class="filter-popup">
                <?php while ($b = mysqli_fetch_assoc($brands)): ?>
                    <a href="#"><?= htmlspecialchars($b['brand']) ?></a>
                <?php endwhile; ?>
            </div>
        </div>

        <div class="filter-group">
            <span class="filter-item">CATEGORIES</span>
            <div class="filter-popup">
                <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                    <a href="#"><?= htmlspecialchars($c['toy_type']) ?></a>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</header>

<!-- ================= BANNER ================= -->
<div class="banner">
    <img src="assets/img/banner1.jpg" class="slide active">
    <img src="assets/img/banner2.jpg" class="slide">
    <img src="assets/img/banner3.jpg" class="slide">
    <img src="assets/img/banner4.jpg" class="slide">

    <div class="arrow left" onclick="prevSlide()">❮</div>
    <div class="arrow right" onclick="nextSlide()">❯</div>

    <div class="dots">
        <span class="dot active" onclick="currentSlide(0)"></span>
        <span class="dot" onclick="currentSlide(1)"></span>
        <span class="dot" onclick="currentSlide(2)"></span>
    </div>
</div>

<!-- ================= PRODUK ================= -->
<div class="product-grid">
<?php while ($p = mysqli_fetch_assoc($products)): ?>
    <div class="product-card">
        <img src="<?= $p['image_url'] ?>" alt="">
        <div class="product-info">
            <small><?= strtoupper($p['toy_type']) ?></small>
            <h4><?= $p['name'] ?></h4>
            <p class="price">Rp <?= number_format($p['price'],0,',','.') ?></p>
            <a href="views/auth/login.php" class="btn-add">Tambah</a>
        </div>
    </div>
<?php endwhile; ?>
</div>

<!-- ================= SCRIPT ================= -->
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

/* FILTER */
document.querySelectorAll('.filter-group').forEach(group => {
    const btn = group.querySelector('.filter-item');
    const popup = group.querySelector('.filter-popup');

    btn.addEventListener('click', e => {
        e.stopPropagation();
        document.querySelectorAll('.filter-popup').forEach(p => {
            if (p !== popup) p.style.display = 'none';
        });
        popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
    });
});
document.addEventListener('click', () => {
    document.querySelectorAll('.filter-popup').forEach(p => p.style.display = 'none');
});
</script>

</body>
</html>
