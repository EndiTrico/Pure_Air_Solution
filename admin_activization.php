<?php
session_start();

$id = $_GET['id'];
$entity = $_GET['entity'];
$paid_date = $_GET['dateValue'];

include 'database/config.php';
include 'database/opendb.php';

if ($entity == 'utenti') {
    $isActive = 1;
    $update = "UPDATE UTENTI 
                SET E_ATTIVO = 1, 
                    DATA_FINE = NULL 
                WHERE UTENTE_ID = ?";
} else if ($entity == "strutture") {
    $sql = "SELECT c.E_ATTIVO 
            FROM STRUTTURE s
            JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID
            WHERE s.STRUTTURA_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE STRUTTURE
                SET E_ATTIVO = 1,
                    DATA_FINE = NULL
                WHERE STRUTTURA_ID = ?";
} else if ($entity == "reparti") {
    $sql = "SELECT c.E_ATTIVO 
            FROM REPARTI d
            JOIN AZIENDE c on d.AZIENDA_ID = c.AZIENDA_ID
            WHERE d.REPARTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive1);

    $stmt->fetch();
    $stmt->close();

    $sql = "SELECT s.E_ATTIVO 
            FROM REPARTI d
            JOIN STRUTTURE s on s.STRUTTURA_ID = d.STRUTTURA_ID
            WHERE d.REPARTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive2);

    $stmt->fetch();
    $stmt->close();

    if ($isActive1 == 1 && $isActive2 == 1) {
        $isActive = 1;
        $update = "UPDATE REPARTI
                    SET E_ATTIVO = 1,
                        DATA_FINE = NULL   
                    WHERE REPARTO_ID = ?";
    } else {
        $isActive = 0;
    }
} else if ($entity == "aziende") {
    $isActive = 1;

    $update = "UPDATE AZIENDE
                SET E_ATTIVO = 1,
                    DATA_FINE = NULL 
                WHERE AZIENDA_ID = ?";
} else if ($entity == "banca conti") {
    $sql = "SELECT c.E_ATTIVO 
            FROM BANCA_CONTI s
            JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID
            WHERE s.BANCA_CONTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE BANCA_CONTI
                SET E_ATTIZVO = 1,
                    DATA_FINE = NULL 
                WHERE BANCA_CONTO_ID = ?";
} else if ($entity == "fatture") {
    $isActive = 1;

    $update = "UPDATE FATTURE 
                SET E_PAGATO = 1,
                    DATA_PAGAMENTO = ? 
                WHERE FATTURA_ID = ?";
} else if ($entity == "impianti") {
    $sql = "SELECT c.E_ATTIVO 
            FROM IMPIANTI d
            JOIN AZIENDE c on d.AZIENDA_ID = c.AZIENDA_ID
            WHERE d.IMPIANTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive1);

    $stmt->fetch();
    $stmt->close();

    $sql = "SELECT s.E_ATTIVO 
            FROM IMPIANTI d
            JOIN STRUTTURE s on s.STRUTTURA_ID = d.STRUTTURA_ID
            WHERE d.IMPIANTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive2);

    $stmt->fetch();
    $stmt->close();

    $sql = "SELECT s.E_ATTIVO 
            FROM IMPIANTI d
            JOIN REPARTI s on s.REPARTO_ID = d.REPARTO_ID
            WHERE d.IMPIANTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    $stmt->execute();
    $stmt->bind_result($isActive3);

    $stmt->fetch();
    $stmt->close();

    if ($isActive1 == 1 && $isActive2 == 1 && $isActive3 == 1) {
        $isActive = 1;
        $update = "UPDATE IMPIANTI
                    SET E_ATTIVO = 1,
                        DATA_FINE = NULL  
                    WHERE IMPIANTO_ID = ?";
    } else {
        $isActive = 0;
    }
} else if ($entity == "dipendenti") {
    $isActive = 1;
    $update = "UPDATE DIPENDENTI
                SET E_ATTIVO = 1,
                    DATA_FINE = NULL 
                WHERE DIPENDENTE_ID = ?";
}

if ($isActive == 0) {
    include 'database/closedb.php';

    echo json_encode(array('status' => 'error'));
} else {
    $stmt = $conn->prepare($update);
    if ($entity == "fatture") {
        $stmt->bind_param("si", $paid_date, $id);
    } else {
        $stmt->bind_param("i", $id);
    }
  	
    $stmt->execute();
    $stmt->close();
    
    date_default_timezone_set('Europe/Berlin');
    $currentDateAndTime = date('Y-m-d H:i:s');
    insertIntoLogs($entity, $id, $currentDateAndTime, $conn);

    include 'database/closedb.php';

    echo json_encode(array('status' => 'success'));
}

function insertIntoLogs($entity, $id, $currentDateAndTime, $conn) {
  	$entity_upper = strtoupper($entity);
    $sql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, ?, ?, 'Attivare', ?)";
    if ($stmt = $conn->prepare($sql)) {
        $userId = $_SESSION["user_id"];
        if ($stmt->bind_param("isis", $userId, $entity_upper, $id, $currentDateAndTime)) {
            $stmt->execute();
        } else {
            echo "Bind param failed: " . $conn->error;
        }
        $stmt->close();
    } else {
        echo "Prepare failed: " . $conn->error;
    }
}