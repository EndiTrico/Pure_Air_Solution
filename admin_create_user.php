<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_user'])) {
        $NOME = mysqli_real_escape_string($conn, $_POST['NOME']);
        $COGNOME = mysqli_real_escape_string($conn, $_POST['COGNOME']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        //  $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);

        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

        $queryCheck = "SELECT UTENTE_ID FROM UTENTI 
                        WHERE EMAIL = ? 
                            AND E_ATTIVO = 0 
                        LIMIT 1";

        $stmt = mysqli_prepare($conn, $queryCheck);
        mysqli_stmt_bind_param($stmt, "s", $user_email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) > 0) {
            mysqli_stmt_bind_result($stmt, $UTENTE_ID);
            mysqli_stmt_fetch($stmt);

            $sql = "UPDATE UTENTI 
                    SET NOME = ?, 
                        COGNOME = ?, 
                        PASSWORD = ?, 
                        RUOLO = ?, 
                        E_ATTIVO = 1, 
                        EMAIL = ?,
                        AZIENDA_ID = ? 
                    WHERE UTENTE_ID = ?";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssii", $NOME, $COGNOME, $hashed_password, $role, $user_email, $UTENTE_ID);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "User Activated Successfully";
                } else {
                    $errorMessage = "Error: Failed to Activate User";
                }
            } catch (Exception $e) {
                $errorMessage = $e->getMessage();
            }
        } else {
            $sql = "INSERT INTO UTENTI (NOME, COGNOME, EMAIL, PASSWORD, RUOLO, E_ATTIVO) VALUES 
                (?, ?, ?, ?, ?, 1)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "sssss", $NOME, $COGNOME, $user_email, $hashed_password, $role);

            try {
                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "User Created Successfully";
                } else {
                    $errorMessage = "Error: Failed to Create User";
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
    $companyDropDown .= '';
    $companyDropDown .= '<option value="" disabled selected>Seleziona Azienda</option>';

    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $companyDropDown .= '<option value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }

    $companyDropDown .= '</select>';

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

    <title>Create User</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/css/multi-select-tag.css">
    <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag@2.0.1/dist/js/multi-select-tag.js"></script>


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
                            <h1 class="h3 mb-3">Create User</h1>
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
                                                        <h5 class="card-title mb-0">Nome *</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" class="form-control" name="user_first_name"
                                                            placeholder="Nome" required>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Cognome *</h5>
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
                                                        <h5 class="card-title mb-0">Ruole *</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                            <select name="role" class="form-select mb-3" required>
                                                                <option value="" disabled selected>Select Role</option>
                                                                <option>Admin</option>
                                                                <option>Cliente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-12 col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Numero *</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" placeholder="Numero" name="user_number"
                                                            class="form-control" value="" required />
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Email *</h5>
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
                                                        <h5 class="card-title mb-0">Password *</h5>
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
                                                        <select name="companies" id="companies" multiple>
                                                            <?php
                                                            include 'database/config.php';
                                                            include 'database/opendb.php';

                                                            $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
                                                            $company = mysqli_query($conn, $query);

                                                            if ($company) {
                                                                while ($row = mysqli_fetch_assoc($company)) {
                                                                    echo '<option value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
                                                                }
                                                            } else {
                                                                $companyDropDown .= "Error: " . mysqli_error($conn);
                                                            }


                                                            include 'database/closedb.php'; ?>
                                                        </select>
                                                    </div>
                                                </div>


                                                <!--              <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Company</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>-->
                                                <div class="row">
                                                    <div class="col-12 d-flex justify-content-center">
                                                        <button type="submit" name="create_user"
                                                            class="btn btn-success btn-lg">Create User</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    new MultiSelectTag('companies')  // id
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