<?php
include '../../auth/check.php';
include '../../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $gambar = $menu['gambar']; // keep old if not replaced

    // Upload new image (optional)
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['gambar']['name']);
        $filename = time() . '_' . $originalName;
        $targetPath = '../../uploads/' . $filename;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            // Optionally delete old image
            if ($menu['gambar'] && file_exists('../../uploads/' . $menu['gambar'])) {
                unlink('../../uploads/' . $menu['gambar']);
            }
            $gambar = $filename;
        }
    }

    // Update DB
    $stmt = $conn->prepare("UPDATE menu SET nama = ?, deskripsi = ?, harga = ?, gambar = ? WHERE id = ?");
    $stmt->bind_param("ssdsi", $nama, $deskripsi, $harga, $gambar, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<h2>Edit Menu</h2>
<form method="POST" enctype="multipart/form-data">
    <label>Nama:</label><br>
    <input type="text" name="nama" value="<?= htmlspecialchars($menu['nama']) ?>" required><br><br>

    <label>Deskripsi:</label><br>
    <textarea name="deskripsi"><?= htmlspecialchars($menu['deskripsi']) ?></textarea><br><br>

    <label>Harga (Rp):</label><br>
    <input type="number" name="harga" step="0.01" value="<?= $menu['harga'] ?>" required><br><br>

    <label>Gambar Saat Ini:</label><br>
    <?php if ($menu['gambar']): ?>
        <img src="../../uploads/<?= $menu['gambar'] ?>" width="100"><br>
    <?php endif; ?>
    <input type="file" name="gambar"><br><br>

    <button type="submit">Simpan Perubahan</button>
</form>
