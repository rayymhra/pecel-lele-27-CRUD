<?php
session_start();
include '../../db.php';
include "../../function.php";


if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];
$error = '';
$success = '';

// Fetch the menu item
$stmt = $conn->prepare("SELECT * FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$menu = $result->fetch_assoc();

if (!$menu) {
    echo "Menu tidak ditemukan.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $harga = (float) $_POST['harga'];
    $stok = (int) $_POST['stock'];
    $status = $_POST['status'];

    if ($nama === '' || $harga <= 0 || $stok < 0 || !in_array($status, ['tersedia', 'habis'])) {
        $error = "Data tidak valid. Pastikan semua kolom diisi dengan benar.";
    } else {
        $update = $conn->prepare("UPDATE menu SET nama = ?, harga = ?, stock = ?, status = ? WHERE id = ?");
        $update->bind_param("sdisi", $nama, $harga, $stok, $status, $id);

        if ($update->execute()) {
            $success = "Menu berhasil diperbarui.";
            // Refresh menu data
            $menu['nama'] = $nama;
            $menu['harga'] = $harga;
            $menu['stock'] = $stok;
            $menu['status'] = $status;
        } else {
            $error = "Gagal memperbarui menu.";
        }
    }
}
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-5 mb-4">
    <h2 class="mb-4 fw-bold">Edit Menu</h2>
    <a href="index.php" class="btn btn-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <form method="POST" class="p-4 border border-warning rounded-3 bg-light shadow-sm">
        <div class="mb-3">
            <label class="form-label fw-semibold text-dark">Nama Menu</label>
            <input type="text" name="nama" class="form-control" required value="<?= htmlspecialchars($menu['nama']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-dark">Harga</label>
            <input type="number" name="harga" class="form-control" min="0" step="0.01" required value="<?= htmlspecialchars($menu['harga']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold text-dark">Stok</label>
            <input type="number" name="stock" class="form-control" min="0" required value="<?= htmlspecialchars($menu['stock']) ?>">
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold text-dark">Status</label>
            <select name="status" class="form-select" required>
                <option value="tersedia" <?= $menu['status'] === 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                <option value="habis" <?= $menu['status'] === 'habis' ? 'selected' : '' ?>>Habis</option>
            </select>
        </div>

        <button type="submit" class="btn btn-warning text-dark fw-bold">Simpan Perubahan</button>
    </form>
</div>


<?php include "../layout/footer.php"; ?>
