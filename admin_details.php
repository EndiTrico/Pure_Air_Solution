<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];

function showDepartmentDropDown($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $id = $_GET['id'];

    if ($entity == 'impianti') {
        $sql = "SELECT r.REPARTO_ID, r.REPARTO_NOME 
                FROM REPARTI r 
                INNER JOIN IMPIANTI i ON r.REPARTO_ID = i.REPARTO_ID
                WHERE i.IMPIANTO_ID = ?
                LIMIT 1";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $execute = mysqli_stmt_get_result($stmt);
    $row_retrieve = mysqli_fetch_assoc($execute);

    include 'database/closedb.php';

    return '<option selected value="' . htmlspecialchars($row_retrieve["REPARTO_ID"]) . '">' . htmlspecialchars($row_retrieve['REPARTO_NOME']) . '</option>';
}

function showStructureDropDown($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $id = $_GET['id'];

    if ($entity == 'reparti') {
        $sql = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME 
                FROM STRUTTURE s 
                INNER JOIN REPARTI d ON s.STRUTTURA_ID = d.STRUTTURA_ID
                WHERE d.REPARTO_ID = ?
                LIMIT 1";
    } else if ($entity == 'impianti') {
        $sql = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME 
                FROM STRUTTURE s 
                INNER JOIN IMPIANTI i ON s.STRUTTURA_ID = i.STRUTTURA_ID
                WHERE i.REPARTO_ID = ?
                LIMIT 1";
    } else if ($entity == 'documenti') {
        $sql = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME 
                FROM STRUTTURE s 
                INNER JOIN DOCUMENTI d ON s.STRUTTURA_ID = d.STRUTTURA_ID
                WHERE d.DOCUMENTO_ID = ?
                LIMIT 1";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $execute = mysqli_stmt_get_result($stmt);
    $row_retrieve = mysqli_fetch_assoc($execute);

    include 'database/closedb.php';

    return '<option selected value="' . htmlspecialchars($row_retrieve["STRUTTURA_ID"]) . '">' . htmlspecialchars($row_retrieve['STRUTTURA_NOME']) . '</option>';
}

function showCompaniesNameDropDown($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $id = $_GET['id'];

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
    $company = mysqli_query($conn, $query);

    $sql = "";
    $companyDropDown = '';

    if ($entity == "utenti") {
        $sql = "SELECT ua.AZIENDA_ID FROM UTENTI u JOIN UTENTI_AZIENDE ua ON u.UTENTE_ID = ua.UTENTE_ID WHERE ua.UTENTE_ID = ?";
    } else if ($entity == "strutture") {
        $sql = "SELECT AZIENDA_ID FROM STRUTTURE WHERE STRUTTURA_ID = ?";
    } else if ($entity == "reparti") {
        $sql = "SELECT AZIENDA_ID FROM REPARTI WHERE REPARTO_ID = ?";
    } else if ($entity == "banca conti") {
        $sql = "SELECT AZIENDA_ID FROM BANCA_CONTI WHERE BANCA_CONTO_ID = ?";
    } else if ($entity == "fatture") {
        $sql = "SELECT AZIENDA_ID FROM FATTURE WHERE FATTURA_ID = ?";
    } else if ($entity == "impianti") {
        $sql = "SELECT AZIENDA_ID FROM IMPIANTI WHERE IMPIANTO_ID = ?";
    } else if ($entity == "documenti") {
        $sql = "SELECT AZIENDA_ID FROM DOCUMENTI WHERE DOCUMENTO_ID = ?";
    }


    $stmt3 = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt3, "i", $id);
    mysqli_stmt_execute($stmt3);
    $execute = mysqli_stmt_get_result($stmt3);
    $selectedOptions = array();

    if ($execute) {
        while ($row_retrieve = mysqli_fetch_assoc($execute)) {
            $selectedOptions[] = $row_retrieve['AZIENDA_ID'];
        }
    }

    if ($company && $stmt3) {
        while ($row = mysqli_fetch_assoc($company)) {
            $selected = (in_array($row['AZIENDA_ID'], $selectedOptions)) ? 'selected' : '';
            $companyDropDown .= '<option ' . $selected . ' value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }

    include 'database/closedb.php';

    return $companyDropDown;
}

function showBankNameDropDown($aziendaID, $bancaContoID)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT BANCA_CONTO_ID, BANCA_NOME FROM BANCA_CONTI WHERE AZIENDA_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $aziendaID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $bankDropDown = "";

        if(empty($bancaContoID) || $bancaContoID == NULL){
            $bankDropDown .= '<option disable selected value="">Seleziona una Banca</option>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['BANCA_CONTO_ID'] == $bancaContoID) ? ' selected' : '';
            $bankDropDown .= '<option value="' . htmlspecialchars($row['BANCA_CONTO_ID']) . '"' . $selected . '>' . htmlspecialchars($row['BANCA_NOME']) . '</option>';
        }

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $bankDropDown = "Errore: " . mysqli_error($conn);
    }

    include 'database/closedb.php';

    return $bankDropDown;
}

function showIBANDropDown($aziendaID, $bancaContoID)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT BANCA_CONTO_ID, IBAN FROM BANCA_CONTI WHERE AZIENDA_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $aziendaID);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $bankDropDown = "";

        if(empty($bancaContoID) || $bancaContoID == NULL){
            $bankDropDown .= '<option disable selected value="">Seleziona un\'IBAN</option>';
        }

        while ($row = mysqli_fetch_assoc($result)) {
            $selected = ($row['BANCA_CONTO_ID'] == $bancaContoID) ? ' selected' : '';
            $bankDropDown .= '<option value="' . htmlspecialchars($row['BANCA_CONTO_ID']) . '"' . $selected . '>' . htmlspecialchars($row['IBAN']) . '</option>';
        }

        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        $bankDropDown = "Errore: " . mysqli_error($conn);
    }

    include 'database/closedb.php';

    return $bankDropDown;
}

