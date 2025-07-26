<?php
session_start(); // Mulai sesi PHP

// Variabel untuk menampung pesan dan tipe pesan
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validasi di sisi server
    if (empty($user_email)) {
        $errors['user_email'] = "Email wajib diisi.";
    } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $errors['user_email'] = "Format email tidak valid.";
    }

    if (empty($user_pass)) {
        $errors['user_pass'] = "Password wajib diisi.";
    } elseif (strlen($user_pass) < 6) {
        $errors['user_pass'] = "Password minimal 6 karakter.";
    }

    if (empty($user_pass_confirm)) {
        $errors['user_pass_confirm'] = "Konfirmasi password wajib diisi.";
    } elseif ($user_pass !== $user_pass_confirm) {
        $errors['user_pass_confirm'] = "Password dan konfirmasi password tidak cocok.";
    }

    if (empty($user_publicname)) {
        $errors['user_publicname'] = "Nama Publik wajib diisi.";
    } elseif (strlen($user_publicname) < 3) {
        $errors['user_publicname'] = "Nama Publik minimal 3 karakter.";
    }

    if (!is_numeric($user_status)) {
        $errors['user_status'] = "Status pengguna harus berupa angka.";
    }

    if (!empty($user_url) && !filter_var($user_url, FILTER_VALIDATE_URL)) {
        $errors['user_url'] = "Format URL tidak valid.";
    }

    if (empty($errors)) {
        $data = [
            'user_email' => $user_email,
            'user_pass' => $user_pass,
            'user_status' => (int)$user_status,
            'user_publicname' => $user_publicname,
            'user_url' => $user_url
        ];

        $api_url = 'https://api.lumbungdata.com/register';

        $ch = curl_init($api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($ch);
        curl_close($ch);

        if ($response === false) {
            $message = "Kesalahan koneksi API: " . htmlspecialchars($curl_error);
            $message_type = "error";
        } else {
            $response_data = json_decode($response);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $message = "Gagal memproses respons API: Data bukan JSON valid.";
                $message_type = "error";
            } else {
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
                } else {
                    $message = "Gagal menambahkan pengguna. Status HTTP: " . $http_code . ". Pesan: " . htmlspecialchars($response_data->message ?? 'Terjadi kesalahan tidak dikenal.');
                    $message_type = "error";
                }
            }
        }
    } else {
        $message = "Terdapat kesalahan input. Mohon periksa kembali form Anda.";
        $message_type = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LumbungData - Daftar</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Variabel Warna */
        :root {
            --primary-blue: #87CEEB; /* Biru langit (Sky Blue) */
            --dark-brown: #4A2B13; /* Cokelat gelap untuk aksen utama dan teks */
            --light-bg: #F8F8F8; /* Latar belakang sangat terang, sedikit hangat */
            --white: #ffffff;
            --text-dark: #333333; /* Teks gelap umum */
            --border-light: #D4CFC7; /* Border terang yang harmonis dengan cokelat */
            --shadow-light: rgba(0, 0, 0, 0.08);
            --shadow-medium: rgba(0, 0, 0, 0.15); /* Sedikit lebih kuat untuk kontras dengan cokelat */
            --error-red: #D32F2F; /* Warna merah untuk pesan error */
            --success-green: #28a745; /* Warna hijau untuk pesan sukses */
        }

        /* General Body Styling */
        body {
            font-family: 'Public Sans', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--light-bg);
            color: var(--text-dark);
            box-sizing: border-box;
            line-height: 1.6;
        }

        /* Kontainer Utama Form Pendaftaran */
        .signup-form-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px var(--shadow-medium);
            max-width: 700px; /* Lebar yang lebih optimal untuk form pendaftaran dengan 2 kolom */
            width: 90%;
            display: flex;
            flex-direction: column;
            gap: 15px; /* Jarak antar elemen form */
            border: 1px solid var(--border-light);
            margin: auto;
            position: relative;
            z-index: 1;
        }

        /* Logo LumbungData di dalam kontainer form (opsional, jika ingin tetap tampil) */
        .lumbungdata-logo-small {
            font-size: 2.2em;
            color: var(--dark-brown);
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-title {
            text-align: center;
            font-size: 1.8em;
            color: var(--dark-brown);
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9em;
            color: var(--dark-brown);
            font-weight: 500;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="number"],
        .form-group input[type="url"] {
            width: calc(100% - 24px); /* Kurangi padding */
            padding: 12px 12px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-size: 1.05rem;
            color: var(--text-dark);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.3);
            outline: none;
        }

        /* Flex container for horizontal password fields */
        .password-group-container {
            display: flex;
            gap: 20px; /* Space between password fields */
            margin-bottom: 15px; /* Add margin-bottom to this container instead of individual form-groups */
        }

        .password-group-container .form-group {
            flex: 1; /* Each form-group takes equal space */
            margin-bottom: 0; /* Remove individual margin-bottom from grouped items */
        }

        .button-container {
            text-align: right;
            margin-top: 20px;
            display: flex;
            justify-content: flex-end; /* Rata kanan */
            gap: 10px; /* Jarak antar tombol */
            flex-wrap: wrap; /* Izinkan tombol wrap ke baris baru jika tidak cukup ruang */
        }

        .button {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            white-space: nowrap; /* Mencegah teks tombol patah ke baris baru */
        }

        .button.save-button {
            background-color: var(--primary-blue);
            color: var(--dark-brown);
            box-shadow: 0 4px 10px rgba(135, 206, 235, 0.3);
        }
        .button.save-button:hover {
            background-color: #6CB9DA;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(135, 206, 235, 0.4);
        }

        .button.back-button {
            background-color: var(--dark-brown);
            color: var(--white);
            box-shadow: 0 4px 10px rgba(74, 43, 19, 0.2);
        }
        .button.back-button:hover {
            background-color: #3A220F;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(74, 43, 19, 0.3);
        }

        .message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            font-weight: 500;
            border: 1px solid;
        }
        .success {
            background-color: #e6ffed;
            color: var(--success-green);
            border-color: #b2dfdb;
        }
        .error {
            background-color: #ffe6e6;
            color: var(--error-red);
            border-color: #f5c6cb;
        }
        .validation-error {
            color: var(--error-red);
            font-size: 0.8em;
            margin-top: 5px;
            text-align: left;
        }

        /* Responsiveness */
        @media (max-width: 768px) {
            .signup-form-container {
                padding: 30px;
                max-width: 90%;
            }
            .lumbungdata-logo-small {
                font-size: 2em;
            }
            .form-title {
                font-size: 1.6em;
            }
            .password-group-container {
                flex-direction: column; /* Stack password fields on small screens */
                gap: 0; /* Remove gap when stacked */
            }
            .password-group-container .form-group {
                margin-bottom: 15px; /* Restore margin for stacked fields */
            }
            .button-container {
                flex-direction: column;
                align-items: flex-end; /* Mengatur item untuk rata kanan ketika ditumpuk */
                gap: 10px;
            }
            .button {
                width: 100%; /* Tombol memenuhi lebar kontainer di mobile */
                /* Hapus max-width untuk memastikan lebar sama */
                /* Kita bisa tambahkan lebar spesifik jika memang diperlukan, contoh: width: 180px; */
            }
            /* Menambahkan lebar yang sama untuk kedua tombol di mobile */
            .button.back-button,
            .button.save-button {
                width: 180px; /* Atur lebar spesifik untuk kedua tombol di mobile */
                text-align: center; /* Pastikan teks di tengah jika tombol lebih lebar */
            }
        }

        @media (max-width: 480px) {
            .signup-form-container {
                padding: 25px;
            }
            .lumbungdata-logo-small {
                font-size: 1.8em;
            }
            .form-group input {
                padding: 10px 10px;
                font-size: 0.95rem;
            }
            /* Sesuaikan lebar tombol untuk layar yang lebih kecil lagi jika diperlukan */
            .button.back-button,
            .button.save-button {
                width: 160px; /* Sedikit lebih kecil untuk layar sangat kecil */
            }
        }
    </style>
