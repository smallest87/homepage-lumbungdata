<?php
session_start(); // Mulai sesi PHP

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Jika belum login, arahkan kembali ke halaman login
    header('Location: login.php');
    exit();
}

// Ambil username dari sesi
$username = $_SESSION['username'] ?? 'Pengguna'; // Default jika username tidak ada di sesi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #e0f2f7 0%, #c2e0e9 100%);
            color: #333;
            text-align: center;
        }
        .dashboard-container {
            background-color: #ffffff;
            padding: 50px 70px;
            border-radius: 15px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
            max-width: 700px;
            width: 90%;
            animation: fadeInScale 0.8s ease-out forwards;
        }
        h1 {
            color: #2c3e50;
            font-size: 3em;
            margin-bottom: 20px;
            letter-spacing: 1px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.05);
        }
        p {
            font-size: 1.3em;
            line-height: 1.7;
            color: #555;
            margin-bottom: 40px;
        }
        .logout-button {
            display: inline-block;
            background-color: #e74c3c;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .logout-button:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
        }

        /* Keyframe Animation */
        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>Anda telah berhasil masuk ke dashboard. Di sini Anda dapat menemukan fitur-fitur dan informasi penting.</p>
        <p>Ini adalah area yang dilindungi dan hanya dapat diakses setelah login berhasil.</p>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>
</html>
