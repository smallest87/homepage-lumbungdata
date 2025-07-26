<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pengguna Baru</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 15px; }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="number"],
        .form-group input[type="url"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        .form-group input:focus {
            border-color: #007bff;
            outline: none;
            box-shadow: 0 0 0 0.1rem rgba(0, 123, 255, 0.25);
        }
        .buttons-container {
            text-align: right;
            margin-top: 20px;
        }
        .buttons-container button,
        .buttons-container a {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            margin-left: 10px;
        }
        .buttons-container .save-button {
            background-color: #28a745;
            color: white;
        }
        .buttons-container .save-button:hover {
            background-color: #218838;
        }
        .buttons-container .back-button {
            background-color: #6c757d;
            color: white;
        }
        .buttons-container .back-button:hover {
            background-color: #5a6268;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        .success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .validation-error { color: red; font-size: 0.85em; margin-top: 5px; }
        /* Gaya untuk Debug Log */
        .debug-log {
            background-color: #e0e0e0;
            padding: 15px;
            border-radius: 8px;
            margin-top: 30px;
            border: 1px solid #ccc;
            max-width: 900px; /* Lebar maksimum seperti di view_jadwal.php */
            margin-left: auto;
            margin-right: auto;
            overflow-x: auto; /* Untuk scroll horizontal jika log terlalu panjang */
        }
        .debug-log h3 {
            margin-top: 0;
            color: #333;
        }
        .debug-log pre {
            background-color: #f0f0f0;
            padding: 10px;
            border-radius: 4px;
            white-space: pre-wrap; /* Mempertahankan spasi dan baris baru, tapi memecah baris panjang */
            word-wrap: break-word; /* Memecah kata panjang */
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Daftar Pengguna Baru</h2>

        <?php
        // Inisialisasi array log untuk ditampilkan di halaman
        $debug_output = [];
        function log_message($message) {
            global $debug_output;
            // Handle array/object for logging
            if (is_array($message) || is_object($message)) {
                $message = var_export($message, true);
            }
            $debug_output[] = date('Y-m-d H:i:s') . " - " . $message;
        }

        log_message("Halaman signup.php diakses pada " . date('Y-m-d H:i:s'));

        $message = "";
        $message_type = "";
        $errors = [];

        // Mengambil nilai POST untuk mengisi kembali form jika ada error
        $user_email = $_POST['user_email'] ?? '';
        $user_pass = $_POST['user_pass'] ?? '';
        $user_pass_confirm = $_POST['user_pass_confirm'] ?? '';
        $user_publicname = $_POST['user_publicname'] ?? '';
        $user_status = $_POST['user_status'] ?? '0';
        $user_url = $_POST['user_url'] ?? '';

        log_message("Data POST yang diterima: " . json_encode($_POST));

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            log_message("Metode request adalah POST. Memulai validasi.");

            // Validasi di sisi server
            if (empty($user_email)) {
                $errors['user_email'] = "Email wajib diisi.";
                log_message("Validasi Gagal: Email kosong.");
            } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
                $errors['user_email'] = "Format email tidak valid.";
                log_message("Validasi Gagal: Format email tidak valid: " . $user_email);
            }

            if (empty($user_pass)) {
                $errors['user_pass'] = "Password wajib diisi.";
                log_message("Validasi Gagal: Password kosong.");
            } elseif (strlen($user_pass) < 6) {
                $errors['user_pass'] = "Password minimal 6 karakter.";
                log_message("Validasi Gagal: Password terlalu pendek.");
            }

            if (empty($user_pass_confirm)) {
                $errors['user_pass_confirm'] = "Konfirmasi password wajib diisi.";
                log_message("Validasi Gagal: Konfirmasi password kosong.");
            } elseif ($user_pass !== $user_pass_confirm) {
                $errors['user_pass_confirm'] = "Password dan konfirmasi password tidak cocok.";
                log_message("Validasi Gagal: Password dan konfirmasi tidak cocok.");
            }

            if (empty($user_publicname)) {
                $errors['user_publicname'] = "Nama Publik wajib diisi.";
                log_message("Validasi Gagal: Nama Publik kosong.");
            } elseif (strlen($user_publicname) < 3) {
                $errors['user_publicname'] = "Nama Publik minimal 3 karakter.";
                log_message("Validasi Gagal: Nama Publik terlalu pendek.");
            }

            if (!is_numeric($user_status)) {
                 $errors['user_status'] = "Status pengguna harus berupa angka.";
                 log_message("Validasi Gagal: Status pengguna bukan angka: " . $user_status);
            }

            if (!empty($user_url) && !filter_var($user_url, FILTER_VALIDATE_URL)) {
                $errors['user_url'] = "Format URL tidak valid.";
                log_message("Validasi Gagal: Format URL tidak valid: " . $user_url);
            }

            if (empty($errors)) {
                log_message("Validasi di sisi server berhasil. Mengirim data ke API.");
                $data = [
                    'user_email' => $user_email,
                    'user_pass' => $user_pass,
                    'user_status' => (int)$user_status,
                    'user_publicname' => $user_publicname,
                    'user_url' => $user_url
                ];

                $api_url = 'https://api.lumbungdata.com/register';
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
                $curl_errno = curl_errno($ch); // Ambil curl errno untuk debug lebih lanjut
                curl_close($ch);

                log_message("cURL execution completed.");
                log_message("HTTP Status Code received: " . $http_code);
                log_message("cURL Error (if any): [{$curl_errno}] " . ($curl_error ? $curl_error : 'No error'));
                log_message("Raw API Response: " . ($response ? $response : 'Empty response'));

                if ($response === false) {
                    $message = "Kesalahan koneksi API: " . htmlspecialchars($curl_error) . " (Kode: {$curl_errno})";
                    $message_type = "error";
                    log_message("Kesalahan koneksi API (cURL error): " . $curl_error . " (Kode: {$curl_errno})");
                } else {
                    $response_data = json_decode($response);

                    if (json_last_error() !== JSON_ERROR_NONE) {
                        $message = "Gagal memproses respons API: Data bukan JSON valid. Pesan: " . json_last_error_msg();
                        $message_type = "error";
                        log_message("Respon API bukan JSON valid: " . $response);
                    } else {
                        log_message("Decoded API Response (Object):");
                        log_message($response_data);

                        if ($http_code == 201) {
                            $message = $response_data->message ?? 'Pengguna berhasil ditambahkan. Silakan login.';
                            $message_type = "success";
                            // Kosongkan form setelah sukses registrasi
                            $user_email = '';
                            $user_pass = '';
                            $user_pass_confirm = '';
                            $user_publicname = '';
                            $user_status = '0';
                            $user_url = '';
                            log_message("Pengguna berhasil didaftarkan (HTTP 201). Pesan: " . ($response_data->message ?? 'N/A'));
                        } else {
                            $message = "Gagal menambahkan pengguna. Status HTTP: " . $http_code . ". Pesan: " . htmlspecialchars($response_data->message ?? 'Terjadi kesalahan tidak dikenal.');
                            $message_type = "error";
                            log_message("Gagal mendaftar pengguna. HTTP: " . $http_code . ", Pesan API: " . ($response_data->message ?? 'N/A'));
                        }
                    }
                }
            } else {
                $message = "Terdapat kesalahan input. Mohon periksa kembali form Anda.";
                $message_type = "error";
                log_message("Validasi di sisi server gagal. Kesalahan: " . json_encode($errors));
            }
        } else {
            log_message("Metode request adalah GET.");
        }

        if (!empty($message)) {
            log_message("Pesan ditampilkan di halaman: " . $message . " (Tipe: " . $message_type . ")");
        }
        ?>

        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="user_publicname">Nama Publik:</label>
                <input type="text" id="user_publicname" name="user_publicname" value="<?php echo htmlspecialchars($user_publicname); ?>" required minlength="3">
                <?php if (isset($errors['user_publicname'])): ?>
                    <div class="validation-error"><?php echo $errors['user_publicname']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_email">Email Pengguna:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>" required>
                <?php if (isset($errors['user_email'])): ?>
                    <div class="validation-error"><?php echo $errors['user_email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_pass">Password:</label>
                <input type="password" id="user_pass" name="user_pass" required minlength="6">
                <?php if (isset($errors['user_pass'])): ?>
                    <div class="validation-error"><?php echo $errors['user_pass']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_pass_confirm">Konfirmasi Password:</label>
                <input type="password" id="user_pass_confirm" name="user_pass_confirm" required>
                <?php if (isset($errors['user_pass_confirm'])): ?>
                    <div class="validation-error"><?php echo $errors['user_pass_confirm']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_status">Status Pengguna (Angka, Default: 0):</label>
                <input type="number" id="user_status" name="user_status" value="<?php echo htmlspecialchars($user_status); ?>">
                <?php if (isset($errors['user_status'])): ?>
                    <div class="validation-error"><?php echo $errors['user_status']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_url">URL Profil (Opsional):</label>
                <input type="url" id="user_url" name="user_url" value="<?php echo htmlspecialchars($user_url); ?>">
                <?php if (isset($errors['user_url'])): ?>
                    <div class="validation-error"><?php echo $errors['user_url']; ?></div>
                <?php endif; ?>
            </div>

            <div class="buttons-container">
                <a href="view_user.php" class="back-button">Kembali ke Daftar</a>
                <button type="submit" class="save-button">Daftar</button>
            </div>
        </form>
    </div>

    <?php if (!empty($debug_output)): ?>
    <div class="debug-log">
        <h3>Debug Log `signup.php`:</h3>
        <pre><?php echo implode("\n", $debug_output); ?></pre>
    </div>
    <?php endif; ?>

</body>
</html>