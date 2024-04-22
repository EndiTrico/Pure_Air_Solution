<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_POST["id"];

if (!empty($id)) {
    $query = "SELECT REPARTO_ID, REPARTO_NOME FROM REPARTI WHERE STRUTTURA_ID = ? AND E_ATTIVO = 1";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['REPARTO_ID'] . '">' . $row['REPARTO_NOME'] . '</option>';
        }
    } else {
        echo '<option disabled selected value="">Non Esiste Alcuna Struttura per Quell\'Agenzia</option>';
    }
}

include 'database/closedb.php';
