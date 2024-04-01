<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['create_department'])) {
        $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
        $department_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $department_structure_id = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $department_address = mysqli_real_escape_string($conn, $_POST['department_address']);
        $department_city = mysqli_real_escape_string($conn, $_POST['department_city']);
        $department_information = mysqli_real_escape_string($conn, $_POST['department_information']);

        $queryCheck = "SELECT REPARTO_ID FROM REPARTI 
                        WHERE REPARTO_NOME = ? 
                            AND AZIENDA_ID = ? 
                            AND STRUTTURA_ID = ? 
                        LIMIT 1";

        $stmt = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmt, "sii", $department_name, $department_company_id, $department_structure_id);
        mysqli_stmt_execute($stmt);
        $resultCheck = mysqli_stmt_get_result($stmt);

        if ($resultCheck) {
            if (mysqli_num_rows($resultCheck) > 0) {
                $errorMessage = "C'è un Reparto con Quel Nome in Quella Struttura e Agenzia";
            } else {
                $sql = "INSERT INTO REPARTI (REPARTO_NOME, AZIENDA_ID, STRUTTURA_ID, INDIRIZZO, CITTA, INFORMAZIONI, E_ATTIVO) VALUES 
                        (?, ?, ?, ?, ?, ?, 1)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "siisss", $department_name, $department_company_id, $department_structure_id, $department_address, $department_city, $department_information);

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $successfulMessage = "Reparto Creato con Successo";
                    } else {
                        $errorMessage = "Errore: Impossibile Creare il Reparto";
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

function showCompanyName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";

    $companyDropDown .= '<select class="form-select mb-3" name = "company_name" id="company-dropdown" required>';
    $companyDropDown .= '<option value="" disabled selected>Seleziona un\'Azienda</option>';

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

    <title>Create Department</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
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
                        <div class="col-auto">
                            <a class="btn transparent-btn" href="admin_create.php">
                                <img alt="Back" style="margin-top: -8px;" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">Crea un Reparto</h1>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <form id="departmentForm" method="post">
                                                <div class="row">

                                                    <?php
                                                    if (!empty ($errorMessage)) {
                                                        echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div style="height: auto; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert"><h4 style = "padding-top:5px; color: #cc0000; font-weight:bold;">' . $errorMessage . '</h4>
                                                                    </div> 
                                                                </div>                                                    
                                                            </div>
                                                        </div>';
                                                    } else if (!empty ($successfulMessage)) {
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
                                                        <div class="col-12">
                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">Nome<span
                                                                style="color:red;">*</span></h5>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        name="department_name" placeholder="Nome"
                                                                        required>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">Azienda<span
                                                                style="color:red;">*</span>
                                                                </h5>
                                                                <div class="col-sm-4">
                                                                    <?php echo showCompanyName() ?>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                                                                </h5>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        name="department_address"
                                                                        placeholder="Indirizzo">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">Struttura<span
                                                                style="color:red;">*</span>
                                                                </h5>
                                                                <div class="col-sm-4">
                                                                    <select name="structure_name" id="structure_name"
                                                                        class="form-select mb-3" required>
                                                                        <option disable selected value="">Seleziona una
                                                                            Struttura</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">Citta
                                                                </h5>
                                                                <div class="col-sm-4">
                                                                    <input type="text" class="form-control"
                                                                        name="department_city" placeholder="Citta">
                                                                </div>
                                                            </div>

                                                            <div class="mb-3 row">
                                                                <h5 class="card-title col-sm-2 col-form-label">
                                                                    Informazioni</h5>
                                                                <div class="col-sm-4">
                                                                    <textarea class="form-control"
                                                                        name="department_information" rows="3"
                                                                        placeholder="Informazioni"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button name="create_department" id="createDepartmentButton"
                                                                class="btn btn-success btn-lg">Crea un Reparto</button>
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
                </div>
            </main>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#company-dropdown").change(function () {
                var companyID = $(this).val();
                var post_id = 'id=' + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_structures.php",
                    data: post_id,
                    cache: false,
                    success: function (cities) {
                        $("#structure_name").html(cities);
                    }
                });
            });
        });
    </script>
</body>

</html>