</head>
<body>
    <div class="signup-form-container">
        <h1 class="lumbungdata-logo-small">LumbungData</h1>
        <h2 class="form-title">Daftar Pengguna Baru</h2>

        <?php if (!empty($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="signup.php" method="POST">
            <div class="form-group">
                <label for="user_publicname">Nama Publik:</label>
                <input type="text" id="user_publicname" name="user_publicname" value="<?php echo htmlspecialchars($user_publicname); ?>" required minlength="3" placeholder="Nama yang akan ditampilkan">
                <?php if (isset($errors['user_publicname'])): ?>
                    <div class="validation-error"><?php echo $errors['user_publicname']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_email">Email Pengguna:</label>
                <input type="email" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user_email); ?>" required placeholder="Alamat email Anda">
                <?php if (isset($errors['user_email'])): ?>
                    <div class="validation-error"><?php echo $errors['user_email']; ?></div>
                <?php endif; ?>
            </div>

            <div class="password-group-container">
                <div class="form-group">
                    <label for="user_pass">Password:</label>
                    <input type="password" id="user_pass" name="user_pass" required minlength="6" placeholder="Minimal 6 karakter">
                    <?php if (isset($errors['user_pass'])): ?>
                        <div class="validation-error"><?php echo $errors['user_pass']; ?></div>
                    <?php endif; ?>
                </div>

                <div class="form-group">
                    <label for="user_pass_confirm">Konfirmasi Password:</label>
                    <input type="password" id="user_pass_confirm" name="user_pass_confirm" required placeholder="Ulangi password Anda">
                    <?php if (isset($errors['user_pass_confirm'])): ?>
                        <div class="validation-error"><?php echo $errors['user_pass_confirm']; ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="user_status">Status Pengguna (Angka, Default: 0):</label>
                <input type="number" id="user_status" name="user_status" value="<?php echo htmlspecialchars($user_status); ?>" placeholder="Misal: 0">
                <?php if (isset($errors['user_status'])): ?>
                    <div class="validation-error"><?php echo $errors['user_status']; ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="user_url">URL Profil (Opsional):</label>
                <input type="url" id="user_url" name="user_url" value="<?php echo htmlspecialchars($user_url); ?>" placeholder="Contoh: https://lumbungdata.com/profil_saya">
                <?php if (isset($errors['user_url'])): ?>
                    <div class="validation-error"><?php echo $errors['user_url']; ?></div>
                <?php endif; ?>
            </div>

            <div class="button-container">
                <a href="/" class="button back-button">Kembali ke Login</a>
                <button type="submit" class="button save-button">Daftar</button>
            </div>
        </form>
    </div>
</body>
</html>