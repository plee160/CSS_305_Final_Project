<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $c_username = trim(htmlspecialchars($_POST['currentName']));

        if ($c_username === "") {
            echo "Username could not be found";
             echo '<br><br><button onclick="location.href=\'Admin.html\'">Return to Admin  Page</button>';
            exit;
        }

        //Data if c_username is Found
        $stmt1 = $conn->prepare("DELETE FROM `users` Where User= ?");
        $stmt1->bind_param("s", $c_username);
        $stmt1->execute();

        if ($stmt1->affected_rows > 0) {
            echo "User $c_username has been deleted.";
            echo '<br><br><button onclick="location.href=\'Admin.html\'">Return to Admin Page</button>';
        } else {
            echo "Deletion Failed";
            echo '<br><br><button onclick="location.href=\'Admin.html\'">Return to Admin  Page</button>';
        }

        $stmt2 = $conn->prepare("DELETE FROM `login` Where Username= ?");
        $stmt2->bind_param("s", $c_username);
        $stmt2->execute();

        if ($stmt2->affected_rows > 0) {
            echo "User $c_username has been deleted.";
            echo '<br><br><button onclick="location.href=\'Admin.html\'">Return to Admin Page</button>';
        } else {
            echo "Deletion Failed";
            echo '<br><br><button onclick="location.href=\'Admin.html\'">Return to Admin  Page</button>';
        }
        
        
        
    }

?>