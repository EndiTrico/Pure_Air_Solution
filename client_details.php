<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];

function showStructureDropDown($id)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $sql = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME 
            FROM STRUTTURE s 
            INNER JOIN REPARTI d ON s.STRUTTURA_ID = d.STRUTTURA_ID
            WHERE d.REPARTO_ID = ?
            LIMIT 1";

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
            $row = mysqli_fetch_assoc($result);
            showBills($row);
        }
    }


    include 'database/closedb.php';
}


function showUsers($row)
{
    echo '
<form id="userForm" method="post">
    <div class="row">
        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Nome</h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_first_name" value = "' . $row["NOME"] . '" 
                        disabled>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cognome</h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_last_name" value = "' . $row["COGNOME"] . '"
                        disabled> 
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Azienda Posizione</h5>
                </div>
                <div class="card-body">
                    <input type="text" 
                        name="user_position" class="form-control" value="' . $row["AZIENDA_POSIZIONE"] . '" disabled/> 
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ruolo</h5>
                </div>
                <div class="card-body">
                    <select data-allow-clear="1" name="user_role"
                        class="form-select mb-3" disabled>
                        <option value="" style="margin-right:20px !important;"
                            disabled selected hidden>Seleciona Ruolo</option>
                        <option value="Admin" ' . ($row["RUOLO"] == "Admin" ? 'selected' : '') . '>Admin</option>
                        <option value="Cliente" ' . ($row["RUOLO"] == "Cliente" ? 'selected' : '') . '>Cliente</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Numero</h5>
                </div>
                <div class="card-body">
                    <input type="text" name="user_number"
                        class="form-control" value="' . $row["NUMERO"] . '" disabled />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">E-mail</h5>
                </div>
                <div class="card-body">
                    <div>
                        <input type="email" name="user_email"
                            value="' . $row["EMAIL"] . '" class="form-control" disabled />
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Password</h5>
                </div>
                <div class="card-body">
                    <input type="password"
                        name="user_password" class="form-control" value="" disabled
                        />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aziende</h5>
                </div>
                <div class="card-body">
                    <select
                        name="user_companies[]" id= "select" data-allow-clear="1" multiple disabled>' .
        showCompaniesNameDropDown("utenti") . '
                    </select>
                </div>
            </div>
        </div>
       
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(function () {
    $(\'select\').each(function () {
        $(this).select2({
            theme: \'bootstrap4\',
            width: \'style\',
            allowClear: Boolean($(this).data(\'allow-clear\')),
        });
    });
});
</script>';
}

function showCompanies($row)
{
    echo ' <form id="companyForm" method="post">
    <div class="row">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Nome</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control"
                            name="company_name" value = "' . $row["AZIENDA_NOME"] . '" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Codice Fiscale</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control"
                            name="company_codice_fiscale" value = "' . $row["CODICE_FISCALE"] . '"
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 1</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_1"] . '" 
                            name="company_contact1" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_2"] . '"
                            name="company_contact2" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_1"] . '"
                            name="company_contact3" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 1</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_1"] . '"
                            name="company_telephone1"
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_2"] . '"
                            name="company_telephone2"
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_3"] . '"
                            name="company_telephone3"
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data di Iscrizione</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <input type="text" class="form-control" disabled
                                    id="datePicker" name="company_date_joined"
                                    value = "' . $row["DATA_ISCRIZIONE"] . '"
                                    style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Partita Iva</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value ="' . $row["PARTITA_IVA"] . '"
                            name="company_nipt" 
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Website</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["WEBSITE"] . '"
                            name="company_website"disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 1</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_1'] . '"
                            name="company_email1"
                            disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_2'] . '"
                            name="company_email2" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_3'] . '"
                            name="company_email3" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['INDIRIZZO'] . '"
                            name="company_address" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citta</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['CITTA'] . '" 
                            name="company_city" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo Pec</h5>
                    </div>
                    <div class="card-body">
                        <input type="email" class="form-control"  value = "' . $row['INDIRIZZO_PEC'] . '"
                            name="company_address_pec" 
                            disabled>
                    </div>
                </div>
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Sinistra</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control"
                                id="datePicker1" name="company_date_left"
                                value = "' . $row["DATA_SINISTRA"] . '" disabled 
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                    </div>
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
                            name="company_information" rows="3" disabled
                        >' . $row['INFORMAZIONI'] . '</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
';
}

function showStructures($row)
{
    echo '
<form id="structureForm" method="post">
    <div class="row">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Nome</h5>
                    </div>
                    <div class="card-body" style="height: 78px !important;">
                        <input type="text" class="form-control" name="structure_name" value = "' . $row["STRUTTURA_NOME"] . '" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["INDIRIZZO"] . '"
                            name="structure_address" disabled>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende</h5>
                    </div>
                    <div class="card-body">
                        <div> <select disabled
                        name="structure_companies[]" id= "select" data-allow-clear="1">' .
        showCompaniesNameDropDown("strutture") . '</select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citta</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CITTA"] . '"
                            name="structure_city" disabled>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informazioni</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" disabled
                            name="structure_information" rows="3"
                            >' . $row["INFORMAZIONI"] . '</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(function () {
    $(\'select\').each(function () {
        $(this).select2({
            theme: \'bootstrap4\',
            width: \'style\',
            allowClear: Boolean($(this).data(\'allow-clear\')),
        });
    });
});

</script>';
}

function showDepartments($row, $id)
{
    echo '
    <form id="departmentForm" method="post">
    <div class="row">
        <div class="row">
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Nome</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="department_name" 
                        value = "' . $row["REPARTO_NOME"] . '" disabled>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Azienda</h5>
                    </div>
                    <div class="card-body">
                        <div><select class="form-select mb-3" name = "company_name" id="company-dropdown" disabled>'
        . showCompaniesNameDropDown('reparti') . '</select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" disabled
                        value = "' . $row["INDIRIZZO"] . ' "name="department_address">
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Struttura</h5>
                    </div>
                    <div class="card-body">
                        <select name="structure_name" id="structure_name" class="form-select mb-3" disabled>
                            <option disable selected value="">Seleziona una Struttura</option> ' . showStructureDropDown($id) . '
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citta</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="department_city" 
                        value = "' . $row["CITTA"] . '" disabled>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informazioni</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" disabled name="department_information" rows="3" 
                         >' . $row["INFORMAZIONI"] . '"</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $("#company-dropdown").change(function() {
                var companyID = $(this).val();
                var post_id = \'id=\' + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_structures.php",
                    data: post_id,
                    cache: false,
                    success: function(cities) {
                        $("#structure_name").html(cities);
                    }
                });
            });
        });
    </script>';
}

