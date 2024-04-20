<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_POST["id"];

if (!empty($id)) {
    $query = "SELECT BANCA_CONTO_ID, BANCA_NOME FROM BANCA_CONTI WHERE AZIENDA_ID = ? AND E_ATTIVO = 1 ORDER BY BANCA_NOME ";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['BANCA_NOME'] . '">' . $row['BANCA_NOME']  . ' </option>';
        }
    } else {
        echo '<option disabled selected value="">Non Esiste Alcuna Nome per Quell\'Agenzia</option>';
    }
}

include 'database/closedb.php';
