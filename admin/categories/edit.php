<?php
session_start();
include '../../db.php';
include "../../function.php";


$id = (int)($_GET['id'] ?? 0);

if (!$id) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

// Fetch existing data
$stmt = $conn->prepare("SELECT * FROM categories WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: index.php");
    exit;
}

$category = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!$name) {
        $error = "Nama kategori wajib diisi.";
    } else {
        $stmt = $conn->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $name, $description, $id);

        if ($stmt->execute()) {
            $success = "Kategori berhasil diperbarui.";
            // Refresh data
            $category['name'] = $name;
            $category['description'] = $description;
        } else {
            $error = "Terjadi kesalahan saat memperbarui kategori.";
        }
    }
}
?>

<?php include "../layout/navbar.php"; ?>
<?php include "../layout/sidebar.php"; ?>

<div class="container mt-5">
    <div class="card border-warning">
        <div class="card-header bg-warning text-dark fw-bold">
            Edit Kategori
        </div>
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php elseif ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="name" class="form-control" required 
                        value="<?= htmlspecialchars($category['name']) ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($category['description']) ?></textarea>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-secondary">← Kembali</a>
                    <button type="submit" class="btn btn-warning text-dark fw-semibold">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php include "../layout/footer.php"; ?>
