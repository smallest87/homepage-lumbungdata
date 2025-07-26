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
        /* Variabel Warna Baru */
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

        /* Main Container for the entire page content */
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 1000px; /* Sedikit lebih lebar untuk dekorasi garis */
            padding: 30px; /* Padding sedikit lebih besar */
            gap: 80px;
            flex-wrap: wrap;
            position: relative; /* Diperlukan untuk garis vertikal absolut */
        }

        /* Garis Dekorasi Vertikal */
        .main-container::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            height: 80%; /* Tinggi garis disesuaikan */
            width: 1px; /* Ketebalan garis */
            background-color: var(--accent-line);
            z-index: 0; /* Pastikan di belakang konten */
            display: block; /* Sembunyikan pada mobile */
        }

        /* Left Section (Branding) */
        .left-section {
            flex: 1;
            max-width: 450px;
            text-align: left;
            padding-right: 20px;
            z-index: 1; /* Di atas garis dekorasi */
        }

        /* Styling for LumbungData Logo */
        .lumbungdata-logo {
            font-size: 3.2em;
            color: var(--dark-brown); /* Logo utama menjadi cokelat gelap */
            font-weight: 700;
            margin-bottom: 15px;
            line-height: 1;
            display: block;
        }

        .left-section p {
            font-size: 1.3em;
            line-height: 1.4;
            color: var(--text-dark); /* Teks slogan juga cokelat gelap atau mendekati */
            margin-top: 0;
            font-weight: 300;
        }

        /* Right Section (Login Form Container) */
        .right-section {
            flex: 1;
            max-width: 380px;
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px var(--shadow-medium); /* Bayangan lebih jelas */
            display: flex;
            flex-direction: column;
            gap: 20px;
            border: 1px solid var(--border-light);
            z-index: 1; /* Di atas garis dekorasi */
        }

        .form-title {
            text-align: center;
            font-size: 1.8em;
            color: var(--dark-brown); /* Judul form menjadi cokelat gelap */
            margin-bottom: 25px;
            font-weight: 600;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 15px;
            position: relative; /* Untuk garis dekorasi input */
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: calc(100% - 24px);
            padding: 12px 12px;
            border: 1px solid var(--border-light);
            border-radius: 8px;
            font-size: 1.05rem;
            color: var(--text-dark);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="password"]:focus {
            border-color: var(--primary-blue); /* Border fokus biru langit */
            box-shadow: 0 0 0 3px rgba(135, 206, 235, 0.3); /* Glow biru langit */
            outline: none;
        }

        /* Garis Dekorasi Bawah Input (opsional) */
        .form-group input {
            position: relative;
            z-index: 2; /* Di atas garis dekorasi jika ada */
        }
        /* .form-group::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background-color: var(--border-light);
            transition: background-color 0.3s ease;
            z-index: 1;
        } */
        /* .form-group input:focus + ::after {
            background-color: var(--primary-blue);
        } */


        .button {
            width: 100%;
            padding: 15px 0;
            background-color: var(--primary-blue); /* Tombol utama biru langit */
            color: var(--dark-brown); /* Teks tombol utama cokelat gelap untuk kontras */
            border: none;
            border-radius: 8px;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 10px rgba(135, 206, 235, 0.3); /* Bayangan biru langit */
        }

        .button:hover {
            background-color: #6CB9DA; /* Biru langit lebih gelap saat hover */
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(135, 206, 235, 0.4);
        }

        .link-text {
            text-align: center;
            font-size: 0.9em;
        }

        .link-text a {
            color: var(--primary-blue); /* Link menjadi biru langit */
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .link-text a:hover {
            text-decoration: underline;
            color: #6CB9DA; /* Biru langit lebih gelap saat hover */
        }

        .separator {
            border-top: 1px solid var(--border-light);
            margin: 20px 0;
        }

        .create-account-button {
            display: block;
            width: fit-content;
            padding: 12px 25px;
            background-color: var(--dark-brown); /* Tombol sekunder cokelat gelap */
            color: var(--white); /* Teks putih untuk kontras */
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            text-decoration: none;
            margin: 0 auto;
            box-shadow: 0 4px 10px rgba(74, 43, 19, 0.2); /* Bayangan cokelat gelap */
        }

        .create-account-button:hover {
            background-color: #3A220F; /* Cokelat gelap lebih gelap saat hover */
            transform: translateY(-1px);
            box-shadow: 0 6px 15px rgba(74, 43, 19, 0.3);
        }

        /* Responsiveness */
        @media (max-width: 850px) {
            .main-container {
                flex-direction: column;
                padding-top: 50px;
                gap: 40px;
            }

            .main-container::before {
                display: none; /* Sembunyikan garis vertikal pada tampilan mobile */
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
            <form class="login-form">
                <div class="form-group">
                    <input type="text" id="email" placeholder="Email atau Nama Pengguna" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" placeholder="Kata Sandi" required>
                </div>
                <button type="submit" class="button">Masuk</button>
            </form>
            <div class="link-text">
                <a href="#">Lupa Kata Sandi?</a>
            </div>
            <div class="separator"></div>
            <a href="https://lumbungdata.com/signup.php" class="create-account-button">Buat Akun Baru</a>
        </div>
    </div>
</body>
</html>