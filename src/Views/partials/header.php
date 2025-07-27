<?php
// views/partials/header.php

// Variabel $user_publicname_header akan digunakan di sini.
// Pastikan $_SESSION['user_publicname'] diatur oleh DashboardController.
$user_publicname_header = $_SESSION['user_publicname'] ?? 'Tuan';
?>
<div class="header-top">
  <div class="header-left">
    <a href="#" class="logo">LumbungData</a>
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
      </div>

  <div class="header-right-actions">
    <a href="#" class="action-icon-button" title="Tambah Data">
      &#x2795; </a>
    <a href="#" class="action-icon-button" title="Edit Pengguna">
      &#x270E; </a>
    <a href="#" class="action-icon-button" title="Pengaturan Sistem">
      &#x2699; </a>
        
        <a href="#" class="profile-display-button" title="Lihat Profil">
            <img src="https://via.placeholder.com/24x24/FFFFFF/8B0000?text=JD" alt="Profil" class="profile-icon-pic">
            <span class="profile-name-text">Selamat Datang, <?php echo htmlspecialchars($user_publicname_header); ?></span>
        </a>

    <a href="/logout" class="logout-button">Logout</a>
  </div>
</div>