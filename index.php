<?php
session_start();
include 'validateLogin.php';

$errorMessage = '';

if (isset($_POST['email']) && isset($_POST['password'])) {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (validateLogin($email, $password)) {
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
            $errorMessage = "Invalid credentials!";
        }
    }
}
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
            <div class="left panel">
                <div class="signin-welcome">
                    <form id="login-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="signin-form">
                        <h2 class="title">Sign in</h2>
                        <div class="input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" name="email" value="" required />
                        </div>
                        <div class="input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Password" name="password" value="" required />
                        </div>
                        <button type="submit" class="btn solid">Log In</button>
                    </form>
                    <?php if (!empty($errorMessage)) { ?>
                        <script>
                            Swal.fire({
                                title: "Unsuccessful Logged In",
                                text: "<?php echo $errorMessage; ?>",
                                icon: "error",
                                showCancelButton: true,
                                confirmButtonColor: "red",
                                confirmButtonText: "OK"
                            });
                        </script>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>Do You Want to Know About Us?</h3>
                    <p>
                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Debitis,
                        ex ratione. Aliquid!
                    </p>
                    <button class="btn transparent" id="welcome-btn">
                        Welcome
                    </button>
                </div>
                <img src="images/log.svg" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Do You Want to Sign in?</h3>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum
                        laboriosam ad deleniti.
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>

                <img src="images/person.png" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="signin.js"></script>
</body>

</html>