function showBankAccounts($row)
{
    echo '
<form id="bankAccountForm" method="post">
    <div class="row">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Il Nome Della Banca</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bank_name" 
                        value = "' . $row["BANCA_NOME"] . '" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende</h5>
                    </div>
                    <div class="card-body">
                        <div> <select class="form-select mb-3" name = "company_name" disabled> ' .
        showCompaniesNameDropDown("banca conti") . '</select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">IBAN</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bank_iban" 
                        value = "' . $row["IBAN"] . '" disabled>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>';
}

function showBills($row)
{
    echo '
<form id="billForm" method="post">
    <div class="row">                    
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Il Nome Della Fattura</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bill_name"
                            value = "' . $row["FATTURA_NOME"] . '" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Valore</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" id="value" oninput="calculateValueWithVAT()"
                            name="bill_value" 
                            value = "' . $row["VALORE"] . '"min = 0  max = 100000000000000000000000000 step="any" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende</h5>
                        </div>
                    <div class="card-body">
                         <select class="form-select mb-3" name = "company_name" disabled>' .
        showCompaniesNameDropDown("fatture") . '</select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data di Fatturazione</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <input type="text" class="form-control"
                                    id="datePicker" name="bill_billing_date"
                                    value = "' . $row["DATA_FATTURAZIONE"] . '" disabled
                                    style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Valore Iva Inclusa</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" id="bill_withVAT" disabled 
                            name="bill_withVAT"
                            value = "' . $row["VALORE_IVA_INCLUSA"] . '" min = 0  max = 100000000000000000000000000 step="any" disabled>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">IVA (%)</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" id="VAT" oninput="calculateValueWithVAT()"
                            name="bill_VAT" min="0" max="100" step="any" value = "' . $row["IVA"] . '"
                            disabled>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Moneta</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select class="form-select mb-3" name="bill_currency" disabled>
                                <option value="USD" <?php if ($row["MONETA"] == "USD") echo "selected"; ?>United States Dollar (USD)</option>
                                <option value="EUR" <?php if ($row["MONETA"] == "EUR") echo "selected"; ?>Euro (EUR)</option>
                                <option value="JPY" <?php if ($row["MONETA"] == "JPY") echo "selected"; ?>Japanese Yen (JPY)</option>
                                <option value="GBP" <?php if ($row["MONETA"] == "GBP") echo "selected"; ?>British Pound Sterling (GBP)</option>
                                <option value="AUD" <?php if ($row["MONETA"] == "AUD") echo "selected"; ?>Australian Dollar (AUD)</option>
                                <option value="CAD" <?php if ($row["MONETA"] == "CAD") echo "selected"; ?>Canadian Dollar (CAD)</option>
                                <option value="CHF" <?php if ($row["MONETA"] == "CHF") echo "selected"; ?>Swiss Franc (CHF)</option>
                                <option value="CNY" <?php if ($row["MONETA"] == "CNY") echo "selected"; ?>Chinese Yuan (CNY)</option>
                                <option value="SEK" <?php if ($row["MONETA"] == "SEK") echo "selected"; ?>Swedish Krona (SEK)</option>
                                <option value="NZD" <?php if ($row["MONETA"] == "NZD") echo "selected"; ?>New Zealand Dollar (NZD)</option>
                                <option value="KRW" <?php if ($row["MONETA"] == "KRW") echo "selected"; ?>South Korean Won (KRW)</option>
                                <option value="SGD" <?php if ($row["MONETA"] == "SGD") echo "selected"; ?>Singapore Dollar (SGD)</option>
                                <option value="NOK" <?php if ($row["MONETA"] == "NOK") echo "selected"; ?>Norwegian Krone (NOK)</option>
                                <option value="MXN" <?php if ($row["MONETA"] == "MXN") echo "selected"; ?>Mexican Peso (MXN)</option>
                                <option value="INR" <?php if ($row["MONETA"] == "INR") echo "selected"; ?>Indian Rupee (INR)</option>
                                <option value="RUB" <?php if ($row["MONETA"] == "RUB") echo "selected"; ?>Russian Ruble (RUB)</option>
                                <option value="ZAR" <?php if ($row["MONETA"] == "ZAR") echo "selected"; ?>South African Rand (ZAR)</option>
                                <option value="BRL" <?php if ($row["MONETA"] == "BRL") echo "selected"; ?>Brazilian Real (BRL)</option>
                                <option value="TRY" <?php if ($row["MONETA"] == "TRY") echo "selected"; ?>Turkish Lira (TRY)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data di Pagamento</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <input type="text" class="form-control"
                                id="datePicker1" name="bill_payment_date" disabled
                                value = "' . $row["DATA_PAGAMENTO"] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
               </div>
            </div>
            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Descrizione</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="bill_information" disabled
                            rows="3">' . $row["DESCRIZIONE"] . '</textarea>
                    </div>
                </div>
            </div>
        </div>   
    </div>
</form>

<script>
    function calculateValueWithVAT() {
        var value = parseFloat(document.getElementById("value").value);
        var billVAT = parseFloat(document.getElementById("VAT").value);

        if (isNaN(value)) {
            value = 0;
        }  
        if (isNaN(billVAT)) {
            billVAT = 0;
        }
    
        var valueWithVAT = (value * (1 + (billVAT / 100))).toFixed(2);

        document.getElementById("bill_withVAT").value = valueWithVAT;
    }
</script>
';
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

    <title>Edit Entity</title>

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-BTBZNOArLzKrjzlkrMgXw0S51oBnuy0/HWkCARN0aSUSnt5N6VX/9n6tsQwnPVK68OzI6KARmxx3AeeBfM2y+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <div class="wrapper">
        <?php include "client_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "client_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;"
                                href="client_display_entities.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
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
                                }
                                ?>
                            </h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
                months: moment.localeData().months().map(capitalizeFirstLetter), // Capitalize months
                weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter), // Capitalize weekdays
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter) // Capitalize weekdaysShort
            },
            onSelect: function () {
                console.log(this.getMoment().format('Do MMMM YYYY'));
            }
        });
    </script>
</body>

</html>