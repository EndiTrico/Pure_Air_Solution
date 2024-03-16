<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

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
        if(!empty($_POST['user_companies'])){
            $user_companies = $_POST['user_companies'];
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
            $sql = "INSERT INTO UTENTI (NOME, COGNOME, EMAIL, PASSWORD, NUMERO, RUOLO, AZIENDA_POSIZIONE, E_ATTIVO) VALUES 
                (?, ?, ?, ?, ?, ?, ?, 1)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssiss", $user_first_name, $user_last_name, $user_email, $hashed_password, $user_numero, $user_role, $user_position);
            try {
                if (mysqli_stmt_execute($stmt)) {
                    if (!empty($user_companies)) {
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

                        if (!empty($user_companies)) {
                            foreach ($user_companies as $company_id) {
                                $sql2 = "INSERT INTO UTENTI_AZIENDE (UTENTE_ID, AZIENDA_ID) VALUES (?, ?)";

                                $company_id = (int) $company_id;

                                $stmt2 = mysqli_prepare($conn, $sql2);
                                mysqli_stmt_bind_param($stmt2, "ii", $user_id, $company_id);
                                mysqli_stmt_execute($stmt2);
                            }
                        }
                    }
                    $successfulMessage = "Utente Creato con Successo";
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
function showAllCompanies()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";

    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $companyDropDown .= '<option value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }


    include 'database/closedb.php';

    return $companyDropDown;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Crea un Utente</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <!-- select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <!-- select2-bootstrap4-theme -->
    <link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css"
        rel="stylesheet"> <!-- for live demo page -->

</head>

<body>
    <div class="wrapper">
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_create.php"><img
                                    src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Crea un Utente</h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
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

                                            <div class="col-12 col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Nome <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" class="form-control" name="user_first_name"
                                                            placeholder="Nome" required>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Cognome <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" class="form-control" name="user_last_name"
                                                            placeholder="Cognome" required>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Azienda Posizione</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" placeholder="Azienda Posizione"
                                                            name="user_position" class="form-control" value="" />
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Ruolo <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                            <select data-allow-clear="1" name="user_role"
                                                                class="form-select mb-3" required>
                                                                <option value="" style="margin-right:20px !important;"
                                                                    disabled selected hidden>Seleciona Ruolo</option>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Cliente">Cliente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Numero <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" placeholder="Numero" name="user_number"
                                                            class="form-control" value="" required />
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">E-mail <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                            <input type="email" placeholder="Email" name="user_email"
                                                                value="" class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Password <span
                                                                style="color:red;">*</span></h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="password" placeholder="Password"
                                                            name="user_password" class="form-control" value=""
                                                            required />
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Aziende</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <select multiple placeholder="Seleciona Azienda"
                                                            name="user_companies[]" id="select" data-allow-clear="1">
                                                            <?php echo showAllCompanies(); ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <button type="submit" name="create_user"
                                                        class="btn btn-success btn-lg">Crea un Utente</button>
                                                </div>
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

                <script>
                    $(function () {
                        $('select').each(function () {
                            $(this).select2({
                                theme: 'bootstrap4',
                                width: 'style',
                                placeholder: $(this).attr('placeholder'),
                                allowClear: Boolean($(this).data('allow-clear')),
                            });
                        });
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