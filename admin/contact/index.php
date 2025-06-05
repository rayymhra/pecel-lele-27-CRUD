<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM kontak WHERE id = 1");
$kontak = $result->fetch_assoc();
?>

<h2>Informasi Kontak</h2>
<p><strong>Lokasi:</strong> <?= nl2br(htmlspecialchars($kontak['lokasi'])) ?></p>
<p><strong>Jam Buka:</strong> <?= htmlspecialchars($kontak['jam_buka']) ?></p>
<p><strong>Catatan:</strong> <?= nl2br(htmlspecialchars($kontak['catatan'])) ?></p>

<a href="edit.php">Edit Kontak</a>
