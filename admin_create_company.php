<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['create_company'])) {
        $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
        $company_codice_fiscale = mysqli_real_escape_string($conn, $_POST['company_codice_fiscale']);
        $company_contact1 = mysqli_real_escape_string($conn, $_POST['company_contact1']);
        $company_contact2 = mysqli_real_escape_string($conn, $_POST['company_contact2']);
        $company_contact3 = mysqli_real_escape_string($conn, $_POST['company_contact3']);
        $company_telephone1 = mysqli_real_escape_string($conn, $_POST['company_telephone1']);
        $company_telephone2 = mysqli_real_escape_string($conn, $_POST['company_telephone2']);
        $company_telephone3 = mysqli_real_escape_string($conn, $_POST['company_telephone3']);
        $company_nipt = mysqli_real_escape_string($conn, $_POST['company_nipt']);
        $company_website = mysqli_real_escape_string($conn, $_POST['company_website']);
        $company_email1 = mysqli_real_escape_string($conn, $_POST['company_email1']);
        $company_email2 = mysqli_real_escape_string($conn, $_POST['company_email2']);
        $company_email3 = mysqli_real_escape_string($conn, $_POST['company_email3']);
        $company_address = mysqli_real_escape_string($conn, $_POST['company_address']);
        $company_city = mysqli_real_escape_string($conn, $_POST['company_city']);
        $company_address_pec = mysqli_real_escape_string($conn, $_POST['company_address_pec']);
        $company_information = mysqli_real_escape_string($conn, $_POST['company_information']);


        $queryCheck = "SELECT AZIENDA_ID FROM AZIENDE 
                        WHERE PARTITA_IVA = ?
                        LIMIT 1";

        $stmtCheck = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmtCheck, "s", $company_nipt);
        mysqli_stmt_execute($stmtCheck);
        $resultCheck = mysqli_stmt_get_result($stmtCheck);

        if ($resultCheck) {
            if (mysqli_num_rows($resultCheck) < 0) {
                $errorMessage = "Errore: C'è Una Azienda con Quella Partita Iva";
            } else {
                $sql = "INSERT INTO AZIENDE (AZIENDA_NOME, PARTITA_IVA, CODICE_FISCALE, CONTATTO_1, CONTATTO_2, CONTATTO_3, EMAIL_1, EMAIL_2, EMAIL_3,  
                                            TELEFONO_1, TELEFONO_2, TELEFONO_3, INDIRIZZO, CITTA, INDIRIZZO_PEC, WEBSITE, DATA_ISCRIZIONE, INFORMAZIONI, E_ATTIVO) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE(NOW()), ?, 1)";

                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssssiiisssss", $company_name, $company_nipt, $company_codice_fiscale, $company_contact1, $company_contact2, $company_contact3, $company_email1, $company_email2, $company_email3, $company_telephone1, $company_telephone2, $company_telephone3, $company_address, $company_city, $company_address_pec, $company_website, $company_information);

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $successfulMessage = "L'agenzia è Stata Creata con Successo";
                    } else {
                        $errorMessage = "Errore: Impossibile Creare L'Azienda";
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


    <title>Crea un Azienda</title>

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
                        <div class="col-auto">
                            <a class="btn transparent-btn" href="admin_create.php">
                                <img alt="Back" style="margin-top: -8px;" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">Crea un Azienda</h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-body">
                                        <form id="companyForm" method="post">
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
                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Nome <span
                                                                        style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_name" placeholder="Nome" required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Codice Fiscale <span
                                                                        style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_codice_fiscale"
                                                                    placeholder="Codice Fiscale" required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Contatto 1</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_contact1" placeholder="Contatto 1">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Contatto 2</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_contact2" placeholder="Contatto 2">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Contatto 3</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_contact3" placeholder="Contatto 3">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Numero di Telefono 1</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="number" class="form-control"
                                                                    name="company_telephone1"
                                                                    placeholder="Numero di Telefono 1">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Numero di Telefono 2</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="number" class="form-control"
                                                                    name="company_telephone2"
                                                                    placeholder="Numero di Telefono 2">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Numero di Telefono 3</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="number" class="form-control"
                                                                    name="company_telephone3"
                                                                    placeholder="Numero di Telefono 3">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-12 col-lg-6">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Partita Iva <span
                                                                        style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_nipt" placeholder="Partita Iva"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Website </h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_website" placeholder="Website">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Email 1 <span
                                                                        style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_email1" placeholder="Email 1"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Email 2</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_email2" placeholder="Email 2">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Email 3</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_email3" placeholder="Email 3">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Indirizzo</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_address" placeholder="Indirizzo">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Citta</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="text" class="form-control"
                                                                    name="company_city" placeholder="Citta">
                                                            </div>
                                                        </div>
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Indirizzo Pec <span
                                                                        style="color:red;">*</span></h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <input type="email" class="form-control"
                                                                    name="company_address_pec" placeholder="Indirizzo"
                                                                    required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <h5 class="card-title mb-0">Informazioni</h5>
                                                            </div>
                                                            <div class="card-body">
                                                                <textarea class="form-control"
                                                                    name="company_information" rows="3"
                                                                    placeholder="Informazioni"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button name="create_company" id="createUserButton"
                                                            class="btn btn-success btn-lg">Crea un Azienda</button>
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