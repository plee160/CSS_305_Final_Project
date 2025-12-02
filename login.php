<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);


        $conn->query("INSERT INTO `login` (`Username`, `User_Password`)
            VALUES ('$name', '$password')");
    
        header ("Location: index.html");
        exit;
    }


















?>