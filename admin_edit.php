<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_user'])) {
        $NOME = mysqli_real_escape_string($conn, $_POST['NOME']);
        $COGNOME = mysqli_real_escape_string($conn, $_POST['COGNOME']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);

        $sql = "";

        if (empty($user_password)) {
            $sql = "UPDATE UTENTI SET 
                    NOME = ?, 
                    COGNOME = ?, 
                    EMAIL = ?, 
                    ROLE = ?, 
                    AZIENDA_ID = ? 
                    WHERE UTENTE_ID = ?";
            $params = array($NOME, $COGNOME, $user_email, $role, $user_company, $id);
        } else {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT);

            $sql = "UPDATE UTENTI SET 
                    NOME = ?, 
                    COGNOME = ?, 
                    EMAIL = ?,
                    PASSWORD = ?,
                    ROLE = ?, 
                    AZIENDA_ID = ? 
                    WHERE UTENTE_ID = ?";
            $params = array($NOME, $COGNOME, $user_email, $hashed_password, $role, $user_company, $id);
        }

        try {
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssssii", ...$params);

                if (mysqli_stmt_execute($stmt)) {
                    $successfulMessage = "User Updated Successfully";
                } else {
                    $errorMessage = "Error: Failed to Update User";
                }

                mysqli_stmt_close($stmt);
            } else {
                $errorMessage = "Error: Failed to prepare statement";
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    } else if (isset($_POST['update_company'])) {
        $AZIENDA_NOME = mysqli_real_escape_string($conn, $_POST['AZIENDA_NOME']);
        $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);

        $sql = "UPDATE AZIENDE 
                SET EMAIL = ?, 
                    AZIENDA_NOME = ?
                WHERE AZIENDA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssi", $company_email, $AZIENDA_NOME, $id);

            if (mysqli_stmt_execute($stmt)) {
                $successfulMessage = "Company Updated Successfully";
            } else {
                $errorMessage = "Error: Failed to Update Company";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Error: Failed to prepare statement";
        }
    } else if (isset($_POST['update_structure'])) {
        $STRUTTURA_NOME = mysqli_real_escape_string($conn, $_POST['STRUTTURA_NOME']);
        $AZIENDA_ID = mysqli_real_escape_string($conn, $_POST['AZIENDA_ID']);

        $sql = "UPDATE STRUTTURE 
                SET AZIENDA_ID = ?, 
                    STRUTTURA_NOME = ?
                WHERE STRUTTURA_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "isi", $AZIENDA_ID, $STRUTTURA_NOME, $id);

            if (mysqli_stmt_execute($stmt)) {
                $successfulMessage = "Structure Updated Successfully";
            } else {
                $errorMessage = "Error: Failed to Update Structure";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Error: Failed to prepare statement";
        }
    } else if (isset($_POST['update_department'])) {
        $REPARTO_NOME = mysqli_real_escape_string($conn, $_POST['REPARTO_NOME']);
        $AZIENDA_ID = mysqli_real_escape_string($conn, $_POST['AZIENDA_ID']);
        $STRUTTURA_ID = mysqli_real_escape_string($conn, $_POST['STRUTTURA_ID']);

        $sql = "UPDATE REPARTI 
                SET AZIENDA_ID = ?, 
                    REPARTO_NOME = ?,
                    STRUTTURA_ID = ?
                WHERE REPARTO_ID = ?";

        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "issi", $AZIENDA_ID, $REPARTO_NOME, $STRUTTURA_ID, $id);

            if (mysqli_stmt_execute($stmt)) {
                $successfulMessage = "Department Updated Successfully";
            } else {
                $errorMessage = "Error: Failed to Update Department";
            }

            mysqli_stmt_close($stmt);
        } else {
            $errorMessage = "Error: Failed to prepare statement";
        }
    }
}

include 'database/closedb.php';

function showStructureForDepartment($id)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $sql = "SELECT s.STRUTTURA_ID, s.STRUTTURA_NOME 
            FROM STRUTTURE s 
            INNER JOIN REPARTI d ON s.STRUTTURA_ID = d.STRUTTURA_ID
            WHERE d.REPARTO_ID = ?
            LIMIT 1";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $execute = mysqli_stmt_get_result($stmt);
    $row_retrieve = mysqli_fetch_assoc($execute);

    include 'database/closedb.php';

    return '<option selected value="' . htmlspecialchars($row_retrieve["STRUTTURA_ID"]) . '">' . htmlspecialchars($row_retrieve['STRUTTURA_NOME']) . '</option>';
}

function showAZIENDENameDropDown($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $id = $_GET['id'];

    // Prepare the SQL query to fetch all AZIENDE
    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE";
    $company = mysqli_query($conn, $query);

    $sql = "";
    $companyDropDown = '<select class="form-select mb-3" name="user_company" id="company-dropdown" required>';
    $companyDropDown .= '<option value="" disabled selected>Select Company</option>';

    // Prepare and execute the SQL query based on the entity type
    if ($entity == "UTENTI") {
        $sql = "SELECT AZIENDA_ID FROM UTENTI WHERE UTENTE_ID = ?";
    } else if ($entity == "STRUTTURE") {
        $sql = "SELECT AZIENDA_ID FROM STRUTTURE WHERE STRUTTURA_ID = ?";
    } else if ($entity == "REPARTI") {
        $sql = "SELECT AZIENDA_ID FROM REPARTI WHERE REPARTO_ID = ?";
    }

    // Prepare and execute the statement
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $execute = mysqli_stmt_get_result($stmt);
    $row_retrieve = mysqli_fetch_assoc($execute);

    // Fetch and construct dropdown options
    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $selected = ($row_retrieve['AZIENDA_ID'] == $row['AZIENDA_ID']) ? 'selected' : '';
            $companyDropDown .= '<option ' . $selected . ' value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }

    $companyDropDown .= '</select>';

    include 'database/closedb.php';

    return $companyDropDown;
}



