<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$result = $conn->query("SELECT * FROM kontak WHERE id = 1");
$kontak = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lokasi = $_POST['lokasi'];
    $jam_buka = $_POST['jam_buka'];
    $catatan = $_POST['catatan'];

    $stmt = $conn->prepare("UPDATE kontak SET lokasi = ?, jam_buka = ?, catatan = ? WHERE id = 1");
    $stmt->bind_param("sss", $lokasi, $jam_buka, $catatan);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container">
    <h2 class="mb-4">Edit Kontak</h2>
<form method="POST">
    <div class="mb-3">
        <label>Lokasi:</label>
        <textarea name="lokasi" required class="form-control"><?= htmlspecialchars($kontak['lokasi']) ?></textarea>
    </div>
    
    <div class="mb-3">
        <label>Jam Buka:</label>
    <input type="text" class="form-control" name="jam_buka" value="<?= htmlspecialchars($kontak['jam_buka']) ?>" required>
    </div>
    
    <div class="mb-3">
        <label>Catatan:</label>
    <textarea name="catatan" class="form-control" ><?= htmlspecialchars($kontak['catatan']) ?></textarea>
    </div>
    

    <button type="submit" class="btn btn-warning">Simpan</button>
</form>
</div>

