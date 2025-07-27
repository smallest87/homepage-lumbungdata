<?php
// views/partials/article_card.php
// Pastikan variabel $article sudah didefinisikan sebelum di-include
// Contoh: $article = ['title' => 'Judul Artikel', 'date' => 'Tanggal', 'excerpt' => 'Isi cuplikan'];
?>
<div class="article-card">
    <h3><?php echo htmlspecialchars($article['title'] ?? 'Judul Artikel'); ?></h3>
    <span class="date"><?php echo htmlspecialchars($article['date'] ?? 'Tanggal Tidak Diketahui'); ?></span>
    <p><?php echo htmlspecialchars($article['excerpt'] ?? 'Cuplikan isi artikel tidak tersedia.'); ?></p>
    <a href="#" class="read-more">Baca Selengkapnya &raquo;</a>
</div>