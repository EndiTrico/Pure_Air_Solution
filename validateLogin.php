<?php

function validateLogin($email, $password)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT Password, E_ATTIVO FROM UTENTI WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $hashed_password, $E_ATTIVO);
        mysqli_stmt_fetch($stmt);

        if ($E_ATTIVO == 1) {
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

    $query = "SELECT RUOLO FROM UTENTI WHERE Email=?";
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
