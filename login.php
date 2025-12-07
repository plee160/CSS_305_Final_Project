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
            // Username Login Database Get
            $stmt1 = $conn->prepare("SELECT `Username` FROM `login` Where Username= ?");
            $stmt1->bind_param("s", $userName);
            $stmt1->execute();
            $result1 = $stmt1->get_result(); //mysqli Object
            $row1 = $result1->fetch_assoc(); //Creates the Row array from mysqli Object
            
            //User Database Get
            $stmt2 = $conn->prepare("SELECT `User` FROM `users` Where User= ?");
            $stmt2->bind_param("s", $userName);
            $stmt2->execute();
            $result2 = $stmt2->get_result(); 
            $row2 = $result2->fetch_assoc(); 

            if ($row1['Username'] == $row2['User']) {
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