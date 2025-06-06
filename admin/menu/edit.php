<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();

if (!$menu) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $status = $_POST['status'];
    $gambar = $menu['gambar'];

    // Handle image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $originalName = basename($_FILES['gambar']['name']);
        $filename = time() . '_' . $originalName;
        $targetPath = '../../uploads/' . $filename;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetPath)) {
            $gambar = $filename;
        }
    }

    $stmt = $conn->prepare("UPDATE menu SET nama=?, deskripsi=?, harga=?, stock=?, status=?, gambar=? WHERE id=?");
    $stmt->bind_param("ssdissi", $nama, $deskripsi, $harga, $stock, $status, $gambar, $id);
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

                <label>Stok:</label><br>
    <input type="number" name="stock" min="0" value="<?= (int)$menu['stock'] ?>" required class="form-control"><br>

    <label>Status:</label><br>
    <select name="status" required class="form-select mb-3">
        <option value="tersedia" <?= $menu['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
        <option value="habis" <?= $menu['status'] === 'habis' ? 'selected' : '' ?>>Habis</option>
    </select>

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
