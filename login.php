<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $userName = trim(htmlspecialchars($_POST['username']));
        $password = trim(htmlspecialchars($_POST['password']));


        $stmt = $conn->prepare("SELECT `User_Password` FROM `login` Where Username= ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result(); //mysqli Object
        $row = $result->fetch_assoc(); //Creates the Row array from mysqli Object
        
        if (password_verify($password, $row['User_Password'])) {
            echo "Success";
            header ("Location: index.html");
        } else {
            echo "Username or Password was Invalid.";
        }




        
        exit;
    }


















?>