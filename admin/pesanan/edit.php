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

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Edit Pesanan</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
        <div class="mb-3">
            <label class="form-label">Nama Pesanan:</label>
            <input type="text" name="nama" value="<?= htmlspecialchars($pesanan['nama']) ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Gambar Saat Ini:</label><br>
            <?php if ($pesanan['gambar']) : ?>
                <img src="../../uploads/<?= $pesanan['gambar'] ?>" width="150" class="img-thumbnail mb-2"><br>
            <?php endif; ?>
            <input type="file" name="gambar" class="form-control">
            <div class="form-text">Kosongkan jika tidak ingin mengubah gambar.</div>
        </div>

        <div class="col-2">
             <button type="submit" class="btn btn-warning fw-semibold text-dark">
           Update
        </button>
        <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
        </div>
       
    </form>
</div>


<?php include "../layout/footer.php" ?>
