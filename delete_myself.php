<?php
include 'database/config.php';
include 'database/opendb.php';

$email = $_GET['email'];

$queryUsers = "UPDATE users 
               SET IS_ACTIVE = 0
               WHERE EMAIL = ?";

$stmt = mysqli_prepare($conn, $queryUsers);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

include 'database/closedb.php';

header('Location: logout.php');
exit();
