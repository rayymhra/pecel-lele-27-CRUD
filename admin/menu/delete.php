<?php
include '../../auth/check.php';
include '../../db.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

// Get image to delete
$stmt = $conn->prepare("SELECT gambar FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Delete image file if exists
if ($row && $row['gambar'] && file_exists('../../uploads/' . $row['gambar'])) {
    unlink('../../uploads/' . $row['gambar']);
}

// Delete from DB
$stmt = $conn->prepare("DELETE FROM menu WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
?>
