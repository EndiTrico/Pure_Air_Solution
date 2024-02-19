<?php
session_start();
include 'validateLogin.php';

$errorMessage = '';

if (isset($_SESSION['email'])) {
    $role = determineRole($_SESSION['email']);
    if ($role === "Admin") {
        header('Location: admin_dashboard.php');
    } elseif ($role === "Client") {
        header('Location: client_dashboard.php');
    }
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $loginResult = validateLogin($email, $password);
    if ($loginResult['success']) {
        $_SESSION['email'] = $email;
        $role = determineRole($email);
        if ($role == "Admin") {
            header('Location: admin_dashboard.php');
            exit();
        } else if ($role == "Client") {
            header('Location: client_dashboard.php');
            exit();
        }
    } else {
        $_SESSION['errorMessage'] = $loginResult['message'];
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

$errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
unset($_SESSION['errorMessage']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="signin.css" />
    <title>Pure Air Solutions</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="sign-in-form">
                    <h2 class="title">Log In</h2>
                    <div class="input-field">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Email" name="email" value="" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Password" name="password" value="" required />
                    </div>
                    <input type="submit" value="Log In" class="btn solid" />
                </form>
                <?php if (!empty($errorMessage)) { ?>
                    <script>
                        Swal.fire({
                            title: "Unsuccessful Login",
                            text: "<?php echo $errorMessage; ?>",
                            icon: "error",
                            showCancelButton: false,
                            confirmButtonColor: "red",
                            confirmButtonText: "OK"
                        });
                    </script>
                <?php } ?>
                <form action="#" class="sign-up-form">

                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Pure Air Solutions</h3>
                    <p>
                        New Here? Click down to the button below to get more detailed
                        information about us!
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Welcome
                    </button>
                </div>
                <img src="img/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Part of Us?</h3>
                    <p>
                        If you want to log in to our portal,
                        you need to click the button below!
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Log in
                    </button>
                </div>
                <img src="img/person.png" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="signin.js"></script>
</body>

</html>