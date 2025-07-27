<?php
// views/partials/header.php

// Variabel seperti $user_publicname bisa didefinisikan di controller dan dilewatkan
// ke view utama (dashboard/index.php), lalu secara otomatis tersedia di partials ini.
?>
<div class="header-top">
    <div class="header-left">
        <a href="#" class="logo">SitusKu.id</a>
    </div>

    <div class="header-center-nav">
        <a href="#" class="nav-item">
            <span class="icon">&#127968;</span> Beranda
        </a>
        <a href="#" class="nav-item">
            <span class="icon">&#128193;</span> Arsip
        </a>
        <a href="#" class="nav-item">
            <span class="icon">&#128226;</span> Pemberitahuan
        </a>
        <a href="#" class="nav-item">
            <span class="icon">&#128100;</span> Profil
        </a>
    </div>

    <div class="header-right-actions">
        <a href="#" class="action-icon-button" title="Tambah Data">
            &#x2795; </a>
        <a href="#" class="action-icon-button" title="Edit Pengguna">
            &#x270E; </a>
        <a href="#" class="action-icon-button" title="Pengaturan Sistem">
            &#x2699; </a>
        <a href="/logout" class="logout-button">Logout</a>
    </div>
</div>