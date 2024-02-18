<?php
include 'database/config.php';
include 'database/opendb.php';

$query = "SELECT CONCAT(FIRST_NAME, ' ', LAST_NAME) AS Full_Name FROM users WHERE EMAIL = '" . $_SESSION['email'] . "'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$fullName = $row['Full_Name'];

$query1 = "SELECT FIRST_NAME FROM users WHERE EMAIL = '" . $_SESSION['email'] . "'";
$first_name_result = mysqli_query($conn, $query1);
$first_name_row = mysqli_fetch_assoc($first_name_result);
$first_name = $first_name_row['FIRST_NAME'];

$query2 = "SELECT LAST_NAME FROM users WHERE EMAIL = '" . $_SESSION['email'] . "'";
$last_name_result = mysqli_query($conn, $query2);
$last_name_row = mysqli_fetch_assoc($last_name_result);
$last_name = $last_name_row['LAST_NAME'];

$initials = strtoupper(substr($first_name, 0, 1) . substr($last_name, 0, 1));

include 'database/closedb.php';

function firstName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query1 = "SELECT FIRST_NAME FROM users WHERE EMAIL = '" . $_SESSION['email'] . "'";
    $first_name_result = mysqli_query($conn, $query1);
    $first_name_row = mysqli_fetch_assoc($first_name_result);
    $first_name = $first_name_row['FIRST_NAME'];

    include 'database/closedb.php';
   
    return $first_name;
}

function lastName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query2 = "SELECT LAST_NAME FROM users WHERE EMAIL = '" . $_SESSION['email'] . "'";
    $last_name_result = mysqli_query($conn, $query2);
    $last_name_row = mysqli_fetch_assoc($last_name_result);
    $last_name = $last_name_row['LAST_NAME'];

    include 'database/closedb.php';

    return $last_name;
}

function fullName()
{
    return firstName() . " " . lastName();
}

function initials()
{
    return strtoupper(substr(firstName(), 0, 1) . substr(lastName(), 0, 1));
}