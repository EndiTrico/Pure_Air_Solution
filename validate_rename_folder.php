<?php
include 'nas/credentials.php';
header('Content-Type: application/json');

session_start();
date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFolderName = $_POST['folderName'];
    $currentFolderPath = $_POST['currentPath'];
    $dirName = dirname($currentFolderPath);

    if (!is_dir($dirName)) {
        echo json_encode(['success' => false, 'message' => 'Percorso Corrente Non Valido.']);
    } else {
        $targetFolder = $dirName . '/' . $newFolderName;
        $encodedCurrentPath = $baseUrl . '/' . ltrim($currentFolderPath, '/');
        $encodedTargetPath = $baseUrl . '/' . ltrim($targetFolder, '/');

        // Rename folder on NAS using WebDAV
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $encodedCurrentPath);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "MOVE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Destination: $encodedTargetPath"
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode == 201 || $httpCode == 204) { // HTTP 201 Created or 204 No Content
            // Update documents and logs
            getDocumentsThatWillChange($currentFolderPath, $targetFolder, $currentDateAndTime, $_SESSION['user_id']);
            echo json_encode(['success' => true, 'message' => 'Cartella Rinominata Correttamente.', 'newPath' => $targetFolder]);
        } elseif ($httpCode == 404) { // HTTP 404 Not Found
            echo json_encode(['success' => false, 'message' => 'La cartella specificata non esiste.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Impossibile Rinominare la Cartella. Codice: ' . $httpCode]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta Non Valida']);
}

function getDocumentsThatWillChange($currentFolderPath, $targetFolder, $currentDateAndTime, $user_id) {
    include 'database/config.php';
    include 'database/opendb.php';
    
    $affectedFiles = [];
    $selectQuery = "SELECT DOCUMENTO_ID FROM DOCUMENTI WHERE PERCORSO LIKE ?";
    if ($stmtSelect = mysqli_prepare($conn, $selectQuery)) {
        $likePath = $currentFolderPath . '%';
        mysqli_stmt_bind_param($stmtSelect, "s", $likePath);
        mysqli_stmt_execute($stmtSelect);
        mysqli_stmt_bind_result($stmtSelect, $documentoID);
        
        while (mysqli_stmt_fetch($stmtSelect)) {
            $affectedFiles[] = ['documentoID' => $documentoID];
        }
        mysqli_stmt_close($stmtSelect);
    } else {
        error_log("Error preparing statement: " . mysqli_error($conn));
    }
    
    $updateSuccess = updatePath($currentFolderPath, $targetFolder);
    $logSuccess = insertIntoLogs($currentFolderPath, $targetFolder, $affectedFiles, $currentDateAndTime, $user_id);

    include 'database/closedb.php';
	return true;
}

function updatePath($currentFolderPath, $targetFolder){
  	include 'database/config.php';
	include 'database/opendb.php';

    $updateQuery = "UPDATE DOCUMENTI
                	SET PERCORSO = REPLACE(PERCORSO, ?, ?)
                	WHERE PERCORSO LIKE CONCAT(?, '%')";

  	$stmtUpdate = mysqli_prepare($conn, $updateQuery);
	mysqli_stmt_bind_param($stmtUpdate, "sss", $currentFolderPath, $targetFolder, $currentFolderPath);
	mysqli_stmt_execute($stmtUpdate);
	
	mysqli_stmt_close($stmtUpdate);
    include 'database/closedb.php';

  return true;
}

function insertIntoLogs($currentFolderPath, $targetFolder, $affectedFiles, $currentDateAndTime, $user_id){
  	include 'database/config.php';
	include 'database/opendb.php';
  
	foreach ($affectedFiles as $file) {

      	$logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, ATTRIBUTO, VECCHIO_VALORE, NUOVO_VALORE, DATA_ORA) 
    				VALUES (?, 'DOCUMENTI', ?, 'Modificare', 'PERCORSO', ?, ?, ?)";
    	$stmtLog = mysqli_prepare($conn, $logSql);
    	mysqli_stmt_bind_param($stmtLog, "iisss", $user_id,  $file['documentoID'], $currentFolderPath, $targetFolder, $currentDateAndTime);
    	mysqli_stmt_execute($stmtLog);
    	mysqli_stmt_close($stmtLog);
	}
  
 	$logCartella = "INSERT INTO LOGS (UTENTE_ID, ENTITA, AZIONE, ATTRIBUTO, VECCHIO_VALORE, NUOVO_VALORE, DATA_ORA) 
    				VALUES (?, 'CARTELLE', 'Modificare', 'NOME', ?, ?, ?)";
   	$stmtCartella = mysqli_prepare($conn, $logCartella);
    mysqli_stmt_bind_param($stmtCartella, "isss", $user_id, $currentFolderPath, $targetFolder, $currentDateAndTime);
   	mysqli_stmt_execute($stmtCartella);
    mysqli_stmt_close($stmtCartella);
  	
  	include 'database/closedb.php';
    return true;

}
