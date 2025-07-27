<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LumbungData - Login</title>
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
            --accent-line: rgba(74, 43, 19, 0.1); /* Garis dekorasi cokelat transparan */
            --error-red: #D32F2F; /* Warna merah untuk pesan error */
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
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 1000px;
            padding: 30px;
            gap: 80px;
            flex-wrap: wrap;
            position: relative;
        }
        .main-container::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            height: 80%;
            width: 1px;
            background-color: var(--accent-line);
            z-index: 0;
            display: block;
        }
        .left-section {
            flex: 1;
            max-width: 450px;
            text-align: left;
            padding-right: 20px;
            z-index: 1;
        }
        .lumbungdata-logo {
            font-size: 3.2em;
            color: var(--dark-brown);
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1;
            display: block;
        }
        .left-section p {
            font-size: 1.3em;
            line-height: 1.4;
            color: var(--text-dark);
            margin-top: 0;
            font-weight: 300;
        }
        .right-section {
            flex: 1;
            max-width: 380px;
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px var(--shadow-medium);
            display: flex;
            flex-direction: column;
            gap: 20px;
            border: 1px solid var(--border-light);
            z-index: 1;
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
            position: relative;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9em;
            color: var(--dark-brown);
            font-weight: 500;
        }
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="text"] {
            width: calc(100% - 24px);
            padding: 12px 12px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-size: 1.05rem;
            color: var(--text-dark);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }
        .form-group input[type="email"]:focus,
        .form-group input[type="password"]:focus,
        .form-group input[type="text"]:focus {
            border-color: var(--primary-blue);
            box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.3);
            outline: none;
        }
        .button {
            width: 100%;
            padding: 15px 0;
            background-color: var(--primary-blue);
            color: var(--dark-brown);
            border: none;
            border-radius: 8px;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(135, 206, 235, 0.3);
        }
        .button:hover {
            background-color: #6CB9DA;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(135, 206, 235, 0.4);
        }
        .link-text {
            text-align: center;
            font-size: 0.9em;
        }
        .link-text a {
            color: var(--primary-blue);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .link-text a:hover {
            text-decoration: underline;
            color: #6CB9DA;
        }
        .separator {
            border-top: 1px solid var(--border-light);
            margin: 20px 0;
        }
        .create-account-button {
            display: block;
            width: fit-content;
            padding: 12px 25px;
            background-color: var(--dark-brown);
            color: var(--white);
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            text-decoration: none;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(74, 43, 19, 0.2);
        }
        .create-account-button:hover {
            background-color: #3A220F;
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(74, 43, 19, 0.3);
        }
        .error-message {
            color: var(--error-red);
            margin-bottom: 15px;
            font-size: 0.95em;
            font-weight: 500;
            text-align: center;
        }
        @media (max-width: 850px) {
            .main-container {
                flex-direction: column;
                padding-top: 50px;
                gap: 40px;
            }
            .main-container::before {
                display: none;
            }
            .left-section, .right-section {
                text-align: center;
                max-width: 90%;
                padding-right: 0;
            }
            .right-section {
                padding: 30px;
            }
            .lumbungdata-logo {
                font-size: 2.8em;
            }
            .left-section p {
                font-size: 1.1em;
            }
        }
        @media (max-width: 480px) {
            .right-section {
                padding: 25px;
            }
            .form-group input {
                padding: 10px 10px;
                font-size: 0.95rem;
            }
            .button {
                font-size: 1.05rem;
                padding: 13px 0;
            }
            .create-account-button {
                font-size: 0.9rem;
                padding: 10px 20px;
            }
            .form-title {
                font-size: 1.5em;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="left-section">
            <h1 class="lumbungdata-logo">LumbungData</h1>
            <p>Bertumbuh untuk bermanfaat bagi orang lain.</p>
        </div>

        <div class="right-section">
            <h2 class="form-title">Login ke Akun Anda</h2>
            <?php if (!empty($pesan_error)): ?>
                <p class="error-message"><?php echo htmlspecialchars($pesan_error); ?></p>
            <?php endif; ?>
            <form action="/" method="POST"> <div class="form-group">
                    <label for="user_email">Email atau Nama Pengguna:</label>
                    <input type="text" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user_email_input); ?>" placeholder="Masukkan email atau nama pengguna Anda" required>
                </div>
                <div class="form-group">
                    <label for="password">Kata Sandi:</label>
                    <input type="password" id="password" name="password" placeholder="Masukkan kata sandi Anda" required>
                </div>
                <button type="submit" class="button">Masuk</button>
            </form>
            <div class="link-text">
                <a href="#">Lupa Kata Sandi?</a>
            </div>
            <div class="separator"></div>
            <a href="/signup" class="create-account-button">Buat Akun Baru</a> </div>
    </div>
</body>
</html>
