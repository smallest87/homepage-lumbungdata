<?php
session_start(); // Mulai sesi PHP

// Periksa apakah pengguna sudah login
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    // Jika sudah login, langsung arahkan ke dashboard
    header('Location: dashboard.php');
    exit(); // Penting untuk menghentikan eksekusi skrip setelah redirect
}

// Jika belum login, lanjutkan dengan menampilkan halaman selamat datang
$nama_pengguna = "Teman"; // Default, bisa disesuaikan jika Anda punya logika nama pengguna yang berbeda
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%);
            color: #333;
            text-align: center;
            overflow: hidden;
        }
        .container {
            background-color: #ffffff;
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 90%;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeInRise 1s ease-out forwards;
        }
        h1 {
            color: #4a90e2;
            font-size: 2.8em;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.05);
        }
        p {
            font-size: 1.2em;
            line-height: 1.6;
            color: #555;
            margin-bottom: 30px;
        }
        .button-group {
            margin-top: 30px;
        }
        .button {
            display: inline-block;
            background-color: #4a90e2;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin: 0 10px;
        }
        .button:hover {
            background-color: #357bd8;
            transform: translateY(-2px);
        }
        .button.login {
            background-color: #28a745;
        }
        .button.login:hover {
            background-color: #218838;
        }
        /* New style for the Daftar button */
        .button.daftar {
            background-color: #ffc107; /* A yellow/orange color */
            color: #333; /* Darker text for contrast */
        }
        .button.daftar:hover {
            background-color: #e0a800; /* Darker yellow/orange on hover */
        }

        /* Keyframe Animations */
        @keyframes fadeInRise {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Halo, <?php echo htmlspecialchars($nama_pengguna); ?>!</h1>
        <p>Selamat datang di website kami. Kami senang Anda ada di sini. Jelajahi berbagai fitur dan konten yang telah kami siapkan untuk Anda.</p>

        <div class="button-group">
            <a href="#" class="button">Mulai Sekarang</a>
            <a href="login.php" class="button login">Login</a>
            <a href="https://lumbungdata.com/signup.php" class="button daftar">Daftar</a>
        </div>
    </div>
</body>
</html>