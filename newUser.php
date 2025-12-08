<?php
    include 'db.php';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $name = trim(htmlspecialchars($_POST['newUser']));
        $newPass = trim(htmlspecialchars($_POST['newPass']));
        $password = password_hash($newPass, PASSWORD_BCRYPT);
        $Default_Role = 'Tier1';

        //Checks if User exists in the Users Database if not it will add them into it
        $stmt1 = $conn->prepare("SELECT `User` FROM `users` Where User = ?");
        $stmt1->bind_param("s", $name);
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        $row1 = $result1->fetch_assoc();
        //If returns Null adds into User otherwise Vaque Error Statment
        if ($row1) {
            echo "Eror please try again";
            return;
        } else {
            $stmt2 = $conn->prepare("INSERT INTO `users` (`User`, `role`, `created_at`)
            VALUES (?, ?, NOW())");
            $stmt2->bind_param("ss", $name, $Default_Role);
            if ($stmt2->execute()) {
                echo "Added into the user Database";
            }
        }
        


        //Adds into the Login database. Username is Unique Attribute 
        // so no need to code a check
        $stmt = $conn->prepare("INSERT INTO `login` (`Username`, `User_Password`)
            VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $password);

        

        if ($stmt->execute()) {
            header ("Location: index.html");
        } else {
            echo "Failed to Register";
        }
        exit;
    }
?>