<?php
header('Content-Type: application/json');
include 'nas/credentials.php';
session_start();
date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFolderName = $_POST['folderName'];
    $currentFolderPath = $_POST['currentPath'];
	
    $targetFolder = $currentFolderPath . '/' . rawurlencode($newFolderName);

    $folderUrl = $baseUrl . '/' . ltrim($targetFolder, '/');

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $folderUrl);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "MKCOL"); // MKCOL is used to create directories in WebDAV
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 201) { // HTTP 201 Created
        // Insert into logs
        insertIntoLogs($currentDateAndTime, $_SESSION['user_id'], $targetFolder);
        echo json_encode(['success' => true, 'message' => 'Cartella Creata Correttamente.']);
    } elseif ($httpCode == 405) { // HTTP 405 Method Not Allowed (Folder already exists)
        echo json_encode(['success' => false, 'message' => 'Esiste Già Una Cartella con Quel Nome.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Impossibile Creare la Cartella. Codice: ' . $httpCode]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta Non Valida']);
}

function insertIntoLogs($currentDateAndTime, $user_id, $targetFolder){
  	include 'database/config.php';
	include 'database/opendb.php';
  
 	$logCartella = "INSERT INTO LOGS (UTENTE_ID, ENTITA, AZIONE, ATTRIBUTO, NUOVO_VALORE, DATA_ORA) 
    				VALUES (?, 'CARTELLE', 'Creare', 'NOME', ?, ?)";
   	$stmtCartella = mysqli_prepare($conn, $logCartella);
    mysqli_stmt_bind_param($stmtCartella, "iss", $user_id, $targetFolder, $currentDateAndTime);
   	mysqli_stmt_execute($stmtCartella);
    mysqli_stmt_close($stmtCartella);
  	
  	include 'database/closedb.php';
    return true;

}

