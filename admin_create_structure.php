<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_structure'])) {
        $STRUTTURA_NOME = mysqli_real_escape_string($conn, $_POST['STRUTTURA_NOME']);
        $AZIENDA_ID = mysqli_real_escape_string($conn, $_POST['AZIENDA_NOME']);

        $queryCheck = "SELECT STRUTTURA_ID FROM STRUTTURE 
                       WHERE STRUTTURA_NOME = ? 
                            AND AZIENDA_ID = ? 
                            AND E_ATTIVO = 0 
                       LIMIT 1";
        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        if ($stmtCheck) {
            mysqli_stmt_bind_param($stmtCheck, "si", $STRUTTURA_NOME, $AZIENDA_ID);

            if (mysqli_stmt_execute($stmtCheck)) {
                $resultCheck = mysqli_stmt_get_result($stmtCheck);
                if (mysqli_num_rows($resultCheck) > 0) {
                    $rowCheck = mysqli_fetch_assoc($resultCheck);

                    $sql = "UPDATE STRUTTURE 
                            SET STRUTTURA_NOME = ?, 
                                E_ATTIVO = 1, 
                                AZIENDA_ID = ?
                            WHERE STRUTTURA_ID = ?";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "sii", $STRUTTURA_NOME, $AZIENDA_ID, $rowCheck['STRUTTURA_ID']);

                        try {
                            if (mysqli_stmt_execute($stmt)) {
                                $successfulMessage = "Structure Activated Successfully";
                            } else {
                                $errorMessage = "Error: Failed to Activate Structure";
                            }
                        } catch (mysqli_sql_exception $e) {
                            $errorMessage = "Error: " . $e->getMessage();
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        $errorMessage = "Error: Failed to prepare statement";
                    }
                } else {
                    $sql = "INSERT INTO STRUTTURE (STRUTTURA_NOME, AZIENDA_ID, E_ATTIVO) VALUES (?, ?, 1)";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "si", $STRUTTURA_NOME, $AZIENDA_ID);

                        try {
                            if (mysqli_stmt_execute($stmt)) {
                                $successfulMessage = "Structure Created Successfully";
                            } else {
                                $errorMessage = "Error: Failed to Create Structure";
                            }
                        } catch (mysqli_sql_exception $e) {
                            $errorMessage = "Error: " . $e->getMessage();
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        $errorMessage = "Error: Failed to prepare statement";
                    }
                }
            } else {
                $errorMessage = "Error: Failed to execute statement";
            }

            mysqli_stmt_close($stmtCheck);
        } else {
            $errorMessage = "Error: Failed to prepare statement";
        }
    }
}

include 'database/closedb.php';

function showAZIENDEName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";
    $companyDropDown .= '<select class="form-select mb-3" name = "AZIENDA_NOME" required>';
    $companyDropDown .= '<option value="" disabled selected>Select Company</option>';

    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $companyDropDown .= '<option value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
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
                                                                <h5 class="card-title mb-0">Structure Name</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control" name="STRUTTURA_NOME" placeholder="Structure Name" required>
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
                                                                    <?php echo showAZIENDEName() ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_structure" id="createStructureButton" class="btn btn-success btn-lg">Create Structure</button>
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