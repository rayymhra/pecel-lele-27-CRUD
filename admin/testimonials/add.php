<?php
include '../../auth/check.php';
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d'); // Otomatis tanggal hari ini

    $stmt = $conn->prepare("INSERT INTO testimoni (nama, isi, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $isi, $tanggal);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Tambah Testimoni</h2>
<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Isi Testimoni:</label><br>
    <textarea name="isi" required></textarea><br><br>

    <button type="submit">Simpan</button>
</form>
