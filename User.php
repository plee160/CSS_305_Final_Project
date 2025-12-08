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
        <form name="form" id="form" method="post" action ="userUpdate.php">
            
            <h2 id="title">Update User Form</h2> <br>
            
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


            <label id="top">New Username:</label>  
            <input type="text" name="newName"> <br><br>

            <label id="top">Current Email:</label>  
            <select name="currentEmail" > 
            <option value = "">--Choose Corresponding Email--</option>     
            <!--Displays when User is selected on Top-->
            <?php
                $Users = getUsers();
            
                foreach($Users as $user) {
                    ?>        
                    <option value ="<?php echo $user['email'] ?>">
                    <?php echo $user['email'] ?>
                    </option> 
                    <?php
                }
            ?>
            
            </select><br>


            <label id="top">New Email:</label>  
            <input type="text" name="newEmail"> <br><br>

            <label id="top">New Role:</label> <select name="newRole">
            <option value="">--Select New Role Here--</option>    
            <option>Tier1</option>
            <option>Tier2</option>
            <option>Admin</option>    
            </select>  <br><br>

            <button type="submit">Update</button>
            </section>
        </form>
    </body>
</html>