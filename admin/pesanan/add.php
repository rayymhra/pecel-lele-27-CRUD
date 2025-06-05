<?php
include '../../auth/check.php';
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
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
    $stmt = $conn->prepare("INSERT INTO pesanan (nama, gambar) VALUES (?, ?)");
    $stmt->bind_param("ss", $nama, $gambar);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Tambah Pesanan</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama Pesanan:</label><br>
    <input type="text" name="nama" required><br><br>

    <label>Gambar:</label><br>
    <input type="file" name="gambar"><br><br>

    <button type="submit">Simpan</button>
</form>
