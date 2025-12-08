<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $c_username = trim(htmlspecialchars($_POST['currentName']));
        $n_username = trim(htmlspecialchars($_POST['newName']));
        $c_email = trim(htmlspecialchars($_POST['currentEmail']));
        $n_email = trim(htmlspecialchars($_POST['newEmail']));
        $n_role = trim(htmlspecialchars($_POST['newRole']));

        //Data if c_username is Found
        $stmt1 = $conn->prepare("SELECT `email`, `role` FROM `users` Where User= ?");
        $stmt1->bind_param("s", $c_username);
        $stmt1->execute();
        $result1 = $stmt1->get_result(); 
        $row1 = $result1->fetch_assoc();

        $stmt = $conn->prepare("UPDATE users SET `User` = ?, `email` = ?, `role` = ? 
        WHERE `User` = ?");

        $c_role = $row1['role'];

        // Checks if Username is Empty as its Unique to Identify
        if (!$row1) { 
            echo "User Not Found";
            return;
        }
        //Assigns c_email to DB Email if left Empty
        if (empty($c_email)) {
            $c_email = $row1['email']; 
        }
        //If Email doesn't match return Error
        if ($c_email != $row1['email']){
            echo "User and Email do not Match";
            return;
        }

        

        

        // Current replaces New email
        if (empty($n_email)) { 
            $n_email = $c_email;
        }
        if (empty($n_role)) {
            $n_role = $c_role;
        }
        if (empty($n_username)) {
            $n_username = $c_username;
        }



        $stmt->bind_param("ssss", $n_username, $n_email, $n_role, 
        $c_username);
        if ($stmt->execute()) {
            echo "Succesfuly Updated!";
            echo '<br><button onclick="location.href=\'Admin.html\'">Return to Admin  Page</button>';
        } else {
            echo "Could not Find User.";
        }
        
        
    }

?>