<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

$entity = $_GET['entity'];

$query = "";

if ($entity == "utenti") {
    $query = "SELECT DISTINCT u.UTENTE_ID, u.NOME, u.COGNOME, u.EMAIL, u.NUMERO, u.RUOLO, u.AZIENDA_POSIZIONE, u.E_ATTIVO , u.DATA_INIZIO, u.DATA_FINE
                FROM UTENTI u
                LEFT JOIN UTENTI_AZIENDE a ON u.UTENTE_ID = a.UTENTE_ID";
} else if ($entity == "aziende") {
    $query = "SELECT DISTINCT a.AZIENDA_ID, a.AZIENDA_NOME, a.PARTITA_IVA, a.CODICE_FISCALE, a.INDIRIZZO, a.CITTA, a.INDIRIZZO_PEC, a.WEBSITE, a.DATA_INIZIO, a.DATA_FINE, a.E_ATTIVO
                FROM AZIENDE a";
} else if ($entity == "strutture") {
    $query = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME, a.AZIENDA_NOME, s.DATA_INIZIO, s.DATA_FINE, s.E_ATTIVO
                FROM STRUTTURE s
                JOIN AZIENDE a on s.AZIENDA_ID = a.AZIENDA_ID";
} else if ($entity == "reparti") {
    $query = "SELECT d.REPARTO_ID, d.REPARTO_NOME, s.STRUTTURA_NOME, a.AZIENDA_NOME, d.DATA_INIZIO, d.DATA_FINE, d.E_ATTIVO
                FROM REPARTI d 
                JOIN STRUTTURE s ON d.STRUTTURA_ID = s.STRUTTURA_ID
                JOIN AZIENDE a on d.AZIENDA_ID = a.AZIENDA_ID";
} else if ($entity == "banca conti") {
    $query = "SELECT b.BANCA_CONTO_ID, a.AZIENDA_NOME, b.BANCA_NOME, b.IBAN, b.DATA_INIZIO, b.DATA_FINE, b.E_ATTIVO
                FROM BANCA_CONTI b
                JOIN AZIENDE a ON a.AZIENDA_ID = b.AZIENDA_ID";
} else if ($entity == "fatture") {
    $query = "SELECT f.FATTURA_ID, a.AZIENDA_NOME, f.VALORE, f.VALORE_IVA_INCLUSA, f.IVA, f.MONETA, 
                f.DATA_FATTURAZIONE, f.DATA_PAGAMENTO, f.DATA_SCADENZA, f.E_PAGATO
                FROM FATTURE f
                JOIN AZIENDE a ON a.AZIENDA_ID = f.AZIENDA_ID";
} else if ($entity == "impianti") {
    $query = "SELECT i.IMPIANTO_ID, i.IMPIANTO_NOME, a.AZIENDA_NOME, s.STRUTTURA_NOME, r.REPARTO_NOME, i.CAPACITA_UTA,
                i.DATA_INIZIO, i.DATA_FINE, i.DATA_ULTIMA_ATT, i.E_ATTIVO
                FROM IMPIANTI i
                JOIN AZIENDE a ON i.AZIENDA_ID = a.AZIENDA_ID
                JOIN STRUTTURE s ON i.STRUTTURA_ID = s.STRUTTURA_ID
                JOIN REPARTI r ON i.REPARTO_ID = r.REPARTO_ID";
} else if ($entity == "documenti") {
    $query = "SELECT d.DOCUMENTO_ID, d.NOME, a.AZIENDA_NOME, s.STRUTTURA_NOME, d.PERCORSO, d.DATA_CARICAMENTO, d.DATA_CANCELLATA, d.E_ATTIVO
    			FROM DOCUMENTI d 
                JOIN STRUTTURE s ON s.STRUTTURA_ID= d.STRUTTURA_ID 
                JOIN AZIENDE a ON s.AZIENDA_ID = a.AZIENDA_ID";
} else if ($entity == "logs") {
    $query = "SELECT LOG_ID, UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, UA_AZIENDA_ID, UA_UTENTE_ID, ATTRIBUTO, VECCHIO_VALORE,
                NUOVO_VALORE, DATA_ORA
                FROM LOGS;";
}

if (!empty($_SESSION['company_ID'])) {
    $sanitizedIDs = array_map('intval', $_SESSION['company_ID']);
    $idList = implode(',', $sanitizedIDs);
    $query .= " WHERE a.AZIENDA_ID IN ($idList)";
    if ($entity === 'utenti') {
        $query .= " GROUP BY 
                    u.UTENTE_ID, 
                    u.NOME, 
                    u.COGNOME, 
                    u.EMAIL, 
                    u.NUMERO, 
                    u.RUOLO, 
                    u.AZIENDA_POSIZIONE, 
                    u.E_ATTIVO";
    }
}


