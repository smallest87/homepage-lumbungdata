<?php
// views/layout/base.php

// Variabel seperti $pageTitle, $user_publicname, $articles, dll.
// diharapkan sudah didefinisikan di controller dan tersedia di sini.

// Pastikan jalur ke partials sudah benar relatif terhadap lokasi base.php
$partialsPath = __DIR__ . '/../partials/'; // Mengasumsikan partials satu level di atas layout

// Set default page title jika tidak disediakan
$pageTitle = $pageTitle ?? 'Aplikasi Elegan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ======================================================= */
        /* BASE STYLES (MOBILE FIRST & GENERAL) */
        /* ======================================================= */
        body {
            font-family: 'Open Sans', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
            background-color: #f4f7f6;
            color: #333;
            text-align: center;
            overflow-x: hidden; /* Mencegah scroll horizontal */
        }

        /* Box sizing global untuk kemudahan layout */
        *, *::before, *::after {
            box-sizing: border-box;
        }

        /* HEADER (TOP BAR) */
        .header-top {
            width: 100%;
            background-color: #8B0000;
            color: white;
            padding: 10px 15px; /* Default padding mobile */
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        .header-top .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.5em; /* Default ukuran mobile */
            font-weight: 700;
            color: white;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        /* HEADER CENTER NAV (TAB NAVIGASI) */
        .header-center-nav {
            display: none; /* Default disembunyikan di mobile */
        }

        .header-center-nav .nav-item {
            color: white;
            text-decoration: none;
            font-size: 1.05em;
            font-weight: 600;
            padding: 8px 12px;
            position: relative;
            transition: background-color 0.3s ease, border-radius 0.3s ease;
            border-radius: 5px;
            display: flex;
            align-items: center;
        }

        .header-center-nav .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }

        .header-center-nav .nav-item span.icon {
            font-size: 1.3em;
            margin-right: 8px;
            line-height: 1;
        }

        /* HEADER RIGHT ACTIONS (TOMBOL ADMIN) */
        .header-right-actions {
            display: flex;
            align-items: center;
            gap: 10px; /* Default jarak mobile */
        }

        .header-right-actions .action-icon-button {
            background: none;
            border: 1px solid rgba(255, 255, 255, 0.4);
            color: white;
            width: 32px; /* Default ukuran mobile */
            height: 32px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.1em;
            cursor: pointer;
            transition: background-color 0.3s ease, border-color 0.3s ease;
            text-decoration: none;
        }

        .header-right-actions .action-icon-button:hover {
            background-color: rgba(255, 255, 255, 0.25);
            border-color: white;
        }

        .header-right-actions .logout-button {
            background-color: #e74c3c;
            color: white;
            padding: 6px 12px; /* Default padding mobile */
            border-radius: 5px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.85em;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .header-right-actions .logout-button:hover {
            background-color: #c0392b;
            transform: translateY(-1px);
        }

        /* MAIN LAYOUT WRAPPER (MOBILE) */
        .main-layout-wrapper {
            display: flex;
            flex: 1; /* Mengambil sisa ruang vertikal */
            flex-direction: column; /* Default: stack vertikal di mobile */
            width: 100%;
            max-width: 100%; /* Lebar penuh di mobile */
            margin: 0;
            padding: 0 15px; /* Padding samping untuk mobile */
        }

        /* SIDEBAR KIRI (PENGATURAN) - MOBILE: SEMBUNYIKAN */
        .left-sidebar {
            display: none; /* Sembunyikan secara default */
        }

        /* KONTEN TENGAH - MOBILE */
        .main-content-area {
            flex: 1; /* Mengambil sisa ruang */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px 0; /* Padding vertikal mobile */
            overflow-y: auto;
            text-align: left;
            width: 100%;
        }

        .main-content-area h1 {
            font-family: 'Montserrat', sans-serif;
            color: #2c3e50;
            font-size: 1.8em; /* Default ukuran mobile */
            font-weight: 700;
            margin-bottom: 30px;
            text-align: center;
            width: 100%;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .article-cards-container {
            display: grid;
            grid-template-columns: 1fr; /* Selalu satu kolom */
            gap: 20px; /* Default jarak mobile */
            width: 100%;
            max-width: 600px; /* Kontrol lebar item */
            padding-bottom: 20px;
        }

        .article-card {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            padding: 20px; /* Default padding mobile */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border: 1px solid #eee;
        }

        .article-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .article-card h3 {
            font-family: 'Montserrat', sans-serif;
            color: #8B0000;
            font-size: 1.3em;
            font-weight: 600;
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .article-card .date {
            font-size: 0.8em;
            color: #95a5a6;
            margin-bottom: 10px;
        }

        .article-card p {
            font-size: 0.9em;
            line-height: 1.6;
            color: #555;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .article-card .read-more {
            font-size: 0.85em;
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .article-card .read-more:hover {
            color: #3498db;
        }

        /* SIDEBAR KANAN (TOPIK POPULER) - MOBILE: SEMBUNYIKAN */
        .right-sidebar {
            display: none; /* Sembunyikan secara default */
        }


        /* ======================================================= */
        /* MEDIA QUERIES UNTUK TAMPILAN DESKTOP ( >= 992px ) */
        /* ======================================================= */
        @media (min-width: 992px) {
            /* HEADER (TOP BAR) */
            .header-top {
                padding: 15px 40px; /* Padding desktop */
            }

            .header-top .logo {
                font-size: 2em; /* Ukuran desktop */
            }

            .header-center-nav {
                display: flex; /* Tampilkan di desktop */
                gap: 30px; /* Jarak desktop */
            }

            .header-right-actions {
                gap: 15px; /* Jarak desktop */
            }

            .header-right-actions .action-icon-button {
                width: 38px; /* Ukuran desktop */
                height: 38px;
                font-size: 1.3em;
            }

            .header-right-actions .logout-button {
                padding: 8px 18px; /* Padding desktop */
                font-size: 0.95em;
            }

            /* MAIN LAYOUT WRAPPER (DESKTOP) */
            .main-layout-wrapper {
                flex-direction: row; /* Berubah menjadi baris di desktop */
                max-width: 1400px; /* Lebar maksimum desktop */
                margin: 0 auto; /* Pusatkan */
                padding: 0 40px; /* Padding samping desktop */
            }

            /* SIDEBAR KIRI (PENGATURAN) - DESKTOP: TAMPILKAN DAN TERAPKAN SEMUA GAYA VISUALNYA */
            .left-sidebar {
                display: flex; /* Tampilkan di desktop */
                flex-shrink: 0; /* Jangan menyusut */
                width: 250px; /* Lebar tetap */
                background-color: #242526; /* Warna latar belakang gelap */
                color: white; /* Warna teks umum */
                padding: 15px 0; /* Padding internal */
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05); /* Bayangan */
                border-right: none; /* Hapus border */
                align-items: flex-start; /* Pastikan konten sidebar mulai dari kiri */
                flex-direction: column; /* Konten di dalamnya tersusun kolom */
                overflow-y: auto; /* Scroll jika perlu */
            }

            .sidebar-profile {
                display: flex; /* Aktifkan flex untuk profil */
                align-items: center;
                padding: 10px 20px;
                margin-bottom: 10px;
                color: white;
                text-decoration: none;
                transition: background-color 0.2s ease;
                border-radius: 8px;
                margin-right: 10px;
                margin-left: 10px;
            }

            .sidebar-profile:hover {
                background-color: #3a3b3c;
            }

            .sidebar-profile .profile-pic {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                object-fit: cover;
                margin-right: 10px;
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .sidebar-profile .profile-name {
                font-weight: 600;
                font-size: 1em;
                color: #e4e6eb;
            }

            .left-sidebar hr {
                border: none;
                border-top: 1px solid #3a3b3c;
                margin: 10px 15px;
            }

            .left-sidebar h2 {
                font-family: 'Montserrat', sans-serif;
                color: #8a8d91;
                font-size: 1em;
                font-weight: 600;
                margin-bottom: 15px;
                padding: 0 20px;
                width: 100%;
                text-align: left;
            }

            .left-sidebar ul {
                list-style: none;
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .left-sidebar ul li {
                margin-bottom: 0;
            }

            .left-sidebar ul li a {
                display: flex;
                align-items: center;
                padding: 10px 20px;
                color: #e4e6eb;
                text-decoration: none;
                font-size: 0.95em;
                font-weight: 500;
                transition: background-color 0.2s ease, border-radius 0.2s ease;
                border-radius: 8px;
                margin-right: 10px;
                margin-left: 10px;
                border-left: none;
            }

            .left-sidebar ul li a:hover,
            .left-sidebar ul li a.active {
                background-color: #3a3b3c;
                color: #e4e6eb;
                border-left-color: transparent;
            }

            .left-sidebar ul li a span.icon {
                margin-right: 10px;
                font-size: 1.25em;
                width: 24px;
                height: 24px;
                display: flex;
                justify-content: center;
                align-items: center;
                color: #8B0000;
            }

            .left-sidebar .see-more-toggle {
                display: flex;
                align-items: center;
                padding: 10px 20px;
                color: #e4e6eb;
                text-decoration: none;
                font-size: 0.95em;
                font-weight: 500;
                transition: background-color 0.2s ease, border-radius 0.2s ease;
                border-radius: 8px;
                margin-top: 10px;
                margin-right: 10px;
                margin-left: 10px;
                cursor: pointer;
            }

            .left-sidebar .see-more-toggle:hover {
                background-color: #3a3b3c;
            }

            .left-sidebar .see-more-toggle .arrow-icon {
                margin-right: 10px;
                font-size: 1.2em;
                transition: transform 0.3s ease;
            }

            .left-sidebar .see-more-toggle.expanded .arrow-icon {
                transform: rotate(180deg);
            }


            /* KONTEN TENGAH - DESKTOP */
            .main-content-area {
                padding: 30px; /* Padding desktop */
            }

            .main-content-area h1 {
                font-size: 2.8em; /* Ukuran desktop */
                margin-bottom: 40px;
                padding-bottom: 20px;
            }

            .article-cards-container {
                gap: 30px; /* Jarak desktop */
                max-width: 700px; /* Lebar item desktop */
                padding-bottom: 30px;
            }

            .article-card {
                padding: 30px; /* Padding desktop */
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            }

            .article-card h3 {
                font-size: 1.6em; /* Ukuran desktop */
            }

            .article-card .date {
                font-size: 0.85em;
            }

            .article-card p {
                font-size: 0.95em;
            }

            .article-card .read-more {
                font-size: 0.9em;
            }

            /* SIDEBAR KANAN (TOPIK POPULER) - DESKTOP: TAMPILKAN DAN TERAPKAN SEMUA GAYA VISUALNYA */
            .right-sidebar {
                display: flex; /* Tampilkan di desktop */
                flex-shrink: 0; /* Jangan menyusut */
                width: 280px; /* Lebar tetap */
                background-color: #ffffff;
                color: #333;
                padding: 25px 0;
                box-shadow: -2px 0 10px rgba(0, 0, 0, 0.05);
                border-left: 1px solid #eee;
                align-items: flex-start; /* Pastikan konten sidebar mulai dari kiri */
                flex-direction: column; /* Konten di dalamnya tersusun kolom */
                overflow-y: auto; /* Scroll jika perlu */
            }

            .right-sidebar h2 {
                font-family: 'Montserrat', sans-serif;
                color: #2c3e50;
                font-size: 1.4em;
                font-weight: 600;
                margin-bottom: 25px;
                padding: 0 25px;
                width: 100%;
                text-align: right;
            }

            .right-sidebar ul {
                list-style: none;
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .right-sidebar ul li {
                margin-bottom: 5px;
            }

            .right-sidebar ul li a {
                display: flex;
                align-items: center;
                flex-direction: row-reverse;
                justify-content: flex-end;
                padding: 12px 25px;
                color: #555;
                text-decoration: none;
                font-size: 1em;
                font-weight: 400;
                transition: background-color 0.3s ease, color 0.3s ease;
                border-right: 5px solid transparent;
            }

            .right-sidebar ul li a:hover,
            .right-sidebar ul li a.active {
                background-color: #f0f3f6;
                color: #8B0000;
                border-right-color: #8B0000;
            }

            .right-sidebar ul li a span.icon {
                margin-left: 15px;
                margin-right: 0;
                font-size: 1.2em;
                width: 20px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <?php include $partialsPath . 'header.php'; ?>

    <div class="main-layout-wrapper">
        <?php include $partialsPath . 'sidebar_left.php'; ?>

        <div class="main-content-area">
            <h1>Tren Artikel Terbaru</h1>
            <div class="article-cards-container">
                <?php
                // Contoh data artikel (ini biasanya datang dari Controller/Model)
                $articles = [
                    ['title' => 'Pentingnya Privasi Data di Era Digital', 'date' => '27 Juli 2025', 'excerpt' => 'Dalam lanskap digital yang terus berkembang, privasi data menjadi semakin krusial. Artikel ini membahas mengapa melindungi informasi pribadi Anda adalah prioritas utama dan bagaimana organisasi berupaya menjaga keamanan data pengguna...'],
                    ['title' => 'Tren Teknologi Terbaru yang Wajib Anda Ketahui', 'date' => '25 Juli 2025', 'excerpt' => 'Dari kecerdasan buatan hingga komputasi kuantum, dunia teknologi tidak pernah berhenti berinovasi. Mari kita selami beberapa tren paling menarik yang akan membentuk masa depan kita...'],
                    ['title' => 'Memulai Karir di Industri Kreatif: Panduan Lengkap', 'date' => '24 Juli 2025', 'excerpt' => 'Industri kreatif menawarkan peluang tak terbatas bagi mereka yang bersemangat. Pelajari langkah-langkah esensial untuk membangun portofolio, menemukan mentor, dan berhasil di bidang ini...'],
                    ['title' => 'Tips Efektif Mengelola Waktu untuk Produktivitas Maksimal', 'date' => '23 Juli 2025', 'excerpt' => 'Merasa kewalahan dengan daftar tugas? Temukan strategi pengelolaan waktu yang telah terbukti untuk meningkatkan efisiensi Anda dan mencapai tujuan pribadi dan profesional Anda...'],
                    ['title' => 'Dampak Perubahan Iklim pada Ekosistem Lokal', 'date' => '22 Juli 2025', 'excerpt' => 'Perubahan iklim bukan lagi ancaman di masa depan, melainkan kenyataan yang memengaruhi ekosistem di seluruh dunia. Artikel ini menyoroti dampak spesifik pada flora dan fauna lokal serta upaya konservasi...'],
                    ['title' => 'Investasi Saham untuk Pemula: Apa yang Perlu Anda Tahu', 'date' => '21 Juli 2025', 'excerpt' => 'Memasuki dunia investasi bisa menakutkan, tetapi dengan pemahaman dasar yang tepat, Anda bisa memulai perjalanan finansial Anda. Pelajari istilah kunci dan strategi awal di pasar saham...'],
                ];

                foreach ($articles as $article) {
                    include $partialsPath . 'article_card.php';
                }
                ?>
            </div>
        </div>

        <?php include $partialsPath . 'sidebar_right.php'; ?>
    </div>
    <script>
        // Contoh script untuk "Lihat selengkapnya" jika Anda ingin fungsionalitasnya
        document.addEventListener('DOMContentLoaded', function() {
            const seeMoreToggle = document.querySelector('.see-more-toggle');
            if (seeMoreToggle) {
                seeMoreToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    // Ini hanya contoh, dalam implementasi nyata, Anda akan
                    // toggle class pada elemen container yang menyembunyikan item
                    // atau menggunakan JS untuk menambah/menghapus item.
                    this.classList.toggle('expanded');
                    alert('Fungsionalitas "Lihat selengkapnya" perlu diimplementasikan dengan JavaScript yang sebenarnya.');
                });
            }
        });
    </script>
</body>
</html>