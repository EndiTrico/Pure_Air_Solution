<?php
session_start();

// open database
include 'database/config.php';
include 'database/opendb.php';

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
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>Blank Page | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>

    <style>
        #searchBox {
            border-radius: 50px;
            margin-left: 65%;
            width: 80%;
            display: none;
        }
    </style>

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
                                                <a onclick="fetchData('users')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Create
                                                    User</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('companies')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Create
                                                    Company</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('structures')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Create
                                                    Structure</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('departments')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Create
                                                    Departments</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="card-header output col-md-6" id="output">
                                           <input oninput="search()" type="text" id="searchBox" class="form-control justify-content-center" placeholder="Search...">

                                        </div>

                                        <div id="tableContainer" class="mt-4">
                                            <!-- Table will be displayed here -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>


            <script>
                var selected_entity = "";

                function fetchData(entity) {
                   
                    document.getElementById("searchBox").style.display = "block";

                    selected_entity = entity;
                    var searchQuery = document.getElementById('searchBox').value;
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "fetch_data.php?entity=" + entity + "&search=" + searchQuery, true);
                    xhttp.send();
                    
                }

                function search() {
                    var entity = selected_entity; // Set the entity you want to search for, e.g., 'users', 'companies', etc.
                    var searchQuery = document.getElementById('searchBox').value;
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "fetch_data.php?entity=" + entity + "&search=" + searchQuery, true);
                    xhttp.send();
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