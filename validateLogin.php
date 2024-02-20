<?php

function validateLogin($email, $password)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT * FROM users WHERE Email=? AND Password=? AND IS_ACTIVE = ?";
    $stmt = mysqli_prepare($conn, $query);
    $hashed_password = password_hash('sha256',  $user_password);
    $is_active = 1;
    mysqli_stmt_bind_param($stmt, "ssi", $email, $hashed_password, $is_active);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $numrows = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    include 'database/closedb.php';

    if ($numrows > 0) {
        return ['success' => true];
    } else {
        return ['success' => false, 'message' => "Invalid credentials!"];
    }
}


function determineRole($email)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT Role FROM users WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $role);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    include 'database/closedb.php';

    return $role;
}