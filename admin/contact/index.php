<?php
include '../../auth/check.php';
include '../../db.php';

$result = $conn->query("SELECT * FROM kontak WHERE id = 1");
$kontak = $result->fetch_assoc();

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<h2>Informasi Kontak</h2>
<div class="card my-3">
    <div class="card-body">
        <p><strong>Lokasi:</strong> <?= nl2br(htmlspecialchars($kontak['lokasi'])) ?></p>
        <p><strong>Jam Buka:</strong> <?= htmlspecialchars($kontak['jam_buka']) ?></p>
        <p><strong>Catatan:</strong> <?= nl2br(htmlspecialchars($kontak['catatan'])) ?></p>
    </div>
</div>


<a href="edit.php" class="btn btn-warning">Edit Kontak</a>

<?php include "../layout/footer.php" ?>