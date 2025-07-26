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
        .input-group input[type="email"],
        .input-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }
        .input-group input[type="email"]:focus,
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
        /* Gaya untuk Debug Log */
        .debug-log {
            background-color: #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            border: 1px solid #ccc;
            max-width: 900px; /* Lebar maksimum */
            margin-left: auto;
            margin-right: auto;
            overflow-x: auto;
        }
        .debug-log h3 {
            margin-top: 0;
            color: #333;
        }
        .debug-log pre {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Akun</h2>
        <?php
        session_start(); // Mulai sesi PHP

        // Inisialisasi array log untuk ditampilkan di halaman
        $debug_output = [];
        function log_message($message) {
            global $debug_output;
            if (is_array($message) || is_object($message)) {
                $message = var_export($message, true);
            }
            $debug_output[] = date('Y-m-d H:i:s') . " - " . $message;
        }

        log_message("Halaman login.php diakses pada " . date('Y-m-d H:i:s'));

        $pesan_error = '';
        $user_email_input = $_POST['user_email'] ?? '';
        $password_input = $_POST['password'] ?? '';

        // Jika sudah login, langsung arahkan ke dashboard
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            log_message("Pengguna sudah login, mengarahkan ke dashboard.php");
            header('Location: dashboard.php');
            exit();
        }

        // Cek apakah ada data POST yang dikirim (form disubmit)
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            log_message("Metode request adalah POST. Memulai proses login.");
            log_message("Data POST yang diterima: " . json_encode($_POST));

            // Validasi input dasar
            if (empty($user_email_input) || empty($password_input)) {
                $pesan_error = 'Email dan password wajib diisi.';
                log_message("Validasi Gagal: Email atau password kosong.");
            } else {
                // Data yang akan dikirim ke API
                $data = [
                    'user_email' => $user_email_input,
                    'user_pass' => $password_input,
                ];

                $api_url = 'https://api.lumbungdata.com/login'; // Endpoint API untuk login
                log_message("URL API: " . $api_url);
                log_message("Data dikirim ke API: " . json_encode($data));

                $ch = curl_init($api_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

                $response = curl_exec($ch);
                $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $curl_error = curl_error($ch);
                $curl_errno = curl_errno($ch);
                curl_close($ch);

                log_message("cURL execution completed.");
                log_message("HTTP Status Code received: " . $http_code);
                log_message("cURL Error (if any): [{$curl_errno}] " . ($curl_error ? $curl_error : 'No error'));
                log_message("Raw API Response: " . ($response ? $response : 'Empty response'));

                if ($response === false) {
                    $pesan_error = "Kesalahan koneksi API: " . htmlspecialchars($curl_error) . " (Kode: {$curl_errno})";
                    log_message("Kesalahan koneksi API (cURL error): " . $curl_error . " (Kode: {$curl_errno})");
                } else {
                    $response_data = json_decode($response);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $pesan_error = "Gagal memproses respons API: Data bukan JSON valid. Pesan: " . json_last_error_msg();
                        log_message("Respon API bukan JSON valid: " . $response);
                    } else {
                        log_message("Decoded API Response (Object):");
                        log_message($response_data);

                        if ($http_code == 200) { // 200 OK untuk sukses login
                            $_SESSION['logged_in'] = true;
                            $_SESSION['user_email'] = $response_data->user_email ?? $user_email_input;
                            $_SESSION['jwt_token'] = $response_data->jwt ?? null;
                            $_SESSION['user_id'] = $response_data->user_id ?? null; // Jika API mengembalikan user ID
                            $_SESSION['user_publicname'] = $response_data->user_publicname ?? 'Pengguna'; // Simpan public name dari API

                            log_message("Login berhasil. Mengarahkan ke dashboard.php. Token JWT disimpan.");
                            header('Location: dashboard.php');
                            exit();
                        } else {
                            $pesan_error = htmlspecialchars($response_data->message ?? 'Email atau password salah.');
                            log_message("Login gagal. HTTP: " . $http_code . ", Pesan API: " . ($response_data->message ?? 'N/A'));
                        }
                    }
                }
            }
        }

        if ($pesan_error): ?>
            <p class="error-message"><?php echo htmlspecialchars($pesan_error); ?></p>
        <?php endif; ?>
        <form action="login.php" method="POST">
            <div class="input-group">
                <label for="user_email">Email:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user_email_input); ?>" required>
            </div>
            <div class="input-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="login-button">Masuk</button>
        </form>
    </div>

    <?php if (!empty($debug_output)): ?>
    <div class="debug-log">
        <h3>Debug Log `login.php`:</h3>
        <pre><?php echo implode("\n", $debug_output); ?></pre>
    </div>
    <?php endif; ?>
</body>
</html>