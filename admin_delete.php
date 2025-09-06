<?php
include 'database/config.php';
include 'database/opendb.php';

session_start();

$id = $_GET['id'];
$entity = $_GET['entity'];
$left_date = $_GET['dateValue'];

date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');


if ($entity == "aziende") {
    $childEntities = [
        'REPARTO-REPARTI' => "SELECT REPARTO_ID FROM REPARTI WHERE AZIENDA_ID = ? AND E_ATTIVO = 1",
        'STRUTTURA-STRUTTURE' => "SELECT STRUTTURA_ID FROM STRUTTURE WHERE AZIENDA_ID = ? AND E_ATTIVO = 1",
        'UTENTE-UTENTI_AZIENDE' => "SELECT UTENTE_ID FROM UTENTI_AZIENDE WHERE AZIENDA_ID = ?",
        'BANCA_CONTO-BANCA_CONTI' => "SELECT BANCA_CONTO_ID FROM BANCA_CONTI WHERE AZIENDA_ID = ? AND E_ATTIVO = 1",
        'IMPIANTO-IMPIANTI' => "SELECT IMPIANTO_ID FROM IMPIANTI WHERE AZIENDA_ID = ? AND E_ATTIVO = 1"
    ];

    foreach ($childEntities as $name => $query) {
        $stmtFetch = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmtFetch, "i", $id);
        mysqli_stmt_execute($stmtFetch);
        $result = mysqli_stmt_get_result($stmtFetch);
        
      	$parts = explode("-", $name);

		$partOfPK = $parts[0];
		$childEntity = $parts[1];
      
        if ($childEntity == 'UTENTI_AZIENDE') {
 	        $deleteQuery = "DELETE FROM UTENTI_AZIENDE WHERE UTENTE_ID = ?";
            $stmtDelete = mysqli_prepare($conn, $deleteQuery);
            mysqli_stmt_bind_param($stmtDelete, "i", $childId);
            mysqli_stmt_execute($stmtDelete);
        } else {
            $updateQuery = "UPDATE " . $childEntity . " SET E_ATTIVO = 0, DATA_FINE = ? WHERE " . "AZIENDA_ID = ?";
            $stmtUpdate = mysqli_prepare($conn, $updateQuery);
            mysqli_stmt_bind_param($stmtUpdate, "si", $left_date, $childId);
            mysqli_stmt_execute($stmtUpdate);
        }
      
        while ($row = mysqli_fetch_assoc($result)) {
            $childId = $row[$partOfPK . '_ID'];

            if ($childEntity == 'UTENTI_AZIENDE') {
                insertIntoLogsUTENTI_AZIENDA($conn, $_SESSION['user_id'], $childEntity, $id , $childId , $currentDateAndTime);
            } else {
                insertIntoLogs($conn, $_SESSION['user_id'], $childEntity, $childId, $currentDateAndTime);
            }
        }
    }
    mysqli_stmt_close($stmtUpdate);
    mysqli_stmt_close($stmtDelete);
    
	$updateAzienda = "UPDATE AZIENDE SET E_ATTIVO = 0, DATA_FINE = ? WHERE AZIENDA_ID = ?";
    $stmtAzienda = mysqli_prepare($conn, $updateAzienda);
    mysqli_stmt_bind_param($stmtAzienda, "si", $left_date, $id);
    mysqli_stmt_execute($stmtAzienda);
    mysqli_stmt_close($stmtAzienda);

    insertIntoLogs($conn, $_SESSION['user_id'], 'AZIENDE', $id, $currentDateAndTime);
} else if ($entity == "strutture") {
    $childEntities = [
        'IMPIANTO-IMPIANTI' => "SELECT IMPIANTO_ID FROM IMPIANTI WHERE STRUTTURA_ID = ? AND E_ATTIVO = 1",
        'REPARTO-REPARTI' => "SELECT REPARTO_ID FROM REPARTI WHERE STRUTTURA_ID = ? AND E_ATTIVO = 1"
    ];

    foreach ($childEntities as $name => $query) {
        $stmtFetch = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmtFetch, "i", $id);
        mysqli_stmt_execute($stmtFetch);
        $result = mysqli_stmt_get_result($stmtFetch);

        $parts = explode("-", $name);
        $partOfPK = $parts[0];
        $childEntity = $parts[1];

        $updateQuery = "UPDATE " . $childEntity . " SET E_ATTIVO = 0, DATA_FINE = ? WHERE " . " STRUTTURA_ID = ?";
        $stmtUpdate = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "si", $left_date, $id);
        mysqli_stmt_execute($stmtUpdate);

        while ($row = mysqli_fetch_assoc($result)) {
            $childId = $row[$partOfPK . '_ID'];
         
            insertIntoLogs($conn, $_SESSION['user_id'], $childEntity, $childId, $currentDateAndTime);
        }
    }
    mysqli_stmt_close($stmtUpdate);
  
  	$updateStruttura = "UPDATE STRUTTURE SET E_ATTIVO = 0, DATA_FINE = ? WHERE STRUTTURA_ID = ?";
    $stmtStruttura = mysqli_prepare($conn, $updateStruttura);
    mysqli_stmt_bind_param($stmtStruttura, "si", $left_date, $id);
    mysqli_stmt_execute($stmtStruttura);
    mysqli_stmt_close($stmtStruttura);

    insertIntoLogs($conn, $_SESSION['user_id'], "STRUTTURE", $id, $currentDateAndTime);
} else if ($entity == "reparti") {
    $childEntities = [
        'IMPIANTO-IMPIANTI' => "SELECT IMPIANTO_ID FROM IMPIANTI WHERE REPARTO_ID = ? AND E_ATTIVO = 1"
    ];

    foreach ($childEntities as $name => $query) {
        $stmtFetch = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmtFetch, "i", $id);
        mysqli_stmt_execute($stmtFetch);
        $result = mysqli_stmt_get_result($stmtFetch);

        $parts = explode("-", $name);
        $partOfPK = $parts[0];
        $childEntity = $parts[1];
        
        $updateQuery = "UPDATE " . $childEntity . " SET E_ATTIVO = 0, DATA_FINE = ? WHERE REPARTO_ID = ?";
        $stmtUpdate = mysqli_prepare($conn, $updateQuery);
        mysqli_stmt_bind_param($stmtUpdate, "si", $left_date, $id);
        mysqli_stmt_execute($stmtUpdate);
    
        while ($row = mysqli_fetch_assoc($result)) {
            $childId = $row[$partOfPK . '_ID'];

            insertIntoLogs($conn, $_SESSION['user_id'], $childEntity, $childId, $currentDateAndTime);
        }
    }
    mysqli_stmt_close($stmtUpdate);

    $updateReparti = "UPDATE REPARTI SET E_ATTIVO = 0, DATA_FINE = ? WHERE REPARTO_ID = ?";
    $stmtReparti = mysqli_prepare($conn, $updateReparti);
    mysqli_stmt_bind_param($stmtReparti, "si", $left_date, $id);
    mysqli_stmt_execute($stmtReparti);
    mysqli_stmt_close($stmtReparti);

    insertIntoLogs($conn, $_SESSION['user_id'], "REPARTI", $id, $currentDateAndTime);
} else if ($entity == "utenti") {
      $childEntities = [
        'AZIENDA-UTENTI_AZIENDE' => "SELECT AZIENDA_ID FROM UTENTI_AZIENDE WHERE UTENTE_ID = ?"
      ];

    foreach ($childEntities as $name => $query) {
        $stmtFetch = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmtFetch, "i", $id);
        mysqli_stmt_execute($stmtFetch);
        $result = mysqli_stmt_get_result($stmtFetch);
        
      	$parts = explode("-", $name);

		$partOfPK = $parts[0];
		$childEntity = $parts[1];
       
        $deleteQuery = "DELETE FROM UTENTI_AZIENDE WHERE UTENTE_ID = ?";
        $stmtDelete = mysqli_prepare($conn, $deleteQuery);
        mysqli_stmt_bind_param($stmtDelete, "i", $id);  
        mysqli_stmt_execute($stmtDelete);
        
        while ($row = mysqli_fetch_assoc($result)) {
           $childId = $row[$partOfPK . '_ID'];
          
           insertIntoLogsUTENTI_AZIENDA($conn, $_SESSION['user_id'], $childEntity, $childId, $id, $currentDateAndTime);
        }
    }
   mysqli_stmt_close($stmtDelete);
    
	$updateUtente = "UPDATE UTENTI SET E_ATTIVO = 0, DATA_FINE = ? WHERE UTENTE_ID = ?";
    $stmtUtente = mysqli_prepare($conn, $updateUtente);
    mysqli_stmt_bind_param($stmtUtente, "si", $left_date, $id);
    mysqli_stmt_execute($stmtUtente);
    mysqli_stmt_close($stmtUtente);

    insertIntoLogs($conn, $_SESSION['user_id'], 'UTENTI', $id, $currentDateAndTime); 
} else if ($entity == "banca conti") {
	$updateQuery = "UPDATE BANCA_CONTI SET E_ATTIVO = 0, DATA_FINE = ? WHERE BANCA_CONTO_ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
	mysqli_stmt_bind_param($stmtUpdate, "si", $left_date, $id);
    mysqli_stmt_execute($stmtUpdate);
   	mysqli_stmt_close($stmtUpdate);

    insertIntoLogs($conn, $_SESSION['user_id'], 'BANCA_CONTI', $id, $currentDateAndTime);    
} else if ($entity == "fatture") {
    $updateQuery = "UPDATE FATTURE SET E_PAGATO = 0, DATA_PAGAMENTO = NULL WHERE FATTURA_ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "i", $id);
    mysqli_stmt_execute($stmtUpdate);
   	mysqli_stmt_close($stmtUpdate);

    insertIntoLogs($conn, $_SESSION['user_id'], 'FATTURE', $id, $currentDateAndTime);
}  else if ($entity == "impianti") {
    $updateQuery = "UPDATE IMPIANTI SET E_ATTIVO = 0, DATA_FINE = ? WHERE IMPIANTO_ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "si", $left_date, $id);
    mysqli_stmt_execute($stmtUpdate);
   	mysqli_stmt_close($stmtUpdate);

    insertIntoLogs($conn, $_SESSION['user_id'], 'IMPIANTI', $id, $currentDateAndTime);
} else if ($entity == 'cartelle') {
	echo deleteDirectory($id, $currentDateAndTime);
} else if ($entity == 'documenti') {
	echo deleteFile($id, $currentDateAndTime);
} else if ($entity == 'dipendenti') {
    $updateQuery = "UPDATE DIPENDENTI SET E_ATTIVO = 0, DATA_FINE = ? WHERE DIPENDENTE_ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmtUpdate, "ii", $left_date, $id);
    mysqli_stmt_execute($stmtUpdate);
   	mysqli_stmt_close($stmtUpdate);

    insertIntoLogs($conn, $_SESSION['user_id'], 'DIPENDENTI', $id, $currentDateAndTime);  
} else if ($entity == 'registro_lavori') {
    $deleteQuery = "DELETE FROM REGISTRO_LAVORI WHERE REGISTRO_LAVORO_ID = ?";
    $stmtDelete = mysqli_prepare($conn, $deleteQuery);
    mysqli_stmt_bind_param($stmtDelete, "i",  $id);
    mysqli_stmt_execute($stmtDelete);
   	mysqli_stmt_close($stmtDelete);

    insertIntoLogs($conn, $_SESSION['user_id'], 'REGISTRO_LAVORI', $id, $currentDateAndTime);  
}

