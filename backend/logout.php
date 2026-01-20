<?php
session_start();

/* HAPUS SEMUA DATA SESSION */
session_unset();
session_destroy();

/* BALIK KE HALAMAN LOGIN */
header("Location: ../views/auth/login.php");
exit;
