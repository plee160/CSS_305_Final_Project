
<?php 
$host = "localhost";
$user = "root";
$password = "mysql";
$dbname = "css_305_final";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed T 3T" . $conn_error);
}