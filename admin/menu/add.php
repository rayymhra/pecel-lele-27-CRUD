<?php
include '../../auth/check.php';
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambar = null;

    // Handle image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['gambar']['name']);
        $filename = time() . '_' . $originalName;
        $targetPath = '../../uploads/' . $filename;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            $gambar = $filename;
        }
    }

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO menu (nama, deskripsi, harga, gambar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssds", $nama, $deskripsi, $harga, $gambar);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Tambah Menu</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi"></textarea><br><br>

    <label>Harga (Rp):</label><br>
    <input type="number" name="harga" step="0.01" required><br><br>

    <label>Gambar:</label><br>
    <input type="file" name="gambar"><br><br>

    <button type="submit">Simpan</button>
</form>
