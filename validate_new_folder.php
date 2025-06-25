<?php
//header('Content-Type: application/json');
//session_start();
	date_default_timezone_set('Europe/Berlin');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['folderName']) && isset($_POST['currentPath'])) {
	
	$newFolderName = $_POST['folderName'];
    $currentFolderPath = $_POST['currentPath'];
	
  	createFolder($newFolderName, $currentFolderPath, false);
	
}  /*else {
    echo json_encode(['success' => false, 'message' => 'Richiesta Non Valida']);
}*/

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

function createFolder($newFolderName, $currentFolderPath, $returnJSON) {
    include 'nas/credentials.php';
	$currentDateAndTime = date('Y-m-d H:i:s');
    $targetFolder = $currentFolderPath . '/' . rawurlencode($newFolderName);

    $folderUrl = $baseUrl . '/' . ltrim($targetFolder, '/');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $folderUrl);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "MKCOL");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
  
    if ($returnJSON) 
        returnJSON($currentDateAndTime, $folderUrl, $httpCode);
    else
        printJSON($currentDateAndTime, $folderUrl, $httpCode);   

}

function returnJSON($currentDateAndTime, $folderUrl, $httpCode){
    if ($httpCode == 201) {
      	session_start();
        insertIntoLogs($currentDateAndTime, $_SESSION['user_id'], $folderUrl);
    } 
}

function printJSON($currentDateAndTime, $folderUrl, $httpCode){
    session_start();
  
  	if ($httpCode == 201) {
        insertIntoLogs($currentDateAndTime, $_SESSION['user_id'], $folderUrl);
        echo json_encode(['success' => true, 'message' => 'Cartella Creata Correttamente.']);
    } elseif ($httpCode == 405) {
        echo json_encode(['success' => false, 'message' => 'Esiste Già Una Cartella con Quel Nome: '.$folderUrl]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Impossibile Creare la Cartella. Codice: ' . $httpCode]);
    }
}