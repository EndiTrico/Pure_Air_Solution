<?php
include 'database/config.php';
include 'database/opendb.php';
session_start();

if (isset($_GET['path'])) {
    $currentPath = $_GET['path'];
    echo listDirectory($currentPath);
}

function listDirectory($path)
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
			<br>
			<br>
            <div class="col-12 d-flex flex-column flex-lg-row justify-content-lg-around align-items-center">
                <button class="btn btn-warning btn-lg mb-2 mb-lg-0" onclick="confirmUploadFile(\'' . addslashes($path) . '\')"><img src="images/add_file.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Carica un Documento</button>
                <button class="btn btn-success btn-lg mb-2 mb-lg-0" onclick="confirmNewFolder(\'' . addslashes($path) . '\')"><img src="images/add_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Nuova Cartella</button>
                <button class="btn btn-danger btn-lg mb-2 mb-lg-0"' . $disabled . '  onclick="confirmDeleteFolder(\'' . addslashes($path) . '\')"><img src="images/delete_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Rimuovere la Cartella</button>
    			<button class="btn btn-info btn-lg" ' . $disabled . ' onclick="confirmRenameFolder(\'' . addslashes($path) . '\')"><img src="images/rename_folder.png" alt="folder btn btn-info">&nbsp;&nbsp;&nbsp;Rinomina la Cartella</button>
			</div>
       <div class="card-body">
       <br><br>
';


    foreach ($files as $file) {
        if ($file == '.' || $file == '..')
            continue;
        $fullPath = $path . '/' . $file;
        $fullPath2 = realpath($path . '/' . $file);
        $isDir = is_dir($fullPath2);

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
                <button type='button' class='btn btn-danger' onclick='confirmDeleteFile(\"" . addslashes($fullPath) . "\", \"" .  addslashes($file) . "\");'> <img src='images/delete_file.png' alt='delete icon'>&nbsp;&nbsp;&nbsp;Elimina il Documento</button>
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

include 'database/closedb.php';