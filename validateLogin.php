<?php

function validateLogin($email, $pw)
{
    include 'database/config.php';
    include 'database/opendb.php';
    
    $md5 = md5($pw);
    $query = "SELECT * FROM users WHERE Email='$email' AND Password='$md5'";
    $result = mysqli_query($conn, $query) or die ("Error executing the query");

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
    include 'database/config.php';
    include 'database/opendb.php';
    
    $escaped_email = mysqli_real_escape_string($conn, $email);
    
    $query = "SELECT Role FROM users WHERE Email = '$escaped_email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $role = $row['Role'];
        
        include 'database/closedb.php';
        return $role;
    } else {
        include 'database/closedb.php';
        return null;
    }
}
