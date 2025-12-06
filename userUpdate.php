<?php
    include 'db.php';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 

        $c_username = trim(htmlspecialchars($_POST['currentName']));
        $n_username = trim(htmlspecialchars($_POST['newName']));

        if ($conn->query("UPDATE users SET `User` = '$n_username' Where `User` = '$c_username'")) {
            echo "Success";
        } else {
            echo "Error";
        }
        
        
    }

?>