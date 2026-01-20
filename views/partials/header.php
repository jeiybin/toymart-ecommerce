<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include __DIR__ . '/../../config/database.php';

$brands     = mysqli_query($conn, "SELECT DISTINCT brand FROM products");
$categories = mysqli_query($conn, "SELECT DISTINCT toy_type FROM products");
$characters = mysqli_query($conn, "SELECT DISTINCT character_name FROM products");
?>

<header class="main-header">

    <!-- TOP -->
    <div class="header-top">
        <div class="logo">
            <a href="/webtoymart/views/user/home.php">TOYMART</a>
        </div>

        <div class="search-box">
            <form action="/webtoymart/views/user/search.php" method="GET">
                <input 
                    type="text" 
                    name="q"
                    placeholder="Cari nama / brand / kategori / karakter "
                    required
                    >

                </form>
        </div>


        <div class="header-right">
            <a href="/webtoymart/views/user/profile.php" class="icon-btn">
                <i class="fa-regular fa-user"></i>
            </a>
            <a href="/webtoymart/views/user/cart.php" class="icon-btn">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
        </div>
    </div>

    <!-- FILTER -->
    <div class="header-bottom">

        <!-- CHARACTER -->
        <div class="filter-group">
            <div class="filter-item">CHARACTER</div>
            <div class="filter-popup">
                <?php while ($ch = mysqli_fetch_assoc($characters)): ?>
                    <a href="filter.php?type=character&value=<?= urlencode($ch['character_name']) ?>">
                        <?= htmlspecialchars($ch['character_name']) ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- BRAND -->
        <div class="filter-group">
            <div class="filter-item">BRAND</div>
            <div class="filter-popup">
                <?php while ($b = mysqli_fetch_assoc($brands)): ?>
                    <a href="filter.php?type=brand&value=<?= urlencode($b['brand']) ?>">
                        <?= htmlspecialchars($b['brand']) ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

        <!-- CATEGORY -->
        <div class="filter-group">
            <div class="filter-item">CATEGORIES</div>
            <div class="filter-popup">
                <?php while ($c = mysqli_fetch_assoc($categories)): ?>
                    <a href="filter.php?type=category&value=<?= urlencode($c['toy_type']) ?>">
                        <?= htmlspecialchars($c['toy_type']) ?>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</header>

<script>
document.querySelectorAll('.filter-group').forEach(group => {
    const btn = group.querySelector('.filter-item');
    const popup = group.querySelector('.filter-popup');

    btn.addEventListener('click', e => {
        e.stopPropagation();

        document.querySelectorAll('.filter-popup').forEach(p => {
            if (p !== popup) p.style.display = 'none';
        });

        popup.style.display =
            popup.style.display === 'block' ? 'none' : 'block';
    });
});

document.addEventListener('click', () => {
    document.querySelectorAll('.filter-popup').forEach(p => {
        p.style.display = 'none';
    });
});
</script>
