<?php
include 'database/config.php';
include 'database/opendb.php';

$companyID = $_POST["id"];
$bankName = $_POST["name"];

if (!empty($companyID)) {
    $query = "SELECT BANCA_CONTO_ID, IBAN FROM BANCA_CONTI WHERE AZIENDA_ID = ? AND BANCA_NOME = ? ORDER BY IBAN";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "is", $companyID, $bankName);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['BANCA_CONTO_ID'] . '">' . $row['IBAN']  . ' </option>';
        }
    } else {
        echo '<option disabled selected value="">Non Esiste Alcuna IBAN per Quella Banca</option>';
    }
}

include 'database/closedb.php';
