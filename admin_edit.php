<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';
include 'nas/credentials.php';
include 'nas/nas_functions.php';

$id = $_GET['id'];
$entity = $_GET['entity'];
date_default_timezone_set('Europe/Berlin');
$errorMessage = '';
$successfulMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_user'])) {
        $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
        $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
        $user_position = mysqli_real_escape_string($conn, $_POST['user_position']);
        $user_number = mysqli_real_escape_string($conn, $_POST['user_number']);
        $user_joined_date = empty(mysqli_real_escape_string($conn, $_POST['user_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['user_joined_date']);
        $user_left_date = empty(mysqli_real_escape_string($conn, $_POST['user_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['user_left_date']);

        $sql = "";

        if (empty($user_password)) {
            $fields = [
                'NOME' => $user_first_name,
                'COGNOME' => $user_last_name,
                'EMAIL' => $user_email,
                'RUOLO' => $user_role,
                'NUMERO' => $user_number,
                'AZIENDA_POSIZIONE' => $user_position,
                'DATA_INIZIO' => $user_joined_date,
                'DATA_FINE' => $user_left_date
            ];
            $existingEntity = oldRecord($entity, $id);

            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        EMAIL = ?, 
                        RUOLO = ?, 
                        NUMERO = ?,
                        AZIENDA_POSIZIONE = ?,
                        DATA_INIZIO = ?,
                        DATA_FINE = ?
                    WHERE UTENTE_ID = ?";
            $params = array($user_first_name, $user_last_name, $user_email, $user_role, $user_number, $user_position, $user_joined_date, $user_left_date, $id);
        } else {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);
            $fields = [
                'NOME' => $user_first_name,
                'COGNOME' => $user_last_name,
                'EMAIL' => $user_email,
                'PASSWORD' => $user_password,
                'RUOLO' => $user_role,
                'NUMERO' => $user_number,
                'AZIENDA_POSIZIONE' => $user_position,
                'DATA_INIZIO' => $user_joined_date,
                'DATA_FINE' => $user_left_date
            ];
            $existingEntity = oldRecord($entity, $id);

            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        EMAIL = ?, 
                        RUOLO = ?, 
                        NUMERO = ?,
                        AZIENDA_POSIZIONE = ?,
                        PASSWORD = ?,
                        DATA_INIZIO = ?,
                        DATA_FINE = ?
                        WHERE UTENTE_ID = ?";
            $params = array($user_first_name, $user_last_name, $user_email, $user_role, $user_number, $user_position, $hashed_password, $user_joined_date, $user_left_date, $id);
        }

        try {
            $stmt = mysqli_prepare($conn, $sql);
            $modifiedDate = date("Y-m-d H:i:s");

            if ($stmt) {
                if (empty($user_password)) {
                    mysqli_stmt_bind_param($stmt, "ssssisssi", ...$params);
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssissssi", ...$params);
                }
                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    $existingCompaniesQuery = "SELECT AZIENDA_ID FROM UTENTI_AZIENDE WHERE UTENTE_ID = ?";
                    $stmt = mysqli_prepare($conn, $existingCompaniesQuery);
                    mysqli_stmt_bind_param($stmt, "i", $id);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    $existingCompanies = [];
                    while ($row = mysqli_fetch_assoc($result)) {
                        $existingCompanies[] = $row['AZIENDA_ID'];
                    }
                    mysqli_stmt_close($stmt);

                    $newCompanies = isset($_POST['user_companies']) ? $_POST['user_companies'] : [];
                    $companiesToAdd = array_diff($newCompanies, $existingCompanies);
                    $companiesToRemove = array_diff($existingCompanies, $newCompanies);

                    if (!empty($companiesToRemove)) {
                        foreach ($companiesToRemove as $companyToRemove) {
                            $deleteQuery = "DELETE FROM UTENTI_AZIENDE WHERE UTENTE_ID = ? AND AZIENDA_ID = ?";
                            $stmt = mysqli_prepare($conn, $deleteQuery);
                            mysqli_stmt_bind_param($stmt, "ii", $id, $companyToRemove);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);


                            $logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, UA_UTENTE_ID, AZIONE, UA_AZIENDA_ID, DATA_ORA) 
                            			VALUES (?, 'UTENTI_AZIENDE', ?, 'Eliminare', ?, ?)";
                            $logStmt = mysqli_prepare($conn, $logSql);
                            mysqli_stmt_bind_param($logStmt, "iiss", $_SESSION["user_id"], $id, $companyToRemove, $modifiedDate);
                            mysqli_stmt_execute($logStmt);
                            mysqli_stmt_close($logStmt);
                        }
                    }

                    $isChangedUtentiAziende = false;
                    if (!empty($companiesToAdd)) {
                        foreach ($companiesToAdd as $companyToAdd) {
                            $insertQuery = "INSERT INTO UTENTI_AZIENDE (UTENTE_ID, AZIENDA_ID) VALUES (?, ?)";
                            $stmt = mysqli_prepare($conn, $insertQuery);
                            mysqli_stmt_bind_param($stmt, "ii", $id, $companyToAdd);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_close($stmt);


                            $logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, UA_UTENTE_ID, AZIONE, UA_AZIENDA_ID, DATA_ORA) 
                            			VALUES (?, 'UTENTI_AZIENDE', ?, 'Creare', ?, ?)";
                            $logStmt = mysqli_prepare($conn, $logSql);
                            mysqli_stmt_bind_param($logStmt, "iiss", $_SESSION["user_id"], $id, $companyToAdd, $modifiedDate);
                            mysqli_stmt_execute($logStmt);
                            mysqli_stmt_close($logStmt);
                        }
                        $isChangedUtentiAziende = true;
                    }
                    $isChangedUser = insertIntoLogs($fields, $entity, $id, $existingEntity);

                    $isChanged = $isChangedUtentiAziende || $isChangedUser;


                    $isChanged ? $successfulMessage = "Utente Aggiornato con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $company_joined_date = empty(mysqli_real_escape_string($conn, $_POST['company_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['company_joined_date']);
        $company_left_date = empty(mysqli_real_escape_string($conn, $_POST['company_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['company_left_date']);

        $fields = [
            'AZIENDA_NOME' => $company_name,
            'PARTITA_IVA' => $company_nipt,
            'CODICE_FISCALE' => $company_codice_fiscale,
            'CONTATTO_1' => $company_contact1,
            'CONTATTO_2' => $company_contact2,
            'CONTATTO_3' => $company_contact3,
            'EMAIL_1' => $company_email1,
            'EMAIL_2' => $company_email2,
            'EMAIL_3' => $company_email3,
            'TELEFONO_1' => $company_telephone1,
            'TELEFONO_2' => $company_telephone2,
            'TELEFONO_3' => $company_telephone3,
            'INDIRIZZO' => $company_address,
            'CITTA' => $company_city,
            'INDIRIZZO_PEC' => $company_address_pec,
            'DATA_INIZIO' => $company_joined_date,
            'DATA_FINE' => $company_left_date,
            'WEBSITE' => $company_website,
            'INFORMAZIONI' => $company_information
        ];

        $existingEntity = oldRecord($entity, $id);
        $sql = '';
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
                    DATA_INIZIO = ?,
                    DATA_FINE = ?
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
                $company_joined_date,
                $company_left_date,
                $id
            );

            if (mysqli_stmt_execute($stmt)) {
                $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                $isChanged ? $successfulMessage = "Azienda Aggiornata con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $structure_joined_date = empty(mysqli_real_escape_string($conn, $_POST['structure_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['structure_joined_date']);
        $structure_left_date = empty(mysqli_real_escape_string($conn, $_POST['structure_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['structure_left_date']);

        $sql = '';
        $fields = [
            'STRUTTURA_NOME' => $structure_name,
            'AZIENDA_ID' => $structure_company_id,
            'INDIRIZZO' => $structure_address,
            'CITTA' => $structure_city,
            'INFORMAZIONI' => $structure_information,
            'DATA_INIZIO' => $structure_joined_date,
            'DATA_FINE' => $structure_left_date
        ];

        $existingEntity = oldRecord($entity, $id);

        $sql = "UPDATE STRUTTURE 
                SET AZIENDA_ID = ?,
                    STRUTTURA_NOME = ?, 
                    INDIRIZZO = ?, 
                    CITTA = ?, 
                    INFORMAZIONI = ?,
                    DATA_INIZIO = ?,
                    DATA_FINE = ?
                WHERE STRUTTURA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssssi", $structure_company_id, $structure_name, $structure_address, $structure_city, $structure_information, $structure_joined_date, $structure_left_date, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                    $isChanged ? $successfulMessage = "Struttura Aggiornata con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $department_joined_date = empty(mysqli_real_escape_string($conn, $_POST['department_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['department_joined_date']);
        $department_left_date = empty(mysqli_real_escape_string($conn, $_POST['department_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['department_left_date']);

        $fields = [
            'REPARTO_NOME' => $department_name,
            'STRUTTURA_ID' => $department_structure_id,
            'AZIENDA_ID' => $department_company_id,
            'INDIRIZZO' => $department_address,
            'CITTA' => $department_city,
            'INFORMAZIONI' => $department_information,
            'DATA_INIZIO' => $department_joined_date,
            'DATA_FINE' => $department_left_date
        ];

        $existingEntity = oldRecord($entity, $id);

        $sql = '';
        $sql = "UPDATE REPARTI 
                SET REPARTO_NOME = ?, 
                    AZIENDA_ID = ?, 
                    STRUTTURA_ID = ?, 
                    INDIRIZZO = ?, 
                    CITTA = ?, 
                    INFORMAZIONI = ?,
                    DATA_INIZIO = ?,
                    DATA_FINE = ?
                WHERE REPARTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "siisssssi", $department_name, $department_company_id, $department_structure_id, $department_address, $department_city, $department_information, $department_joined_date, $department_left_date, $id);

            if (mysqli_stmt_execute($stmt)) {
                $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                $isChanged ? $successfulMessage = "Reparto Aggiornato con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $bank_joined_date = empty(mysqli_real_escape_string($conn, $_POST['bank_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['bank_joined_date']);
        $bank_left_date = empty(mysqli_real_escape_string($conn, $_POST['bank_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['bank_left_date']);

        $fields = [
            'AZIENDA_ID' => $bank_company_id,
            'BANCA_NOME' => $bank_name,
            'IBAN' => $bank_IBAN,
            'DATA_INIZIO' => $bank_joined_date,
            'DATA_FINE' => $bank_left_date
        ];

        $existingEntity = oldRecord($entity, $id);

        $sql = '';
        $sql = "UPDATE BANCA_CONTI 
                SET AZIENDA_ID = ?, 
                    BANCA_NOME = ?, 
                    IBAN = ?,
                    DATA_INIZIO = ?,
                    DATA_FINE = ?
                WHERE BANCA_CONTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issssi", $bank_company_id, $bank_name, $bank_IBAN, $bank_joined_date, $bank_left_date, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                    $isChanged ? $successfulMessage = "Il Conto Bancario è Stato Aggiornato con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $bill_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $bill_value = ROUND(($_POST['bill_value']), 2);
        $bill_billing_date = empty(mysqli_real_escape_string($conn, $_POST['bill_billing_date'])) ? null : mysqli_real_escape_string($conn, $_POST['bill_billing_date']);
        $bill_VAT = ROUND($_POST['bill_VAT'], 2);
        $bill_currency = mysqli_real_escape_string($conn, $_POST['bill_currency']);
        $bill_payment_date = empty(mysqli_real_escape_string($conn, $_POST['bill_payment_date'])) ? null : mysqli_real_escape_string($conn, $_POST['bill_payment_date']);
        $bill_information = mysqli_real_escape_string($conn, $_POST['bill_information']);
        $bill_value_with_VAT = ROUND($_POST['bill_withVAT'], 2);
        $bill_expiration_date = empty(mysqli_real_escape_string($conn, $_POST['bill_expiration_date'])) ? null : mysqli_real_escape_string($conn, $_POST['bill_expiration_date']);
        $bill_bank_conto_id = empty(mysqli_real_escape_string($conn, $_POST['bill_bank_iban'])) ? null : mysqli_real_escape_string($conn, $_POST['bill_bank_iban']);

        $fields = [
            'AZIENDA_ID' => $bill_company_id,
            'VALORE' => $bill_value,
            'DATA_FATTURAZIONE' => $bill_billing_date,
            'IVA' => $bill_VAT,
            'MONETA' => $bill_currency,
            'DATA_PAGAMENTO' => $bill_payment_date,
            'DESCRIZIONE' => $bill_information,
            'VALORE_IVA_INCLUSA' => $bill_value_with_VAT,
            'DATA_SCADENZA' => $bill_expiration_date,
            'BANCA_CONTO_ID' => $bill_bank_conto_id
        ];

        $existingEntity = oldRecord($entity, $id);

        $sql = '';
        $sql = "UPDATE FATTURE 
                SET AZIENDA_ID = ?, 
                    DESCRIZIONE = ?, 
                    VALORE = ?, 
                    VALORE_IVA_INCLUSA = ?, 
                    IVA = ?, 
                    MONETA = ?, 
                    DATA_FATTURAZIONE = ?, 
                    DATA_PAGAMENTO = ?,
                    DATA_SCADENZA = ?,
                    BANCA_CONTO_ID = ?
        WHERE FATTURA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "isdddssssii", $bill_company_id, $bill_information, $bill_value, $bill_value_with_VAT, $bill_VAT, $bill_currency, $bill_billing_date, $bill_payment_date, $bill_expiration_date, $bill_bank_conto_id, $id);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                    $isChanged ? $successfulMessage = "Fattura è Stata Aggiornata con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
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
        $impianto_data_inizio = empty(mysqli_real_escape_string($conn, $_POST['impianto_data_inizio'])) ? null : mysqli_real_escape_string($conn, $_POST['impianto_data_inizio']);
        $impianto_mandata = mysqli_real_escape_string($conn, $_POST['impianto_mandata']);
        $impianto_data_ultima_att = empty(mysqli_real_escape_string($conn, $_POST['impianto_data_ultima_att'])) ? null : mysqli_real_escape_string($conn, $_POST['impianto_data_ultima_att']);
        $impianto_ultima_attivita = mysqli_real_escape_string($conn, $_POST['impianto_ultima_attivita']);
        $impianto_presa_aria_esterna = mysqli_real_escape_string($conn, $_POST['impianto_presa_aria_esterna']);
        $impianto_data_fine = empty(mysqli_real_escape_string($conn, $_POST['impianto_data_fine'])) ? null : mysqli_real_escape_string($conn, $_POST['impianto_data_fine']);

        $impianto_company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $impianto_structure_id = mysqli_real_escape_string($conn, $_POST['structure_name']);
        $impianto_department_id = mysqli_real_escape_string($conn, $_POST['department_name']);

        $fields = [
            'IMPIANTO_NOME' => $impianto_nome,
            'AZIENDA_ID' => $impianto_company_id,
            'STRUTTURA_ID' => $impianto_structure_id,
            'REPARTO_ID' => $impianto_department_id,
            'CAPACITA_UTA' => $impianto_capacita_uta,
            'MANDATA' => $impianto_mandata,
            'RIPRESA' => $impianto_ripresa,
            'ESPULSIONE' => $impianto_espulsione,
            'PRESA_ARIA_ESTERNA' => $impianto_presa_aria_esterna,
            'DATA_INIZIO' => $impianto_data_inizio,
            'ULTIMA_ATTIVITA' => $impianto_ultima_attivita,
            'DATA_FINE' => $impianto_data_fine,
            'DATA_ULTIMA_ATT' => $impianto_data_ultima_att
        ];

        $existingEntity = oldRecord($entity, $id);

        $sql = '';
        $sql = "UPDATE IMPIANTI 
                SET IMPIANTO_NOME = ?,
                    AZIENDA_ID = ?,
                    STRUTTURA_ID = ?,
                    REPARTO_ID = ?,
                    CAPACITA_UTA = ?,
                    MANDATA = ?,
                    RIPRESA = ?,
                    ESPULSIONE = ?,
                    PRESA_ARIA_ESTERNA = ?,
                    ULTIMA_ATTIVITA = ?,
                    DATA_INIZIO = ?,
                    DATA_ULTIMA_ATT = ?,
                    DATA_FINE = ?
                WHERE IMPIANTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "siiidddddssssi",
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
                $impianto_data_inizio,
                $impianto_data_ultima_att,
                $impianto_data_fine,
                $id
            );
            try {
                if (mysqli_stmt_execute($stmt)) {
                    $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                    $isChanged ? $successfulMessage = "L'impianto è Stato Aggiornato con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
                } else {
                    $errorMessage = "Errore: Impossibile Aggiornare l'Impianto";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Errore: " . $e->getMessage();
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
        }
    } else if (isset($_POST['update_employee'])) {
        $employee_first_name = mysqli_real_escape_string($conn, $_POST['employee_first_name']);
        $employee_last_name = mysqli_real_escape_string($conn, $_POST['employee_last_name']);
        $employee_email = mysqli_real_escape_string($conn, $_POST['employee_email']);
        ///$employee_photo = mysqli_real_escape_string($conn, $_POST['employee_photo']);
        $employee_birthday = empty(mysqli_real_escape_string($conn, $_POST['employee_birthday'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_birthday']);
        $employee_code = mysqli_real_escape_string($conn, $_POST['employee_code']);
        $employee_indirizzo = mysqli_real_escape_string($conn, $_POST['employee_indirizzo']);
        $employee_role = mysqli_real_escape_string($conn, $_POST['employee_role']);
        $employee_company = mysqli_real_escape_string($conn, $_POST['employee_company']);
        $employee_iva = mysqli_real_escape_string($conn, $_POST['employee_iva']);
        $employee_telephone = mysqli_real_escape_string($conn, $_POST['employee_telephone']);
        $employee_number = mysqli_real_escape_string($conn, $_POST['employee_number']);
        $employee_qualification = mysqli_real_escape_string($conn, $_POST['employee_qualification']);
        $employee_position = mysqli_real_escape_string($conn, $_POST['employee_position']);
        $employee_contract = mysqli_real_escape_string($conn, $_POST['employee_contract']);
        $employee_inizio_date = empty(mysqli_real_escape_string($conn, $_POST['employee_inizio_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_inizio_date']);
        $employee_left_date = empty(mysqli_real_escape_string($conn, $_POST['employee_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_left_date']);
        $employee_medical_date = empty(mysqli_real_escape_string($conn, $_POST['employee_medical_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_medical_date']);
        $employee_cosegna_date = empty(mysqli_real_escape_string($conn, $_POST['employee_cosegna_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_cosegna_date']);
        $employee_specifica_date = empty(mysqli_real_escape_string($conn, $_POST['employee_specifica_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_specifica_date']);
        $employee_base_date = empty(mysqli_real_escape_string($conn, $_POST['employee_base_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_base_date']);
        $employee_cat3_date = empty(mysqli_real_escape_string($conn, $_POST['employee_cat3_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_cat3_date']);

        $newFileName = mysqli_real_escape_string($conn, $_POST['file-name']);
        $isUploadedToWebsite = FALSE;
        $isUploadedToNAS = TRUE;
        $uploadedFile = '';
      	$fileTmp = '';
        $targetFilePath = '';
        $targetDirectory = $baseUrl . "/" . $imageRootPath;
      
      	if(isset($_FILES["employee_photo"]) && $_FILES["employee_photo"]["error"] === UPLOAD_ERR_OK) {
          	$isUploadedToWebsite = TRUE;
            $uploadedFile = $_FILES["employee_photo"];
            $fileTmp = $uploadedFile["tmp_name"];
            $fileName = pathinfo($uploadedFile["name"], PATHINFO_FILENAME);
            $fileExt = strtolower(pathinfo($uploadedFile["name"], PATHINFO_EXTENSION));
    
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            if (in_array($fileExt, $allowedTypes)) {
                $newFileName = $fileName . "___" . uniqid() . "." . $fileExt;
                $targetFilePath = $targetDirectory . "/" . $newFileName;
            } else {
                $errorMessage = "Errore: Formato file non valido. Solo JPG, PNG e GIF sono consentiti.";
            }
        }  

        $fields = [
            'NOME' => $employee_first_name,
            'COGNOME' => $employee_last_name,
            'EMAIL' => $employee_email,
            'FOTOGRAFIA' => $newFileName,
            'DATA_DI_NASCITA' => $employee_birthday,
            'CODICE_FISCALE' => $employee_code,
            'INDIRIZZO' => $employee_indirizzo,
            'RUOLO' => $employee_role,
            'RAGIONE_SOCIALE' => $employee_company,
            'PIVA' => $employee_iva,
            'TELEFONO' => $employee_telephone,
            'MATRICOLA' => $employee_number,
            'QUALIFICA' => $employee_qualification,
            'MANSIONE' => $employee_position,
            'CONTRATTO' => $employee_contract,
            'ASSUNTO_IL' => $employee_inizio_date,
            'DATA_FINE' => $employee_left_date,
            'VISITA_MEDICA_IDONEITA' => $employee_medical_date,
            'RICEVUTA_CONSEGNA_DPI' => $employee_cosegna_date,
            'ATTESTATO_FORMAZIONE_SPECIFICA' => $employee_specifica_date,
            'CORSO_FORMAZIONE_INFORMAZIONE_BASE' => $employee_base_date,
            'CORSO_UTILIZZO_DPI_CAT3' => $employee_cat3_date
        ];

        $existingEntity = oldRecord($entity, $id);
        $sql = '';
        $sql = "UPDATE DIPENDENTI 
                SET NOME = ?,
                    COGNOME = ?,
                    EMAIL = ?,
                    FOTOGRAFIA = ?,
                    DATA_DI_NASCITA = ?,
                    CODICE_FISCALE = ?,
                    INDIRIZZO = ?,
                    RUOLO = ?,
                    RAGIONE_SOCIALE = ?,
                    PIVA = ?,
                    TELEFONO = ?,
                    MATRICOLA = ?,
                    QUALIFICA = ?,
                    MANSIONE = ?,
                    CONTRATTO = ?,
                    ASSUNTO_IL = ?,
                    DATA_FINE = ?,
                    VISITA_MEDICA_IDONEITA = ?,
                    RICEVUTA_CONSEGNA_DPI = ?,
                    ATTESTATO_FORMAZIONE_SPECIFICA = ?,
                    CORSO_FORMAZIONE_INFORMAZIONE_BASE = ?,
                    CORSO_UTILIZZO_DPI_CAT3 = ?
                WHERE DIPENDENTE_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param(
                $stmt,
                "sssssssssssissssssssssi",
                $employee_first_name,
                $employee_last_name,
                $employee_email,
                $newFileName,
                $employee_birthday,
                $employee_code,
                $employee_indirizzo,
                $employee_role,
                $employee_company,
                $employee_iva,
                $employee_telephone,
                $employee_number,
                $employee_qualification,
                $employee_position,
                $employee_contract,
                $employee_inizio_date,
                $employee_left_date,
                $employee_medical_date,
                $employee_cosegna_date,
                $employee_specifica_date,
                $employee_base_date,
                $employee_cat3_date,
                $id
            );
                    
            
            if($isUploadedToWebsite) {
                if(!uploadToWebDAV($targetFilePath, $fileTmp)){   
                  echo $targetFilePath;
                  echo $fileTmp;
                    $newFileName = NULL;
                    $errorMessage .= "Errore: Impossibile caricare l'immagine.";
                    $isUploadedToNAS = FALSE;
                }
            }
                
            if ($isUploadedToNAS && mysqli_stmt_execute($stmt)) {
                $isChanged = insertIntoLogs($fields, $entity, $id, $existingEntity);
                $isChanged ? $successfulMessage = "Dipendente Aggiornata con Successo" : $infoMessage = "Non Hai Modificato Alcun Attributo";
            } else {
                if($isUploadedToWebsite && $isUploadedToNAS){
                    deleteImage($targetFilePath);
                }
                $errorMessage .= "Errore: Impossibile Aggiornare la Azienda";
            }
            
            mysqli_stmt_close($stmt); 
        } else {
            $errorMessage .= "Errore: Impossibile Preparare l'Istruzione";
        }
    }

    include 'database/closedb.php';
}

    function insertIntoLogs($fields, $entity, $id, $existingEntity)
    {
        include 'database/config.php';
        include 'database/opendb.php';
        $modifiedDate = date("Y-m-d H:i:s");
        $entity01 = strtoupper($entity);
        $changed = false;


        foreach ($fields as $key => $value) {
            if ($value != $existingEntity[$key] && $key != 'PASSWORD') {
                $changed = true;

                $logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, ATTRIBUTO, VECCHIO_VALORE, NUOVO_VALORE, DATA_ORA) 
                            VALUES (?, ?, ?, 'Modificare', ?, ?, ?, ?)";
                $logStmt = mysqli_prepare($conn, $logSql);
                mysqli_stmt_bind_param($logStmt, "isissss", $_SESSION["user_id"], $entity01, $id, $key, $existingEntity[$key], $value, $modifiedDate);
                mysqli_stmt_execute($logStmt);
                mysqli_stmt_close($logStmt);
            } else if ($key == 'PASSWORD' && $value != '') {
                $changed = true;

                $logSql01 = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, ATTRIBUTO, DATA_ORA) 
                                VALUES (?, ?, ?, 'Modificare', ?, ?)";
                $logStmt01 = mysqli_prepare($conn, $logSql01);
                mysqli_stmt_bind_param($logStmt01, "isiss", $_SESSION["user_id"], $entity01, $id, $key, $modifiedDate);
                mysqli_stmt_execute($logStmt01);
                mysqli_stmt_close($logStmt01);

            }
        }
 
    

        include 'database/closedb.php';

        return $changed;
    }   

function oldRecord($entity, $id)
{
    include 'database/config.php';
    include 'database/opendb.php';

    if ($entity == 'utenti') {
        $existingSql = "SELECT NOME, COGNOME, EMAIL, PASSWORD, NUMERO, AZIENDA_POSIZIONE, RUOLO, DATA_INIZIO, DATA_FINE FROM UTENTI WHERE UTENTE_ID = ?";
    } else if ($entity == 'aziende') {
        $existingSql = "SELECT AZIENDA_NOME, PARTITA_IVA ,CODICE_FISCALE ,CONTATTO_1 ,CONTATTO_2 ,CONTATTO_3 ,EMAIL_1 ,EMAIL_2 ,EMAIL_3,
                        TELEFONO_1 ,TELEFONO_2 ,TELEFONO_3 ,INDIRIZZO ,CITTA ,INDIRIZZO_PEC ,DATA_INIZIO ,DATA_FINE ,WEBSITE ,INFORMAZIONI 
                        FROM AZIENDE WHERE AZIENDA_ID = ?";
    } else if ($entity == 'aziende') {
        $existingSql = "SELECT AZIENDA_NOME, PARTITA_IVA ,CODICE_FISCALE ,CONTATTO_1 ,CONTATTO_2 ,CONTATTO_3 ,EMAIL_1 ,EMAIL_2 ,EMAIL_3,
                        TELEFONO_1 ,TELEFONO_2 ,TELEFONO_3 ,INDIRIZZO ,CITTA ,INDIRIZZO_PEC ,DATA_INIZIO ,DATA_FINE ,WEBSITE ,INFORMAZIONI 
                        FROM AZIENDE WHERE AZIENDA_ID = ?";
    } else if ($entity == 'banca conti') {
        $existingSql = "SELECT AZIENDA_ID, BANCA_NOME, IBAN, DATA_FINE, DATA_INIZIO FROM BANCA_CONTI WHERE BANCA_CONTO_ID = ?";
    } else if ($entity == 'fatture') {
        $existingSql = "SELECT DATA_FATTURAZIONE, VALORE_IVA_INCLUSA, VALORE, MONETA, IVA, E_PAGATO, DESCRIZIONE, DATA_SCADENZA, DATA_PAGAMENTO, BANCA_CONTO_ID, AZIENDA_ID FROM FATTURE WHERE FATTURA_ID = ?";
    } else if ($entity == 'reparti') {
        $existingSql = "SELECT REPARTO_NOME, STRUTTURA_ID, INFORMAZIONI, DATA_INIZIO, DATA_FINE, CITTA, AZIENDA_ID, INDIRIZZO FROM REPARTI WHERE REPARTO_ID = ?";
    } else if ($entity == 'strutture') {
        $existingSql = "SELECT STRUTTURA_NOME, INFORMAZIONI, INDIRIZZO, DATA_INIZIO, DATA_FINE, CITTA, AZIENDA_ID FROM STRUTTURE WHERE STRUTTURA_ID = ?";
    } else if ($entity == 'impianti') {
        $existingSql = "SELECT ULTIMA_ATTIVITA, STRUTTURA_ID, RIPRESA, REPARTO_ID, PRESA_ARIA_ESTERNA, IMPIANTO_NOME, MANDATA, ESPULSIONE, DATA_ULTIMA_ATT, DATA_INIZIO, DATA_FINE, CAPACITA_UTA, AZIENDA_ID FROM IMPIANTI WHERE IMPIANTO_ID = ?";
    } else if ($entity == 'dipendenti') {
        $existingSql = "SELECT NOME, COGNOME, EMAIL, FOTOGRAFIA, DATA_DI_NASCITA, CODICE_FISCALE, INDIRIZZO, RUOLO, RAGIONE_SOCIALE, PIVA, TELEFONO, MATRICOLA, QUALIFICA, MANSIONE, CONTRATTO, ASSUNTO_IL, DATA_FINE, VISITA_MEDICA_IDONEITA, RICEVUTA_CONSEGNA_DPI, ATTESTATO_FORMAZIONE_SPECIFICA, CORSO_FORMAZIONE_INFORMAZIONE_BASE, CORSO_UTILIZZO_DPI_CAT3 FROM DIPENDENTI WHERE DIPENDENTE_ID = ?";
    }

    $stmt = mysqli_prepare($conn, $existingSql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $existingEntity = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    include 'database/closedb.php';

    return $existingEntity;
}


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
                WHERE i.IMPIANTO_ID = ?
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

        if (empty($bancaContoID) || $bancaContoID == NULL) {
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

        if (empty($bancaContoID) || $bancaContoID == NULL) {
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
    } else if ($entity == "dipendenti") {
        $query = "SELECT * FROM DIPENDENTI WHERE DIPENDENTE_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            include 'admin_edit_employee.php';
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

    <title>Aggiorna Entita</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet">


    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script defer>
        function calculateValueWithVAT() {
            var value = parseFloat(document.getElementById("value").value);
            var VAT = parseFloat(document.getElementById("VAT").value);
            if (isNaN(value)) value = 0;
            if (isNaN(VAT)) VAT = 0;
            var valueWithVAT = (value * (1 + VAT / 100)).toFixed(2);
            document.getElementById("bill_withVAT").value = valueWithVAT;
        }
    </script>
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
                                } else if ($entity == "dipendenti") {
                                    echo "Aggiorna il Dipendente";
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
                                    } else if (!empty($infoMessage)) {
                                        echo '<div class="col-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <div style="height: auto; font-size:20px; text-align:center; background-color: #FFFACD; color: #9B870C;" class="alert alert-warning" role="alert"><h4 style = "padding-top:5px; color: #9B870C; font-weight:bold;">' . $infoMessage . '</h4>
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

        document.getElementById("employee_photo").addEventListener("change", function() {
          let fileName = this.files.length > 0 ? this.files[0].name : "Nessun file selezionato";
          document.getElementById("file-name").value = fileName;
        });

        document.getElementById('clear-file').addEventListener('click', function() {
			document.getElementById('employee_photo').value = ''; // Reset file input
        	document.getElementById('file-name').value = 'Nessun file selezionato'; // Reset text input
    	});
    </script>
    <script src="js/app.js"></script>

</body>

</html>