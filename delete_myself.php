<?php
include 'database/config.php';
include 'database/opendb.php';

$email = $_GET['email'];


$queryUsers = "UPDATE users 
                SET IS_ACTIVE = 0
                WHERE EMAIL = '" . $email . "'";

mysqli_query($conn, $queryUsers);

include 'database/closedb.php';

header('Location: logout.php');
exit();
