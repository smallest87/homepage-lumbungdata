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
        /* Your existing CSS */
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
        .signup-form-container {
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px var(--shadow-medium);
            max-width: 700px;
            width: 90%;
            display: flex;
            flex-direction: column;
            gap: 15px;
            border: 1px solid var(--border-light);
            margin: auto;
            position: relative;
            z-index: 1;
        }
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
            width: calc(100% - 24px);
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
        .password-group-container {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        .password-group-container .form-group {
            flex: 1;
            margin-bottom: 0;
        }
        .button-container {
            text-align: right;
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            flex-wrap: wrap;
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
            white-space: nowrap;
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
                flex-direction: column;
                gap: 0;
            }
            .password-group-container .form-group {
                margin-bottom: 15px;
            }
            .button-container {
                flex-direction: column;
                align-items: flex-end;
                gap: 10px;
            }
            .button {
                width: 100%;
            }
            .button.back-button,
            .button.save-button {
                width: 180px;
                text-align: center;
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
            .button.back-button,
            .button.save-button {
                width: 160px;
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

        <form action="/signup" method="POST"> <div class="form-group">
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
