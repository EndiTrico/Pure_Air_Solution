<?php
// Assuming you have already established a MySQL connection
include 'database/config.php';
include 'database/opendb.php';
session_start();

$entity = $_GET['entity'];
$search = $_GET['search'];

$query = "";

if ($entity == "utenti") {
    $query = "SELECT u.UTENTE_ID, u.NOME, u.COGNOME, u.EMAIL, u.NUMERO, u.RUOLO, u.AZIENDA_POSIZIONE, u.E_ATTIVO 
                FROM UTENTI u";
} else if ($entity == "aziende") {
    $query = "SELECT AZIENDA_ID, AZIENDA_NOME, PARTITA_IVA, CODICE_FISCALE, CONTATTO_1, CONTATTO_2, CONTATTO_3, EMAIL_1, EMAIL_2, EMAIL_3, TELEFONO_1, TELEFONO_2, TELEFONO_3, INDIRIZZO, CITTA, INDIRIZZO_PEC, WEBSITE, DATA_ISCRIZIONE, DATA_SINISTRA, INFORMAZIONI, E_ATTIVO
                FROM AZIENDE";
} else if ($entity == "strutture") {
    $query = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME, s.E_ATTIVO, c.AZIENDA_NOME
                FROM STRUTTURE s
                JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID";
} else if ($entity == "reparti") {
    $query = "SELECT d.REPARTO_ID, d.REPARTO_NOME, d.E_ATTIVO, s.STRUTTURA_NOME, c.AZIENDA_NOME
                FROM REPARTI d 
                JOIN STRUTTURE s ON d.STRUTTURA_ID = s.STRUTTURA_ID
                JOIN AZIENDE c on d.AZIENDA_ID = c.AZIENDA_ID";
}

if (!empty($search)) {
    if ($entity == "UTENTI") {
        $query .= " WHERE CONCAT(u.NOME, ' ', u.COGNOME, ' ', u.EMAIL, ' ', u.RUOLO) LIKE '%$search%'";
    } else if ($entity == "AZIENDE") {
        $query .= " WHERE CONCAT(AZIENDA_NOME, ' ', EMAIL) LIKE '%$search%'";
    } else if ($entity == "STRUTTURE") {
        $query .= " WHERE CONCAT(s.STRUTTURA_NOME, ' ', c.AZIENDA_NOME) LIKE '%$search%'";
    } else if ($entity == "departures") {
        $query .= " WHERE CONCAT(d.REPARTO_NOME, ' ', s.STRUTTURA_NOME, ' ', c.AZIENDA_NOME) LIKE '%$search%'";   
    }
}

if (!empty($_SESSION['AZIENDA_ID'])) {
    $query .= " AND AZIENDA_ID = " . $_SESSION["AZIENDA_ID"];
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>';
    $columnIndex = 0;

    while ($fieldinfo = mysqli_fetch_field($result)) {
        if ($fieldinfo->name === 'PASSWORD' || strpos(strtolower($fieldinfo->name), 'id')) {
            continue;
        }

        $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));
        echo '<th>' . $fieldName . '</th>';
    }

    if ($_SESSION['role'] == 'Admin') {
        echo '<th>Actions</th>';
    }
    
    echo '</tr>
            </thead>
                <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $E_ATTIVO = 0;
        $is_admin = "";

        foreach ($row as $key => $value) {
            if ($key == 'E_ATTIVO') {
                echo $value == 1 ? '<td><span class="badge-success-custom">Active</span></td>' :
                    '<td><span class="badge-danger-custom">Inactive</span></td>';
                $E_ATTIVO = $value;
            } else if (strpos(strtolower($key), 'id')){
                continue;
            } else {
                echo '<td>' . $value . '</td>';
            }

            if ($key == 'RUOLE') {
                $is_admin = $value;
            }
        }

        if ($_SESSION['role'] == 'Admin') {
            echo '<td><a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Modifica</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if ($E_ATTIVO == 0) {
                echo '<button class="btn btn-info" onclick="confirmActivation(\'' . reset($row) . '\', \'' . $entity . '\')"> Attiva </button>';
            } else {
                echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Elimina</button>';
            }
            echo '</td></tr>';
        }
    }

    echo '</tbody>';
    echo '</table></div>';

  
} else {
    echo '<div class="col-12">
            <div class="card-header"><div style="margin-top: -20px; padding-top: 8px; height: 40px; font-size:20px; text-align:center; background-color: #fed48b; color: #d98b19; font-weight:bold" class="alert alert-danger" role="alert">No Data Found</div>                                                    
            </div>
        </div>';
}

mysqli_free_result($result);
include 'database/closedb.php';