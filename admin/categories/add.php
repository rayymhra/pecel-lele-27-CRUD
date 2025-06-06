<?php
session_start();
include '../../db.php';
include "../../function.php";


$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!$name) {
        $error = "Nama kategori wajib diisi.";
    } else {
        $stmt = $conn->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            $success = "Kategori berhasil ditambahkan.";
        } else {
            $error = "Terjadi kesalahan saat menyimpan kategori.";
        }
    }
}
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-4">
    <!-- <h2>Tambah Kategori</h2> -->

    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card border-warning">
        <div class="card-header bg-warning text-dark fw-bold">
            Tambah Kategori
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" placeholder="Contoh: Minuman" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Tuliskan deskripsi kategori..."></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-warning fw-semibold text-dark">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include "../layout/footer.php"; ?>
