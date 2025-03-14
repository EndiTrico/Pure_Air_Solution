<?php
    function uploadToWebDAV($webdavUrl, $fileTmpPath) {
        include 'nas/credentials.php';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $webdavUrl);
        curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
        curl_setopt($ch, CURLOPT_PUT, true);
        
        // TEMPORARY
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $fh = fopen($fileTmpPath, 'r');
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, filesize($fileTmpPath));

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        fclose($fh);
        curl_close($ch);

        if ($httpCode == 201 || $httpCode == 204) {
            return true;
        } else {
            error_log("WebDAV upload failed. HTTP Code: " . $httpCode);
            return false;
        }
    }

  function deleteImage($filePath) {
      include 'credentials.php';

      $encodedFileName = rawurlencode(basename($filePath));
      $fileUrl = $baseUrl . '/' . rawurlencode(dirname($filePath)) . '/' . $encodedFileName;

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, $filePath);
      curl_setopt($ch, CURLOPT_USERPWD, "$username:$password");
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);
      $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
      $curlError = curl_error($ch);
      curl_close($ch);

      error_log("HTTP Code: $httpCode");
      error_log("Response: $response");
      error_log("cURL Error: $curlError");

      if ($httpCode != 204 && $httpCode != 200) {
          throw new Exception("Impossibile eliminare il file. URL: $filePath. Codice HTTP: $httpCode");
      }
  }