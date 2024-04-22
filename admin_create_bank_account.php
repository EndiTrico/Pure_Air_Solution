<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_bank_account'])) {
        $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
        $bank_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bank_IBAN = mysqli_real_escape_string($conn, $_POST['bank_iban']);
        $bank_left_date = mysqli_real_escape_string($conn, $_POST['bank_left_date']);
        $bank_joined_date = mysqli_real_escape_string($conn, $_POST['bank_joined_date']);

        $queryCheck = "SELECT BANCA_CONTO_ID FROM BANCA_CONTI 
                       WHERE BANCA_NOME = ? 
                            AND IBAN = ?
                       LIMIT 1";
        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        if ($stmtCheck) {
            mysqli_stmt_bind_param($stmtCheck, "ss", $bank_name, $bank_IBAN);

            if (mysqli_stmt_execute($stmtCheck)) {
                $resultCheck = mysqli_stmt_get_result($stmtCheck);
                if (mysqli_num_rows($resultCheck) > 0) {
                    echo 'C\'è una Struttura con Quel nome in Quell\'Agenzia';
                } else {

                    if (empty($bank_left_date)) {
                        $sql = "INSERT INTO BANCA_CONTI (AZIENDA_ID, BANCA_NOME, IBAN, DATA_INIZIO, DATA_FINITO, E_ATTIVO) 
                                VALUES (?, ?, ?, ?, ?, 1)";
                    } else {
                        $sql = "INSERT INTO BANCA_CONTI (AZIENDA_ID, BANCA_NOME, IBAN, DATA_INIZIO, DATA_FINITO, E_ATTIVO) 
                                VALUES (?, ?, ?, ?, ?, 0)";
                    }

                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "issss", $bank_company_id, $bank_name, $bank_IBAN, $bank_joined_date, $bank_left_date);

                        try {
                            if (mysqli_stmt_execute($stmt)) {
                                $successfulMessage = "Il Conto Bancario è Stato Creato con Successo";
                            } else {
                                $errorMessage = "Errore: Impossibile Creare un Conto Bancario";
                            }
                        } catch (mysqli_sql_exception $e) {
                            $errorMessage = "Error: " . $e->getMessage();
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
                    }
                }
            } else {
                $errorMessage = "Errore: Impossibile Eseguire l'Istruzione";
            }

            mysqli_stmt_close($stmtCheck);
        } else {
            $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
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
    $companyDropDown .= '<select class="form-select mb-3" name = "company_name" required>';
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

    <title>Crea un Conto Bancario</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <h1 class="h3 mb-3">Crea un Conto Bancario</h1>
                        </div>
                        <div class="col-12">
                            <div class="card" style="background:url('./images/logo/logo01_backgroundForm.png'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
                                <div class="card-body">
                                    <div class="card-body">
                                        <form id="bankAccountForm" method="post">
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
                                                    <div class="col-12">

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Il Nome Della
                                                                Banca<span style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="bank_name" placeholder="Il Nome Della Banca" required>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Aziende <span style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <?php echo showCompanyName() ?>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">IBAN<span style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <input type="text" class="form-control" name="bank_iban" placeholder="IBAN" required>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Data di
                                                                Inizio<span style="color:red;">*</span>
                                                            </h5>
                                                            <div class="col-sm-4">
                                                                <input readonly type="text" class="form-control" id="datePicker" name="bank_joined_date" placeholder="Data di Inizio" required style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Data di
                                                                Finito
                                                            </h5>
                                                            <div class="col-sm-4">
                                                                <input readonly type="text" class="form-control" id="datePicker" name="bank_left_date" placeholder="Data di Finito" style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_bank_account" id="createBankAccountButton" class="btn btn-success btn-lg">Crea un Conto
                                                            Bancario</button>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>

    <script type="text/javascript">
        const flatpickrInstance = flatpickr("#datePicker", {
            locale: 'it',
            dateFormat: "Y-m-d",
        });
    </script>
</body>

</html>