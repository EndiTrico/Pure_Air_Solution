<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_user'])) {
        $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
        $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
        $user_position = mysqli_real_escape_string($conn, $_POST['user_position']);
        $user_number = mysqli_real_escape_string($conn, $_POST['user_number']);

        if (!empty($_POST['user_companies'])) {
            $user_companies = $_POST['user_companies'];
        }

        $sql = "";

        if (empty($user_password)) {
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
                if (empty($user_password)) {
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

                    if (!empty($user_companies)) {
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
    } else if (isset($_POST['update_company'])) {
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
                    AZIENDA_ID = ?";

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
    } else if (isset($_POST['update_structure'])) {
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
    } else if (isset($_POST['update_department'])) {
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
    } else if (isset($_POST['update_bank_account'])) {
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
    } else if (isset($_POST['update_bill'])) {
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
    } else if (isset($_POST['update_impianto'])) {
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

        $sql = "UPDATE IMPIANTI 
                SET NOME_UTA = ?,
                    AZIENDA_ID = ?,
                    STRUTTURA_ID = ?,
                    REPARTO_ID = ?,
                    CAPACITA_UTA = ?,
                    MANDATA = ?,
                    RIPRESA = ?,
                    ESPULSIONE = ?,
                    PRESA_ARIA_ESTERNA = ?,
                    ULTIMA_ATTIVITA = ?,
                    DATA_DI_INIZIO_UTILIZZO = ?,
                    DATA_ULTIMA_ATT = ?
                WHERE IMPIANTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "siiidddddsssi",
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
                $impianto_data_ultima_att,
                $id
            );
            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "L'impianto è Stato Aggiornato con Successo";
                } else {
                    $errorMessage = "Errore: Impossibile Aggiornare l'Impianto";
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
        $bankDropDown = "Error: " . mysqli_error($conn);
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
        $bankDropDown = "Error: " . mysqli_error($conn);
    }

    include 'database/closedb.php';

    return $bankDropDown;
}


function showCompaniesNameDropDown($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';


    $id = $_GET['id'];

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE WHERE E_ATTIVO = 1";
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
            include 'admin_edit_user.php';
        }
    } else if ($entity == 'aziende') {
        $query = "SELECT * FROM AZIENDE WHERE AZIENDA_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_company.php';
        }
    } else if ($entity == 'strutture') {
        $query = "SELECT * FROM STRUTTURE WHERE STRUTTURA_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_structure.php';
        }
    } else if ($entity == "reparti") {
        $query = "SELECT * FROM REPARTI WHERE REPARTO_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_department.php';
        }
    } else if ($entity == "banca conti") {
        $query = "SELECT * FROM BANCA_CONTI WHERE BANCA_CONTO_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_bank_account.php';
        }
    } else if ($entity == "fatture") {
        $query = "SELECT FATTURE.*, BANCA.BANCA_NOME, BANCA.IBAN FROM FATTURE 
                LEFT JOIN BANCA_CONTI BANCA ON FATTURE.BANCA_CONTO_ID = BANCA.BANCA_CONTO_ID 
                WHERE FATTURA_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_bill.php';
        }
    } else if ($entity == "impianti") {
        $query = "SELECT * FROM IMPIANTI WHERE IMPIANTO_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_impianto.php';
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
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Aggiorna Entita</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-BTBZNOArLzKrjzlkrMgXw0S51oBnuy0/HWkCARN0aSUSnt5N6VX/9n6tsQwnPVK68OzI6KARmxx3AeeBfM2y+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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
                            <a class="btn transparent-btn" style="margin-top: -7px;" href="admin_display_entities.php">
                                <img alt="Back" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
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
                                    echo "Aggiorna  l'Impianto";
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/it.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"> </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>
        const flatpickrInstance = flatpickr("#datePicker", {
            locale: 'it',
            dateFormat: "Y-m-d",
        });
       

    </script>
    <script src="js/app.js"></script>

</body>

</html>