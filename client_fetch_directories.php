<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

if (isset($_GET['path'])) {
    $currentPath = $_GET['path'];
    echo listDirectory($currentPath);
}

function generateBreadcrumb($path) {
    $parts = explode("/", trim($path, "/"));
    $breadcrumb = [];
    $fullPath = "";

    foreach ($parts as $index => $part) {
        $fullPath .= "/" . $part;
        $encodedPath = htmlspecialchars($fullPath, ENT_QUOTES, 'UTF-8');

      	$breadcrumb[] = '<button class="folder btn btn-light px-1 py-0 m-0" data-path="' . $encodedPath . '">' . rawurldecode($part) . '</button>';
    }

    return implode(" / ", $breadcrumb);
}

function listDirectory($path)
{
 	include 'nas/credentials.php';
    
  	$originalPath = rawurldecode($path);
    $url = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PROPFIND"); // WebDAV PROPFIND request
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Depth: 1", // Get only the current folder's contents
    ]);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    // Parse the XML response
    $xml = simplexml_load_string($response);
    $namespaces = $xml->getNamespaces(true);
    $files = [];
    foreach ($xml->children($namespaces['D']) as $response) {
        $href = (string)$response->href;
        $type = isset($response->propstat->prop->resourcetype->collection) ? 'directory' : 'file';

        if (trim(urldecode($href), '/') === trim($originalPath, '/') || basename(urldecode($href)) === '@Recycle') {
            continue;
        }

        $files[] = [
            'name' => basename(urldecode($href)),
            'type' => $type,
            'href' => urldecode($href),
        ];
    }

    // Determine the previous path
    $output = '';
    $disabled = '';
    $previousPath = '';
  	$encodedPreviousPath = '';
	$encodedRootPath = htmlspecialchars('clienti', ENT_QUOTES, 'UTF-8');
    $lastSlashPos = strrpos($path, '/');

    if ($lastSlashPos !== false) {
        $previousPath = substr($path, 0, $lastSlashPos);
      	$encodedPreviousPath = htmlspecialchars($previousPath, ENT_QUOTES, 'UTF-8');
        $disabled = '';
    } else {
        $disabled = 'disabled';
    }

  	$breadcrumb = generateBreadcrumb($path);

    $output .= '<div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-around align-items-center">
    			    <button class="folder btn btn-light btn-lg mb-2 mb-lg-0" ' . $disabled . ' data-path= "' . $encodedPreviousPath . '"><img src="images/previous_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Cartella Precedente</button>
    				<h2 class="folder btn-lg mb-2 mb-lg-0" style="text-align:center;"><b>Percorso Attuale:</b> ' . $breadcrumb . '</h2>    			    
                    <button class="folder btn btn-light btn-lg" ' . $disabled . ' data-path="' . $encodedRootPath . '"><img src="images/root_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Cartella Principale</button>
			    </div>
                <div class="card-body">
			    <br><br>';
	
  	$companyIDs = $_SESSION['company_ID'];
   	$clientCompanies = getTrimmedCompanyNames($companyIDs);

  	foreach ($files as $file) {
        if ($file['name'] === '.' || $file['name'] === '..' 
            || (!in_array(trim($file['name']), $clientCompanies) && str_replace("/", "", $path) === $rootPath)) {
            continue;
        }

        if ($file['type'] === 'directory') {
            $icon = "images/folder.png";
       } elseif (endsWith($file['name'], '.pdf')) {
            $icon = "images/pdf.png";
        } elseif (endsWith($file['name'], '.mp4')) {
            $icon = "images/mp4.png";
        } else {
            $icon = "images/file.png";        
        }
      
        $fullPath = $path . '/' . rawurlencode($file['name']);
        $fullPath2 = $url . '/' .  rawurlencode($file['name']);      
        if ($file['type'] === 'directory') {
            $output .= "<div class='d-flex justify-content'><button class='folder btn btn-light' href='#' data-path='" . $fullPath . "'><img src='$icon' alt='folder btn btn-light icon'>&nbsp;&nbsp;&nbsp;" . htmlspecialchars($file['name']) . "</button></div><br><br>";
        } else {          
			$output .= "<div class='d-flex justify-content-between align-items-center'>
    						<a class='file btn btn-light me-auto' target='_blank' href='" . htmlspecialchars($fullPath2) . "'>
        						<img src='" . htmlspecialchars($icon) . "' alt='file icon'>&nbsp;&nbsp;&nbsp;" . htmlspecialchars($file['name']) . "
    						</a>
    						<div class='d-flex'>
								<a href='download.php?path=" . urlencode($fullPath2) . "&directory=no' class='btn btn-light me-2'>
    								<img src='images/download.png' alt='download icon'>&nbsp;&nbsp;&nbsp;Scarica
								</a>
    						</div>
						</div>
                        <br>";          
        }
   
    }
            
    $output .= '</div>';

    return $output;
}


function endsWith($string, $endString)
{
    $len = strlen($endString);
    if ($len == 0) {
        return true;
    }
    return (substr($string, -$len) === $endString);
}

function getTrimmedCompanyNames($companyIDs) {
  	include 'database/config.php';
  	include 'database/opendb.php';
  
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
  
	  include 'database/closedb.php';

    return $companies;
}


include 'database/closedb.php';