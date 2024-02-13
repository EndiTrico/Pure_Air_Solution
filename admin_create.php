<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

function showCompaniesName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT Name FROM Companies";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";
    // Start HTML select element
    $companyDropDown .= '<select class="form-select mb-3" name = "user_company" required>';
    $companyDropDown .= '<option selected>Select Company</option>';

    // Check if the query was successful
    if ($company) {
        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($company)) {
            // Output an option for each company
            $companyDropDown .= '<option>' . htmlspecialchars($row['Name']) . '</option>';
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

function showStructuresName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    // Perform the SQL query to fetch company names
    $query2 = "SELECT Name FROM Structures";
    $structure = mysqli_query($conn, $query2);

    $structureDropDown = "";
    $structureDropDown .= '<select name="structure_name" class="form-select mb-3" required>';
    $structureDropDown .= '<option selected>Select Structure</option>';

    if ($structure) {
        // Fetch rows from the result set
        while ($row = mysqli_fetch_assoc($structure)) {
            // Output an option for each company
            $structureDropDown .= '<option>' . htmlspecialchars($row['Name']) . '</option>';
        }
    } else {
        // If the query failed, handle the error
        $structureDropDown .= "Error: " . mysqli_error($conn);
    }

    // Close HTML select element
    $structureDropDown .= '</select>';

    // Close the database connection
    include 'database/closedb.php';

    return $structureDropDown;
}


// Close the database connection
include 'database/closedb.php';
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

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script>

    </script>

</head>

<body>
    <div class="wrapper">
        <?php include "verticalNavBar.php"; ?>
        <div class="main">
            <?php include "horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Create Entities</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_user.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Create
                                                        User</a>
                                                </div>
                                            </div>

                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_company.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Create
                                                        Company</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" col-12 col-lg-6">
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_user.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Create
                                                        Structure</a>
                                                </div>
                                            </div>

                                            <div class=" card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_user.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Create
                                                        Departments</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
        </div>
    </div>
    </main>

    <script>
        function showForm(formId) {
            // Hide all forms
            document.querySelectorAll('.card-body form').forEach(form => {
                form.style.display = 'none';
            });

            // Show the selected form
            document.getElementById(formId).style.display = 'block';
        }

    </script>

   
    <footer class="footer">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-6 text-start">
                    <p class="mb-0">
                        <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a>
                        &copy;
                    </p>
                </div>
                <div class="col-6 text-end">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted" href="https://adminkit.io/" target="_blank">Help
                                Center</a>
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