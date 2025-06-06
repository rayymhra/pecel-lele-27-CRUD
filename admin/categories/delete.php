<?php
session_start();
include '../../db.php';
include "../../function.php";


$id = (int)($_GET['id'] ?? 0);

if ($id) {
    // Optional: Before deleting, you may want to set category_id in menus referencing this category to NULL
    $conn->query("UPDATE menu SET category_id = NULL WHERE category_id = $id");
    
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit;
