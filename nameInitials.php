<?php
include 'database/config.php';
include 'database/opendb.php';

$query = "SELECT CONCAT(FIRST_NAME, ' ', LAST_NAME) AS Full_Name FROM users WHERE EMAIL = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fullName);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

$query1 = "SELECT FIRST_NAME FROM users WHERE EMAIL = ?";
$stmt1 = mysqli_prepare($conn, $query1);
mysqli_stmt_bind_param($stmt1, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt1);
mysqli_stmt_bind_result($stmt1, $first_name);
mysqli_stmt_fetch($stmt1);
mysqli_stmt_close($stmt1);

$query2 = "SELECT LAST_NAME FROM users WHERE EMAIL = ?";
$stmt2 = mysqli_prepare($conn, $query2);
mysqli_stmt_bind_param($stmt2, "s", $_SESSION['email']);
mysqli_stmt_execute($stmt2);
mysqli_stmt_bind_result($stmt2, $last_name);
mysqli_stmt_fetch($stmt2);

$initials = strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));

include 'database/closedb.php';

function firstName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query1 = "SELECT FIRST_NAME FROM users WHERE EMAIL = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_bind_result($stmt1, $first_name);
    mysqli_stmt_fetch($stmt1);
    include 'database/closedb.php';

    return ucwords(strtolower($first_name));
}

function lastName()
{
    include 'database/config.php';
    include 'database/opendb.php';
    $query2 = "SELECT LAST_NAME FROM users WHERE EMAIL = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "s", $_SESSION['email']);
    mysqli_stmt_execute($stmt2);
    mysqli_stmt_bind_result($stmt2, $last_name);
    mysqli_stmt_fetch($stmt2);
    include 'database/closedb.php';

    return ucwords(strtolower($last_name));
}

function fullName()
{
    return firstName() . " " . lastName();
}

function initials()
{
    return strtoupper(substr(firstName(), 0, 1) . substr(lastName(), 0, 1));
}