<?php
// logout.php - di lumbungdata.com

session_start();
error_log('[Logout Page Debug] Session started. Session ID: ' . session_id());


// Hapus semua variabel sesi
$_SESSION = array();
error_log('[Logout Page Debug] Session variables cleared.');

// Hancurkan sesi
session_destroy();
error_log('[Logout Page Debug] Session destroyed.');


// Arahkan pengguna kembali ke halaman login atau beranda
header('Location: https://lumbungdata.com/login.php'); // Atau halaman beranda
exit();
?>