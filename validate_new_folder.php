<?php
header('Content-Type: application/json');

session_start();
date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newFolderName = $_POST['folderName'];
    $currentFolderPath = $_POST['currentPath'];
	
    $targetFolder = $currentFolderPath . '/' . $newFolderName;

    if (file_exists($targetFolder)) {
        echo json_encode(['success' => false, 'message' => 'Esiste Già Una Cartella con Quel Nome.']);
    } else {
       
        if (mkdir($targetFolder, 0777, true)) {
			echo json_encode(['success' => true, 'message' => 'Cartella Creata Correttamente.']);
          	insertIntoLogs($currentDateAndTime, $_SESSION['user_id'], $targetFolder);
        } else {
            echo json_encode(['success' => false, 'message' => 'Impossibile Creare la Cartella.']);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Richiesta Non Valida']);
}

function insertIntoLogs($currentDateAndTime, $user_id, $targetFolder){
  	include 'database/config.php';
	include 'database/opendb.php';
  
 	$logCartella = "INSERT INTO LOGS (UTENTE_ID, ENTITA, AZIONE, ATTRIBUTO, NUOVO_VALORE, DATA_ORA) 
    				VALUES (?, 'CARTELLE', 'Inserimento', 'NOME', ?, ?)";
   	$stmtCartella = mysqli_prepare($conn, $logCartella);
    mysqli_stmt_bind_param($stmtCartella, "iss", $user_id, $targetFolder, $currentDateAndTime);
   	mysqli_stmt_execute($stmtCartella);
    mysqli_stmt_close($stmtCartella);
  	
  	include 'database/closedb.php';
    return true;

}

