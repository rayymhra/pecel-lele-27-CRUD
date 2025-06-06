<?php
session_start();
include '../../db.php';

// Only allow staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: ../../auth/login.php");
    exit;
}

// Get order ID from URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Optional: Check if the order exists before deleting
$check = $conn->prepare("SELECT * FROM orders WHERE id = ?");
$check->bind_param("i", $id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows === 0) {
    // If not found, redirect with error (or show message)
    header("Location: index.php?msg=notfound");
    exit;
}

// Delete the order
$stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php?msg=deleted");
exit;
?>
