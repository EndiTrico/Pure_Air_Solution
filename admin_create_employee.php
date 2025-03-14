<?php
    include 'auth_check.php';
    include 'database/config.php';
    include 'database/opendb.php';
    include 'nas/credentials.php';
	include 'nas/nas_functions.php';

    $errorMessage = "";
    $successfulMessage = "";
  
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['create_employee'])) {
            $employee_first_name = mysqli_real_escape_string($conn, $_POST['employee_first_name']);
            $employee_last_name = mysqli_real_escape_string($conn, $_POST['employee_last_name']);
            $employee_email = mysqli_real_escape_string($conn, $_POST['employee_email']);
            //$employee_photo = mysqli_real_escape_string($conn, $_POST['employee_photo']);
            $employee_birthday = empty(mysqli_real_escape_string($conn, $_POST['employee_birthday'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_birthday']);
            $employee_code = mysqli_real_escape_string($conn, $_POST['employee_code']);
            $employee_indirizzo = mysqli_real_escape_string($conn, $_POST['employee_indirizzo']);
            $employee_role = mysqli_real_escape_string($conn, $_POST['employee_role']);
            $employee_company = mysqli_real_escape_string($conn, $_POST['employee_company']);
            $employee_iva = mysqli_real_escape_string($conn, $_POST['employee_iva']);
            $employee_telephone = mysqli_real_escape_string($conn, $_POST['employee_telephone']);
            $employee_number = mysqli_real_escape_string($conn, $_POST['employee_number']);
            $employee_qualification = mysqli_real_escape_string($conn, $_POST['employee_qualification']);
            $employee_position = mysqli_real_escape_string($conn, $_POST['employee_position']);
            $employee_contract = mysqli_real_escape_string($conn, $_POST['employee_contract']);
           // $employee_inizio_date = empty(mysqli_real_escape_string($conn, $_POST['employee_inizio_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_inizio_date']);
           $employee_inizio_date = mysqli_real_escape_string($conn, $_POST['employee_inizio_date']);
 $employee_left_date = empty(mysqli_real_escape_string($conn, $_POST['employee_left_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_left_date']);
            $employee_medical_date = empty(mysqli_real_escape_string($conn, $_POST['employee_medical_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_medical_date']);
            $employee_cosegna_date = empty(mysqli_real_escape_string($conn, $_POST['employee_cosegna_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_cosegna_date']);
            $employee_specifica_date = empty(mysqli_real_escape_string($conn, $_POST['employee_specifica_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_specifica_date']);
            $employee_base_date = empty(mysqli_real_escape_string($conn, $_POST['employee_base_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_base_date']);
            $employee_cat3_date = empty(mysqli_real_escape_string($conn, $_POST['employee_cat3_date'])) ? null : mysqli_real_escape_string($conn, $_POST['employee_cat3_date']);

        	$isUploadedToWebsite = FALSE;
        	$isUploadedToNAS = FALSE;           	
          	$targetDirectory = $baseUrl . "/" . $imageRootPath;
            $uploadedFile = '';
            
          	$fileName = '';
            $fileExt = '';

            $newFileName = '';
            $targetFilePath = '';
            $allowedTypes = ["jpg", "jpeg", "png", "gif"];
            
          	if(isset($_FILES["employee_photo"]) && $_FILES["employee_photo"]["error"] === UPLOAD_ERR_OK) {
          		$isUploadedToWebsite = TRUE;
            	$uploadedFile = $_FILES["employee_photo"];
            	$fileTmp = $uploadedFile["tmp_name"];
            	$fileName = pathinfo($uploadedFile["name"], PATHINFO_FILENAME);
            	$fileExt = strtolower(pathinfo($uploadedFile["name"], PATHINFO_EXTENSION));
    
            	$allowedTypes = ["jpg", "jpeg", "png", "gif"];
            	if(in_array($fileExt, $allowedTypes)) {
                	$newFileName = $fileName . "___" . uniqid() . "." . $fileExt;
                	$targetFilePath = $targetDirectory . "/" . $newFileName;
            	} else {
              		$errorMessage = "Errore: Formato file non valido. Solo JPG, PNG e GIF sono consentiti.";
            	}
        	}  
           
            $queryCheck = "SELECT EMAIL, CODICE_FISCALE, MATRICOLA
                            FROM DIPENDENTI 
                            WHERE EMAIL = ? OR CODICE_FISCALE = ? OR MATRICOLA = ?
                            LIMIT 1";

            $stmt = mysqli_prepare($conn, $queryCheck);
            mysqli_stmt_bind_param($stmt, "ssi", $employee_email, $employee_code, $employee_number);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                mysqli_stmt_bind_result($stmt, $found_email, $found_code, $found_id);
                mysqli_stmt_fetch($stmt);
                
                $matchedColumns = [];
                
                if (isset($found_email) && $found_email === $employee_email) { $matchedColumns[] = "\nEMAIL: " . $found_email; }
                if (isset($found_code) && $found_code === $employee_code) { $matchedColumns[] = "\nCODICE_FISCALE: " . $found_code; }
                if (isset($found_id) && $found_id === $employee_number) { $matchedColumns[] = "MATRICOLA: " . $found_id; }
                
                $errorMessage = "Errore: C'è un Dipendente. Colonne trovate:<br>" . implode("<br>", $matchedColumns);
            } else if ($isUploadedToWebsite && !in_array(strtolower($fileExt), $allowedTypes)) {
                $errorMessage = "Errore: Formato file non valido. Solo JPG, PNG e GIF sono consentiti.";
            } else {
                $is_active = empty($employee_left_date) ? 1 : 0;
                
                if (!$isUploadedToWebsite){
                    $newFileName = NULL;            
                } else {
                    if(!uploadToWebDAV($targetFilePath, $uploadedFile["tmp_name"])){
                      	$isUploadedToNAS = FALSE;
                        $newFileName = NULL;
                        $errorMessage .= "Errore: Impossibile caricare l'immagine.";
                    } else {
                     	$isUploadedToNAS = TRUE;
                    }
                }

                $sql = "INSERT INTO DIPENDENTI (NOME, COGNOME, EMAIL, FOTOGRAFIA, DATA_DI_NASCITA, CODICE_FISCALE, INDIRIZZO, RUOLO, RAGIONE_SOCIALE, PIVA, TELEFONO, MATRICOLA, QUALIFICA, MANSIONE, CONTRATTO, ASSUNTO_IL, DATA_FINE, VISITA_MEDICA_IDONEITA, RICEVUTA_CONSEGNA_DPI, ATTESTATO_FORMAZIONE_SPECIFICA, CORSO_FORMAZIONE_INFORMAZIONE_BASE, CORSO_UTILIZZO_DPI_CAT3, E_ATTIVO) 
                            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssssssssssissssssssssi", $employee_first_name, $employee_last_name, $employee_email, $newFileName, $employee_birthday, $employee_code, $employee_indirizzo, $employee_role, $employee_company, $employee_iva, $employee_telephone, $employee_number, $employee_qualification, $employee_position, $employee_contract, $employee_inizio_date, $employee_left_date, $employee_medical_date, $employee_cosegna_date, $employee_specifica_date, $employee_base_date, $employee_cat3_date, $is_active);
            
                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $sql = "SELECT DIPENDENTE_ID
                                FROM DIPENDENTI
                                WHERE EMAIL = ? OR CODICE_FISCALE = ? OR MATRICOLA = ?
                                LIMIT 1";

                        $stmt1 = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt1, "ssi", $employee_email, $employee_code, $employee_number);
                        mysqli_stmt_execute($stmt1);
                        mysqli_stmt_store_result($stmt1);

                        mysqli_stmt_bind_result($stmt1, $employee_id);
                        mysqli_stmt_fetch($stmt1);

                        date_default_timezone_set('Europe/Berlin');
                        $currentDateAndTime = date('Y-m-d H:i:s');

                        $successfulMessage = "Dipendente Creato con Successo";

                        $sql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, 'DIPENDENTI', ?, 'Creare', ?)";

                        $stmt = mysqli_prepare($conn, $sql);
                        mysqli_stmt_bind_param($stmt, "iis", $_SESSION["user_id"], $employee_id, $currentDateAndTime);
                        mysqli_stmt_execute($stmt);
                        mysqli_stmt_close($stmt);      
                    } else {
                      	if($isUploadedToNAS) {
                     		deleteImage($targetFilePath);
                        }
                        $errorMessage .= "Errore: Impossibile Creare il Dipendente";
                    }
                } catch (Exception $e) {
                    $errorMessage .= $e->getMessage();
                }
            }
        }
    }

    include 'database/closedb.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Crea un Dipendente</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet"> <!--for live demo page -->

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    <!-- FlatPickr  - Input Date -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .alert {
            margin-left: 20px
        }

        .passwordCheck {
            margin-right: 10px;
        }

      .fa {
            font-size: 1rem;
            margin-left: 1px;
            border-color: lightgray;
        }

        #btnToggle {
            border-color: darkgray;
            background-color: white;
        }

        .select2-container .select2-search--inline .select2-search__field {
            margin-left: -6px !important;
            padding-left: 14px !important;
        }

        .select2-selection__rendered {
            padding-top: 5px !important;
        }

        .form-select {
            color: #6d6f72 !important;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <a class="btn transparent-btn" style="margin-top: -7px;" href="admin_create.php">
                                <img alt="Back" src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col">
                            <h1 class="h3 mb-3">Crea un Dipendente</h1>
                        </div>

                        <div class="col-12">
                            <div class="card"
                                style="background:url('./images/logo/logo01_backgroundForm.png'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
                                <div class="card-body">
								 	<form id="employeeForm" method="post" enctype="multipart/form-data">
                                        <div class="row">
                                            <?php
                                            if (!empty($errorMessage)) {
                                                echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div style="height: auto; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert"><h4 style = "padding-top:5px; color: #cc0000; font-weight:bold;">' . $errorMessage . '</h4>
                                                                    </div> 
                                                                </div>                                                    
                                                            </div>
                                                        </div>';
                                            } else if (!empty($successfulMessage)) {
                                                echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <div style="height: auto; font-size:20px; text-align:center; background-color: #ccffcc; color: #006600;" class="alert alert-success" role="alert"><h4 style = "padding-top:5px; color: #006600; font-weight:bold;">' . $successfulMessage . '</h4>
                                                                    </div> 
                                                                </div>                                                    
                                                            </div>
                                                        </div>';
                                            }
                                            ?>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Nome<span
                                                        style="color:red;">*</span></h5>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="employee_first_name"
                                                        placeholder="Nome" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Cognome<span
                                                        style="color:red;">*</span></h5>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="employee_last_name"
                                                        placeholder="Cognome" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">E-mail<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="email" placeholder="Email" name="employee_email" value=""
                                                        class="form-control" required />
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3 row d-flex justify-content-center align-items-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Fotografia</h5>
                                                <div class="col-sm-4 d-flex align-items-center">
                                              		<label for="employee_photo" class="btn btn-info text-center" style="width: 20%;">Sfoglia</label>
                                                  	<input type="file" id="employee_photo" name="employee_photo" class="d-none" accept="image/*">
                                                  	<input type="text" id="file-name" class="form-control me-2" placeholder="Nessun file selezionato" readonly style="width: 80%;">
                                                  	<button type="button" id="clear-file" class="btn btn-danger" style="width: 25%;">Cancella</button>
                                                 </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Data di
                                                    Nascita
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_birthday" placeholder="Data di Nascita"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Codice Fiscale<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Codice Fiscale"
                                                        name="employee_code" class="form-control" value="" required />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Indirizzo"
                                                        name="employee_indirizzo" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Ruolo
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Ruolo"
                                                        name="employee_role" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Ragiola Sociale
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Ragiola Sociale"
                                                        name="employee_company" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">P. IVA
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="P. IVA"
                                                        name="employee_iva" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Telefono
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Telefono" name="employee_telephone"
                                                        class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Matricola<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="number" placeholder="Matricola" name="employee_number"
                                                        class="form-control" value="" required />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Qualifica
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Qualifica" name="employee_qualification"
                                                        class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Mansione
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Mansione" name="employee_position"
                                                        class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Contratto
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Contratto" name="employee_contract"
                                                        class="form-control" value="" />
                                                </div>
                                            </div>
  
                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Assunto Il<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="datePicker"
                                                        name="employee_inizio_date" placeholder="Assunto Il"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white"
                                                           required \>
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Data di
                                                    Fine
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_left_date" placeholder="Data di Fine"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Visita Medica Idoneita
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_medical_date" placeholder="Visita Medica Idoneita"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Ricevuta Cosegna DPI
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_cosegna_date" placeholder="Ricevuta Cosegna DPI"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Attestato Formazione Specifica
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_specifica_date" placeholder="Attestato Formazione Specifica"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Corso Formazione Informazione Base
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_base_date" placeholder="Corso Formazione Informazione Base"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Corso Utilizzo DPI Cat3
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="employee_cat3_date" placeholder="Corso Utilizzo DPI Cat3"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <button type="submit" name="create_employee"
                                                    class="btn btn-success btn-lg">Crea un Dipendente</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
                    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
                    crossorigin="anonymous"></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


                <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
                <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/it.js"></script>

                <script>

                    const flatpickrInstance = flatpickr("#datePicker", {
                        locale: 'it',
                        dateFormat: "Y-m-d",
                    });
                    
                    document.getElementById("employee_photo").addEventListener("change", function() {
                        let fileName = this.files.length > 0 ? this.files[0].name : "Nessun file selezionato";
                        document.getElementById("file-name").value = fileName;
                    });

                    document.getElementById('clear-file').addEventListener('click', function() {
        				document.getElementById('employee_photo').value = ''; // Reset file input
        				document.getElementById('file-name').value = 'Nessun file selezionato'; // Reset text input
    				});
                </script>

            </main>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>