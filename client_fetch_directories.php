<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

if (isset($_GET['path'])) {
    $currentPath = $_GET['path'];
    echo listDirectory($conn, $currentPath);
}

function listDirectory($conn, $path)
{
    $files = scandir($path);
    $output = '';
    $disabled = '';
    $previousPath = '';

    $lastSlashPos = strrpos($path, '/');

    if ($lastSlashPos !== false) {
        $previousPath = substr($path, 0, $lastSlashPos);
        $disabled = '';
    } else {
        $disabled = 'disabled';
    }

    $output .= '<div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-around align-items-center">
    			    <button class="folder btn btn-light btn-lg mb-2 mb-lg-0" ' . $disabled . ' data-path= "' . $previousPath . '"><img src="images/previous_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Cartella Precedence</button>
       			    <h2 class="folder btn-lg mb-2 mb-lg-0" style = "text-align:center;"> <b>Percorso Attuale:</b> ' . $path . ' </h2>
    			    <button class="folder btn btn-light btn-lg" ' . $disabled . ' data-path="pas"><img src="images/root_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Cartella Principale</button>
			    </div>
                
                <div class="card-body">
			    <br>
			    <br>
                ';
	
  	$companyIDs = $_SESSION['company_ID'];
   	$clientCompanies = getTrimmedCompanyNames($conn, $companyIDs);
  
    foreach ($files as $file) {
        if ($file == '.' || $file == '..')
            continue;
        $fullPath = $path . '/' . $file;
        $fullPath2 = realpath($path . '/' . $file);
        $isDir = is_dir($fullPath2);

        if ($path == 'pas' && (!in_array(trim($file), $clientCompanies) || !$isDir)) {
            continue;
        }

        $icon = "images/file.png";

        if ($isDir) {
            $icon = "images/folder.png";
        } elseif (endsWith($file, '.pdf')) {
            $icon = "images/pdf.png";
        } elseif (endsWith($file, '.mp4')) {
            $icon = "images/mp4.png";
        }

        if ($isDir) {
            $output .= "<div class='d-flex justify-content'><button class='folder btn btn-light' href='#' data-path='" . $fullPath . "'><img src='$icon' alt='folder btn btn-light icon'>&nbsp;&nbsp;&nbsp;$file</button></div><br><br>";
        } else {
            $output .= "<div class='d-flex justify-content-between align-items-center'>
                <a class='file btn btn-light' target='_blank' href='" . htmlspecialchars($fullPath) . "'>
                    <img src='$icon' alt='file icon'>&nbsp;&nbsp;&nbsp;$file
                </a>
            </div><br><br>";;
        }
    }

    $output .= '</div>';
    echo $output;

}

function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function getTrimmedCompanyNames($conn, $companyIDs) {
    if (!is_array($companyIDs) || empty($companyIDs)) {
        return [];
    }

 	$companies = [];
    $sanitizedIDs = array_map('intval', $companyIDs);
    $idList = implode(',', $sanitizedIDs);

    $query = "SELECT CONCAT(TRIM(AZIENDA_NOME),' - ', TRIM(PARTITA_IVA)) AS AZIENDA_FOLDER FROM AZIENDE WHERE AZIENDA_ID IN ($idList)";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           $companies[] = $row['AZIENDA_FOLDER'];
        }
    }
  
    $conn->close();
	
    return $companies;
}


include 'database/closedb.php';