function showForm()
{
    include 'database/config.php';
    include 'database/opendb.php';
    $entity = $_GET['entity'];
    $id = $_GET['id'];

    if ($entity == 'utenti') {
        $query = "SELECT * FROM UTENTI WHERE UTENTE_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_user.php';
            $row = mysqli_fetch_assoc($result);
            showUsers($row);
        }
    } else if ($entity == 'aziende') {
        $query = "SELECT * FROM AZIENDE WHERE AZIENDA_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_company.php';

            $row = mysqli_fetch_assoc($result);
            showCompanies($row);
        }
    } else if ($entity == 'strutture') {
        $query = "SELECT * FROM STRUTTURE WHERE STRUTTURA_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_structure.php';

            $row = mysqli_fetch_assoc($result);
            showStructures($row);
        }
    } else if ($entity == "reparti") {
        $query = "SELECT * FROM REPARTI WHERE REPARTO_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_department.php';

            $row = mysqli_fetch_assoc($result);
            showDepartments($row, $id);
        }
    } else if ($entity == "banca conti") {
        $query = "SELECT * FROM BANCA_CONTI WHERE BANCA_CONTO_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_bank_account.php';

            $row = mysqli_fetch_assoc($result);
            showBankAccounts($row);
        }
    } else if ($entity == "fatture") {
        $query = "SELECT * FROM FATTURE WHERE FATTURA_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

      if ($result) {
            include 'client_details_bill.php';

            $row = mysqli_fetch_assoc($result);
            showBills($row);
        }
    } else if ($entity == "impianti") {
        $query = "SELECT * FROM IMPIANTI WHERE IMPIANTO_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_impianto.php';

            $row = mysqli_fetch_assoc($result);
            showImpianti($row);
        }
    } else if ($entity == "documenti") {
        $query = "SELECT * FROM DOCUMENTI WHERE DOCUMENTO_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            include 'client_details_document.php';

            $row = mysqli_fetch_assoc($result);
            showDocuments($row);
        }
    }


    include 'database/closedb.php';
}




?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Visualizza Entita</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet">




    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/moment/min/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment/locale/it.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
  
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
                            <a class="btn transparent-btn" style="margin-top: -7px;" href="admin_display_logs.php">
                                <img alt="Back" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">
                                <?php
                                if ($entity == "utenti") {
                                    echo "Utente";
                                } else if ($entity == "aziende") {
                                    echo "Azienda";
                                } else if ($entity == "strutture") {
                                    echo "Struttura";
                                } else if ($entity == "reparti") {
                                    echo "Reparto";
                                } else if ($entity == "banca conti") {
                                    echo "Conto Bancario";
                                } else if ($entity == "fatture") {
                                    echo "Fattura";
                                } else if ($entity == "impianti") {
                                    echo "Impianto";
                                } else if ($entity == "documenti") {
                                    echo "Documenti";
                                }
                                ?>
                            </h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
                                    <?php showForm() ?>
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
    <script>
        moment.locale('it');

        function capitalizeFirstLetter(word) {
            return word.charAt(0).toUpperCase() + word.slice(1);
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
                months: moment.localeData().months().map(capitalizeFirstLetter), 
                weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter),
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter) // Capitalize weekdaysShort
            },
            onSelect: function () {
                console.log(this.getMoment().format('Do MMMM YYYY'));
            }
        });
    </script>
</body>

</html>