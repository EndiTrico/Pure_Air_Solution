<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

$id = $_GET['id'];
$entity = $_GET['entity'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['update_user'])) {
        // Retrieve form data
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
        $user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        $user_company = mysqli_real_escape_string($conn, $_POST['user_company']);
        //$query3 = "SELECT COMPANY_ID FROM companies WHERE NAME = '$user_company'";

        $query_user = "SELECT password FROM users WHERE USER_ID =" . $id;
        $password =  mysqli_query($conn, $query_user);
        //$result = mysqli_query($conn, $query3);

        // if ($result && mysqli_num_rows($result) >= 0) {
        // Fetch one row from the result set
        // $row_user_company = mysqli_fetch_assoc($result);
        // $company_id = $row_user_company['COMPANY_ID'];

        $sql = "";
        $md5 = md5($user_password);

        if ($md5 == $user_email) {
            $sql = "UPDATE users SET 
                FIRST_NAME = '$first_name', 
                LAST_NAME = '$last_name', 
                EMAIL = '$user_email', 
                ROLE = '$role', 
                COMPANY_ID = $user_company 
                WHERE USER_ID = $id";
        } else {
            $sql = "UPDATE users SET 
                FIRST_NAME = '$first_name', 
                LAST_NAME = '$last_name', 
                EMAIL = '$user_email',
                PASSWORD = '$md5',
                ROLE = '$role', 
                COMPANY_ID = $user_company 
                WHERE USER_ID = $id";
        }

        try {
            if (mysqli_query($conn, $sql)) {
                $successfulMessage = "User Updated Successfully";
            } else {
                $errorMessage = "Error: Failed to Update User";
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
        //  }
    } else if (isset($_POST['update_company'])) {
        // Retrieve form data
        $company_name = mysqli_real_escape_string($conn, $_POST['company_name']);
        $company_email = mysqli_real_escape_string($conn, $_POST['company_email']);

        // Insert data into the users table
        $sql = "UPDATE companies 
        SET EMAIL = '$company_email' 
        WHERE NAME = '$company_name'";

        try {
            if (mysqli_query($conn, $sql)) {
                $successfulMessage = "Company Updated Successfully";
            } else {
                $errorMessage = "Error: Failed to Update Company";
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
        }
    }
}

// Close the database connection
include 'database/closedb.php';

function showCompaniesNameDropDown()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $id = $_GET['id'];

    $query = "SELECT COMPANY_ID, NAME FROM Companies";
    $company = mysqli_query($conn, $query);

    $query2 = "SELECT COMPANY_ID FROM Users WHERE USER_ID =" . $id;
    $user_company =  mysqli_query($conn, $query2);
    $row_comapany = mysqli_fetch_assoc($user_company);

    $companyDropDown = "";
    // Start HTML select element
    $companyDropDown .= '<select class="form-select mb-3" name = "user_company" required>';
    $companyDropDown .= '<option value="" disabled selected>Select Company</option>';

    // Check if the query was successful
    if ($company) {
        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($company)) {
            // Output an option for each company
            $companyDropDown .= '<option ' . ($row_comapany['COMPANY_ID'] == $row['COMPANY_ID'] ? 'selected' : '') . ' value="' . $row['COMPANY_ID'] . '">' . htmlspecialchars($row['NAME']) . '</option>';
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


function showForm()
{
    include 'database/config.php';
    include 'database/opendb.php';
    $entity = $_GET['entity'];
    $id = $_GET['id'];

    if ($entity == 'users') {
        $query = "SELECT * FROM Users WHERE USER_ID =" . $id;
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result) {
            $row = mysqli_fetch_assoc($result);

            echo '<form id="userForm" method="post">
        <div class="row">';

            echo '<div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">First Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="' . $row["First_Name"] . '" required>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Last Name</h5>
                    </div>
                    <div class="card-body">
                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="' . $row["Last_Name"] . '" required>
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
                                <option ' . ($row["Role"] == "Admin" ? 'selected' : '') . '>Admin</option>
                                <option ' . ($row["Role"] == "Client" ? 'selected' : '') . '>Client</option>
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
                            <input type="email" placeholder="Email" name="user_email" class="form-control" value="' . $row["Email"] . '"  required>
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
                        <div>' . showCompaniesNameDropDown() .
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
    } else if ($entity == 'companies') {
        $query = "SELECT * FROM COMPANIES WHERE COMPANY_ID =" . $id;
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
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
                                <input type="text" class="form-control" name="company_name" placeholder="Company Name" value="' . $row['Name'] . '"required>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Email</h5>
                            </div>
                            <div class="card-body">
                                <input type="email" class="form-control" name="company_email" placeholder="Email" value="' . $row['Email'] . '"required>
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
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_display_entities.php"><img src="./images/back_button.png"></a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Update User</h1>
                        </div>

                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
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
                                    <?php showForm(); ?>
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