<?php

session_start();
include 'validateLogin.php';

$errorMessage = '';

if (isset($_SESSION['email'])) {
    $role = determineRole($_SESSION['email']);
    if ($role === "Admin") {
        header('Location: admin_dashboard.php');
    } else if ($role === "Client") {
        header('Location: client_dashboard.php');
    } else {
        header('Location: admin_create_user.php');
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $input_password = $_POST['inpt_password'];

    $loginResult = validateLogin($email, $input_password);
    if ($loginResult['success']) {
        $_SESSION['email'] = $email;
        $role = determineRole($email);
        $_SESSION["role"] = $role;
        $user_id = determineUserID($email);
        $_SESSION["user_id"] = $user_id;

        if ($role == "Admin") {
            header('Location: admin_dashboard.php');
            exit();
        } else if ($role == "Cliente") {
            include 'database/config.php';
            include 'database/opendb.php';

            $queryCompanyID = "SELECT ua.AZIENDA_ID 
                               FROM UTENTI_AZIENDE ua
                               JOIN UTENTI u ON ua.UTENTE_ID = u.UTENTE_ID
                               WHERE u.EMAIL = ? ";

            $stmt = mysqli_prepare($conn, $queryCompanyID);
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['email']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            mysqli_stmt_bind_result($stmt, $company_ID);
            $company_IDs = array();

            while (mysqli_stmt_fetch($stmt)) {
                $company_IDs[] = $company_ID;
            }

            $_SESSION["company_ID"] = $company_IDs;

            include 'database/closedb.php';

            header('Location: client_dashboard.php');
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = $loginResult['message'];
        header('Location: index.php');
        exit();
    }
}

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
unset($_SESSION['errorMessage']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Pure Air Solutions</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-in">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="sign-in-form">
                <h1>Login</h1>
                <br>
                <span>Inserisci l'email e la password per accedere all'applicazione PAS</span>
                <br>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Email" name="email" value="" required />
                </div>
                <div class="input-field">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="inpt_password" name="inpt_password" placeholder="Password" value=""
                        required />
                    <i class="fa-solid fa-eye" id="eyeIconPassword" onclick="togglePassword()"></i>
                </div>
                <input type="submit" value="Log In" class="btn hidden" id="login"/>
            </form>
            <?php if (!empty($errorMessage)) { ?>
                <script>
                    Swal.fire({
                        title: "Accesso non Riuscito",
                        text: "<?php echo $errorMessage; ?>",
                        icon: "error",
                        showCancelButton: false,
                        confirmButtonColor: "red",
                        confirmButtonText: "OK"
                    });
                </script>
            <?php } ?>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Pure Air Solutions</h1>
                    <p>Per navigare sulla pagina web principale cliccare sul pulsante qui sotto</p>
                    <button class="btn hidden" id="register">Sito Web PAS</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            localStorage.clear();
        }

        let
            passwordInput = document.getElementById('inpt_password');
        iconPassword = document.getElementById('eyeIconPassword');

        function togglePassword() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                iconPassword.classList.add("fa-regular", "fa-eye-slash");
                iconPassword.classList.remove("fa-solid", "fa-eye");
            } else {
                passwordInput.type = 'password';
                iconPassword.classList.add("fa-solid", "fa-eye");
                iconPassword.classList.remove("fa-regular", "fa-eye-slash");
            }
        }

    </script>

    </script>
</body>

</html>