<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

$entity = $_GET['entity'];

$query = "";

if ($entity == "utenti") {
    $query = "SELECT u.UTENTE_ID, u.NOME, u.COGNOME, u.EMAIL, u.NUMERO, u.RUOLO, u.AZIENDA_POSIZIONE, u.E_ATTIVO 
                FROM UTENTI u";
} else if ($entity == "aziende") {
    $query = "SELECT AZIENDA_ID, AZIENDA_NOME, PARTITA_IVA, CODICE_FISCALE, INDIRIZZO, CITTA, INDIRIZZO_PEC, WEBSITE, DATA_ISCRIZIONE, DATA_SINISTRA, E_ATTIVO
                FROM AZIENDE";
} else if ($entity == "strutture") {
    $query = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME, c.AZIENDA_NOME, s.E_ATTIVO
                FROM STRUTTURE s
                JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID";
} else if ($entity == "reparti") {
    $query = "SELECT d.REPARTO_ID, d.REPARTO_NOME, s.STRUTTURA_NOME, c.AZIENDA_NOME, d.E_ATTIVO
                FROM REPARTI d 
                JOIN STRUTTURE s ON d.STRUTTURA_ID = s.STRUTTURA_ID
                JOIN AZIENDE c on d.AZIENDA_ID = c.AZIENDA_ID";
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


if (!empty($_SESSION['AZIENDA_ID'])) {
    $query .= " WHERE AZIENDA_ID = " . $_SESSION["AZIENDA_ID"];
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

if ($_SESSION['role'] == 'Admin' || $entity == 'utenti' || $entity == 'aziende') {
    echo '<th>Azioni</th>';
}

echo '</tr>
        </thead>
            <tbody>';

if (mysqli_num_rows($result) > 0) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $E_ATTIVO = 0;
        $is_admin = "";

        foreach ($row as $key => $value) {
            if ($key == 'E_ATTIVO') {
                echo $value == 1 ? '<td><span class="badge-success-custom">Attivo</span></td>' :
                    '<td><span class="badge-danger-custom">Inattivo</span></td>';
                $E_ATTIVO = $value;
            } else if ($key == 'E_PAGATO') {
                echo $value == 1 ? '<td><span class="badge-success-custom">Pagato</span></td>' :
                    '<td><span class="badge-danger-custom">Non&nbsp;Pagato</span></td>';
            } else if (strpos(strtolower($key), 'id')) {
                continue;
            } else {
                echo '<td>' . $value . '</td>';
            }

            if ($key == 'RUOLE') {
                $is_admin = $value;
            }
        }


        if ($_SESSION['role'] == 'Admin') {
            echo '<td>
                    <div class="btn-group">
                        <a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Modifica</a>&nbsp&nbsp&nbsp';
            if ($E_ATTIVO == 0) {
                echo '<button class="btn btn-success" onclick="confirmActivation(' . reset($row) .  ', \'' . $entity . '\')">Attivalo</button>&nbsp&nbsp&nbsp';
            } else {
                echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Elimina</button>&nbsp&nbsp&nbsp';
            }
            if ($entity == "utenti" || $entity == "aziende") {
                echo '<a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-info">Dettagli</a>';
            }
            echo '</div></td></tr>';
        } else if ($entity == "utenti" || $entity == "aziende") {
            echo '<td>
            <div class="btn-group">
                 <a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-info">Dettagli</a>
                 </div></td></tr>';
        }
    }
}

echo '</tbody>';



echo '</table></div>';


/*else {
    echo '<div class="col-12">
            <div class="card-header"><div style="margin-top: -20px; padding-top: 8px; height: 40px; font-size:20px; text-align:center; background-color: #fed48b; color: #d98b19; font-weight:bold" class="alert alert-danger" role="alert">No Data Found</div>                                                    
            </div>
        </div>';
}*/

mysqli_free_result($result);
include 'database/closedb.php';
