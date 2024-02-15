<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

$errorMessage = "";
$successfulMessage = "";

function displayEntity($entityype, $searchValue = "")
{
    include 'database/config.php';
    include 'database/opendb.php';

    // Get data type from AJAX request
    $tableQuery = "";
    // Fetch data based on data type
    if ($entityype == "user") {
        $query = "SELECT u.USER_ID, u.FIRST_NAME, u.LAST_NAME, u.EMAIL, u.ROLE, c.NAME FROM users
                JOIN companies ON u.COMPANY_ID = c.COMPANY_ID";
        if (!empty($searchValue)) {
            // Add WHERE clause to filter based on search query
            $query .= " WHERE u.FIRST_NAME LIKE '%$searchValue%' OR u.LAST_NAME LIKE '%$searchValue%' OR u.EMAIL LIKE '%$searchValue%'";
        }
        $tableQuery .= "<table>
    <tr>
      <th>User ID</th>
      <th>First Name</th>
      <th>Last Name</th>
      <th>Email</th>
      <th>Password</th>
      <th>Role</th>
      <th>Company Name</th>
      <th>Actions</th>
    </tr>";
    } elseif ($entityype == "company") {
        $query = "SELECT * FROM companies";
    } elseif ($entityype == "structure") {
        $query = "SELECT * FROM structures";
    } elseif ($entityype == "department") {
        $query = "SELECT * FROM departments";
    }

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Output data of each row
        while ($row = mysqli_fetch_assoc($result)) {

            $tableQuery .= "<tr>";

            foreach ($row as $column => $value) {
                // Echo each column's value
                $tableQuery .= "<td>" . $value . "</td>";
            }

            $tableQuery .= "</tr>";
        }
    } else {
        echo "0 results";
    }
    include 'database/closedb.php';

    return $tableQuery;
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
        $(document).ready(function () {
            $(".display-button").click(function () {
                var dataType = $(this).data('type'); // Get the data-type attribute of the clicked button
                $.ajax({
                    url: <?php echo $_SERVER["PHP_SELF"]; ?>,
                    method: "POST",
                    data: {
                        type: dataType
                    },
                    dataType: "html",
                    success: function (response) {
                        $("#data-table").html(response); // Update the table with fetched data
                    }
                });
            });

            $("#search-box").keyup(function () {
                var searchValue = $(this).val().trim(); // Get the value of the search box
                var dataType = $(".display-button.active").data('type'); // Get the data-type attribute of the active button

                // Send AJAX request to fetch filtered data
                $.ajax({
                    url: <?php echo $_SERVER["PHP_SELF"]; ?>,
                    method: "POST",
                    data: {
                        type: dataType,
                        search: searchValue // Pass the search query to the server
                    },
                    dataType: "html",
                    success: function (response) {
                        $("#data-table").html(response); // Update the table with filtered data
                    }
                });
            });
        });
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
                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="showResult('output', 'user')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Create
                                                    User</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a href="admin_create_company.php"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Create
                                                    Company</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a href="admin_create_structure.php"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Create
                                                    Structure</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a href="admin_create_department.php"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Create
                                                    Departments</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="card-header output" id="output" style="display: none;">
                                          <input type="text" class="form-control" id="search-box" placeholder="Search">

                                        </div>
                                        <div class="card-body output" id="output" style="display: none;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <script>
                function showResult(formId, entity) {
                    // Hide all forms
                    document.querySelectorAll('.card-body output').forEach(form => {
                        form.style.display = 'none';
                    });

                    // Show the selected form
                    document.getElementById(formId).style.display = 'block';

                    if (entity == 'user') {
                        <?php echo displayEntity('user'); ?>
                    } else if (entity == 'company') {
                        displayEntity();
                    } else if (entity == 'structure') {
                        displayEntity();
                    } else if (entity == 'department') {
                        displayEntity();
                    }
                }
            </script>


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a class="text-muted" href="https://adminkit.io/"
                                    target="_blank"><strong>AdminKit</strong></a>
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