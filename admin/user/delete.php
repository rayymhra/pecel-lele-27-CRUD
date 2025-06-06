<?php
include '../../auth/check.php';
include '../../db.php';
include "../../function.php";


$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");

header("Location: index.php");
exit;
