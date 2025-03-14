<?php
include 'database/config.php';
include 'database/opendb.php';

$email = $_SESSION['email'];

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset ($_POST['update_profile'])) {
        $user_first_name = mysqli_real_escape_string($conn, $_POST['user_first_name']);
        $user_last_name = mysqli_real_escape_string($conn, $_POST['user_last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_number = mysqli_real_escape_string($conn, $_POST['user_number']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_confirm_password = mysqli_real_escape_string($conn, $_POST['user_confirm_password']);

        if ($user_password == $user_confirm_password) {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

         	$fields = [
    			'NOME' => $user_first_name,
    			'COGNOME' => $user_last_name,
    			'EMAIL' => $user_email,
        		'PASSWORD' => $user_password,
    			'NUMERO' => $user_number
            ];
                  $existingEntity = oldRecord($_SESSION['user_id']);

            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        PASSWORD = ?,
						NUMERO = ?,  
                        EMAIL = ?
                    WHERE EMAIL = ?";

            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssss", $user_first_name, $user_last_name, $hashed_password, $user_number, $user_email, $email);

                try {
                    if (mysqli_stmt_execute($stmt)) {
                        $isChanged = insertIntoLogs($fields, 'UTENTI', $_SESSION['user_id'], $existingEntity);
                    	$isChanged ? $successfulMessage = "Profilo Aggiornato con Successo": $infoMessage = "Non Hai Modificato Alcun Attributo";
                        $_SESSION['email'] = $user_email;
                    } else {
                        $errorMessage = "Errore: Impossibile Aggiornare il Profilo";
                    }
                } catch (mysqli_sql_exception $e) {
                    $errorMessage = "Errore: " . $e->getMessage();
                } finally {
                    mysqli_stmt_close($stmt);
                }
            } else {
                $errorMessage = "Errore: Impossibile Preparare l'Istruzione";
            }
        } else {
            $errorMessage = "Le Password Non Corrispondono!";
        }
    }
}

function insertIntoLogs($fields, $entity, $id, $existingEntity){
    include 'database/config.php';
	include 'database/opendb.php';
	$modifiedDate = date("Y-m-d H:i:s");
    $entity01 = strtoupper($entity);  
    $changed = false;

	foreach ($fields as $key => $value) {
		if ($value != $existingEntity[$key] && $key != 'PASSWORD') {
            $changed = true;

        	$logSql = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, ATTRIBUTO, VECCHIO_VALORE, NUOVO_VALORE, DATA_ORA) 
            			VALUES (?, ?, ?, 'Modificare', ?, ?, ?, ?)";
            $logStmt = mysqli_prepare($conn, $logSql);
            mysqli_stmt_bind_param($logStmt, "isissss", $id, $entity01, $id, $key, $existingEntity[$key], $value, $modifiedDate);
            mysqli_stmt_execute($logStmt);
            mysqli_stmt_close($logStmt);
        } else if ($key == 'PASSWORD' && $value != '') {
        	$changed = true;

        	$logSql01 = "INSERT INTO LOGS (UTENTE_ID, ENTITA, ENTITA_ID, AZIONE, ATTRIBUTO, DATA_ORA) 
            				VALUES (?, ?, ?, 'Modificare', ?, ?)";
            $logStmt01 = mysqli_prepare($conn, $logSql01);
            mysqli_stmt_bind_param($logStmt01, "isiss", $id, $entity01, $id, $key, $modifiedDate);
            mysqli_stmt_execute($logStmt01);
            mysqli_stmt_close($logStmt01);
        
        }
    }
  
	include 'database/closedb.php';
    
    return $changed;
}

