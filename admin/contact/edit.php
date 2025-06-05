<?php
include '../../auth/check.php';
include '../../db.php';

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
?>

<h2>Edit Kontak</h2>
<form method="POST">
    <label>Lokasi:</label><br>
    <textarea name="lokasi" required><?= htmlspecialchars($kontak['lokasi']) ?></textarea><br><br>

    <label>Jam Buka:</label><br>
    <input type="text" name="jam_buka" value="<?= htmlspecialchars($kontak['jam_buka']) ?>" required><br><br>

    <label>Catatan:</label><br>
    <textarea name="catatan"><?= htmlspecialchars($kontak['catatan']) ?></textarea><br><br>

    <button type="submit">Simpan</button>
</form>
