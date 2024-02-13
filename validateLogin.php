<?php

function validateLogin($email, $pw)
{
    // open database
    include 'database/config.php';
    include 'database/opendb.php';
    
    $md5 = md5($pw);
    $query = "SELECT * FROM users WHERE Email='$email' AND Password='$md5'";
    $result = mysqli_query($conn, $query) or die ("Error executing the query");

    //check that at least one row was returned
    $numrows = mysqli_num_rows($result);
    if($numrows > 0){
        include 'database/closedb.php';  
        return true;
    } else {
        include 'database/closedb.php';  
        return false;
    }

}

function determineRole($email){
    // Open database
    include 'database/config.php';
    include 'database/opendb.php';
    
    // Escape email to prevent SQL injection
    $escaped_email = mysqli_real_escape_string($conn, $email);
    
    // Execute query
    $query = "SELECT Role FROM users WHERE Email = '$escaped_email'";
    $result = mysqli_query($conn, $query);

    // Check if query was successful
    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch role
        $row = mysqli_fetch_assoc($result);
        $role = $row['Role'];
        
        // Close database connection
        include 'database/closedb.php';
        
        // Return role value
        return $role;
    } else {
        // Close database connection
        include 'database/closedb.php';
        
        // Return null if no role found
        return null;
    }
}
