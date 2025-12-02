
<?php 
$host = "localhost";
$user = "plee_login";
$password = "GrapeShot9000#";
$dbname = "login";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed T 3T" . $conn_error);

}
