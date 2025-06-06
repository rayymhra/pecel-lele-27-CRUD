<?php

// include "../function.php";

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: " . base_url() . "auth/login.php");
    exit;
}
