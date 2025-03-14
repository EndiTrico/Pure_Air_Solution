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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Pure Air Solutions</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</head>

<body>

    <div class="container-login" id="container-login">
        <div class="col-12 col-md-6 form-container-login sign-in">
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
                <input type="submit" value="Log In" class="btn hidden" id="login" />
                <div class="d-flex align-items-center">
        <p class="mb-0 mr-2">PAS&nbsp;Website:</p>
        <button class="btnPAS hidden" id="register">Sito&nbsp;Web&nbsp;PAS</button>
    </div>
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
        <div class="d-none d-md-block toggle-container-login ">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>Pure Air Solutions</h1>
                    <p>Per navigare sulla pagina web principale cliccare sul pulsante qui sotto</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.onload = function () {
            localStorage.clear();
        }
      
      document.getElementById("register").addEventListener("click", function() {
    window.location.href = "/index.html";
});

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

</body>

</html>