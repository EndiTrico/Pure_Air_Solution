<?php
session_start();

$defaultUploadDir = 'pas';

$uploadDir = isset($_POST['uploadPath']) ? $_POST['uploadPath'] : $defaultUploadDir;
$strutturaID = $_POST['strutturaID'];
$aziendaID = $_POST['aziendaID'];

date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');

$response = [];

if (!empty($_FILES['filesToUpload']['name'][0])) {
    foreach ($_FILES['filesToUpload']['name'] as $key => $name) {
        $path = $uploadDir . '/' . basename($name);
        $fileType = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        // File size check
        /*  if ($_FILES['filesToUpload']['size'][$key] > 50000000) {
              $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'File size exceeds 50 MB limit.'];
              continue;
          }*/

        if (file_exists($path)) {
            $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'Il documento esiste già.'];
            continue;
        }

        /* if (!file_exists($uploadDir)) {
             mkdir($uploadDir, 0777, true);
         }*/

        if (move_uploaded_file($_FILES['filesToUpload']['tmp_name'][$key], $path)) {
            $response[] = ['name' => $name, 'status' => 'success', 'message' => 'Il file è stato caricato con successo.'];
			
          	$documentoID = insertIntoDocumenti($aziendaID, $strutturaID, $name, $path, $currentDateAndTime);
			insertIntoLogs($_SESSION['user_id'], 'DOCUMENTI', $documentoID, $currentDateAndTime);

   /*         include 'database/config.php';
            include 'database/opendb.php';

            $insertQuery = "INSERT INTO DOCUMENTI (IMPIANTO_ID, NOME, PERCORSO, DATA_CARICAMENTO, E_ATTIVO) VALUES (?, ?, ?, ?, 1)";
            if ($stmt = mysqli_prepare($conn, $insertQuery)) {
                mysqli_stmt_bind_param($stmt, "isss", $strutturaID, $name, $path, $currentDateAndTime);
                mysqli_stmt_execute($stmt);
                $documentoID = mysqli_insert_id($conn);
                mysqli_stmt_close($stmt);
            } else {
                $documentoID = "";
            }

            $logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, 'DOCUMENTI', ?, 'Inserimento', ?)";
            if ($stmtLog = mysqli_prepare($conn, $logSql)) {
                mysqli_stmt_bind_param($stmtLog, "iis", $_SESSION['user_id'], $documentoID, $currentDateAndTime);
                mysqli_stmt_execute($stmtLog);
                mysqli_stmt_close($stmtLog);
            }

            include 'database/closedb.php';*/

        } else {
            $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'Impossibile caricare il file.'];
        }
    }
} else {
    $response[] = ['status' => 'failed', 'message' => 'Nessun file è stato caricato.'];
}

header('Content-Type: application/json');
echo json_encode($response);

function insertIntoDocumenti($aziendaID, $strutturaID, $name, $path, $currentDateAndTime){
    include 'database/config.php';
    include 'database/opendb.php';

    $insertQuery = "INSERT INTO DOCUMENTI (AZIENDA_ID, STRUTTURA_ID, NOME, PERCORSO, DATA_CARICAMENTO, E_ATTIVO) VALUES (?, ?, ?, ?, 1)";
    if ($stmt = mysqli_prepare($conn, $insertQuery)) {
        mysqli_stmt_bind_param($stmt, "iisss", $aziendaID, $strutturaID, $name, $path, $currentDateAndTime);
        mysqli_stmt_execute($stmt);
        $documentoID = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);
        include 'database/closedb.php';
        return $documentoID;
    } else {
        include 'database/closedb.php';
        return false;
    }
}

function insertIntoLogs($userId, $entity, $entityId, $actionDate) {
    include 'database/config.php';
    include 'database/opendb.php';

    $logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, ?, ?, 'Inserimento', ?)";
    if ($stmtLog = mysqli_prepare($conn, $logSql)) {
        mysqli_stmt_bind_param($stmtLog, "isis", $userId, $entity, $entityId, $actionDate);
        mysqli_stmt_execute($stmtLog);
        mysqli_stmt_close($stmtLog);
        include 'database/closedb.php';
        return true;
    } else {
        include 'database/closedb.php';
        return false;
    }
}
