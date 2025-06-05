<?php
include '../../auth/check.php';
include '../../db.php';

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM testimoni WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: index.php");
exit;
