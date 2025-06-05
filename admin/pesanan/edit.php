<?php
include '../../auth/check.php';
include '../../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM pesanan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_assoc();

if (!$pesanan) {
    echo "Data tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $gambar = $pesanan['gambar'];

    // Handle image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['gambar']['name']);
        $filename = time() . '_' . $originalName;
        $targetPath = '../../uploads/' . $filename;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            // Hapus gambar lama jika ada
            if ($gambar && file_exists('../../uploads/' . $gambar)) {
                unlink('../../uploads/' . $gambar);
            }
            $gambar = $filename;
        }
    }

    $stmt = $conn->prepare("UPDATE pesanan SET nama = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $gambar, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Edit Pesanan</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama Pesanan:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($pesanan['nama']) ?>" required><br><br>

    <label>Gambar (kosongkan jika tidak diubah):</label><br>
    <?php if ($pesanan['gambar']) : ?>
        <img src="../../uploads/<?= $pesanan['gambar'] ?>" width="150"><br>
    <?php endif; ?>
    <input type="file" name="gambar"><br><br>

    <button type="submit">Update</button>
</form>
