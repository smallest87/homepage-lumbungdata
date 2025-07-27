<?php
// views/partials/sidebar_left.php

// URL API untuk mengambil data menu
$api_url = "https://api.lumbungdata.com/menu";

// Inisialisasi cURL untuk mengambil data dari API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Mengembalikan respons sebagai string

// Eksekusi cURL dan dapatkan respons
$response = curl_exec($ch);

// Periksa error cURL
if (curl_errno($ch)) {
    $error_msg = curl_error($ch);
    // Log error atau tangani sesuai kebutuhan Anda, misalnya dengan menampilkan menu default
    error_log("API Error saat mengambil menu: " . $error_msg);
    $menu_items = []; // Fallback ke array kosong jika ada error
} else {
    // Dekode respons JSON
    $data = json_decode($response, true); // true untuk mengubah ke array asosiatif

    // Periksa apakah JSON valid dan memiliki kunci 'data'
    if (json_last_error() === JSON_ERROR_NONE && isset($data['data'])) {
        $menu_items = $data['data'];
    } else {
        // Tangani error dekode JSON atau kunci 'data' yang hilang
        error_log("Respons JSON tidak valid atau kunci 'data' hilang dari API menu: " . $response);
        $menu_items = []; // Fallback ke array kosong
    }
}

// Tutup cURL
curl_close($ch);

// Kategorikan item menu berdasarkan nilai 'posisi' dari API
$main_menu_items = [];
$shortcut_menu_items = [];

foreach ($menu_items as $item) {
    // Pastikan kunci 'posisi' dan 'judul' ada dan tidak kosong
    if (isset($item['posisi']) && isset($item['judul'])) {
        // Asumsi: 'utama' untuk menu utama dan 'pintasan' untuk pintasan
        // Anda mungkin perlu menyesuaikan string ini berdasarkan data aktual dari API Anda
        if ($item['posisi'] === 'utama') { // Contoh: "utama" untuk item menu utama
            $main_menu_items[] = $item;
        } elseif ($item['posisi'] === 'pintasan') { // Contoh: "pintasan" untuk item pintasan
            $shortcut_menu_items[] = $item;
        }
    }
}

?>

<div class="left-sidebar">
    <a href="#" class="sidebar-profile">
        <img src="https://via.placeholder.com/36x36" alt="Julian Sukrisna Susilo" class="profile-pic">
        <span class="profile-name">Julian Sukrisna Susilo</span>
    </a>
    <hr>
    <ul>
        <?php
        // Loop untuk menampilkan item menu utama
        foreach ($main_menu_items as $item):
        ?>
            <li>
                <a href="#">
                    <span><?php echo htmlspecialchars($item['judul']); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="#" class="see-more-toggle">
        <span class="arrow-icon">&#9662;</span> Lihat selengkapnya
    </a>

    <hr>
    <h2 style="padding: 0 20px; font-size: 1em; font-weight: 600; text-align: left; color: #8a8d91; margin-bottom: 15px;">Pintasan Anda</h2>
    <ul>
        <?php
        // Loop untuk menampilkan item pintasan
        foreach ($shortcut_menu_items as $item):
        ?>
            <li>
                <a href="#">
                    <span><?php echo htmlspecialchars($item['judul']); ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>