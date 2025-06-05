<?php
include '../../auth/check.php';
include '../../db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];
    $tanggal = date('Y-m-d'); // Otomatis tanggal hari ini

    $stmt = $conn->prepare("INSERT INTO testimoni (nama, isi, tanggal) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama, $isi, $tanggal);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Tambah Testimoni</h2>

    <form method="POST" class="shadow-sm p-4 rounded">
        <div class="mb-3">
            <label for="nama" class="form-label fw-semibold">Nama:</label>
            <input type="text" class="form-control" name="nama" id="nama" required>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label fw-semibold">Isi Testimoni:</label>
            <textarea class="form-control" name="isi" id="isi" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-warning text-dark fw-semibold">
             Simpan
        </button>
    </form>
</div>


<?php include "../layout/footer.php" ?>
