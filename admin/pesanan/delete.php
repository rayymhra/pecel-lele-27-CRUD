<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Ambil nama gambar untuk dihapus
$stmt = $conn->prepare("SELECT gambar FROM pesanan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

// Hapus gambar dari folder
if ($data && $data['gambar'] && file_exists('../uploads/' . $data['gambar'])) {
    unlink('../../uploads/' . $data['gambar']);
}

// Hapus data dari DB
$stmt = $conn->prepare("DELETE FROM pesanan WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
