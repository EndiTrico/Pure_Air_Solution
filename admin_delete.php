<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];

$queryREPARTI = "";
$querySTRUTTURE = "";
$queryUTENTI = "";
$queryCompany = "";

if ($entity == "AZIENDE") {
    $queryREPARTI = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";
    $querySTRUTTURE = "UPDATE STRUTTURE 
                        SET E_ATTIVO = 0
                        WHERE AZIENDA_ID = ?";
    $queryUTENTI = "UPDATE UTENTI 
                    SET E_ATTIVO = 0
                    WHERE AZIENDA_ID = ?";
    $queryCompany = "UPDATE AZIENDE
                    SET E_ATTIVO = 0,
                    DATA_SINISTRA = DATE(NOW())
                    WHERE AZIENDA_ID = ?";

    $stmtREPARTI = mysqli_prepare($conn, $queryREPARTI);
    $stmtSTRUTTURE = mysqli_prepare($conn, $querySTRUTTURE);
    $stmtUTENTI = mysqli_prepare($conn, $queryUTENTI);
    $stmtCompany = mysqli_prepare($conn, $queryCompany);

    mysqli_stmt_bind_param($stmtREPARTI, "i", $id);
    mysqli_stmt_bind_param($stmtSTRUTTURE, "i", $id);
    mysqli_stmt_bind_param($stmtUTENTI, "i", $id);
    mysqli_stmt_bind_param($stmtCompany, "i", $id);

    mysqli_stmt_execute($stmtREPARTI);
    mysqli_stmt_execute($stmtSTRUTTURE);
    mysqli_stmt_execute($stmtUTENTI);
    mysqli_stmt_execute($stmtCompany);
} else if ($entity == "STRUTTURE") {
    $queryREPARTI = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";
    $querySTRUTTURE = "UPDATE STRUTTURE 
                        SET E_ATTIVO = 0
                        WHERE STRUTTURA_ID = ?";

    $stmtREPARTI = mysqli_prepare($conn, $queryREPARTI);
    $stmtSTRUTTURE = mysqli_prepare($conn, $querySTRUTTURE);

    mysqli_stmt_bind_param($stmtREPARTI, "i", $id);
    mysqli_stmt_bind_param($stmtSTRUTTURE, "i", $id);

    mysqli_stmt_execute($stmtREPARTI);
    mysqli_stmt_execute($stmtSTRUTTURE);
} else if ($entity == "REPARTI") {
    $queryREPARTI = "UPDATE REPARTI 
                        SET E_ATTIVO = 0
                        WHERE REPARTO_ID = ?";

    $stmtREPARTI = mysqli_prepare($conn, $queryREPARTI);

    mysqli_stmt_bind_param($stmtREPARTI, "i", $id);

    mysqli_stmt_execute($stmtREPARTI);
} else if ($entity == "UTENTI") {
    $queryUTENTI = "UPDATE UTENTI 
                    SET E_ATTIVO = 0
                    WHERE UTENTE_ID = ?";

    $stmtUTENTI = mysqli_prepare($conn, $queryUTENTI);

    mysqli_stmt_bind_param($stmtUTENTI, "i", $id);

    mysqli_stmt_execute($stmtUTENTI);
}

include 'database/closedb.php';

header('Location: admin_display_entities.php');
exit();