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
                        WHERE COMPANY_ID = ?";
    $queryStructures = "UPDATE structures 
                        SET IS_ACTIVE = 0
                        WHERE COMPANY_ID = ?";
    $queryUsers = "UPDATE users 
                    SET IS_ACTIVE = 0
                    WHERE COMPANY_ID = ?";
    $queryCompany = "UPDATE companies
                    SET IS_ACTIVE = 0,
                    DATE_LEFT = DATE(NOW())
                    WHERE COMPANY_ID = ?";

    $stmtDepartments = mysqli_prepare($conn, $queryDepartments);
    $stmtStructures = mysqli_prepare($conn, $queryStructures);
    $stmtUsers = mysqli_prepare($conn, $queryUsers);
    $stmtCompany = mysqli_prepare($conn, $queryCompany);

    mysqli_stmt_bind_param($stmtDepartments, "i", $id);
    mysqli_stmt_bind_param($stmtStructures, "i", $id);
    mysqli_stmt_bind_param($stmtUsers, "i", $id);
    mysqli_stmt_bind_param($stmtCompany, "i", $id);

    mysqli_stmt_execute($stmtDepartments);
    mysqli_stmt_execute($stmtStructures);
    mysqli_stmt_execute($stmtUsers);
    mysqli_stmt_execute($stmtCompany);
} else if ($entity == "structures") {
    $queryDepartments = "UPDATE departments 
                        SET IS_ACTIVE = 0
                        WHERE STRUCTURE_ID = ?";
    $queryStructures = "UPDATE structures 
                        SET IS_ACTIVE = 0
                        WHERE STRUCTURE_ID = ?";

    $stmtDepartments = mysqli_prepare($conn, $queryDepartments);
    $stmtStructures = mysqli_prepare($conn, $queryStructures);

    mysqli_stmt_bind_param($stmtDepartments, "i", $id);
    mysqli_stmt_bind_param($stmtStructures, "i", $id);

    mysqli_stmt_execute($stmtDepartments);
    mysqli_stmt_execute($stmtStructures);
} else if ($entity == "departments") {
    $queryDepartments = "UPDATE departments 
                        SET IS_ACTIVE = 0
                        WHERE DEPARTMENT_ID = ?";

    $stmtDepartments = mysqli_prepare($conn, $queryDepartments);

    mysqli_stmt_bind_param($stmtDepartments, "i", $id);

    mysqli_stmt_execute($stmtDepartments);
} else if ($entity == "users") {
    $queryUsers = "UPDATE users 
                    SET IS_ACTIVE = 0
                    WHERE USER_ID = ?";

    $stmtUsers = mysqli_prepare($conn, $queryUsers);

    mysqli_stmt_bind_param($stmtUsers, "i", $id);

    mysqli_stmt_execute($stmtUsers);
}

include 'database/closedb.php';

header('Location: admin_display_entities.php');
exit();