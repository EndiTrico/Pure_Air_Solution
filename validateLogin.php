<?php

function validateLogin($email, $input_password)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT Password, E_ATTIVO FROM UTENTI WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);  
  
  $nr = mysqli_stmt_num_rows($stmt);
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $hashed_password, $E_ATTIVO);
        mysqli_stmt_fetch($stmt);
      
        if ($E_ATTIVO == 1) {
            if (password_verify($input_password, $hashed_password)) {
                mysqli_stmt_close($stmt);
                include 'database/closedb.php';
                return ['success' => true];
            }
             //$input_hash = hash('sha256', $password);
          /*  if ($input_password == $hashed_password) {
                mysqli_stmt_close($stmt);
                include 'database/closedb.php';
                return ['success' => true];
            }*/
        }
    }
  
    mysqli_stmt_close($stmt);
    include 'database/closedb.php';

    return ['success' => false, 'message' => "Credenziali non Valide!"];
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

function determineUserID($email)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT UTENTE_ID FROM UTENTI WHERE Email=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    mysqli_stmt_bind_result($stmt, $user_id);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    
    include 'database/closedb.php';

    return $user_id;
}

