<?php
include '../../auth/check.php';
include '../../db.php';

$id = $_GET['id'];
$result = $conn->query("SELECT * FROM testimoni WHERE id = $id");
$testimoni = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];

    $stmt = $conn->prepare("UPDATE testimoni SET nama = ?, isi = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $isi, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Edit Testimoni</h2>
<form method="POST">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($testimoni['nama']) ?>" required><br><br>

    <label>Isi Testimoni:</label><br>
    <textarea name="isi" required><?= htmlspecialchars($testimoni['isi']) ?></textarea><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
