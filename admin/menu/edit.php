<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";

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

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-warning text-dark fw-bold">
            Edit Menu
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" name="nama" id="nama"
                        value="<?= htmlspecialchars($menu['nama']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"><?= htmlspecialchars($menu['deskripsi']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" name="harga" id="harga" step="0.01"
                        value="<?= $menu['harga'] ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label><br>
                    <?php if ($menu['gambar']): ?>
                        <img src="../../uploads/<?= $menu['gambar'] ?>" class="img-thumbnail mb-2" style="max-width: 150px;">
                    <?php else: ?>
                        <p class="text-muted">Belum ada gambar.</p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Ganti Gambar (Opsional)</label>
                    <input class="form-control" type="file" name="gambar" id="gambar">
                </div>

                <button type="submit" class="btn btn-warning text-dark fw-semibold">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>


<?php include "../layout/footer.php" ?>
