<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_impianto'])) {
        $impianto_nome = mysqli_real_escape_string($conn, $_POST['impianto_nome']);
        $impianto_capacita_uta = mysqli_real_escape_string($conn, $_POST['impianto_capacita_uta']);
        $impianto_ripresa = mysqli_real_escape_string($conn, $_POST['impianto_ripresa']);
        $impianto_espulsione = mysqli_real_escape_string($conn, $_POST['impianto_espulsione']);
        $impianto_data_inizio_utilizzo = mysqli_real_escape_string($conn, $_POST['impianto_data_inizio_utilizzo']);
        $impianto_mandata = mysqli_real_escape_string($conn, $_POST['impianto_mandata']);
        $impianto_data_ultima_att = mysqli_real_escape_string($conn, $_POST['impianto_data_ultima_att']);
        $impianto_ultima_attivita = mysqli_real_escape_string($conn, $_POST['impianto_ultima_attivita']);
        $impianto_presa_aria_esterna = mysqli_real_escape_string($conn, $_POST['impianto_presa_aria_esterna']);

        $impianto_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $impianto_structure_id = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $impianto_department_id = mysqli_real_escape_string($conn, $_POST['department_name']);


        $queryCheck = "SELECT IMPIANTO_ID FROM IMPIANTI
                        WHERE NOME_UTA = ?
                            AND AZIENDA_ID = ?
                            AND STRUTTURA_ID = ?
                            AND REPARTO_ID = ?
                        LIMIT 1";

        $stmt = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmt, "siii", $impianto_nome, $impianto_company_id, $impianto_structure_id, $impianto_department_id);
        mysqli_stmt_execute($stmt);
        $resultCheck = mysqli_stmt_get_result($stmt);

        if ($resultCheck) {
            if (mysqli_num_rows($resultCheck) > 0) {
                $errorMessage = "C'è un Reparto con Quel Nome in Quella Struttura, Reparto e Agenzia";
            } else {
                $sql = "INSERT INTO IMPIANTI 
                (NOME_UTA, AZIENDA_ID, STRUTTURA_ID, REPARTO_ID, CAPACITA_UTA, MANDATA, RIPRESA, 
                ESPULSIONE, PRESA_ARIA_ESTERNA, ULTIMA_ATTIVITA, DATA_DI_INIZIO_UTILIZZO, 
                DATA_ULTIMA_ATT, E_ATTIVO) VALUES 
                        (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param(
                    $stmt,
                    "siiidddddsss",
                    $impianto_nome,
                    $impianto_company_id,
                    $impianto_structure_id,
                    $impianto_department_id,
                    $impianto_capacita_uta,
                    $impianto_mandata,
                    $impianto_ripresa,
                    $impianto_espulsione,
                    $impianto_presa_aria_esterna,
                    $impianto_ultima_attivita,
                    $impianto_data_inizio_utilizzo,
                    $impianto_data_ultima_att
                );

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $successfulMessage = "Impianto Creato con Successo";
                    } else {
                        $errorMessage = "Errore: Impossibile Creare il Impianto";
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

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE WHERE E_ATTIVO = 1";
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

    <title>Crea un Impianto</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/locale/it.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-BTBZNOArLzKrjzlkrMgXw0S51oBnuy0/HWkCARN0aSUSnt5N6VX/9n6tsQwnPVK68OzI6KARmxx3AeeBfM2y+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- FlatPickr  - Input Date -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .form-select {
            color: #6d6f72 !important;
        }
    </style>
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
                            <a class="btn transparent-btn" style="margin-top: -7px;" href="admin_create.php">
                                <img alt="Back" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">Crea un Impianto</h1>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="background:url('./images/logo/logo01_backgroundForm.png'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <form id="impiantoForm" method="post">
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
                                                    } elseif (!empty($successfulMessage)) {
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

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Nome Uta<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="impianto_nome" placeholder="Nome" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Capacita Uta<span style="color:red;">*</span>
                                                        </h5>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="impianto_capacita_uta" name="impianto_capacita_uta" placeholder="Capacita Uta" min=0 max=100000000000000000000000000 step="any" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Ripresa<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="impianto_ripresa" name="impianto_ripresa" placeholder="Ripresa" min=0 max=100000000000000000000000000 step="any" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Espulsione<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="impianto_espulsione" name="impianto_espulsione" placeholder="Espulsione" min=0 max=100000000000000000000000000 step="any" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Azienda<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <?php echo showCompanyName() ?>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Struttura<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                                                                <option disable selected value="">Seleziona una
                                                                    Struttura</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Reparto<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <select name="department_name" id="department_name" class="form-control form-select mb-3" required>
                                                                <option disable selected value="">Seleziona un
                                                                    Reparto</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">
                                                            Mandata<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="impianto_mandata" name="impianto_mandata" placeholder="Mandata" min=0 max=100000000000000000000000000 step="any" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Presa Aria
                                                            Esterna<span style="color:red;">*</span></h5>
                                                        <div class="col-sm-4">
                                                            <input type="number" class="form-control" id="impianto_presa_aria_esterna" name="impianto_presa_aria_esterna" placeholder="Presa Aria Esterna" min=0 max=100000000000000000000000000 step="any" required>
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Ultima Attivita
                                                        </h5>
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control" name="impianto_ultima_attivita" placeholder="Ultima Attivita">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Data di Inizio
                                                            Utilizzo
                                                        </h5>
                                                        <div class="col-sm-4">
                                                            <input readonly type="text" class="form-control" id="datePicker" name="impianto_data_inizio_utilizzo" placeholder="Data di Inizio Utilizzo" style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white;">
                                                        </div>
                                                    </div>

                                                    <div class="mb-3 row d-flex justify-content-center">
                                                        <h5 class="card-title col-sm-2 col-form-label">Data Ultima Att
                                                        </h5>
                                                        <div class="col-sm-4">
                                                            <input readonly type="text" class="form-control" id="datePicker" name="impianto_data_ultima_att" placeholder="Data Ultima Att" style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <button name="create_impianto" id="createImpiantoButton" class="btn btn-success btn-lg">Crea un
                                                    Impianto</button>
                                            </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
    <script>
        const flatpickrInstance = flatpickr("#datePicker", {
            locale: 'it',
            dateFormat: "Y-m-d",
        });
        $(document).ready(function() {
            $("#company-dropdown").change(function() {
                var companyID = $(this).val();
                var post_id = 'id=' + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_structures.php",
                    data: post_id,
                    cache: false,
                    success: function(structure) {
                        $("#structure_name").html(structure);
                        $('#structure_name').trigger('change');
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#structure_name").change(function() {
                var companyID = $(this).val();
                var post_id = 'id=' + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_departments.php",
                    data: post_id,
                    cache: false,
                    success: function(department) {
                        $("#department_name").html(department);
                    }
                });
            });
        });
    </script>
</body>

</html>