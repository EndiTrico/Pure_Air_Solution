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
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-blank.html" />

    <title>Blank Page | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

                    <h1 class="h3 mb-3">Display Entities</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('users')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    Users</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('companies')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    Companies</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('structures')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    Structures</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('departments')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    Departments</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-12">
                                        <div class="card-header output col-md-6" id="output">
                                            <input oninput="search()" type="text" id="searchBox"
                                                class="form-control justify-content-center" placeholder="Search...">

                                        </div>

                                        <div id="tableContainer" class="mt-4">
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
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "fetch_data.php?entity=" + entity + "&search=" + searchQuery, true);
                    xhttp.send();

                }

                function search() {
                    var entity = selected_entity; 
                    var searchQuery = document.getElementById('searchBox').value;
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                        }
                    };
                    xhttp.open("GET", "fetch_data.php?entity=" + entity + "&search=" + searchQuery, true);
                    xhttp.send();
                }
                function confirmDelete(id, entity) {
                    Swal.fire({
                        title: "Are You Sure?",
                        text: "All the dependent entities will be set to inactive",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Action performed successfully",
                                icon: "success",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                var url = 'admin_delete.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent(entity);
                                window.location.href = url;
                            }, 2000);
                        }
                    });
                }
            </script>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>