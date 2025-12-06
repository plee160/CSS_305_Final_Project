<?php
/*
I certify that the PHP file I am submitting is all my own work.
None of it is copied from any source or any person.
Signed: Samuel Boye,add your names
Date: 12/06/2025
Class: CSS 305
File Name: userUpdate.php
Assignment: Final Project – Car Parts Catalog
Description: Updates an existing user's username, email, and role.
*/
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $currentName  = trim(htmlspecialchars($_POST['currentName'] ?? ''));
    $newName      = trim(htmlspecialchars($_POST['newName'] ?? ''));
    $currentEmail = trim(htmlspecialchars($_POST['currentEmail'] ?? ''));
    $newEmail     = trim(htmlspecialchars($_POST['newEmail'] ?? ''));
    $currentRole  = trim(htmlspecialchars($_POST['currentRole'] ?? ''));
    $newRole      = trim(htmlspecialchars($_POST['NewRole'] ?? ''));

    if ($currentName === '' || $currentEmail === '') {
        echo "Current username and current email are required.";
        exit;
    }

    // Build parts of update dynamically
    $fields = [];
    $params = [];
    $types  = '';

    if ($newName !== '') {
        $fields[]  = "username = ?";
        $params[]  = $newName;
        $types    .= 's';
    }

    if ($newEmail !== '') {
        $fields[]  = "email = ?";
        $params[]  = $newEmail;
        $types    .= 's';
    }

    if ($newRole !== '') {
        $fields[]  = "role = ?";
        $params[]  = $newRole;
        $types    .= 's';
    }

    if (empty($fields)) {
        echo "No new values to update.";
        exit;
    }

    // WHERE clause uses currentName + currentEmail to find the row
    $sql = "UPDATE users SET " . implode(', ', $fields) .
           " WHERE username = ? AND email = ?";

    $params[] = $currentName;
    $params[] = $currentEmail;
    $types   .= 'ss';

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "User updated successfully.";
        } else {
            echo "No matching user found or no changes made.";
        }
    } else {
        echo "Database error: " . $stmt->error;
    }

} else {
    header("Location: User.html");
    exit;
}
?>
