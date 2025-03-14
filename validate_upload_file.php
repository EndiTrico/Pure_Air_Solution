<?php
session_start();
include 'nas/credentials.php';

$defaultUploadDir = $nas_url . '/pas';

$uploadDir = isset($_POST['uploadPath']) ? $_POST['uploadPath'] : $defaultUploadDir;
$strutturaID = $_POST['strutturaID'];
$aziendaID = $_POST['aziendaID'];

date_default_timezone_set('Europe/Berlin');
$currentDateAndTime = date('Y-m-d H:i:s');

$response = [];

if (!empty($_FILES['filesToUpload']['name'][0])) {
    foreach ($_FILES['filesToUpload']['name'] as $key => $name) {
        $encodedName = rawurlencode(pathinfo($name, PATHINFO_FILENAME)) . '.' . pathinfo($name, PATHINFO_EXTENSION);
        $path = $uploadDir . '/' . $encodedName;
        $fileType = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        $fileTempPath = $_FILES['filesToUpload']['tmp_name'][$key];

        if (!file_exists($fileTempPath)) {
            $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'Temporary file does not exist.'];
            continue;
        }

        if (fileExistsOnNAS($path, $username, $password)) {
            $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'Il documento esiste già.'];
            continue;
        }

        if (uploadFileToNAS($path, $fileTempPath, $username, $password)) {
            $documentoID = insertIntoDocumenti($aziendaID, $strutturaID, $name, $path, $currentDateAndTime);
            insertIntoLogs($_SESSION['user_id'], $documentoID, $currentDateAndTime);
          	$response[] = ['name' => $name, 'status' => 'success', 'message' => 'Il file è stato caricato con successo.'];
        } else {
            $response[] = ['name' => $name, 'status' => 'failed', 'message' => 'Impossibile caricare il file su NAS.'];
        }
    }
} else {
    $response[] = ['status' => 'failed', 'message' => 'Nessun file è stato caricato.'];
}

// Return JSON response
header('Content-Type: application/json');
ob_end_clean();
$jsonOutput = json_encode($response);
if ($jsonOutput === false) {
    error_log('JSON Encoding Error: ' . json_last_error_msg());
    echo json_encode(['status' => 'failed', 'message' => 'Internal JSON error.']);
    exit;
}
echo $jsonOutput;
exit;

function fileExistsOnNAS($filePath, $username, $password) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $filePath);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_NOBODY, true); // Only check existence
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "HEAD");

    curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    return $httpCode === 200; // File exists if HTTP status is 200
}

function uploadFileToNAS($filePath, $localFilePath, $username, $password) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $filePath);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_PUT, true);
    curl_setopt($ch, CURLOPT_INFILE, fopen($localFilePath, 'r'));
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($localFilePath));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);

    if ($httpCode === 201 || $httpCode === 204 || $httpCode === 207 || $httpCode === 200) { // File uploaded successfully
        return true;
    }

    error_log("Upload failed: HTTP Code: $httpCode, Error: $error, Response: $response");
    return false;
}

function insertIntoDocumenti($aziendaID, $strutturaID, $name, $path, $currentDateAndTime) {
    include 'database/config.php';
    include 'database/opendb.php';

    ob_start();
    
    $documentoID = false;

    try {
        $insertQuery = "INSERT INTO DOCUMENTI (AZIENDA_ID, STRUTTURA_ID, NOME, PERCORSO, DATA_CARICAMENTO, E_ATTIVO) VALUES (?, ?, ?, ?, ?, 1)";

        if ($stmt = mysqli_prepare($conn, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, "iisss", $aziendaID, $strutturaID, $name, $path, $currentDateAndTime);

            if (mysqli_stmt_execute($stmt)) {
        		$documentoID = mysqli_insert_id($conn);
            } else {
                error_log("Execute failed: (" . mysqli_stmt_errno($stmt) . ") " . mysqli_stmt_error($stmt));
            }

            mysqli_stmt_close($stmt);
        } else {
            error_log("Prepare failed: (" . mysqli_errno($conn) . ") " . mysqli_error($conn));
        }
    } catch (Exception $e) {
        error_log("Exception caught in insertIntoDocumenti: " . $e->getMessage());
    }

    include 'database/closedb.php';

    $output = ob_get_clean();

    if ($output) {
        error_log("Unexpected output in insertIntoDocumenti: " . $output);
    }

    return $documentoID ;
}

function insertIntoLogs($userId, $entityId, $actionDate) {
    include 'database/config.php';
    include 'database/opendb.php';
    $logSql =  "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) 
    					VALUES (?, 'DOCUMENTI', ?, 'Creare', ?)";
    if ($stmtLog = mysqli_prepare($conn, $logSql)) {
        mysqli_stmt_bind_param($stmtLog, "iis", $userId, $entityId, $actionDate);
        mysqli_stmt_execute($stmtLog);
        mysqli_stmt_close($stmtLog);
        include 'database/closedb.php';
        return true;
    } else {
        include 'database/closedb.php';
        return false;
    }
}


?>
