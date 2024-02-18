<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];

$queryDepartments = "";
$queryStructures = "";
$queryUsers = "";
$queryCompany = "";

if ($entity == "companies") {
    $queryDepartments = "UPDATE departments 
                        SET IS_ACTIVE = 0
                        WHERE COMPANY_ID = " . $id;
    $queryStructures = "UPDATE structures 
                        SET IS_ACTIVE = 0
                        WHERE COMPANY_ID = " . $id;
    $queryUsers = "UPDATE users 
                    SET IS_ACTIVE = 0
                    WHERE COMPANY_ID = " . $id;
    $queryCompany = "UPDATE companies
                    SET IS_ACTIVE = 0,
                    DATE_LEFT = DATE(NOW())
                    WHERE COMPANY_ID = $id ";

    mysqli_query($conn, $queryDepartments);
    mysqli_query($conn, $queryStructures);
    mysqli_query($conn, $queryUsers);
    mysqli_query($conn, $queryCompany);
} else if ($entity == "structures") {
    $queryDepartments = "UPDATE departments 
                        SET IS_ACTIVE = 0
                        WHERE STRUCTURE_ID = " . $id;
    $queryStructures = "UPDATE structures 
                        SET IS_ACTIVE = 0
                        WHERE STRUCTURE_ID = " . $id;

    mysqli_query($conn, $queryDepartments);
    mysqli_query($conn, $queryStructures);

} else if ($entity == "departments") {
    $queryDepartments = "UPDATE departments 
                        SET IS_ACTIVE = 0
                        WHERE DEPARTMENT_ID = " . $id;

    mysqli_query($conn, $queryDepartments);

} else if ($entity == "users") {
    $queryUsers = "UPDATE users 
                    SET IS_ACTIVE = 0
                    WHERE USER_ID = " . $id;
    mysqli_query($conn, $queryUsers);

}

include 'database/closedb.php';

header('Location: admin_display_entities.php');
exit();
