<?php
include '../../config/database.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pendaftaran Event</title>

    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

<div class="event-wrapper">
    <div class="event-card">
        <h2>Pendaftaran Event</h2>

        <form action="../../backend/event_register.php" method="POST">
            <input type="text" name="nama" placeholder="Masukkan nama" required>
            <input type="email" name="email" placeholder="Masukkan email" required>
            <input type="text" name="no_telp" placeholder="No telepon" required>

            <select name="id_sesi" required>
                <option value="">Pilih sesi</option>
                <?php
                $q = mysqli_query($conn, "
                    SELECT s.id_sesi, s.jam_mulai, s.jam_selesai,
                           (s.kuota - COUNT(p.id_daftar)) AS sisa
                    FROM sesi_event s
                    LEFT JOIN pendaftaran_event p ON s.id_sesi = p.id_sesi
                    GROUP BY s.id_sesi
                ");

                while ($row = mysqli_fetch_assoc($q)) {
                    $disabled = ($row['sisa'] <= 0) ? 'disabled' : '';
                    echo "<option value='{$row['id_sesi']}' $disabled>
                        {$row['jam_mulai']} - {$row['jam_selesai']} (Sisa {$row['sisa']})
                    </option>";
                }
                ?>
            </select>

            <button type="submit">Daftar</button>
        </form>
    </div>
</div>

<!-- ===== POPUP SUCCESS ===== -->
<?php if (isset($_GET['success']) && isset($_GET['no'])): ?>
<div class="modal-overlay" id="successModal">
    <div class="modal-card">
        <h2>Pendaftaran Berhasil 🎉</h2>
        <p>Nomor Pengunjung Anda</p>

        <div class="visitor-number">
            <?= htmlspecialchars($_GET['no']); ?>
        </div>

        <p class="modal-note">
            Harap datang sesuai sesi yang dipilih.
        </p>

        <button onclick="window.location.href='../user/home.php'">OK</button>
    </div>
</div>
<?php endif; ?>

<script>
function closeModal() {
    const modal = document.getElementById('successModal');
    if (modal) modal.style.display = 'none';

    // bersihkan query string agar modal tidak muncul lagi
    history.replaceState(null, '', window.location.pathname);
}
</script>

</body>
</html>
