<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_structure'])) {
        $structure_name = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $company_id = mysqli_real_escape_string($conn, $_POST['company_name']);

        $queryCheck = "SELECT STRUCTURE_ID FROM structures 
                        WHERE NAME = '$structure_name' 
                            AND COMPANY_ID = $company_id 
                            AND IS_ACTIVE = 0 
                        LIMIT 1";
        $resultCheck = mysqli_query($conn, $queryCheck);

        if (mysqli_num_rows($resultCheck) > 0) {
            $rowCheck = mysqli_fetch_assoc($resultCheck);

            $sql = "UPDATE structures 
                    SET 
                        NAME = '$structure_name', 
                        IS_ACTIVE = 1, 
                        COMPANY_ID = '$company_id'
                    WHERE STRUCTURE_ID =" . $rowCheck['STRUCTURE_ID'];

            try {
                if (mysqli_query($conn, $sql)) {
                    $successfulMessage = "Structure Activated Successfully";
                } else {
                    $errorMessage = "Error: Failed to Activate Structure";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        } else {
            $sql = "INSERT INTO structures (NAME, COMPANY_ID, IS_ACTIVE) VALUES 
                    ('$structure_name', '$company_id', 1)";
            try {
                if (mysqli_query($conn, $sql)) {
                    $successfulMessage = "Structure Created Successfully";
                } else {
                    $errorMessage = "Error: Failed to Create Structure";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        }
    }
}

include 'database/closedb.php';

function showCompaniesName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT COMPANY_ID, NAME FROM Companies";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";
    $companyDropDown .= '<select class="form-select mb-3" name = "company_name" required>';
    $companyDropDown .= '<option value="" disabled selected>Select Company</option>';

    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $companyDropDown .= '<option value="' . $row['COMPANY_ID'] . '">' . htmlspecialchars($row['NAME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }

    $companyDropDown .= '</select>';

    include 'database/closedb.php';

    return $companyDropDown;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />


    <title>Create Structure</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="wrapper">
        <?php include "verticalNavBar.php"; ?>
        <div class="main">
            <?php include "horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_create.php"><img
                                    src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Create Structure</h1>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-body">
                                        <form id="structureForm" method="post">
                                            <div class="row">
                                                <?php
                                                if (!empty($errorMessage)) {
                                                    echo '<div class="col-12"> <div class="card"> <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert">' . $errorMessage . '</div>                                                    </div>
                                                    </div> </div>';
                                                } else if (!empty($successfulMessage)) {
                                                    echo '<div class="col-12"> <div class="card"> <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ccffcc; color: #006600;" class="alert alert-success" role="alert">' . $successfulMessage . '</div>                                                    </div>
                                                    </div></div>';
                                                }
                                                ?>

                                                <div class="row">
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Structure Name</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="structure_name" placeholder="Structure Name"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Company</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div>
                                                                    <?php echo showCompaniesName() ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_structure" id="createStructureButton"
                                                            class="btn btn-success btn-lg">Create Structure</button>
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