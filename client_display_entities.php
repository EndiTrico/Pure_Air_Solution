<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

include 'database/closedb.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <title>Display Entities</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        #searchBox {
            border-radius: 50px;
            margin-left: 65%;
            width: 80%;
            display: none;
        }

        .badge-success-custom {
            background-color: #28a745;
            color: #fff;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 999px;
        }

        .badge-danger-custom {
            background-color: #dc3545;
            color: #fff;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 999px;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <?php include "client_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "client_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Display Entities</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('UTENTI')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    UTENTI</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('STRUTTURE')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    STRUTTURE</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('REPARTI')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Display
                                                    REPARTI</a>
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
            </script>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>