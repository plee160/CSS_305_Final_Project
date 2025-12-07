
<?php 

$host = "localhost";
$user = "root";
$password = "mysql";
$dbname = "css_305_final";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed T 3T" . $connect_error);
}

function getUsers() {
    global $conn;
    $data = [];

    $Users = $conn->query("SELECT * FROM users");
    while ($row = $Users->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

?>