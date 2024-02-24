<?php

function validateLogin($email, $password)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT Password, IS_ACTIVE FROM users WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $hashed_password, $is_active);
        mysqli_stmt_fetch($stmt);

        if ($is_active == 1) {
            if (password_verify($password, $hashed_password)) {
                mysqli_stmt_close($stmt);
                include 'database/closedb.php';
                return ['success' => true];
            }
        }
    }

    mysqli_stmt_close($stmt);
    include 'database/closedb.php';

    return ['success' => false, 'message' => "Invalid credentials!"];
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
