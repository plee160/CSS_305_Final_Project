
<?php 
$host = "localhost";
$user = "userLogin";
$password = "GrapeShot9000#";
$dbname = "login";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed T 3T" . $conn_error);

}

