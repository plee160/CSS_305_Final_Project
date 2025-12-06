<?php
$host     = 'localhost';
$username = 'u431967787_Atwruz9hW_userLogin';     
$password = 'GrapeShot9000#';     
$database = 'u431967787_Atwruz9hW_login';     

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
?>
