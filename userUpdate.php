<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $c_username = trim(htmlspecialchars($_POST['currentName']));
        $n_username = trim(htmlspecialchars($_POST['newName']));
        $c_email = trim(htmlspecialchars($_POST['currentEmail']));
        $n_email = trim(htmlspecialchars($_POST['newEmail']));
        $c_role = trim(htmlspecialchars($_POST['currentRole']));
        $n_role = trim(htmlspecialchars($_POST['newRole']));

        $stmt = $conn->prepare("UPDATE users SET `User` = ?, `email` = ?, `role` = ? 
        WHERE `User` = ?");


    // Checks if Username is Empty as its Unique to Identify
        if (empty($c_username)) { 
            echo "Empty Username!";
            return;
        }

        if (empty($n_email)) { //If other Fields is empty its fine
            $n_email = $c_email;
        }
        if (empty($n_role)) {
            $n_role = $c_role;
        }



        $stmt->bind_param("ssss", $n_username, $n_email, $n_role, 
        $c_username);
        if ($stmt->execute()) {
            echo "Succesfuly Updated!";
        } else {
            echo "Could not Find User.";
        }
        
        
    }

?>