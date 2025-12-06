<?php
// session_check.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['username'])) {
    header("Location: index.html");
    exit;
}
?>
