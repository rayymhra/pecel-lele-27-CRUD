<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$id = $_GET['id'];
$result = $conn->query("SELECT * FROM testimoni WHERE id = $id");
$testimoni = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $isi = $_POST['isi'];

    $stmt = $conn->prepare("UPDATE testimoni SET nama = ?, isi = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nama, $isi, $id);
    $stmt->execute();

    header("Location: index.php");
    exit;
}

include "../layout/navbar.php";
include "../layout/sidebar.php";
?>

<div class="container mt-4">
    <h2 class="fw-bold mb-4">Edit Testimoni</h2>

    <form method="POST" class="shadow-sm p-4 rounded bg-light">
        <div class="mb-3">
            <label for="nama" class="form-label fw-semibold">Nama:</label>
            <input type="text" class="form-control" name="nama" id="nama"
                   value="<?= htmlspecialchars($testimoni['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="isi" class="form-label fw-semibold">Isi Testimoni:</label>
            <textarea class="form-control" name="isi" id="isi" rows="4" required><?= htmlspecialchars($testimoni['isi']) ?></textarea>
        </div>

        <button type="submit" class="btn btn-warning text-dark fw-semibold">
            Update
        </button>
    </form>
</div>


<?php include "../layout/footer.php" ?>