function oldRecord($id){
	include 'database/config.php';
  	include 'database/opendb.php';
  
  	$existingSql = "SELECT NOME, COGNOME, EMAIL, PASSWORD, NUMERO, AZIENDA_POSIZIONE, RUOLO, DATA_INIZIO, DATA_FINE FROM UTENTI WHERE UTENTE_ID = ?";
    $stmt = mysqli_prepare($conn, $existingSql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
   	$result = mysqli_stmt_get_result($stmt);
    $existingEntity = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
  
  	include 'database/closedb.php';

    return $existingEntity;
}

function showForm($email)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query_id = "SELECT UTENTE_ID FROM UTENTI WHERE EMAIL = ? LIMIT 1";
    $stmt_id = mysqli_prepare($conn, $query_id);
    if ($stmt_id) {

        mysqli_stmt_bind_param($stmt_id, "s", $email);

        if (mysqli_stmt_execute($stmt_id)) {
            mysqli_stmt_bind_result($stmt_id, $id);

            if (mysqli_stmt_fetch($stmt_id)) {
                mysqli_stmt_close($stmt_id);

                $query = "SELECT * FROM UTENTI WHERE UTENTE_ID = ?";
                $stmt = mysqli_prepare($conn, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "i", $id);

                    if (mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            echo '
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Nome <span style = "color:red;">*</span></h5>
                    </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_first_name" value = "' . $row["NOME"] . '"
                        placeholder="Nome" required>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Cognome <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="user_last_name" value = "' . $row["COGNOME"] . '"
                        placeholder="Cognome" required>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Numero <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="text" placeholder="Numero" name="user_number"
                        class="form-control" value = "' . $row["NUMERO"] . '" required />
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">E-mail <span style = "color:red;">*</span></h5>
                </div>
                <div class="card-body">
                    <input type="email" placeholder="Email" name="user_email"
                        value = "' . $row["EMAIL"] . '" class="form-control" required />
                </div>
            </div>
    
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Password</h5>
                </div>
                <div class="card-body">
                    <div class="input-group">
                        <input type="password" onkeyup="check()" id="password" placeholder="Password" name="user_password" class="form-control"/>
                        <div class="input-group-append">
                            <button type="button" onclick="togglePassword()" id="btnToggle" class="btn btn-outline btn-xs btn-xs btn-2x"><i id="eyeIconPassword" class="fa fa-eye fa-xs"></i></button>        
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <div class="col">
                        <h5 class="card-title mb-0 d-inline">Confirm Password</h5>
                        <p id="alertPassword" class="alert d-inline"></p>
                    </div>
                </div>
                <div class="card-body">
                <div class="input-group">
                    <input type="password" onkeyup="check()" id="confirmPassword" placeholder="Confirm Password" name="user_confirm_password" class="form-control"/>
                    <div class="input-group-append">
                        <button type="button" onclick="toggleConfirmPassword()" id="btnToggle" class="btn btn-outline btn-xs btn-xs btn-2x"><i id="eyeIconConfirmPassword" class="fa fa-eye fa-xs"></i></button>
                    </div>
                </div>
            </div>
            </div>

            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" name="update_profile" class="btn btn-success btn-lg">Salva</button>
                </div>
            </div>
        </div>';
                        }
                    }
                }
            }
        }
    }

    include 'database/closedb.php';
}


