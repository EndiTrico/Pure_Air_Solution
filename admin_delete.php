<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];

$queryDepartment = "";
$queryStructure = "";
$queryUser = "";
$queryCompany = "";
$queryBankAccount = "";
$queryBills = "";


if ($entity == "aziende") {
    $queryDepartment = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";
    $queryStructure = "UPDATE STRUTTURE 
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";
    $queryUser = "DELETE FROM UTENTI_AZIENDE 
                    WHERE AZIENDA_ID = ?";
    $queryCompany = "UPDATE AZIENDE
                    SET E_ATTIVO = 0,
                        DATA_SINISTRA = DATE(NOW())
                    WHERE AZIENDA_ID = ?";
    $queryBankAccount = "UPDATE BANCA_CONTI
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";
    $queryImpianto = "UPDATE IMPIANTO 
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";

    $stmtDepartment = mysqli_prepare($conn, $queryDepartment);
    $stmtStructure = mysqli_prepare($conn, $queryStructure);
    $stmtUser = mysqli_prepare($conn, $queryUser);
    $stmtCompany = mysqli_prepare($conn, $queryCompany);
    $stmtBankAccount = mysqli_prepare($conn, $queryBankAccount);
    $stmtImpianto = mysqli_prepare($conn, $queryImpianto);


    mysqli_stmt_bind_param($stmtDepartment, "i", $id);
    mysqli_stmt_bind_param($stmtStructure, "i", $id);
    mysqli_stmt_bind_param($stmtUser, "i", $id);
    mysqli_stmt_bind_param($stmtCompany, "i", $id);
    mysqli_stmt_bind_param($stmtBankAccount, "i", $id);
    mysqli_stmt_bind_param($stmtImpianto, "i", $id);


    mysqli_stmt_execute($stmtDepartment);
    mysqli_stmt_execute($stmtStructure);
    mysqli_stmt_execute($stmtUser);
    mysqli_stmt_execute($stmtCompany);
    mysqli_stmt_execute($stmtBankAccount);
    mysqli_stmt_execute($stmtImpianto);

} else if ($entity == "strutture") {
    $queryImpianto = "UPDATE IMPIANTO 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";
    $queryDepartment = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";
    $queryStructure = "UPDATE STRUTTURE 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";

    $stmtImpianto = mysqli_prepare($conn, $queryImpianto);
    $stmtDepartment = mysqli_prepare($conn, $queryDepartment);
    $stmtStructure = mysqli_prepare($conn, $queryStructure);

    mysqli_stmt_bind_param($stmtImpianto, "i", $id);
    mysqli_stmt_bind_param($stmtDepartment, "i", $id);
    mysqli_stmt_bind_param($stmtStructure, "i", $id);

    mysqli_stmt_execute($stmtImpianto);
    mysqli_stmt_execute($stmtDepartment);
    mysqli_stmt_execute($stmtStructure);


} else if ($entity == "reparti") {
    $queryImpianto = "UPDATE IMPIANTO 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";

    $queryDepartment = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE REPARTO_ID = ?";

    $stmtImpianto = mysqli_prepare($conn, $queryImpianto);
    $stmtDepartment = mysqli_prepare($conn, $queryDepartment);

    mysqli_stmt_bind_param($stmtImpianto, "i", $id);
    mysqli_stmt_bind_param($stmtDepartment, "i", $id);

    mysqli_stmt_execute($stmtImpianto);
    mysqli_stmt_execute($stmtDepartment);
} else if ($entity == "utenti") {
    $queryUser = "UPDATE UTENTI 
                    SET E_ATTIVO = 0
                    WHERE UTENTE_ID = ?";

    $stmtUser = mysqli_prepare($conn, $queryUser);

    mysqli_stmt_bind_param($stmtUser, "i", $id);

    mysqli_stmt_execute($stmtUser);
} else if ($entity == "banca conti") {
    $queryBankAccount = "UPDATE BANCA_CONTI 
                        SET E_ATTIVO = 0
                        WHERE BANCA_CONTI = ?";

    $stmtBankAccount = mysqli_prepare($conn, $queryBankAccount);

    mysqli_stmt_bind_param($stmtBankAccount, "i", $id);

    mysqli_stmt_execute($stmtBankAccount);
} else if ($entity == "fatture") {
    $queryBills = "UPDATE FATTURE 
                    SET E_PAGATO = 0
                    WHERE FATTURA_ID = ?";

    $stmtBills = mysqli_prepare($conn, $queryBills);

    mysqli_stmt_bind_param($stmtBills, "i", $id);
    mysqli_stmt_execute($stmtBills);
}

include 'database/closedb.php';

header('Location: admin_display_entities.php');
exit();