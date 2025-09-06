<?php
include '../auth_check.php';

include '../database/config.php';
include '../database/opendb.php';
  
$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_job'])) {

        $job_construction = mysqli_real_escape_string($conn, $_POST['job_construction']);
        $job_data = empty(mysqli_real_escape_string($conn, $_POST['job_data'])) ? null : mysqli_real_escape_string($conn, $_POST['job_data']);
        $job_information = mysqli_real_escape_string($conn, $_POST['job_information']);

        $sql = "INSERT INTO REGISTRO_LAVORI (CANTIERE, DATA_LAVORO, INFORMAZIONI, UTENTE_ID) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $job_construction, $job_data, $job_information, $_SESSION["user_id"]);

        try {
            if (mysqli_stmt_execute($stmt)) {
                $registro_lavoro_id = mysqli_insert_id($conn);
                date_default_timezone_set('Europe/Berlin');
                $currentDateAndTime = date('Y-m-d H:i:s');

                $successfulMessage = "Creato con Successo il Record";

                $sql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, 'REGISTRO_LAVORI', ?, 'Creare', ?)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "iis", $_SESSION["user_id"], $registro_lavoro_id, $currentDateAndTime);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = "Errore: Impossibile Creare il Record";
            }
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
    }
}

include '../database/closedb.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Registra Attività</title>

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
        <?php include "employee_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "employee_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row justify-content-center">
                        <div class="col">
                            <h1 class="h3 mb-3">Registra Attività</h1>
                        </div>

                        <div class="col-12">
                            <div class="card"
                                style="background:url('./images/logo/logo01_backgroundForm.png'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
                                <div class="card-body">
                                    <form id="userForm" method="post">
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
                                                <h5 class="card-title col-sm-2 col-form-label">Cantiere
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Cantiere"
                                                        name="job_construction" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Data del Lavoro
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="job_data" placeholder='Data del Lavoro'
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Informazioni</h5>
                                                <div class="col-sm-4">
                                                    <textarea class="form-control" name="job_information" rows="5"
                                                        placeholder="Informazioni"></textarea>
                                                </div>
                                            </div>
                                            
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <button type="submit" name="create_job"
                                                    class="btn btn-success btn-lg">Crea un
                                                    Utente</button>
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