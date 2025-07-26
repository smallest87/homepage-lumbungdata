<?php
session_start(); // Mulai sesi PHP

$pesan_error = '';

// Cek apakah ada data POST yang dikirim (form disubmit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username_input = $_POST['username'] ?? '';
    $password_input = $_POST['password'] ?? '';

    // Kredensial hardcode (username: user123, password: password123)
    $username_valid = 'user123';
    $password_valid = 'password123'; // Dalam aplikasi nyata, ini akan menjadi HASHED password!

    // Lakukan verifikasi kredensial
    if ($username_input === $username_valid && $password_input === $password_valid) {
        // Kredensial cocok, set sesi dan arahkan ke dashboard
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $username_input; // Simpan username ke sesi
        header('Location: dashboard.php'); // Arahkan ke halaman dashboard
        exit(); // Penting untuk menghentikan eksekusi skrip setelah redirect
    } else {
        // Kredensial tidak cocok, tampilkan pesan error
        $pesan_error = 'Username atau password salah.';
    }
}

// Jika sudah login, langsung arahkan ke dashboard
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
        }
        .login-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }
        h2 {
            color: #4a90e2;
            margin-bottom: 30px;
            font-size: 2em;
        }
        .input-group {
            margin-bottom: 20px;
            text-align: left;
        }
        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }
        .input-group input[type="text"],
        .input-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .input-group input[type="text"]:focus,
        .input-group input[type="password"]:focus {
            border-color: #4a90e2;
            outline: none;
        }
        .error-message {
            color: #e74c3c;
            margin-bottom: 15px;
            font-size: 0.95em;
        }
        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .login-button:hover {
            background-color: #218838;
            transform: translateY(-1px);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Akun</h2>
        <?php if ($pesan_error): ?>
            <p class="error-message"><?php echo htmlspecialchars($pesan_error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Masuk</button>
        </form>
    </div>
</body>
</html>
