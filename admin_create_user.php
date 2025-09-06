<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';
include 'fetch_companies.php';


  
$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_user'])) {
        $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
        $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_role = mysqli_real_escape_string($conn, $_POST['user_role']);
        $user_position = mysqli_real_escape_string($conn, $_POST['user_position']);
        $user_numero = mysqli_real_escape_string($conn, $_POST['user_number']);
        $user_joined_date = empty(mysqli_real_escape_string($conn, $_POST['user_joined_date'])) ? null : mysqli_real_escape_string($conn, $_POST['user_joined_date']);
        $user_left_date = mysqli_real_escape_string($conn, $_POST['user_left_date']);
        $user_companies = [];
        
        if ($user_role !== "Dipendente" && !empty($_POST['user_companies'])) {
            $user_companies = $_POST['user_companies'];
        } else {
            $user_companies = [];
        }

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $queryCheck = "SELECT UTENTE_ID 
                        FROM UTENTI 
                        WHERE EMAIL = ? 
                        LIMIT 1";

        $stmt = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmt, "s", $user_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            $errorMessage = "Errore: C'è un Utente con Quell'E-mail";
        } else {

            if (empty($user_left_date)) {
                $sql = "INSERT INTO UTENTI (NOME, COGNOME, EMAIL, PASSWORD, NUMERO, RUOLO, AZIENDA_POSIZIONE, DATA_INIZIO, E_ATTIVO) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssisss", $user_first_name, $user_last_name, $user_email, $hashed_password, $user_numero, $user_role, $user_position, $user_joined_date);
            } else {
                $sql = "INSERT INTO UTENTI (NOME, COGNOME, EMAIL, PASSWORD, NUMERO, RUOLO, AZIENDA_POSIZIONE, DATA_INIZIO, DATA_FINE, E_ATTIVO) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "ssssissss", $user_first_name, $user_last_name, $user_email, $hashed_password, $user_numero, $user_role, $user_position, $user_joined_date, $user_left_date);
            }


            try {
                if (mysqli_stmt_execute($stmt)) {
                    $sql = "SELECT UTENTE_ID
                                FROM UTENTI
                                WHERE EMAIL = ?
                                LIMIT 1";

                    $stmt1 = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt1, "s", $user_email);
                    mysqli_stmt_execute($stmt1);
                    mysqli_stmt_store_result($stmt1);

                    mysqli_stmt_bind_result($stmt1, $user_id);
                    mysqli_stmt_fetch($stmt1);

                    date_default_timezone_set('Europe/Berlin');
                    $currentDateAndTime = date('Y-m-d H:i:s');

                    if (!empty($user_companies)) {
                        foreach ($user_companies as $company_id) {
                            $sql2 = "INSERT INTO UTENTI_AZIENDE (UTENTE_ID, AZIENDA_ID) VALUES (?, ?)";

                            $company_id = (int) $company_id;

                            $stmt2 = mysqli_prepare($conn, $sql2);
                            mysqli_stmt_bind_param($stmt2, "ii", $user_id, $company_id);
                            mysqli_stmt_execute($stmt2);

                            $logSql01 = "INSERT INTO LOGS (UTENTE_ID, ENTITA, UA_AZIENDA_ID, UA_UTENTE_ID, AZIONE, DATA_ORA) VALUES (?, 'UTENTI_AZIENDE', ?, ?,'Creare', ?)";
                            $stmtLog01 = mysqli_prepare($conn, $logSql01);
                            mysqli_stmt_bind_param($stmtLog01, "iiis", $_SESSION["user_id"], $company_id, $user_id, $currentDateAndTime);
                            mysqli_stmt_execute($stmtLog01);
                            mysqli_stmt_close($stmtLog01);
                        }
                    }

                    $successfulMessage = "Utente Creato con Successo";

                    $sql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, DATA_ORA) VALUES (?, 'UTENTI', ?, 'Creare', ?)";

                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "iis", $_SESSION["user_id"], $user_id, $currentDateAndTime);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);
                } else {
                    $errorMessage = "Errore: Impossibile Creare l'Utente";
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
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

    <title>Crea un Utente</title>

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
                            <h1 class="h3 mb-3">Crea un Utente</h1>
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
                                                <h5 class="card-title col-sm-2 col-form-label">Nome<span
                                                        style="color:red;">*</span></h5>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="user_first_name"
                                                        placeholder="Nome" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Cognome<span
                                                        style="color:red;">*</span></h5>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="user_last_name"
                                                        placeholder="Cognome" required>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">E-mail<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="email" placeholder="Email" name="user_email" value=""
                                                        class="form-control" required />
                                                </div>
                                            </div>


                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Password<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <div class="input-group">
                                                        <input type="password" id="password" placeholder="Password"
                                                            name="user_password" class="form-control" required />
                                                        <div class="input-group-append">
                                                            <button type="button" onclick="togglePassword()"
                                                                id="btnToggle"
                                                                class="btn btn-outline btn-xs btn-xs btn-2x"><i
                                                                    id="eyeIconPassword"
                                                                    class="fa fa-eye fa-xs"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Numero<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Numero" name="user_number"
                                                        class="form-control" value="" required />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Azienda Posizione
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input type="text" placeholder="Azienda Posizione"
                                                        name="user_position" class="form-control" value="" />
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Data di
                                                    Inizio
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="user_joined_date" placeholder="Data di Inizio"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Data di
                                                    Fine
                                                </h5>
                                                <div class="col-sm-4">
                                                    <input readonly type="text" class="form-control" id="datePicker"
                                                        name="user_left_date" placeholder="Data di Fine"
                                                        style="background: url('data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E') no-repeat right 10px center; background-size: 16px; background-color: white">
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Ruole<span
                                                        style="color:red;">*</span>
                                                </h5>
                                                <div class="col-sm-4">
                                                    <div>
                                                        <select data-allow-clear="1" name="user_role"
                                                            class="form-select mb-3 " required>
                                                            <option value="" style="margin-right:20px !important;"
                                                                disabled selected hidden>Seleziona Ruolo</option>
                                                            <option value="Admin">Admin</option>
                                                            <option value="Cliente">Cliente</option>
                                                            <option value="Dipendente">Dipendente</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3 row d-flex justify-content-center">
                                                <h5 class="card-title col-sm-2 col-form-label">Aziende</h5>
                                                <div class="col-sm-4">
                                                    <select style="font-size: 1px !important;" multiple
                                                        placeholder="Seleziona Azienda" name="user_companies[]"
                                                        id="multiple_select" data-allow-clear="1">
                                                        <?php echo showCompaniesNameDropDown(); ?>
                                                    </select>
                                                </div>
                                            </div>                         
                                        </div>

                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <button type="submit" name="create_user"
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

                    $(function () {
                        $('#multiple_select').each(function () {
                            $(this).select2({
                                theme: 'bootstrap4',
                                width: 'style',
                                placeholder: $(this).attr('placeholder'),
                                allowClear: Boolean($(this).data('allow-clear')),
                                language: 'it'
                            });
                        });
                    });

                    let
                        passwordInput = document.getElementById('password');
                    iconPassword = document.getElementById('eyeIconPassword');

                    function togglePassword() {
                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            iconPassword.classList.add("fa-eye-slash");
                        } else {
                            passwordInput.type = 'password';
                            iconPassword.classList.remove("fa-eye-slash");
                        }
                    }

                    const roleSelect = document.querySelector('select[name="user_role"]');
                    const companiesSelect = document.getElementById('multiple_select');

                    function handleRoleChange() {
                        if (roleSelect.value === "Dipendente") {
                            $(companiesSelect).val(null).trigger('change'); // Clear selection
                            companiesSelect.disabled = true;
                        } else {
                            companiesSelect.disabled = false;
                        }
                    }

                    roleSelect.addEventListener('change', handleRoleChange);

                    handleRoleChange();

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