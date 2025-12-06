<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

// If opened directly, send back to login form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.html");
    exit;
}

$userName = trim(htmlspecialchars($_POST['username'] ?? ''));
$password = $_POST['password'] ?? '';   // allow ANY characters

if ($userName === '' || $password === '') {
    echo "Please enter both username and password.";
    exit;
}

// Table: users  Columns: username, password (hashed)
$sql = "SELECT password FROM users WHERE username = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $userName);
$stmt->execute();

$result = $stmt->get_result();
$row    = $result->fetch_assoc();

if ($row && isset($row['password'])) {

    if (password_verify($password, $row['password'])) {
        // Login success
        $_SESSION['username'] = $userName;
        header("Location: catalog.php");
        exit;
    } else {
        echo "Username or password was incorrect.";
    }

} else {
    echo "Username or password was incorrect.";
}

exit;
?>
