<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

$email = $_SESSION['email'];

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_profile'])) {
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $user_confirm_password = mysqli_real_escape_string($conn, $_POST['user_confirm_password']);

        $hashed_password = password_hash('sha256', $user_password);

        if ($user_password == $user_confirm_password) {
            $sql = "UPDATE users 
                SET FIRST_NAME = '$first_name', 
                    LAST_NAME = '$last_name', 
                    PASSWORD = '$hashed_password',  
                    EMAIL = '$user_email'
                WHERE EMAIL = '$email'";

            try {
                if (mysqli_query($conn, $sql)) {
                    $successfulMessage = "Profile Updated Successfully";
                } else {
                    $errorMessage = "Error: Failed to Update Profile";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        } else {
            $errorMessage = "Passwords Do Not Match!";
        }

    }
}

include 'database/closedb.php';

function showForm($email)
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query_id = "SELECT USER_ID FROM Users WHERE EMAIL = '" . $email . "' LIMIT 1";
    $result_id = mysqli_query($conn, $query_id);
    $id = mysqli_fetch_assoc($result_id);

    $query = "SELECT * FROM Users WHERE USER_ID =" . $id["USER_ID"];
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        echo '
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">First Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="' . $row["FIRST_NAME"] . '" required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Last Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="' . $row["LAST_NAME"] . '" required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Email</h5>
                    </div>
                    <div class="card-body">
                        <input type="email" placeholder="Email" name="user_email" class="form-control" value="' . $row["EMAIL"] . '"  required>
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
                        <h5 class="card-title mb-0">Confirm Password</h5>
                    </div>
                    <div class="card-body">
                        <input type="password" placeholder="Confirm Password" name="user_confirm_password" class="form-control"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <button type="submit" name="update_profile" class="btn btn-success btn-lg">Save</button>
                    </div>
                </div>
            </div>';
    }
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


    <title>My Profile</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="wrapper">
        <?php include "verticalNavBar.php"; ?>
        <div class="main">
            <?php include "horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <h1 class="h3 mb-3">My Profile</h1>
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
                                                                <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert">' . $errorMessage . '</div>                                                    </div>
                                                            </div>
                                                        </div>';
                                            } else if (!empty($successfulMessage)) {
                                                echo '<div class="col-12">
                                                            <div class="card">
                                                                <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ccffcc; color: #006600;" class="alert alert-success" role="alert">' . $successfulMessage . '</div>                                                    </div>
                                                            </div>
                                                        </div>';
                                            }
                                            ?>

                                            <div class="col-12 col-lg-6">
                                                <div>
                                                    <h5 class="card-title mb-0" style="text-align:center;
                                                                font-size: 50px;
                                                                font-weight:bold;
                                                                margin-top: 5%;">
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
                                                                margin-top: 10%;
                                                                justify-content: center;
                                                                align-items: center;
                                                                font-size: 200px;
                                                                font-weight: bold;"
                                                            class="avatar img-fluid me-1 avatar-circle">
                                                            <?php echo initials(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <?php showForm($email); ?>
                                        </div>
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

</body>

</html>