$result = mysqli_query($conn, $query);
echo dateFilters($entity);


echo '<div class="table-responsive">
            <table id = "fetchTable" class="table text-center">';

echo '<thead>
            <tr>';

$columnIndex = 0;
$data_scadenza = "";

while ($fieldinfo = mysqli_fetch_field($result)) {
    if (
        $fieldinfo->name === 'FATTURA_ID' || ($entity == 'logs' &&
            ($fieldinfo->name == 'LOG_ID' || $fieldinfo->name == 'UTENTE_ID' || $fieldinfo->name == 'ENTITA_ID'
                || $fieldinfo->name == 'UA_AZIENDA_ID' || $fieldinfo->name == 'UA_UTENTE_ID'))
    ) {

        $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));
    } else if ($fieldinfo->name === 'PASSWORD' || strpos(strtolower($fieldinfo->name), 'id')) {
        continue;
    } else {
        $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));
    }

    echo '<th>' . $fieldName . '</th>';
}

if ($entity != 'logs') {
    echo '<th class="noFilter">Azioni</th>';
}


echo '</tr>
        </thead>
            <tbody>';

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $badge = 0;
        $is_admin = "";
        $current_email = "";
        $disabled_document = '';
        $logs_current_entity = '';

        foreach ($row as $key => $value) {
            if ($entity == 'utenti' && $key == 'EMAIL') {
                $current_email = $value;
            } else if ($entity == 'logs' && $key == 'ENTITA') {
                $logs_current_entity = $value;
            }

            if ($key == 'E_ATTIVO') {

                if ($value == 1) {
                    echo '<td><span class="badge-success-custom myBadge">Attivo</span></td>';
                    $disabled_document = '';
                } else {
                    echo '<td><span class="badge-danger-custom myBadge">Inattivo</span></td>';
                    $disabled_document = 'disabled';
                }

                $badge = $value;
            } else if ($key == 'E_PAGATO') {
                $date1 = new DateTime($data_scadenza);
                $today = new DateTime();

                if ($value == 1) {
                    echo '<td><span class="badge-success-custom myBadge">Pagato</span></td>';
                } else {
                    if ($date1 >= $today) {
                        echo '<td><span class="badge-warning-custom myBadge">In&nbsp;Attesa</span></td>';
                    } else {
                        echo '<td><span class="badge-danger-custom myBadge">Non&nbsp;Pagato</span></td>';
                    }
                }

                $badge = $value;
            } else if ($key == 'FATTURA_ID') {
                echo '<td>' . $value . '</td>';
            } else if ($key == 'DATA_SCADENZA') {
                $data_scadenza = $value;
                echo '<td>' . $value . '</td>';
            } else if (
                $entity == 'logs' && ($key == 'LOG_ID' || $key == 'UTENTE_ID' || $key == 'UA_AZIENDA_ID'
                    || $key == 'UA_UTENTE_ID') && (!is_null($value) || !empty($value) || $value == '')
            ) {
                echo linkToEntity($key, $value);
            } else if ($entity == 'logs' && ($key == 'ENTITA_ID') && (!is_null($value) || !empty($value) || $value == '')) {
                echo linkToEntity($logs_current_entity, $value);
            } else if (strpos(strtolower($key), 'id')) {
                continue;
            } else {
                echo '<td>' . $value . '</td>';
            }

            if ($key == 'RUOLO') {
                $is_admin = $value;
            }
        }


        if ($_SESSION['role'] == 'Admin' && $entity != 'logs') {
            if ($current_email == $_SESSION['email']) {
                $disabled = "disabled";
            } else {
                $disabled = "";
            }

            echo '<td>
                    <div class="btn-group">';

            if ($entity == 'fatture') {
                echo '<button ' . $disabled . ' onclick="editEntity(' . reset($row) . ', \'' . $entity . '\')" class="btn btn-warning">Modifica</button>&nbsp&nbsp&nbsp';

                if ($badge == 0) {
                    echo '<button class="btn btn-success" onclick="confirmActivation(' . reset($row) . ', \'' . $entity . '\')">Pagato</button>&nbsp&nbsp&nbsp';
                } else {
                    echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Non&nbsp;Pagato</button>&nbsp&nbsp&nbsp';
                }
            } else if ($entity == 'documenti') {
                $href = htmlspecialchars($row['PERCORSO']);

                echo '<button ' . $disabled_document . ' class="btn btn-info" onclick="if(!this.hasAttribute(\'disabled\')) {window.open(\'' . $href . '\', \'_blank\');}">Apri</button>&nbsp;&nbsp;&nbsp;';
                echo '<button ' . $disabled_document . ' class="btn btn-danger" onclick="confirmDeleteFile(\'' . addslashes($row['PERCORSO']) . '\')">Elimina</button>&nbsp;&nbsp;&nbsp;';
            } else if ($entity == 'logs') {
                continue;
            } else {
                echo '<button ' . $disabled . ' onclick="editEntity(' . reset($row) . ', \'' . $entity . '\')" class="btn btn-warning">Modifica</button>&nbsp&nbsp&nbsp';

                if ($badge == 0) {
                    echo '<button ' . $disabled . ' class="btn btn-success" onclick="confirmActivation(' . reset($row) . ', \'' . $entity . '\')">Attivare</button>&nbsp&nbsp&nbsp';
                } else {
                    echo '<button ' . $disabled . ' class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Elimina</button>&nbsp&nbsp&nbsp';
                }
            }

            echo '</div></td></tr>';
        } else if ($entity != 'logs') {
            echo '<td>
            <div class="btn-group">';
            if ($entity == "documenti") {
                $href = htmlspecialchars($row['PERCORSO']);

                echo '<button ' . $disabled_document . ' class="btn btn-info" onclick="if(!this.hasAttribute(\'disabled\')) {window.open(\'' . $href . '\', \'_blank\');}">Apri</button>&nbsp;&nbsp;&nbsp;';
            } else {
                echo '<a href="client_details.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-info">Dettagli</a>&nbsp&nbsp&nbsp';
            }
            echo '</div></td></tr>';
        }
    }
}

