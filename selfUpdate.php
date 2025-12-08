<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $c_username = trim(htmlspecialchars($_POST['currentUsername']));
        $n_username = trim(htmlspecialchars($_POST['newUsername']));

        $n_email = trim(htmlspecialchars($_POST['newEmail']));


        //Data if c_username is Found
        $stmt1 = $conn->prepare("SELECT `email`, `User` FROM `users` Where User= ?");
        $stmt1->bind_param("s", $c_username);
        $stmt1->execute();
        $result1 = $stmt1->get_result(); 
        $row1 = $result1->fetch_assoc();

        $stmt = $conn->prepare("UPDATE users SET `User` = ?, `email` = ? WHERE `User` = ?");

        // Checks if Username is Empty as its Unique to Identify
        if (!$row1) { 
            echo "User Not Found";
            return;
        }
        if (empty($n_username)) {
            $n_username = $c_username;
        }



        $stmt->bind_param("sss", $n_username, $n_email, $c_username);
        $stmt->execute();
        if($stmt->affected_rows > 0) {

        } else {
            echo "Failed to Update";
        }
        
        
        $stmt2 = $conn->prepare("UPDATE `login` SET `Username` = ? WHERE `Username` = ?");

        // Checks if Username is Empty as its Unique to Identify
        if (!$row1) { 
            echo "User Not Found";
            return;
        }
        if (empty($n_username)) {
            $n_username = $c_username;
        }



        $stmt2->bind_param("ss", $n_username, $c_username);
        $stmt2->execute();
        if(($stmt->affected_rows > 0) && ($stmt2->affected_rows > 0)) {
            echo "Success";
            echo '<br><button onclick="location.href=\'Interface.html\'">Return to Page</button>';

        } else {
            echo "Failed to Update";
        }
        
    }

?>