function insertIntoLogs($conn, $userId, $entity, $entityId, $actionDate) {
  	if ($entity === 'CARTELLE') {
     	$logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, VECCHIO_VALORE, AZIONE, DATA_ORA) VALUES (?, ?, ?, 'Eliminare', ?)";
    	$stmtLog = mysqli_prepare($conn, $logSql);
    	mysqli_stmt_bind_param($stmtLog, "isss", $userId, $entity, $entityId, $actionDate);
    	mysqli_stmt_execute($stmtLog);
   		mysqli_stmt_close($stmtLog);
    } else {
      	$logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, ?, ?, 'Eliminare', ?)";
    	$stmtLog = mysqli_prepare($conn, $logSql);
    	mysqli_stmt_bind_param($stmtLog, "isis", $userId, $entity, $entityId, $actionDate);
    	mysqli_stmt_execute($stmtLog);
   		mysqli_stmt_close($stmtLog);
    }
}

function insertIntoLogsUTENTI_AZIENDA($conn, $userId, $entity, $aziendaId, $utenteId, $actionDate) {
    $logSql01 = "INSERT INTO LOGS (UTENTE_ID, ENTITA, UA_AZIENDA_ID, UA_UTENTE_ID, AZIONE, DATA_ORA) VALUES (?, ?, ?, ?,'Eliminare', ?)";
    $stmtLog01 = mysqli_prepare($conn, $logSql01);
    mysqli_stmt_bind_param($stmtLog01, "isiis", $userId, $entity, $aziendaId, $utenteId, $actionDate);
    mysqli_stmt_execute($stmtLog01);
   	mysqli_stmt_close($stmtLog01);
}

