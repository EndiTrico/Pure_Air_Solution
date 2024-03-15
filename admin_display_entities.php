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

    <title>Visualizza Entità</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <!--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>

    <style>
        .current {
            background-color: whitesmoke !important;
            border: none !important;
        }

        option {
            text-align: center;
        }

        th,
        td,
        tr {
            text-align: center !important;
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

        .button-row {
            display: flex;
            flex-direction: row;
            margin-bottom: 10px;
        }

        .button {
            padding: 10px 20px;
            margin: 0 5px;

        }


        *,
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        .modal {
            position: absolute;
            z-index: 10000;
            top: 0;
            left: 0;
            visibility: hidden;
            width: 100%;
            height: 100%;
        }

        .modal.is-visible {
            visibility: visible;
        }

        .modal-overlay {
            position: fixed;
            z-index: 10;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: hsla(0, 0%, 0%, 0.5);
            visibility: hidden;
            opacity: 0;
            transition: visibility 0s linear 0.3s, opacity 0.3s;
        }

        .modal.is-visible .modal-overlay {
            opacity: 1;
            visibility: visible;
            transition-delay: 0s;
        }

        .modal-wrapper {
            position: absolute;
            z-index: 9999;
            top: 6em;
            left: 50%;
            width: 32em;
            margin-left: -16em;
            background-color: #fff;
            box-shadow: 0 0 1.5em hsla(0, 0%, 0%, 0.35);
        }

        .modal-transition {
            transition: all 0.3s 0.12s;
            transform: translateY(-10%);
            opacity: 0;
        }

        .modal.is-visible .modal-transition {
            transform: translateY(0);
            opacity: 1;
        }

        .modal-header,
        .modal-content {
            padding: 1em;
        }

        .modal-header {
            position: relative;
            background-color: #fff;
            box-shadow: 0 1px 2px hsla(0, 0%, 0%, 0.06);
            border-bottom: 1px solid #e8e8e8;
        }

        .modal-close {
            position: absolute;
            top: 0;
            right: 0;
            padding: 1em;
            color: #aaa;
            background: none;
            border: 0;
        }

        .modal-close:hover {
            color: #777;
        }

        .modal-heading {
            font-size: 1.125em;
            margin: 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        .modal-content>*:first-child {
            margin-top: 0;
        }

        .modal-content>*:last-child {
            margin-bottom: 0;
        }
    </style>

</head>

<body>
    <div class="wrapper">
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Visualizza Entità</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('utenti')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Utenti
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('aziende')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Aziende
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('strutture')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Strutture
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('reparti')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Reparti
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('banca conti')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Banca Conti</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('fatture')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Fatture
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a id="mybtn" onclick="fetchData('impianti')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Mostra Impianti
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12 col-lg-12">
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
                $(document).ready(function () {
                    $('#fetchTable').DataTable({
                        language: {
                            "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Italian.json"
                        }
                    });
                });

                function fetchData(entity) {
                    var xhttp = new XMLHttpRequest();
                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                            $('#fetchTable').DataTable({
                                language: {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Italian.json"
                                },
                                destroy: true
                            });
                        }
                    };
                    xhttp.open("GET", "fetch_data.php?entity=" + entity, true);
                    xhttp.send();
                }


                function confirmDelete(id, entity) {
                    Swal.fire({
                        title: "Sei Sicuro?",
                        text: "Tutte le entità dipendenti verranno impostate su inattive",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Eliminato!",
                                text: "Azione eseguita con successo",
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

                function confirmActivation(id, entity) {
                    Swal.fire({
                        title: "Sei Sicuro?",
                        text: "Tutte le Entità Principali Devono Essere Attive",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var xhr = new XMLHttpRequest();

                            xhr.open('GET', 'admin_activization.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent(entity));

                            xhr.onload = function () {
                                if (xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);

                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: "Attivato!",
                                            text: "L'entità è Impostata su Attiva",
                                            icon: "success",
                                            showConfirmButton: false
                                        });
                                        setTimeout(function () {
                                            var url = "admin_display_entities.php";
                                            window.location.href = url;
                                        }, 2000);
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: "The parent entity is inactive. You need to make the parent entity active to use this command.",
                                            icon: "error",
                                            showConfirmButton: false
                                        });
                                        setTimeout(function () {
                                            var url = "admin_display_entities.php";
                                            window.location.href = url;
                                        }, 2000);
                                    }
                                }
                            };

                            xhr.send();
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