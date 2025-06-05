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

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Tambah Pesanan</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
        <div class="mb-3">
            <label class="form-label">Nama Pesanan:</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar:</label>
            <input type="file" name="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-warning fw-semibold text-dark">
            <i class="bi bi-save"></i> Simpan
        </button>
    </form>
</div>


<?php include "../layout/footer.php" ?>
