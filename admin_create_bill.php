<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_bill'])) {
        $bill_name = mysqli_real_escape_string($conn, $_POST['bill_name']);
        $bill_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bill_value = ROUND(($_POST['bill_value']), 2);
        $bill_billing_date = mysqli_real_escape_string($conn, $_POST['bill_billing_date']);
        $bill_VAT = ROUND($_POST['bill_VAT'], 2);
        $bill_currency = mysqli_real_escape_string($conn, $_POST['bill_currency']);
        $bill_payment_date = mysqli_real_escape_string($conn, $_POST['bill_payment_date']);
        $bill_information = mysqli_real_escape_string($conn, $_POST['bill_information']);
        $bill_value_with_VAT = ROUND((float) $_POST['bill_withVAT'], 2);

        $sql = "INSERT INTO FATTURE (AZIENDA_ID, FATTURA_NOME, DESCRIZIONE, VALORE, VALORE_IVA_INCLUSA, IVA, MONETA, DATA_FATTURAZIONE, DATA_PAGAMENTO, E_PAGATO) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issdddsss", $bill_company_id, $bill_name, $bill_information, $bill_value, $bill_value_with_VAT, $bill_VAT, $bill_currency, $bill_billing_date, $bill_payment_date);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "Fattura è Stata Creata con Successo";
                } else {
                    $errorMessage = "Errore: Impossibile Creare la Fattura";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }

            mysqli_stmt_close($stmt);
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



    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/locale/it.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-BTBZNOArLzKrjzlkrMgXw0S51oBnuy0/HWkCARN0aSUSnt5N6VX/9n6tsQwnPVK68OzI6KARmxx3AeeBfM2y+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

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
                        <div class="col-auto">
                            <a class="btn transparent-btn" href="admin_create.php">
                                <img alt="Back" style="margin-top: -8px;" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">Crea una Fattura</h1>
                        </div>

                        <div class="col-12">
                            <div class="card"
                                style="background:url('./images/logo/logo01_backgroundForm.png'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
                                <div class="card-body">
                                    <div class="card-body">
                                        <form id="billForm" method="post">
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
                                                            <h5 class="card-title col-sm-2 col-form-label">Valore<span
                                                                    style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <input type="number" class="form-control" id="value"
                                                                    oninput="calculateValueWithVAT()" name="bill_value"
                                                                    placeholder="Valore" min=0
                                                                    max=100000000000000000000000000 step="any" required>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Aziende<span
                                                                    style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <?php echo showCompanyName() ?>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Data di
                                                                Fatturazione</h5>
                                                            <div class="col-sm-4">
                                                                <input readonly type="text" class="form-control"
                                                                    id="datePicker" name="bill_billing_date"
                                                                    placeholder="Data di Fatturazione"
                                                                    style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Valore Iva
                                                                Inclusa</h5>
                                                            <div class="col-sm-4">
                                                                <input type="number" class="form-control"
                                                                    id="bill_withVAT" name="bill_withVAT"
                                                                    placeholder="Valore Iva Inclusa" min=0 value = "0"
                                                                    max=100000000000000000000000000 step="any" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">IVA (%)<span
                                                                    style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <input type="number" class="form-control" id="VAT"
                                                                    oninput="calculateValueWithVAT()" name="bill_VAT"
                                                                    placeholder="IVA" min="0" max="100" step="any"
                                                                    required>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Moneta<span
                                                                    style="color:red;">*</span></h5>
                                                            <div class="col-sm-4">
                                                                <div class="form-group">
                                                                    <select class="form-select mb-3"
                                                                        name="bill_currency" required>
                                                                        <option value="" disabled selected>Seleziona la
                                                                            Valuta</option>
                                                                        <option value="USD">United States Dollar (USD)
                                                                        </option>
                                                                        <option value="EUR">Euro (EUR)</option>
                                                                        <option value="JPY">Japanese Yen (JPY)</option>
                                                                        <option value="GBP">British Pound Sterling (GBP)
                                                                        </option>
                                                                        <option value="AUD">Australian Dollar (AUD)
                                                                        </option>
                                                                        <option value="CAD">Canadian Dollar (CAD)
                                                                        </option>
                                                                        <option value="CHF">Swiss Franc (CHF)</option>
                                                                        <option value="CNY">Chinese Yuan (CNY)</option>
                                                                        <option value="SEK">Swedish Krona (SEK)</option>
                                                                        <option value="NZD">New Zealand Dollar (NZD)
                                                                        </option>
                                                                        <option value="KRW">South Korean Won (KRW)
                                                                        </option>
                                                                        <option value="SGD">Singapore Dollar (SGD)
                                                                        </option>
                                                                        <option value="NOK">Norwegian Krone (NOK)
                                                                        </option>
                                                                        <option value="MXN">Mexican Peso (MXN)</option>
                                                                        <option value="INR">Indian Rupee (INR)</option>
                                                                        <option value="RUB">Russian Ruble (RUB)</option>
                                                                        <option value="ZAR">South African Rand (ZAR)
                                                                        </option>
                                                                        <option value="BRL">Brazilian Real (BRL)
                                                                        </option>
                                                                        <option value="TRY">Turkish Lira (TRY)</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Data di
                                                                Pagamento
                                                            </h5>
                                                            <div class="col-sm-4">
                                                                <input readonly type="text" class="form-control"
                                                                    id="datePicker1" name="bill_payment_date"
                                                                    placeholder="Data di Pagamento"
                                                                    style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                            </div>
                                                        </div>

                                                        <div class="mb-3 row d-flex justify-content-center">
                                                            <h5 class="card-title col-sm-2 col-form-label">Descrizione
                                                            </h5>
                                                            <div class="col-sm-4">

                                                                <textarea class="form-control" name="bill_information"
                                                                    rows="3" placeholder="Descrizione"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-12 d-flex justify-content-center">
                                                                <button name="create_bill" id="createBillButton"
                                                                    class="btn btn-success btn-lg">Crea una
                                                                    Fattura</button>
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


    <script>
        moment.locale('it');

        function capitalizeFirstLetter(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
        }

        function calculateValueWithVAT() {
            var value = parseFloat(document.getElementById("value").value);
            var billVAT = parseFloat(document.getElementById("VAT").value);

            if (isNaN(value)) {
                value = 0;
            }
            if (isNaN(billVAT)) {
                billVAT = 0;
            }

            var valueWithVAT = (value * (1 + (billVAT / 100)));

            document.getElementById("bill_withVAT").value = valueWithVAT.toFixed(2);;
        }


        var picker = new Pikaday({
            field: document.getElementById('datePicker'),
            format: 'YYYY-MM-DD',
            i18n: {
                previousMonth: 'Mese Precedente',
                nextMonth: 'Mese Successivo',
                months: moment.localeData().months().map(capitalizeFirstLetter), // Capitalize months
                weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter), // Capitalize weekdays
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter) // Capitalize weekdaysShort
            },
            onSelect: function () {
                console.log(this.getMoment().format('Do MMMM YYYY'));
            }
        });

        var picker = new Pikaday({
            field: document.getElementById('datePicker1'),
            format: 'YYYY-MM-DD',
            i18n: {
                previousMonth: 'Mese Precedente',
                nextMonth: 'Mese Successivo',
                months: moment.localeData().months().map(capitalizeFirstLetter), // Capitalize months
                weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter), // Capitalize weekdays
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter) // Capitalize weekdaysShort
            },
            onSelect: function () {
                console.log(this.getMoment().format('Do MMMM YYYY'));
            }
        });
    </script>
    <script src="js/app.js"></script>
</body>

</html>