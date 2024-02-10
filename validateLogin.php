<?php

function validateLogin($email, $pw)
{
    // open database
    include 'database/config.php';
    include 'database/opendb.php';
    

    $query = "SELECT * FROM users WHERE Email='$email' AND Password='$pw'";
    $result = mysqli_query($conn, $query) or die ("Error executing the query");

    //check that at least one row was returned
    $numrows = mysqli_num_rows($result);
    if($numrows > 0){
        return true;
    } else {
        return false;
    }
    

    include 'database/closedb.php';  
  
}

function determineRole($email){
    // open database
    include 'database/config.php';
    include 'database/opendb.php';
    
     
     return mysqli_query($conn, "SELECT Role FROM users WHERE Email = '$email'");


    include 'database/closedb.php';  
}