echo '      </tbody>
        </table>
    </div>';


mysqli_free_result($result);
include 'database/closedb.php';


function linkToEntity($logs_current_entity, $entity_id)
{
    $logs_current_entity = strtoupper($logs_current_entity);

    if ($logs_current_entity == 'UTENTI' || $logs_current_entity == 'UTENTE_ID' || $logs_current_entity == 'UA_UTENTE_ID') {
        return '<td><a href="admin_details.php?entity=utenti&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'AZIENDE' || $logs_current_entity == 'UA_AZIENDA_ID') {
        return '<td><a href="admin_details.php?entity=aziende&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'STRUTTURE') {
        return '<td><a href="admin_details.php?entity=strutture&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'REPARTI') {
        return '<td><a href="admin_details.php?entity=reparti&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'BANCA_CONTI' || $logs_current_entity == 'BANCA CONTI') {
        return '<td><a href="admin_details.php?entity=banca conti&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'FATTURE') {
        return '<td><a href="admin_details.php?entity=fatture&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'IMPIANTI') {
        return '<td><a href="admin_details.php?entity=impianti&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    } else if ($logs_current_entity == 'DOCUMENTI') {
        return '<td><a href="admin_details.php?entity=documenti&id=' . $entity_id . '">' . $entity_id . '</a></td>';
    }

    return '<td>' . $entity_id . '</td>';
}


function dateFilters($entity)
{
    if ($entity == 'fatture') {
        return '
            <div class="col-12 col-lg-12">
                <table border="0" cellspacing="0" cellpadding="20" style="display: inline-block;">
                    <tbody>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Fatturazione</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minFatturazione" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxFatturazione" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Pagamento</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minPagamento" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxPagamento" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Scadenza</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minScadenza" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxScadenza" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
    } else if ($entity == 'documenti') {
        return '
            <div class="col-12 col-lg-12">
                <table border="0" cellspacing="0" cellpadding="20" style="display: inline-block;">
                    <tbody>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Caricamento</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minCaricamento" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxCaricamento" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Cancellata</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minCancellata" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxCancellata" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
    } else if ($entity == 'logs') {
        return '
            <div class="col-12 col-lg-12">
                <table border="0" cellspacing="0" cellpadding="20" style="display: inline-block;">
                    <tbody>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data e Ora</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minDataOra" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxDataOra" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
    } else if ($entity == 'impianti') {
        return '
            <div class="col-12 col-lg-12">
                <table border="0" cellspacing="0" cellpadding="20" style="display: inline-block;">
                    <tbody>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Inizio</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minInizio" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxInizio" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Fine</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minFine" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxFine" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Ultima Att</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minUltima" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxUltima" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
         ';
    } else {
        return '
            <div class="col-12 col-lg-12">
                <table border="0" cellspacing="0" cellpadding="20" style="display: inline-block;">
                    <tbody>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Inizio</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minInizio" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxInizio" name="flatpickr" 
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                        <tr>
                            <td style="display: inline-block; font-weight:bold; width:200px;">Data di Fine</td>
                            <td style="display: inline-block;">Da:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="minFine" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                            <td style="display: inline-block; padding-left: 10px;">A:</td>
                            <td style="display: inline-block;">
                                <input type="text" id="maxFine" name="flatpickr"
                                    style="text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat left 10px center; background-size: 16px; background-color: white;">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        ';
    }
}