function getUsers() {
    global $conn;
    $data = [];

    $Users = $conn->query("SELECT * FROM users");
    while ($row = $Users->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

This is For getting all the Data in the table I placed in db.php


<label id="top">Current Email:</label>  
            <select name="currentEmail" > 
            <option value = "">--Choose Corresponding Email--</option>     
            <!--Displays when User is selected on Top-->
            <?php
                $Users = getUsers(); //All Data from Table
            
                foreach($Users as $user) { //Print each Row
                    ?>    //Print Row specific Column    
                    <option value ="<?php echo $user['email'] ?>"> 
                    <?php echo $user['email'] ?>
                    </option> 
                    <?php
                }
            ?>
            
            </select><br>
