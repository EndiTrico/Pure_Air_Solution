<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'nas/credentials.php';

if (!isset($_GET['path'])) {
    die("No file or folder specified.");
}

$path = $_GET['path'];
$name = $_GET['directory'];
$full_url = $path;

$logFile = 'downloads.log';
file_put_contents($logFile, date("Y-m-d H:i:s") . " - Download request: " . $full_url . PHP_EOL, FILE_APPEND);


// Get file/folder information
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $full_url);
curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
curl_setopt($ch, CURLOPT_NOBODY, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PROPFIND"); // Get metadata
$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http_code == 404) {
    die("File or folder not found.");
}

// If it's a file, download it directly
if ($name != 'directory') {
  file_put_contents($logFile, date("Y-m-d H:i:s") . " FILE " . PHP_EOL, FILE_APPEND);

    downloadFile($full_url, $username, $password);
} else {
    file_put_contents($logFile, date("Y-m-d H:i:s") . " FOLDER " . PHP_EOL, FILE_APPEND);

    createZipFromWebDAV($full_url, $username, $password);
}

/**
 * Download a file from WebDAV
 */
function downloadFile($file_url, $username, $password) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $file_url);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code != 200) {
        die("Failed to download file.");
    }

    // Extract filename from path
    $filename = basename(parse_url($file_url, PHP_URL_PATH));

    // Set headers for download
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"$filename\"");
    header("Content-Length: " . strlen($data));

    echo $data;
    exit;
}

function fetchWebDAVFiles($folder_url, $username, $password) {
    // Ensure the folder URL ends with a slash
    if (substr($folder_url, -1) !== '/') {
        $folder_url .= '/';
    }

    // Try `PROPFIND` request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $folder_url);
    curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PROPFIND");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Depth: 1"]);
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code === 207 && strpos($response, "<?xml") !== false) {
        // ✅ If XML is returned, parse it
        $xml = simplexml_load_string($response);
        if (!$xml) {
            die("Invalid XML response from WebDAV server.");
        }

        $xml->registerXPathNamespace('d', 'DAV:');
        $files = $xml->xpath('//d:response');
    } else {
        // 🔹 `PROPFIND` failed, fallback to HTML parsing
        error_log("PROPFIND failed (HTTP $http_code). Switching to HTML parsing...");

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $folder_url);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        $response = curl_exec($ch);
        curl_close($ch);

        if (!$response) {
            die("Failed to fetch folder contents. WebDAV might be blocking listing.");
        }

        // Extract file links from HTML response
        preg_match_all('/href=["\'](.*?)["\']/i', $response, $matches);
        if (empty($matches[1])) {
            die("No files found in WebDAV folder.");
        }

        $files = [];
        foreach ($matches[1] as $file) {
            $files[] = $folder_url . basename(urldecode($file));
        }
    }

    return $files;
}

// 🔹 Recursive function to handle subfolders
function downloadWebDAVFolder($folder_url, $username, $password, $zip, $base_folder = '') {
    $files = fetchWebDAVFiles($folder_url, $username, $password);

    foreach ($files as $file_url) {
        if (substr($file_url, -1) === '/') {
            // 🔹 If it's a subfolder, recurse into it
            downloadWebDAVFolder($file_url, $username, $password, $zip, $base_folder . basename($file_url) . '/');
        } else {
            // 🔹 If it's a file, download and add it to ZIP
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $file_url);
            curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $file_data = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($file_data === false || $http_code !== 200) {
                error_log("Skipping file: $file_url (HTTP Code: $http_code)");
                continue;
            }

            // 🏗️ Preserve folder structure inside ZIP
            $zip_path = $base_folder . basename($file_url);
            $zip->addFromString($zip_path, $file_data);
        }
    }
}

// 🔥 Main function to initialize ZIP and trigger folder download
function createZipFromWebDAV($folder_url, $username, $password) {
    $local_zip = tempnam(sys_get_temp_dir(), "webdav") . ".zip";
    $zip = new ZipArchive();

    if ($zip->open($local_zip, ZipArchive::CREATE) !== TRUE) {
        die("Could not create ZIP file.");
    }

    // 🔹 Start recursive download
    downloadWebDAVFolder($folder_url, $username, $password, $zip);

    // 🚨 Ensure ZIP is not empty
    if ($zip->numFiles === 0) {
        $zip->close();
        unlink($local_zip);
        die("No valid files were downloaded.");
    }

    $zip->close();

    // 📦 Send ZIP file to user
    ob_end_clean();
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=\"download.zip\"");
    header("Content-Length: " . filesize($local_zip));
    flush();

    readfile($local_zip);
    unlink($local_zip);
    exit;
}



?>
