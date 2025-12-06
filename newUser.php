<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = trim(htmlspecialchars($_POST['newUser']));
        $newPass = trim(htmlspecialchars($_POST['newPass']));
        $password = password_hash($newPass, PASSWORD_BCRYPT);


        $conn->query("INSERT INTO `login` (`Username`, `User_Password`)
            VALUES ('$name', '$password')");
    
        header ("Location: index.html");
        exit;
    }








?>