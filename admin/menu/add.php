<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stock = $_POST['stock'];
    $status = $_POST['status'];
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

    $stmt = $conn->prepare("INSERT INTO menu (nama, deskripsi, harga, stock, status, gambar) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdiss", $nama, $deskripsi, $harga, $stock, $status, $gambar);
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
            Tambah Menu
        </div>
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" name="nama" id="nama" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" name="harga" id="harga" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar</label>
                    <input class="form-control" type="file" name="gambar" id="gambar">
                </div>

                <div class="mb-3">
                    <label>Stok:</label>
                    <input type="number" name="stock" value="0" min="0" required class="form-control w-50">
                </div>

                <div class="mb-3">
                    <label>Status:</label>
                    <select name="status" required class="form-select">
                        <option value="tersedia">Tersedia</option>
                        <option value="habis">Habis</option>
                    </select>
                </div>





                <button type="submit" class="btn btn-warning text-dark fw-semibold">
                    <i class="bi bi-save"></i> Simpan
                </button>
                <a href="index.php" class="btn btn-secondary ms-2">Batal</a>
            </form>
        </div>
    </div>
</div>

<?php include "../layout/footer.php" ?>

