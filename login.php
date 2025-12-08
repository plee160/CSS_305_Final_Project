<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $userName = trim(htmlspecialchars($_POST['username']));
        $password = trim(htmlspecialchars($_POST['password']));


        $stmt = $conn->prepare("SELECT `User_Password` FROM `login` Where Username= ?");
        $stmt->bind_param("s", $userName);
        $stmt->execute();
        $result = $stmt->get_result(); 
        $row = $result->fetch_assoc(); 
        
        //Checks if Username was left empty
        if (!$row) {
            echo "Username or Password was Invalid";
        }

        if (password_verify($password, $row['User_Password'])) {
            //Get User from users DB
            $stmt2 = $conn->prepare("SELECT `User` FROM `users` Where User= ?");
            $stmt2->bind_param("s", $userName);
            $stmt2->execute();
            $result2 = $stmt2->get_result(); 
            $row2 = $result2->fetch_assoc();
            
            //Get role from users DB
            $stmt3 = $conn->prepare("SELECT `role` FROM `users` Where User= ?");
            $stmt3->bind_param("s", $userName);
            $stmt3->execute();
            $result3 = $stmt3->get_result(); 
            $row3 = $result3->fetch_assoc();

            //Heads to Admin page if role is Admin and is in both users/login DB
            if ($row2 && $row3['role'] == 'Admin') {
                header ("Location: Admin.html");
                return;
            }
            header ("Location: Interface.html");
        } else {
            echo "Username or Password was Invalid.";
        }
        
        exit;
    }

?>