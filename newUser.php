<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name    = trim(htmlspecialchars($_POST['newUser'] ?? ''));
    $newPass = $_POST['newPass'] ?? '';   // allow ANY characters

    if ($name === '' || $newPass === '') {
        echo "Username and password are required.";
        exit;
    }

    // Hash the password securely
    $hashedPassword = password_hash($newPass, PASSWORD_DEFAULT);

    // No email field in the form yet, so store empty string
    $email = '';

    $sql = "INSERT INTO users (username, email, password, role)
            VALUES (?, ?, ?, 'Tier1')";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sss", $name, $email, $hashedPassword);

    if ($stmt->execute()) {
        header("Location: index.html");   // back to login form
        exit;
    } else {
        echo "Database error: " . $stmt->error;
    }

} else {
    header("Location: newUser.html");
    exit;
}
?>