function showForm()
{
    include 'database/config.php';
    include 'database/opendb.php';
    $entity = $_GET['entity'];
    $id = $_GET['id'];

    if ($entity == 'UTENTI') {
        $query = "SELECT * FROM UTENTI WHERE UTENTE_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            echo '<form id="userForm" method="post">
        <div class="row">
        <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">First Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="NOME" placeholder="First Name" value="' . $row["NOME"] . '" required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Last Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="COGNOME" placeholder="Last Name" value="' . $row["COGNOME"] . '" required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Role</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <select name="role" class="form-select mb-3" required>
                                <option value="" disabled selected>Select Role</option> 
                                <option ' . ($row["ROLE"] == "Admin" ? 'selected' : '') . '>Admin</option>
                                <option ' . ($row["ROLE"] == "Client" ? 'selected' : '') . '>Client</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Is Active</h5>
                </div>
                <div class="card-body">
                    <input type="text" class="form-control" name="E_ATTIVO" placeholder="Is Active" value="' . $row["E_ATTIVO"] . '" required>
                </div>
            </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email</h5>
                    </div>
                    <div class="card-body">
                        <div>
                            <input type="email" placeholder="Email" name="user_email" class="form-control" value="' . $row["EMAIL"] . '"  required>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Password</h5>
                    </div>
                    <div class="card-body">
                        <input type="password" placeholder="Password" name="user_password" class="form-control"/>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Company</h5>
                    </div>
                    <div class="card-body">
                        <div>' . showAZIENDENameDropDown($entity) .
                '</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    <button type="submit" name="update_user" class="btn btn-success btn-lg">Update User</button>
                </div>
            </div>
        </div>
    </form>';
        }
    } else if ($entity == 'AZIENDE') {
        $query = "SELECT * FROM AZIENDE WHERE AZIENDA_ID = ?";

        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            echo '<form id="companyForm" method="post">
            <div class="row">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Company Name</h5>
                            </div>
                            <div class="card-body">
                                <input type="text" class="form-control" name="AZIENDA_NOME" placeholder="Company Name" value="' . $row['AZIENDA_NOME'] . '"required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Email</h5>
                            </div>
                            <div class="card-body">
                                <input type="email" class="form-control" name="company_email" placeholder="Email" value="' . $row['EMAIL'] . '"required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <button name="update_company" id="update_company" class="btn btn-success btn-lg">Update Company</button>
                    </div>
                </div>
        </form>';
        }
    } else if ($entity == 'STRUTTURE') {
        $query = "SELECT * FROM STRUTTURE WHERE STRUTTURA_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            echo '<div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Structure Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control"
                            name="STRUTTURA_NOME" placeholder="Structure Name" value="' . $row["STRUTTURA_NOME"] . '" 
                            required>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Company</h5>
                    </div>
                    <div class="card-body">
                        <div>'
                . showAZIENDENameDropDown($entity) .
                '</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_structure" id="updateStructureButton"
                    class="btn btn-success btn-lg">Update Structure</button>
            </div>
        </div>
        </form>';
        }
    } else if ($entity == "REPARTI") {
        $query = "SELECT * FROM REPARTI WHERE REPARTO_ID = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            echo '    
            <form id="departmentForm" method="post">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Department Name</h5>
                            </div>
                            <div class="card-body">
                                <input type="text" class="form-control"
                                name="REPARTO_NOME" value = "' . $row["REPARTO_NOME"] . '" 
                                placeholder="Department Name" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Company</h5>
                            </div>
                        <div class="card-body">
                            <div>'
                . showAZIENDENameDropDown($entity) . '
                            </div>
                        </div>
                    </div>
</div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Structure Name</h5>
                                </div>
                            <div class="card-body">
                                <select name="STRUTTURA_NOME" id="STRUTTURA_NOME"
                                    class="form-select mb-3" required>
                                        <option disable selected value="">Select Structure</option>
                                            ' . showStructureForDepartment($id) . '
                                </select>
                            </div>
                        </div>
                    </div>
            
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center">
                            <button name="update_department" id="updateDepartmentButton"
                                class="btn btn-success btn-lg">Update Department</button>
                        </div>
                    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#company-dropdown").change(function () {
            var companyID = $(this).val();
            var post_id = "id=" + companyID;
            $.ajax
                ({
                    type: "POST",
                    url: "fetch_STRUTTURE.php",
                    data: post_id,
                    cache: false,
                    success: function (cities) {
                        $("#STRUTTURA_NOME").html(cities);
                    }
                });
        });
    });
</script>';
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
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Edit Entity</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            <a class="btn transparent-btn" style="margin-top: -8px;"
                                href="admin_display_entities.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Update
                                <?php
                                if ($entity == "UTENTI") {
                                    echo "User";
                                } else if ($entity == "AZIENDE") {
                                    echo "Company";
                                } else if ($entity == "STRUTTURE") {
                                    echo "Structure";
                                } else if ($entity == "REPARTI") {
                                    echo "Department";
                                }
                                ?>
                            </h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
                                    <?php showForm() ?>
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

</body>

</html>