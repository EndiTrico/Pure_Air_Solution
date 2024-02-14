<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_user'])) {
        // Retrieve form data
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);

        $md5 = md5($user_password);

        $query3 = "SELECT COMPANY_ID FROM companies WHERE NAME = '$user_company'";
        // Perform validation if necessary
        $result = mysqli_query($conn, $query3);
        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch one row from the result set
            $row_user_company = mysqli_fetch_assoc($result);
            $company_id = $row_user_company['COMPANY_ID'];

            // Insert data into the users table
            $sql = "INSERT INTO users (FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, ROLE, IS_ACTIVE, COMPANY_ID) VALUES 
                    ('$first_name', '$last_name', '$user_email', '$md5', '$role', 1, $company_id)";
            try {
                if (mysqli_query($conn, $sql)) {
                    $successfulMessage = "User created successfully";
                } else {
                    $errorMessage = "Error: Failed to create user";
                }
            } catch (mysqli_sql_exception $e) {
                $errorMessage = "Error: " . $e->getMessage();
            }
        }
    }
}

// Close the database connection
include 'database/closedb.php';

function showCompaniesName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT COMPANY_ID, NAME FROM Companies";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";
    // Start HTML select element
    $companyDropDown .= '<select class="form-select mb-3" name = "user_company" required>';
    $companyDropDown .= '<option value="" disabled selected>Select Company</option>';

    // Check if the query was successful
    if ($company) {
        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($company)) {
            // Output an option for each company
            $companyDropDown .= '<option value="' . $row['COMPANY_ID'] . '">' . htmlspecialchars($row['NAME']) . '</option>';
        }
    } else {
        // If the query failed, handle the error
        $companyDropDown .= "Error: " . mysqli_error($conn);
    }

    // Close HTML select element
    $companyDropDown .= '</select>';

    // Close the database connection
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
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>Blank Page | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
</head>

<body>
    <div class="wrapper">
        <?php include "verticalNavBar.php"; ?>
        <div class="main">
            <?php include "horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12 col-lg-1">
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_create.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Create User</h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Form for creating user -->
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
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">First Name</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" required>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Last Name</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" required>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Role</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                            <select name="role" class="form-select mb-3" required>
                                                                <option value="" disabled selected>Select Role
                                                                </option>
                                                                <option>Admin</option>
                                                                <option>Client</option>
                                                            </select>
                                                        </div>
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
                                                            <input type="email" placeholder="Email" name="user_email" value="" class="form-control" required />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Password</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="password" placeholder="Password" name="user_password" class="form-control" value="" required />
                                                    </div>
                                                </div>

                                                <div class="card">
                                                    <div class="card-header">
                                                        <h5 class="card-title mb-0">Company</h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <div>
                                                            <?php echo showCompaniesName() ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex justify-content-center">
                                                    <button type="submit" name="create_user" class="btn btn-success btn-lg">Create User</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> &copy;
                            </p>
                        </div>
                        <div class="col-6 text-end">
                            <ul class="list-inline">
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>