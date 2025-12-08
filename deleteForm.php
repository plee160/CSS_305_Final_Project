<!--  
    I certify that the html file I am submitting is all my own work. 
    None of it is copied from any source or any person. 
    Signed: Philip Lee
    Date: 11/25/2025
    Author: Philip Lee
    Date: 11/25/2025
    Class: CSS 305
    File Name: index.html
    Assignment: Assignment 5
    Description: Login Form
-->
<?php require "db.php" ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>User Editing</title>
        <link rel="stylesheet" href="style.css">
    </head>

    
    <body id="body">
        <form name="form" id="form" method="post" action ="deleteUser.php">
            
            <h2 id="title">Delete User Form</h2> <br>
            
            <section id="section">
            <label id="top">Current Username:</label> 
            <!-- This.Value is on line 39-->
            <select name="currentName" onclick = "getData(this.value)">
            <option value="">--Choose User to Update--</option>  
            <!-- Dynamic Display of Users in Database -->
            <?php
                $Users = getUsers();
            
                foreach($Users as $user) {
                    ?>        
                    <option value ="<?php echo $user['User'] ?>">
                    <?php echo $user['User'] ?>
                    </option> 
                    <?php
                }
            ?>  
            </select> <br>

            </select>  <br><br>

            <button type="submit">Delete User</button>
            </section>
        </form>
    </body>
</html>