<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['update_user'])) {
        $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
        $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
        $user_position = mysqli_real_escape_string($conn, $_POST['user_position']);
        $user_number = mysqli_real_escape_string($conn, $_POST['user_number']);
        if (!empty ($_POST['user_companies'])) {
            $user_companies = $_POST['user_companies'];
        }

        $sql = "";

        if (empty ($user_password)) {
            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        EMAIL = ?, 
                        RUOLO = ?, 
                        NUMERO = ?,
                        AZIENDA_POSIZIONE = ?
                    WHERE UTENTE_ID = ?";
            $params = array($user_first_name, $user_last_name, $user_email, $user_role, $user_number, $user_position, $id);
        } else {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        EMAIL = ?, 
                        RUOLO = ?, 
                        NUMERO = ?,
                        AZIENDA_POSIZIONE = ?,
                        PASSWORD = ?
                        WHERE UTENTE_ID = ?";
            $params = array($user_first_name, $user_last_name, $user_email, $user_role, $user_number, $user_position, $hashed_password, $id);
        }

        try {
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                if (empty ($user_password)) {
                    mysqli_stmt_bind_param($stmt, "ssssisi", ...$params);
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssissi", ...$params);
                }
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);
                    $sql1 = "DELETE 
                            FROM UTENTI_AZIENDE
                            WHERE UTENTE_ID = ? ";
                    $stmt1 = mysqli_prepare($conn, $sql1);
                    mysqli_stmt_bind_param($stmt1, "i", $id);
                    mysqli_stmt_execute($stmt1);

                    if (!empty ($user_companies)) {
                        foreach ($user_companies as $company_id) {
                            $sql2 = "INSERT INTO UTENTI_AZIENDE (UTENTE_ID, AZIENDA_ID) VALUES (?, ?)";

                            $company_id = (int) $company_id;

                            $stmt2 = mysqli_prepare($conn, $sql2);
                            mysqli_stmt_bind_param($stmt2, "ii", $id, $company_id);
                            mysqli_stmt_execute($stmt2);
                        }
                        mysqli_stmt_close($stmt2);
                    }

                    $successfulMessage = "Utente Aggiornato con Successo";
                } else {
                    mysqli_stmt_close($stmt);
                    $errorMessage = "Errore: Impossibile Aggiornare l'Utente";
                }
            } else {
                $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    } else if (isset ($_POST['update_company'])) {
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
        $company_date_joined = mysqli_real_escape_string($conn, $_POST['company_date_joined']);
        $company_date_left = mysqli_real_escape_string($conn, $_POST['company_date_left']);

        $sql = "UPDATE AZIENDE 
                SET AZIENDA_NOME = ?,
                    PARTITA_IVA = ?,
                    CODICE_FISCALE = ?,
                    CONTATTO_1 = ?,
                    CONTATTO_2 = ?,
                    CONTATTO_3 = ?,
                    EMAIL_1 = ?,
                    EMAIL_2 = ?,
                    EMAIL_3 = ?,
                    TELEFONO_1 = ?,
                    TELEFONO_2 = ?,
                    TELEFONO_3 = ?,
                    INDIRIZZO = ?,
                    CITTA = ?,
                    INDIRIZZO_PEC = ?,
                    WEBSITE = ?,
                    INFORMAZIONI = ?,
                    DATA_ISCRIZIONE = ?,
                    DATA_SINISTRA = ?
                WHERE 
                    AZIENDA_ID = ?;";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssiiisssssssi",
                $company_name,
                $company_nipt,
                $company_codice_fiscale,
                $company_contact1,
                $company_contact2,
                $company_contact3,
                $company_email1,
                $company_email2,
                $company_email3,
                $company_telephone1,
                $company_telephone2,
                $company_telephone3,
                $company_address,
                $company_city,
                $company_address_pec,
                $company_website,
                $company_information,
                $company_date_joined,
                $company_date_left,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {
                $successfulMessage = "Azienda Aggiornata con Successo";
            } else {
                $errorMessage = "Errore: Impossibile Aggiornare la Azienda";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
        }
    } else if (isset ($_POST['update_structure'])) {
        $structure_name = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $structure_company_id = $_POST['company_name'];
        $structure_address = mysqli_real_escape_string($conn, $_POST['structure_address']);
        $structure_city = mysqli_real_escape_string($conn, $_POST['structure_city']);
        $structure_information = mysqli_real_escape_string($conn, $_POST['structure_information']);

        $sql = "UPDATE STRUTTURE 
                SET AZIENDA_ID = ?,
                    STRUTTURA_NOME = ?, 
                    INDIRIZZO = ?, 
                    CITTA = ?, 
                    INFORMAZIONI = ? 
                WHERE STRUTTURA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssi", $structure_company_id, $structure_name, $structure_address, $structure_city, $structure_information, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "Struttura Aggiornata con Successo";
                } else {
                    $errorMessage = "Errore: Impossibile Aggiornare la Struttura";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        } else {
            $errorMessage = "Errore: Impossibile Eseguire l'Istruzione";
        }
    } else if (isset ($_POST['update_department'])) {
        $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
        $department_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $department_structure_id = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $department_address = mysqli_real_escape_string($conn, $_POST['department_address']);
        $department_city = mysqli_real_escape_string($conn, $_POST['department_city']);
        $department_information = mysqli_real_escape_string($conn, $_POST['department_information']);

        $sql = "UPDATE REPARTI 
                SET REPARTO_NOME = ?, 
                    AZIENDA_ID = ?, 
                    STRUTTURA_ID = ?, 
                    INDIRIZZO = ?, 
                    CITTA = ?, 
                    INFORMAZIONI = ? 
                WHERE REPARTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siisssi", $department_name, $department_company_id, $department_structure_id, $department_address, $department_city, $department_information, $id);

            if (mysqli_stmt_execute($stmt)) {
                $successfulMessage = "Reparto Aggiornato con Successo";
            } else {
                $errorMessage = "Errore: Impossibile Aggiornare il Reparto";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
        }
    } else if (isset ($_POST['update_bank_account'])) {
        $bank_name = mysqli_real_escape_string($conn, $_POST['bank_name']);
        $bank_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bank_IBAN = mysqli_real_escape_string($conn, $_POST['bank_iban']);

        $sql = "UPDATE BANCA_CONTI 
                SET AZIENDA_ID = ?, 
                    BANCA_NOME = ?, 
                    IBAN = ? 
                WHERE BANCA_CONTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issi", $bank_company_id, $bank_name, $bank_IBAN, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "Il Conto Bancario è Stato Aggiornato con Successo";
                } else {
                    $errorMessage = "Errore: Impossibile Aggiornare  un Conto Bancario";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
        }
    } else if (isset ($_POST['update_bill'])) {
        $bill_name = mysqli_real_escape_string($conn, $_POST['bill_name']);
        $bill_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bill_value = ROUND(($_POST['bill_value']), 2);
        $bill_billing_date = mysqli_real_escape_string($conn, $_POST['bill_billing_date']);
        $bill_VAT = ROUND($_POST['bill_VAT'], 2);
        $bill_currency = mysqli_real_escape_string($conn, $_POST['bill_currency']);
        $bill_payment_date = mysqli_real_escape_string($conn, $_POST['bill_payment_date']);
        $bill_information = mysqli_real_escape_string($conn, $_POST['bill_information']);
        $bill_value_with_VAT = ROUND($_POST['bill_withVAT'], 2);

        $sql = "UPDATE FATTURE 
                SET AZIENDA_ID = ?, 
                    FATTURA_NOME = ?, 
                    DESCRIZIONE = ?, 
                    VALORE = ?, 
                    VALORE_IVA_INCLUSA = ?, 
                    IVA = ?, 
                    MONETA = ?, 
                    DATA_FATTURAZIONE = ?, 
                    DATA_PAGAMENTO = ?
        WHERE FATTURA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issdddsssi", $bill_company_id, $bill_name, $bill_information, $bill_value, $bill_value_with_VAT, $bill_VAT, $bill_currency, $bill_billing_date, $bill_payment_date, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "Fattura è Stata Aggiornata con Successo";
                } else {
                    $errorMessage = "Errore: Impossibile Aggiornata la Fattura";
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
    } else if ($entity == "impianti") {
        $query = "SELECT * FROM IMPIANTI WHERE IMPIANTO_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            showImpianti($row);
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
                    <h5 class="card-title mb-0">Nome <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_first_name" value = "' . $row["NOME"] . '" 
                        placeholder="Nome" required>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cognome <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_last_name" value = "' . $row["COGNOME"] . '"
                        placeholder="Cognome" required> 
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Azienda Posizione</h5>
                </div>
                <div class="card-body">
                    <input type="text" placeholder="Azienda Posizione"
                        name="user_position" class="form-control" value="' . $row["AZIENDA_POSIZIONE"] . '" /> 
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Ruolo <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <div>
                        <select data-allow-clear="1" name="user_role"
                            class="form-select mb-3" required>
                            <option value="" style="margin-right:20px !important;"
                                disabled selected hidden>Seleciona Ruolo</option>
                            <option value="Admin" ' . ($row["RUOLO"] == "Admin" ? 'selected' : '') . '>Admin</option>
                            <option value="Cliente" ' . ($row["RUOLO"] == "Cliente" ? 'selected' : '') . '>Cliente</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Numero <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="text" placeholder="Numero" name="user_number"
                        class="form-control" value="' . $row["NUMERO"] . '" required />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">E-mail <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <div>
                        <input type="email" placeholder="Email" name="user_email"
                            value="' . $row["EMAIL"] . '" class="form-control" required />
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Password</h5>
                </div>
                <div class="card-body">
                    <input type="password" placeholder="Password"
                        name="user_password" class="form-control" value=""
                        />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aziende</h5>
                </div>
                <div class="card-body">
                    <select placeholder="Seleciona Azienda"
                        name="user_companies[]" id= "select" data-allow-clear="1" multiple>' .
        showCompaniesNameDropDown("utenti") . '
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_user" id="updateUserButton"
                    class="btn btn-success btn-lg">Aggiorna</button>
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
            placeholder: $(this).attr(\'placeholder\'),
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
                        <h5 class="card-title mb-0">Nome <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control"
                            name="company_name" placeholder="Nome" value = "' . $row["AZIENDA_NOME"] . '"                                  required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Codice Fiscale <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control"
                            name="company_codice_fiscale" value = "' . $row["CODICE_FISCALE"] . '"
                            placeholder="Codice Fiscale" required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 1</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_1"] . '"
                            name="company_contact1" placeholder="Contatto 1">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_2"] . '"
                            name="company_contact2" placeholder="Contatto 2">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contatto 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["CONTATTO_1"] . '"
                            name="company_contact3" placeholder="Contatto 3">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 1</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_1"] . '"
                            name="company_telephone1"
                            placeholder="Numero di Telefono 1">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_2"] . '"
                            name="company_telephone2"
                            placeholder="Numero di Telefono 2">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Numero di Telefono 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["TELEFONO_3"] . '"
                            name="company_telephone3"
                            placeholder="Numero di Telefono 3">
                    </div>
                </div>
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Iscrizione</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control"
                                id="datePicker" name="company_date_joined" readonly
                                placeholder="Data Iscrizione" value = "' . $row["DATA_ISCRIZIONE"] . '"
                                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                    </div>
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
                        <input type="text" class="form-control" value ="' . $row["PARTITA_IVA"] . '"
                            name="company_nipt" placeholder="Partita Iva"
                            required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Website </h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["WEBSITE"] . '"
                            name="company_website" placeholder="Website">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 1 <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_1'] . '"
                            name="company_email1" placeholder="Email 1"
                            required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 2</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_2'] . '"
                            name="company_email2" placeholder="Email 2">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email 3</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['EMAIL_3'] . '"
                            name="company_email3" placeholder="Email 3">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['INDIRIZZO'] . '"
                            name="company_address" placeholder="Indirizzo">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citta</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row['CITTA'] . '" 
                            name="company_city" placeholder="Citta">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo Pec <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="email" class="form-control"  value = "' . $row['INDIRIZZO_PEC'] . '"
                            name="company_address_pec" placeholder="Indirizzo"
                            required>
                    </div>
                </div>
                <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Data Sinistra</h5>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <input type="text" class="form-control"
                                id="datePicker1" name="company_date_left" readonly
                                placeholder="Data Sinistra" value = "' . $row["DATA_SINISTRA"] . '"
                                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
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
                            name="company_information" rows="3"
                            placeholder="Informazioni">' . $row['INFORMAZIONI'] . '</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_company" id="updateCompanyButton"
                    class="btn btn-success btn-lg">Aggiorna</button>
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
                        <h5 class="card-title mb-0">Nome <span style = "color:red;">*</span></h5>
                    </div>
                    <div class="card-body" style="height: 88px !important;">
                        <input type="text" class="form-control" name="structure_name" placeholder="Nome" value = "' . $row["STRUTTURA_NOME"] . '" required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["INDIRIZZO"] . '"
                            name="structure_address" placeholder="Indirizzo">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende <span style = "color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <div> <select multiple placeholder="Seleciona Azienda"
                        name="company_name[]" id= "select" data-allow-clear="1">' .
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
                            name="structure_city" placeholder="Citta">
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
                            name="structure_information" rows="3"
                            placeholder="Informazioni">' . $row["INFORMAZIONI"] . '</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_structure" id="updateStructureButton" class="btn btn-success btn-lg">Aggiorna</button>
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
            placeholder: $(this).attr(\'placeholder\'),
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
                        value = "' . $row["REPARTO_NOME"] . '"placeholder="Nome" required>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Azienda</h5>
                    </div>
                    <div class="card-body">
                        <div><select class="form-select mb-3" name = "company_name" id="company-dropdown" required>'
        . showCompaniesNameDropDown('reparti') . '</select>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Indirizzo</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" 
                        value = "' . $row["INDIRIZZO"] . ' "name="department_address" placeholder="Indirizzo">
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Struttura</h5>
                    </div>
                    <div class="card-body">
                        <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                            <option disable selected value="">Seleziona una Struttura</option> ' . showStructureDropDown("reparti") . '
                        </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Citta</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="department_city" 
                        value = "' . $row["CITTA"] . '" placeholder="Citta">
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Informazioni</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="department_information" rows="3" 
                        placeholder="Informazioni">' . $row["INFORMAZIONI"] . '"</textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_department" id="updateDepartmentButton" class="btn btn-success btn-lg">Aggiorna</button>
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
                        <h5 class="card-title mb-0">Il Nome Della Banca <span style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bank_name" placeholder="Il Nome Della Banca" 
                        value = "' . $row["BANCA_NOME"] . '" required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende <span style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <div> <select class="form-select mb-3" name = "company_name" required> ' .
        showCompaniesNameDropDown("banca conti") . '</select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">IBAN <span style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bank_iban" 
                        value = "' . $row["IBAN"] . '" placeholder="IBAN" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_bank_account" id="updateBankAccountButton" class="btn btn-success btn-lg">Aggiorna</button>
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
                        <h5 class="card-title mb-0">Il Nome Della Fattura <span
                        style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="bill_name"
                            placeholder="Il Nome Della Fattura" value = "' . $row["FATTURA_NOME"] . '" required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Valore <span
                            style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" id="value" oninput="calculateValueWithVAT()"
                            name="bill_value" placeholder="Valore" 
                            value = "' . $row["VALORE"] . '"min = 0  max = 100000000000000000000000000 step="any" required>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Aziende <span
                            style="color:red;">*</span></h5>
                        </div>
                    <div class="card-body">
                         <select class="form-select mb-3" name = "company_name" required>' .
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
                                    id="datePicker" name="bill_billing_date" readonly
                                    placeholder="Data di Fatturazione" value = "' . $row["DATA_FATTURAZIONE"] . '"
                                    style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
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
                        <input type="number" class="form-control" id="bill_withVAT" 
                            name="bill_withVAT" placeholder="Valore Iva Inclusa" 
                            value = "' . $row["VALORE_IVA_INCLUSA"] . '" min = 0  max = 100000000000000000000000000 step="any" readonly>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">IVA (%) <span
                            style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" id="VAT" oninput="calculateValueWithVAT()"
                            name="bill_VAT" placeholder="IVA" min="0" max="100" step="any" value = "' . $row["IVA"] . '"
                            required>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Moneta <span
                            style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <select class="form-select mb-3" name="bill_currency" required>
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
                                id="datePicker1" name="bill_payment_date" readonly
                                placeholder="Data di Pagamento" value = "' . $row["DATA_PAGAMENTO"] . '"
                                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
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
                        <textarea class="form-control" name="bill_information"
                            rows="3" placeholder="Descrizione">' . $row["DESCRIZIONE"] . '</textarea>
                    </div>
                </div>
            </div>
        </div>   

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_bill" id="updateBillButton" 
                    class="btn btn-success btn-lg">Aggiorna</button>
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

function showImpianti($row)
{
    echo '
<form id="impiantoForm" method="post">
    <div class="row">
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Nome Uta <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body"
                        style="margin-bottom: 15px !important;">
                        <input type="text" class="form-control"
                            name="impianto_nome" placeholder="Nome" value = "' . $row["NOME_UTA"] . '"
                            required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Struttura <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                    <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                        <option disable selected value="">Seleziona una Struttura</option> ' . showStructureDropDown("impianti") . '
                    </select>
                </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Capacita Uta <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["CAPACITA_UTA"] . '"
                            id="impianto_capacita_uta"
                            name="impianto_capacita_uta"
                            placeholder="Capacita Uta" min=0
                            max=100000000000000000000000000 step="any"
                            required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ripresa <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["RIPRESA"] . '"
                            id="impianto_ripresa" name="impianto_ripresa"
                            placeholder="Ripresa" min=0
                            max=100000000000000000000000000 step="any"
                            required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Espulsione <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["ESPULSIONE"] . '"
                            id="impianto_espulsione"
                            name="impianto_espulsione"
                            placeholder="Espulsione" min=0
                            max=100000000000000000000000000 step="any"
                            required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data di Inizio Utilizzo
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <input readonly type="text" class="form-control"
                                id="datePicker" value = "' . $row["DATA_DI_INIZIO_UTILIZZO"] . '"
                                name="impianto_data_inizio_utilizzo"
                                placeholder="Data di Fatturazione"
                                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Azienda <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                    <select class="form-select mb-3" name = "company_name" required>' .
        showCompaniesNameDropDown("fatture") . '</select>
               </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Reparto</h5>
                    </div>
                    <div class="card-body">
                    <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                        <option disable selected value="">Seleziona una Struttura</option> ' . showDepartmentDropDown("impianti") . '
                    </select>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Mandata <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["MANDATA"] . '"
                            id="impianto_mandata" name="impianto_mandata"
                            placeholder="Mandata" min=0
                            max=100000000000000000000000000 step="any"
                            required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Presa Aria Esterna <span
                                style="color:red;">*</span></h5>
                    </div>
                    <div class="card-body">
                        <input type="number" class="form-control" value = "' . $row["PRESA_ARIA_ESTERNA"] . '"
                            id="impianto_presa_aria_esterna"
                            name="impianto_presa_aria_esterna"
                            placeholder="Presa Aria Esterna" min=0
                            max=100000000000000000000000000 step="any"
                            required>
                    </div>
                </div>


                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Ultima Attivita</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" value = "' . $row["ULTIMA_ATTIVITA"] . '"
                            name="impianto_ultima_attivita"
                            placeholder="Ultima Attivita">
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Data Ultima Att
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4">
                            <input readonly type="text" class="form-control" value = "' . $row["DATA_ULTIMA_ATT"] . '"
                                id="datePicker1"
                                name="impianto_data_ultima_att"
                                placeholder="Data di Fatturazione"
                                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>
<script type="text/javascript">
    moment.locale("it");

    function capitalizeFirstLetter(word) {
        return word.charAt(0).toUpperCase() + word.slice(1);
    }

    var picker = new Pikaday({
        field: document.getElementById("datePicker"),
        format: "YYYY-MM-DD",
        i18n: {
            previousMonth: "Mese Precedente",
            nextMonth: "Mese Successivo",
            months: moment.localeData().months().map(capitalizeFirstLetter),
            weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter),
            weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter)
        },
        onSelect: function () {
            console.log(this.getMoment().format("Do MMMM YYYY"));
        }
    });

    var picker = new Pikaday({
        field: document.getElementById("datePicker1"),
        format: "YYYY-MM-DD",
        i18n: {
            previousMonth: "Mese Precedente",
            nextMonth: "Mese Successivo",
            months: moment.localeData().months().map(capitalizeFirstLetter),
            weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter),
            weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter)
        },
        onSelect: function () {
            console.log(this.getMoment().format("Do MMMM YYYY"));
        }
    });

    $(document).ready(function () {
        $("#company-dropdown").change(function () {
            var companyID = $(this).val();
            var post_id = "id=" + companyID;
            $.ajax({
                type: "POST",
                url: "fetch_structures.php",
                data: post_id,
                cache: false,
                success: function (structure) {
                    $("#structure_name").html(structure);
                }
            });
        });
    });
    $(document).ready(function () {
        $("#structure_name").change(function () {
            var companyID = $(this).val();
            var post_id = "id=" + companyID;
            $.ajax({
                type: "POST",
                url: "fetch_departments.php",
                data: post_id,
                cache: false,
                success: function (department) {
                    $("#department_name").html(department);
                }
            });
        });
    });
</script>';
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

    <title>Aggiorna Entita</title>

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
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;"
                                href="admin_display_entities.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">
                                <?php
                                if ($entity == "utenti") {
                                    echo "Aggiorna l'Utente";
                                } else if ($entity == "aziende") {
                                    echo "Aggiorna l'Azienda";
                                } else if ($entity == "strutture") {
                                    echo "Aggiorna la Struttura";
                                } else if ($entity == "reparti") {
                                    echo "Aggiorna il Reparto";
                                } else if ($entity == "banca conti") {
                                    echo "Aggiorna il Conto Bancario";
                                } else if ($entity == "fatture") {
                                    echo "Aggiorna la Fattura";
                                } else if ($entity == "impianti") {
                                    echo "Aggiorna il Impianto";
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
                months: moment.localeData().months().map(capitalizeFirstLetter),
                weekdays: moment.localeData().weekdays().map(capitalizeFirstLetter),
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter)
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
                weekdaysShort: moment.localeData().weekdaysShort().map(capitalizeFirstLetter)
            },
            onSelect: function () {
                console.log(this.getMoment().format('Do MMMM YYYY'));
            }
        });
    </script>
</body>

</html>