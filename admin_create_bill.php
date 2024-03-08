<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_bill'])) {
        $bill_name = mysqli_real_escape_string($conn, $_POST['bill_name']);
        $bank_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bank_IBAN = mysqli_real_escape_string($conn, $_POST['bank_iban']);


        $queryCheck = "SELECT STRUTTURA_ID FROM STRUTTURE 
                       WHERE STRUTTURA_NOME = ? 
                            AND AZIENDA_ID = ? 
                       LIMIT 1";

        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        if ($stmtCheck) {
            mysqli_stmt_bind_param($stmtCheck, "si", $structure_name, $structure_company_id);

            if (mysqli_stmt_execute($stmtCheck)) {
                $resultCheck = mysqli_stmt_get_result($stmtCheck);
                if (mysqli_num_rows($resultCheck) > 0) {
                    echo 'C\'è una Struttura con Quel nome in Quell\'Agenzia';
                } else {
                    $sql = "INSERT INTO STRUTTURE (AZIENDA_ID, STRUTTURA_NOME, INDIRIZZO, CITTA, INFORMAZIONI, E_ATTIVO) 
                            VALUES (?, ?, ?, ?, ?, 1)";
                    $stmt = mysqli_prepare($conn, $sql);
                    if ($stmt) {
                        mysqli_stmt_bind_param($stmt, "issss", $structure_company_id, $structure_name, $structure_address, $structure_city, $structure_information);

                        try {
                            if (mysqli_stmt_execute($stmt)) {
                                $successfulMessage = "Struttura Creata con Successo";
                            } else {
                                $errorMessage = "Errore: Impossibile Creare la Struttura";
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

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
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


    <title>Crea una Fattura</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>






    </body>
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
                            <h1 class="h3 mb-3">Crea una Fattura</h1>
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
                                                                <h5 class="card-title mb-0">Il Nome Della Fattura <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control" name="bill_name" placeholder="Il Nome Della Fattura" required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Valore <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="number" class="form-control" name="bill_value" placeholder="Value" required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Aziende <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div>
                                                                    <?php echo showCompanyName() ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Stato del Pagamento <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body" style="height: 73px !important;">
                                                                <div class="row">
                                                                    <div class="col-auto">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" value=1 type="radio" name="bill_paid" id="flexRadioDefault1">
                                                                            <label class="form-check-label" for="flexRadioDefault1">
                                                                                Pagata
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" value=0 type="radio" name="bill_paid" id="flexRadioDefault2" checked>
                                                                            <label class="form-check-label" for="flexRadioDefault2">
                                                                                Non Pagato
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">IVA (%) <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="number" class="form-control" name="bill_IVA" placeholder="IVA" min="0" max="100" step="0.5" required>
                                                            </div>
                                                        </div>

                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Moneta <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group">
                                                                    <select class="form-select mb-3" name="bill_currency" required>
                                                                        <option value="" disabled selected>Seleziona la Valuta</option>
                                                                        <option value="USD">United States Dollar (USD)</option>
                                                                        <option value="EUR">Euro (EUR)</option>
                                                                        <option value="JPY">Japanese Yen (JPY)</option>
                                                                        <option value="GBP">British Pound Sterling (GBP)</option>
                                                                        <option value="AUD">Australian Dollar (AUD)</option>
                                                                        <option value="CAD">Canadian Dollar (CAD)</option>
                                                                        <option value="CHF">Swiss Franc (CHF)</option>
                                                                        <option value="CNY">Chinese Yuan (CNY)</option>
                                                                        <option value="SEK">Swedish Krona (SEK)</option>
                                                                        <option value="NZD">New Zealand Dollar (NZD)</option>
                                                                        <option value="KRW">South Korean Won (KRW)</option>
                                                                        <option value="SGD">Singapore Dollar (SGD)</option>
                                                                        <option value="NOK">Norwegian Krone (NOK)</option>
                                                                        <option value="MXN">Mexican Peso (MXN)</option>
                                                                        <option value="INR">Indian Rupee (INR)</option>
                                                                        <option value="RUB">Russian Ruble (RUB)</option>
                                                                        <option value="ZAR">South African Rand (ZAR)</option>
                                                                        <option value="BRL">Brazilian Real (BRL)</option>
                                                                        <option value="TRY">Turkish Lira (TRY)</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>



                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">IBAN <span style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="form-group mb-4">
                                                                    <div class="form-group">
                                                                        <input type="date" class="form-control" id="exampleDate" name="date" placeholder = "SELECT">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_bill" id="createBillButton" class="btn btn-success btn-lg">Crea una Fattura</button>
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
   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>

</html>