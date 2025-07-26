<?php
// error.php - di lumbungdata.com

// Mulai sesi PHP
session_start();
error_log('[Error Page Debug] Session started. Session ID: ' . session_id());


// Ambil pesan error dari parameter URL
$errorMessage = $_GET['msg'] ?? 'Terjadi kesalahan tidak diketahui.';
$errorDetails = $_GET['details'] ?? '';
$errorCode = $_GET['code'] ?? 'N/A';
$errorTrace = $_GET['trace'] ?? '';

// --- Logging ke file error PHP server ---
error_log('[Error Page Debug] Error Message: ' . $errorMessage);
error_log('[Error Page Debug] Error Details: ' . $errorDetails);
error_log('[Error Page Debug] Error Code: ' . $errorCode);

if (!empty($errorTrace)) {
    $decodedTrace = urldecode($errorTrace);
    error_log('[Error Page Debug] Error Trace: ' . $decodedTrace);
} else {
    error_log('[Error Page Debug] No explicit trace provided in URL parameters.');
}

// Opsional: Log data sesi yang mungkin tersisa dari upaya login gagal
if (isset($_SESSION['user_id'])) {
    error_log('[Error Page Debug] User ID in session during error: ' . $_SESSION['user_id']);
}
if (isset($_SESSION['oauth_state'])) {
    error_log('[Error Page Debug] OAuth State in session during error: ' . $_SESSION['oauth_state']);
}

// Hapus variabel sesi yang mungkin tersisa dari upaya login yang gagal
unset($_SESSION['oauth_state']);
error_log('[Error Page Debug] OAuth State removed from session on error page.');

// unset($_SESSION['user_id']); // Hapus juga jika Anda ingin memaksa login ulang
// unset($_SESSION['user_email']); // Hapus juga jika Anda ingin memaksa login ulang


// --- Konten HTML Halaman Error ---
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesalahan Otentikasi</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; text-align: center; background-color: #f8d7da; color: #721c24; }
        .error-box {
            background-color: #f8d7da;
            padding: 30px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            max-width: 600px;
            margin: auto;
            margin-top: 50px;
        }
        h1 { color: #dc3545; }
        .go-home-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .go-home-button:hover {
            background-color: #0056b3;
        }
        pre {
            background-color: #ffebe8;
            border: 1px solid #f5c6cb;
            padding: 10px;
            text-align: left;
            overflow-x: auto;
            word-break: break-all; /* Memastikan teks panjang tidak merusak layout */
            white-space: pre-wrap; /* Memastikan baris pecah */
        }
    </style>
</head>
<body>
    <div class="error-box">
        <h1>Kesalahan Otentikasi!</h1>
        <p>Maaf, terjadi masalah saat mencoba login dengan Google.</p>
        <p><strong>Pesan:</strong> <?php echo htmlspecialchars($errorMessage); ?></p>
        <?php if (!empty($errorDetails)): ?>
            <p><strong>Detail:</strong> <?php echo htmlspecialchars($errorDetails); ?></p>
        <?php endif; ?>

        <?php if (!empty($errorCode) && $errorCode != 'N/A'): ?>
            <p><strong>Kode Error:</strong> <?php echo htmlspecialchars($errorCode); ?></p>
        <?php endif; ?>

        <?php if (!empty($errorTrace)): ?>
            <h3>Lacak Kesalahan:</h3>
            <pre><?php echo htmlspecialchars($decodedTrace); ?></pre>
            <p>Informasi ini telah dicatat untuk analisis lebih lanjut.</p>
        <?php endif; ?>

        <a href="https://lumbungdata.com/login.php" class="go-home-button">Kembali ke Halaman Login</a>
    </div>
</body>
</html>