function deleteFile($filePath, $currentDateAndTime) {
    include 'database/config.php';
    include 'database/opendb.php';
	include 'nas/credentials.php';

    // Encode the file path
    $encodedFileName = rawurlencode(basename($filePath));
    $fileUrl = $baseUrl . '/' . rawurlencode(dirname($filePath)) . '/' . $encodedFileName;

    // Send WebDAV DELETE request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $filePath);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    // Log WebDAV response
    error_log("HTTP Code: $httpCode");
    error_log("Response: $response");
    error_log("cURL Error: $curlError");

    // Check if the deletion was successful
    if ($httpCode != 204 && $httpCode != 200) {
        throw new Exception("Impossibile eliminare il file. URL: $filePath. Codice HTTP: $httpCode");
    }

    // Mark the file as deleted in the database
    $selectQuery = "SELECT DOCUMENTO_ID FROM DOCUMENTI WHERE PERCORSO = ? AND E_ATTIVO = 1";
    $stmtSelect = mysqli_prepare($conn, $selectQuery);
    if (!$stmtSelect) {
        throw new Exception("Impossibile preparare l'istruzione SELECT: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtSelect, "s", $filePath);
    mysqli_stmt_execute($stmtSelect);
    mysqli_stmt_bind_result($stmtSelect, $documentoId);
    mysqli_stmt_fetch($stmtSelect);
    mysqli_stmt_close($stmtSelect);

    $updateQuery = "UPDATE DOCUMENTI SET E_ATTIVO = 0, DATA_CANCELLATA = ? WHERE DOCUMENTO_ID = ?";
    $stmtUpdate = mysqli_prepare($conn, $updateQuery);
    if (!$stmtUpdate) {
        throw new Exception("Impossibile preparare l'istruzione UPDATE: " . mysqli_error($conn));
    }
    mysqli_stmt_bind_param($stmtUpdate, "si", $currentDateAndTime, $documentoId);
    mysqli_stmt_execute($stmtUpdate);
    mysqli_stmt_close($stmtUpdate);

    insertIntoLogs($conn, $_SESSION['user_id'], 'DOCUMENTI', $documentoId, $currentDateAndTime);

    include 'database/closedb.php';
}


function deleteDirectory($dirPath, $currentDateAndTime) {
    include 'database/config.php';
    include 'database/opendb.php';

    $baseUrl = "http://2.36.247.103:5000";
    $username = "endi";
    $password = "Endi12345!";

/*    if (!is_dir($dirPath)) {
        throw new InvalidArgumentException("$dirPath must be a directory");
    }
*/
    // Add trailing slash if not present
    if (substr($dirPath, -1) != '/') {
        $dirPath .= '/';
    }

    // Get all files and subdirectories in the directory
    $files = glob($dirPath . '*', GLOB_MARK);

    foreach ($files as $file) {
        if (is_dir($file)) {
            // Recursive call to delete subdirectories
            deleteDirectory($file, $currentDateAndTime);
        } else {
            // Delete individual files via WebDAV
            $fileUrl = $baseUrl . '/' . ltrim($file, '/');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $fileUrl);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            if ($httpCode != 204 && $httpCode != 200) {
                throw new Exception("Impossibile eliminare il documento $file. Codice: $httpCode. Errore cURL: $curlError");
            }

            // Update the database for deleted files
            $selectQuery = "SELECT DOCUMENTO_ID FROM DOCUMENTI WHERE PERCORSO = ? AND E_ATTIVO = 1";
            $stmtSelect = mysqli_prepare($conn, $selectQuery);
            if (!$stmtSelect) {
                throw new Exception("Impossibile preparare l'istruzione select: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmtSelect, "s", $file);
            mysqli_stmt_execute($stmtSelect);
            mysqli_stmt_bind_result($stmtSelect, $documentoId);
            mysqli_stmt_fetch($stmtSelect);
            mysqli_stmt_close($stmtSelect);

            $updateQuery = "UPDATE DOCUMENTI SET E_ATTIVO = 0, DATA_CANCELLATA = ? WHERE DOCUMENTO_ID = ? AND E_ATTIVO = 1";
            $stmtUpdate = mysqli_prepare($conn, $updateQuery);
            if (!$stmtUpdate) {
                throw new Exception("Impossibile preparare l'istruzione update: " . mysqli_error($conn));
            }
            mysqli_stmt_bind_param($stmtUpdate, "si", $currentDateAndTime, $documentoId);
            mysqli_stmt_execute($stmtUpdate);
            mysqli_stmt_close($stmtUpdate);

            insertIntoLogs($conn, $_SESSION['user_id'], 'DOCUMENTI', $documentoId, $currentDateAndTime);
        }
    }

    // Delete the directory via WebDAV
    $dirUrl = $baseUrl . '/' . ltrim($dirPath, '/');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $dirUrl);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($httpCode != 204 && $httpCode != 200) {
        throw new Exception("Impossibile rimuovere la directory $dirPath. Codice: $httpCode. Errore cURL: $curlError");
    } else {
        insertIntoLogs($conn, $_SESSION['user_id'], 'CARTELLE', $dirPath, $currentDateAndTime);
    }

    include 'database/closedb.php';
}



include 'database/closedb.php';

if ($entity == 'documenti' || $entity == 'cartelle') {
  header('Location: admin_display_reports.php');
} else {
	header('Location: admin_display_entities.php');
}
exit();