function showLeftForm($email)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query_id = "SELECT UTENTE_ID FROM UTENTI WHERE EMAIL = ? LIMIT 1";
    $stmt_id = mysqli_prepare($conn, $query_id);
    if ($stmt_id) {

        mysqli_stmt_bind_param($stmt_id, "s", $email);

        if (mysqli_stmt_execute($stmt_id)) {
            mysqli_stmt_bind_result($stmt_id, $id);

            if (mysqli_stmt_fetch($stmt_id)) {
                mysqli_stmt_close($stmt_id);

                $query = "SELECT * FROM UTENTI WHERE UTENTE_ID = ?";
                $stmt = mysqli_prepare($conn, $query);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "i", $id);

                    if (mysqli_stmt_execute($stmt)) {
                        $result = mysqli_stmt_get_result($stmt);
                        if ($result) {
                            $row = mysqli_fetch_assoc($result);
                            echo '
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Azienda Posizione</h5>
        </div>
        <div class="card-body">
            <input type="text" placeholder=""
                name="user_position" class="form-control" value="' . $row["AZIENDA_POSIZIONE"] . '" disabled />
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Ruolo</h5>
        </div>
        <div class="card-body">
            <input type="text" placeholder=""
                name="user_role" class="form-control" value="' . $row["RUOLO"] . '"  disabled />
        </div>
    </div>
    ';
                        }
                    }
                }
            }
        }
    }
    include 'database/closedb.php';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Il Mio Profilo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">


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
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h1 class="h3 mb-3">Il Mio Profilo</h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="userForm" method="post">
                                        <div class="row">
                                            <?php
                                            if (!empty ($errorMessage)) {
                                                echo '<div class="col-12">
                                                        <div class="card">
                                                            <div class="card-header">
                                                                <div style="height: auto; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert"><h4 style = "padding-top:5px; color: #cc0000; font-weight:bold;">' . $errorMessage . '</h4>
                                                                </div> 
                                                            </div>                                                    
                                                        </div>
                                                    </div>';
                                            } else if (!empty ($successfulMessage)) {
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
                                                <h5 class="card-title mb-0" style="text-align:center;
                                                                font-size: 50px;
                                                                font-weight:bold;
                                                                margin-top: 37px;">
                                                    <?php echo fullName() ?>
                                                </h5>

                                                <div
                                                    style="display: flex; justify-content: center; align-items: center;">
                                                    <div style="width: 400px;
                                                                height: 400px;
                                                                border-radius: 50%; 
                                                                background-color: #222e3c;
                                                                color: #fff; 
                                                                display: inline-flex;
                                                                margin-top: 46px;
                                                                justify-content: center;
                                                                align-items: center;
                                                                font-size: 200px;
                                                                font-weight: bold;
                                                                margin-bottom: 45px;
                                                                " class="avatar img-fluid me-1 avatar-circle">
                                                        <?php echo initials(); ?>
                                                        <br>
                                                    </div>
                                                </div>
                                                <?php echo showLeftForm($email); ?>
                                            </div>

                                            <?php showForm($email); ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script>
        function check() {
            var password = document.getElementById('password');
            var confirmPassword = document.getElementById('confirmPassword');
            var alertPassword = document.getElementById('alertPassword');

            if (password.value === '' && confirmPassword.value === '') {
                alertPassword.style.visibility = 'hidden';
            } else {
                alertPassword.style.visibility = 'visible';

                if (password.value === confirmPassword.value) {
                    alertPassword.style.color = '#8CC63E';
                    alertPassword.innerHTML = '<span style="font-weight: bold;"><i class="fas fa-check-circle passwordCheck"></i>Corrisponde</span>';
                } else {
                    alertPassword.style.color = '#EE2B39';
                    alertPassword.innerHTML = '<span style="font-weight: bold;"><i class="fas fa-exclamation-triangle passwordCheck"></i>Non Corrisponde</span>';
                }
            }
        }

        let confirmPasswordInput = document.getElementById('confirmPassword'),
            passwordInput = document.getElementById('password');
            iconPassword = document.getElementById('eyeIconPassword');
            iconConfirmPassword = document.getElementById('eyeIconConfirmPassword');

        function toggleConfirmPassword() {
            if (confirmPasswordInput.type === 'password') {
                confirmPasswordInput.type = 'text';
                iconConfirmPassword.classList.add("fa-eye-slash");
            } else {
                confirmPasswordInput.type = 'password';
                iconConfirmPassword.classList.remove("fa-eye-slash");
            }
        }

        function togglePassword() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconPassword.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = 'password';
                iconPassword.classList.remove("fa-eye-slash");
            }
        }

    </script>

</body>

</html>