<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['create_department'])) {
        // Retrieve form data
        $department_name = mysqli_real_escape_string($conn, $_POST['department_name']);
        $company_id = mysqli_real_escape_string($conn, $_POST['company_name']);
        $structure_id = mysqli_real_escape_string($conn, $_POST['structure_name']);

        //$query_structure = "SELECT STRUCTURE_ID FROM Structures WHERE NAME = '" .  $structure_id . "'";
        //$structure = mysqli_query($conn, $query);
        //$row_structure = mysqli_fetch_assoc($structure);

        // Insert data into the users table
        $sql = "INSERT INTO departments (NAME, COMPANY_ID, STRUCTURE_ID, IS_ACTIVE) VALUES 
                    ('$department_name', '$company_id', '$structure_id',  1)";
        try {
            if (mysqli_query($conn, $sql)) {
                $successfulMessage = "User created successfully";
            } else {
                $errorMessage = "Error: Failed to create company";
            }
        } catch (mysqli_sql_exception $e) {
            $errorMessage = "Error: " . $e->getMessage();
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
    $companyDropDown .= '<select class="form-select mb-3" name = "company_name" id="company-dropdown" required>';
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
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>Blank Page | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

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
                            <a class="btn transparent-btn" style="margin-top: -8px;" href="admin_create.php"><img
                                    src="./images/back_button.png">
                            </a>
                        </div>
                        <div class="col-12 col-lg-11">
                            <h1 class="h3 mb-3">Create Department</h1>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="card-body">
                                            <!-- Form for creating company -->
                                            <form id="companyForm" method="post">
                                                <div class="row">

                                                    <?php
                                                    if (!empty($errorMessage)) {
                                                        echo '<div class="col-12"> <div class="card"> <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ffcccc; color: #cc0000;" class="alert alert-danger" role="alert">' . $errorMessage . '</div>                                                    </div>
                                                    </div> </div>';
                                                    } else if (!empty($successfulMessage)) {
                                                        echo '<div class="col-12"> <div class="card"> <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #ccffcc; color: #006600;" class="alert alert-success" role="alert">' . $successfulMessage . '</div>                                                    </div>
                                                    </div></div>';
                                                    }
                                                    ?>

                                                    <div class="row">
                                                        <div class="col-12 col-lg-6">
                                                            <div class="card">
                                                                <div class="card-header">
                                                                    <h5 class="card-title mb-0">Deparment Name</h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <input type="text" class="form-control"
                                                                        name="department_name"
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
                                                                    <div>
                                                                        <?php echo showCompaniesName() ?>
                                                                    </div>
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
                                                                    <select  name="structure_name" id="structure_name" class="form-select mb-3"
                                                                        required>
                                                                        <option disable selected value="">Select
                                                                            Structure</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-12 d-flex justify-content-center">
                                                            <button name="create_department" id="createDepartmentButton"
                                                                class="btn btn-success btn-lg">Create
                                                                Department</button>
                                                        </div>
                                                    </div>
                                            </form>

                                        </div>
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
                                <a class="text-muted" href="https://adminkit.io/"
                                    target="_blank"><strong>AdminKit</strong></a> &copy;
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("#company-dropdown").change(function () {
                var country_id = $(this).val();
                var post_id = 'id=' + country_id;
                $.ajax
                    ({
                        type: "POST",
                        url: "fetch_structures.php",
                        data: post_id,
                        cache: false,
                        success: function (cities) {
                            $("#structure_name").html(cities);
                        }
                    });
            });
        });
    </script>
</body>

</html>