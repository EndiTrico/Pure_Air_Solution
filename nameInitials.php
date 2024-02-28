<?php
include 'database/config.php';
include 'database/opendb.php';

$query = "SELECT CONCAT(NOME, ' ', COGNOME) AS Full_Name FROM UTENTI WHERE EMAIL = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fullName);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$query1 = "SELECT NOME FROM UTENTI WHERE EMAIL = ?";
$stmt1 = mysqli_prepare($conn, $query1);
mysqli_stmt_bind_param($stmt1, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $NOME);
mysqli_stmt_fetch($stmt1);
mysqli_stmt_close($stmt1);

$query2 = "SELECT COGNOME FROM UTENTI WHERE EMAIL = ?";
$stmt2 = mysqli_prepare($conn, $query2);
mysqli_stmt_bind_param($stmt2, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $COGNOME);
mysqli_stmt_fetch($stmt2);

$initials = strtoupper(substr($NOME, 0, 1) . substr($COGNOME, 0, 1));

include 'database/closedb.php';

function firstName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query1 = "SELECT NOME FROM UTENTI WHERE EMAIL = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_bind_result($stmt1, $NOME);
    mysqli_stmt_fetch($stmt1);
    include 'database/closedb.php';

    return ucwords(strtolower($NOME));
}

function lastName()
{
    include 'database/config.php';
    include 'database/opendb.php';
    $query2 = "SELECT COGNOME FROM UTENTI WHERE EMAIL = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $COGNOME);
    mysqli_stmt_fetch($stmt2);
    include 'database/closedb.php';

    return ucwords(strtolower($COGNOME));
}

function fullName()
{
    return firstName() . " " . lastName();
}

function initials()
{
    return strtoupper(substr(firstName(), 0, 1) . substr(lastName(), 0, 1));
}