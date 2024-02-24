<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_company'])) {
        $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
        $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);

        $queryCheck = "SELECT COMPANY_ID FROM companies 
        WHERE 
            IS_ACTIVE = 0 
            AND (NAME = ? OR EMAIL = ?)
        LIMIT 1";

        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmtCheck, "ss", $company_name, $company_email);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if ($resultCheck) {
            if (mysqli_num_rows($resultCheck) > 0) {
                $rowCheck = mysqli_fetch_assoc($resultCheck);

                $sql = "UPDATE companies 
                        SET NAME = ?, 
                            EMAIL = ?, 
                            DATE_LEFT = NULL, 
                            IS_ACTIVE = 1 
                        WHERE COMPANY_ID = ?";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssi", $company_name, $company_email, $rowCheck['COMPANY_ID']);

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $successfulMessage = "Company Activated Successfully";
                    } else {
                        $errorMessage = "Error: Failed to Activate Company";
                    }
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            } else {
                $sql = "INSERT INTO companies (NAME, EMAIL, DATE_JOINED, IS_ACTIVE) VALUES 
                (?, ?, DATE(NOW()), 1)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ss", $company_name, $company_email);

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $successfulMessage = "Company Created Successfully";
                    } else {
                        $errorMessage = "Error: Failed to Create Company";
                    }
                } catch (Exception $e) {
                    $errorMessage = $e->getMessage();
                }
            }
        } else {
            $errorMessage = "Error: " . mysqli_error($conn);
        }
    }
}

include 'database/closedb.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />


    <title>Create Company</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_create.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Create Company</h1>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-body">
                                        <form id="companyForm" method="post">
                                            <div class="row">

                                                <?php
                                                if (!empty($errorMessage)) {
                                                    echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div style="height: auto; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert"><h4 style = "padding-top:5px; color: #cc0000; font-weight:bold;">' . $errorMessage . '</h4>
                                                                    </div> 
                                                                </div>                                                    
                                                            </div>
                                                        </div>';
                                                } else if (!empty($successfulMessage)) {
                                                    echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div style="height: auto; font-size:20px; text-align:center; background-color: #ccffcc; color: #006600;" class="alert alert-success" role="alert"><h4 style = "padding-top:5px; color: #006600; font-weight:bold;">' . $successfulMessage . '</h4>
                                                                    </div> 
                                                                </div>                                                    
                                                            </div>
                                                        </div>';
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Company Name</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control" name="company_name" placeholder="Company Name" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Email</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="email" class="form-control" name="company_email" placeholder="Email" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_company" id="createUserButton" class="btn btn-success btn-lg">Create Company</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>
    <script src="js/app.js"></script>

</body>

</html>