<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

$entity = $_GET['entity'];

$query = "";

if ($entity == "utenti") {
    $query = "SELECT DISTINCT u.UTENTE_ID, u.NOME, u.COGNOME, u.EMAIL, u.NUMERO, u.RUOLO, u.AZIENDA_POSIZIONE, u.E_ATTIVO 
                FROM UTENTI u
                JOIN UTENTI_AZIENDE a ON u.UTENTE_ID = a.UTENTE_ID";
} else if ($entity == "aziende") {
    $query = "SELECT DISTINCT a.AZIENDA_ID, a.AZIENDA_NOME, a.PARTITA_IVA, a.CODICE_FISCALE, a.INDIRIZZO, a.CITTA, a.INDIRIZZO_PEC, a.WEBSITE, a.DATA_ISCRIZIONE, a.DATA_SINISTRA, a.E_ATTIVO
                FROM AZIENDE a";
} else if ($entity == "strutture") {
    $query = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME, a.AZIENDA_NOME, s.E_ATTIVO
                FROM STRUTTURE s
                JOIN AZIENDE a on s.AZIENDA_ID = a.AZIENDA_ID";
} else if ($entity == "reparti") {
    $query = "SELECT d.REPARTO_ID, d.REPARTO_NOME, s.STRUTTURA_NOME, a.AZIENDA_NOME, d.E_ATTIVO
                FROM REPARTI d 
                JOIN STRUTTURE s ON d.STRUTTURA_ID = s.STRUTTURA_ID
                JOIN AZIENDE a on d.AZIENDA_ID = a.AZIENDA_ID";
} else if ($entity == "banca conti") {
    $query = "SELECT b.BANCA_CONTO_ID, a.AZIENDA_NOME, b.BANCA_NOME, b.IBAN, b.E_ATTIVO
                FROM BANCA_CONTI b
                JOIN AZIENDE a ON a.AZIENDA_ID = b.AZIENDA_ID";
} else if ($entity == "fatture") {
    $query = "SELECT f.FATTURA_ID, f.FATTURA_NOME, a.AZIENDA_NOME, f.VALORE, f.VALORE_IVA_INCLUSA, f.IVA, f.MONETA, 
                f.DATA_FATTURAZIONE, f.DATA_PAGAMENTO, f.E_PAGATO
                FROM FATTURE f
                JOIN AZIENDE a ON a.AZIENDA_ID = f.AZIENDA_ID";
} else if ($entity == "impianti") {
    $query = "SELECT NOME_UTA, CAPACITA_UTA
                FROM IMPIANTI";
}


if (!empty($_SESSION['company_ID'])) {
    $sanitizedIDs = array_map('intval', $_SESSION['company_ID']);
    $idList = implode(',', $sanitizedIDs);
    $query .= " WHERE a.AZIENDA_ID IN ($idList)";
    if ($entity === 'utenti'){
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
echo '<div class="table-responsive">
            <table id = "fetchTable" class="table text-center">';

echo '<thead>
            <tr>';

$columnIndex = 0;

while ($fieldinfo = mysqli_fetch_field($result)) {
    if ($fieldinfo->name === 'PASSWORD' || strpos(strtolower($fieldinfo->name), 'id')) {
        continue;
    }

    $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));

    echo '<th>' . $fieldName . '</th>';
}

    echo '<th class="noFilter">Azioni</th>';


echo '</tr>
        </thead>
            <tbody>';

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $badge = 0;
        $is_admin = "";

        foreach ($row as $key => $value) {
            if ($key == 'E_ATTIVO') {
                echo $value == 1 ? '<td><span class="badge-success-custom myBadge">Attivo</span></td>' :
                    '<td><span class="badge-danger-custom myBadge">Inattivo</span></td>';
                $badge = $value;
            } else if ($key == 'E_PAGATO') {
                echo $value == 1 ? '<td><span class="badge-success-custom myBadge">Pagato</span></td>' :
                    '<td><span class="badge-danger-custom myBadge">Non&nbsp;Pagato</span></td>';
                $badge = $value;
            } else if (strpos(strtolower($key), 'id')) {
                continue;
            } else {
                echo '<td>' . $value . '</td>';
            }

            if ($key == 'RUOLO') {
                $is_admin = $value;
            }
        }


        if ($_SESSION['role'] == 'Admin') {
            echo '<td>
                    <div class="btn-group">
                        <a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Modifica</a>&nbsp&nbsp&nbsp';

            if ($entity == 'fatture') {
                if ($badge == 0) {
                    echo '<button class="btn btn-success" onclick="confirmActivation(' . reset($row) . ', \'' . $entity . '\')">Pagato</button>&nbsp&nbsp&nbsp';
                } else {
                    echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Non&nbsp;Pagato</button>&nbsp&nbsp&nbsp';
                }
            } else {
                if ($badge == 0) {
                    echo '<button class="btn btn-success" onclick="confirmActivation(' . reset($row) . ', \'' . $entity . '\')">Attivare</button>&nbsp&nbsp&nbsp';
                } else {
                    echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Elimina</button>&nbsp&nbsp&nbsp';
                }
            }

            echo '</div></td></tr>';
        } else {
            echo '<td>
            <div class="btn-group">
                <a href="client_details.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-info">Dettagli</a>&nbsp&nbsp&nbsp';
            echo '</div></td></tr>';
        }
    }
}

echo '</tbody>';



echo '</table></div>';


mysqli_free_result($result);
include 'database/closedb.php';