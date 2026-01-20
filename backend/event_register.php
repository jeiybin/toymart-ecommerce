<?php
include '../config/database.php';

$nama    = $_POST['nama'] ?? '';
$email   = $_POST['email'] ?? '';
$no_telp = $_POST['no_telp'] ?? '';
$id_sesi = $_POST['id_sesi'] ?? '';

if (!$nama || !$email || !$no_telp || !$id_sesi) {
    header("Location: ../views/event/register.php");
    exit;
}

/* Ambil data sesi */
$sesi = mysqli_query($conn, "
    SELECT kode_sesi, kuota 
    FROM sesi_event 
    WHERE id_sesi = $id_sesi
");
$data_sesi = mysqli_fetch_assoc($sesi);

/* Hitung jumlah pendaftar */
$cek = mysqli_query($conn, "
    SELECT COUNT(*) AS total 
    FROM pendaftaran_event 
    WHERE id_sesi = $id_sesi
");
$data = mysqli_fetch_assoc($cek);

if ($data['total'] >= $data_sesi['kuota']) {
    header("Location: ../views/event/register.php?error=penuh");
    exit;
}

/* Urutan */
$urutan = $data['total'] + 1;

/* Nomor pengunjung */
$nomor_pengunjung =
    $data_sesi['kode_sesi'] .
    str_pad($urutan, 2, '0', STR_PAD_LEFT);

/* Simpan */
mysqli_query($conn, "
    INSERT INTO pendaftaran_event
    (nama, email, no_telp, id_sesi, urutan_sesi, nomor_pengunjung)
    VALUES
    ('$nama', '$email', '$no_telp', '$id_sesi', '$urutan', '$nomor_pengunjung')
");

header("Location: ../views/event/register.php?success=1&no=$nomor_pengunjung");
exit;
