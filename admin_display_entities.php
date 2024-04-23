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


    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js">
    </script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-BTBZNOArLzKrjzlkrMgXw0S51oBnuy0/HWkCARN0aSUSnt5N6VX/9n6tsQwnPVK68OzI6KARmxx3AeeBfM2y+g==" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        #datepicker {
            display: inline-block;
        }

        .current {
            background-color: whitesmoke !important;
            border: none !important;
        }

        option {
            text-align: center;
        }

        .swal2-overflow {
            overflow-x: visible;
            overflow-y: visible;
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
                                                <a onclick="fetchData('utenti')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Utenti
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('aziende')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Aziende
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('strutture')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Strutture
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3">
                                            <div class="card-header">
                                                <a onclick="fetchData('reparti')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Reparti
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('banca conti')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Banca Conti</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a onclick="fetchData('fatture')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Fatture
                                                </a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4">
                                            <div class="card-header">
                                                <a id="mybtn" onclick="fetchData('impianti')" class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center" style="font-weight: bold;">Mostra Impianti
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
                function fetchData(entity) {
                    var xhttp = new XMLHttpRequest();
                    var table;

                    xhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                            table = $('#fetchTable').DataTable({
                                language: {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Italian.json"
                                },
                                destroy: true,
                                orderCellsTop: true,
                                fixedHeader: false,
                                initComplete: function() {
                                    var api = this.api();

                                    var clonedRow = $('#fetchTable thead tr').clone(true).appendTo('#fetchTable thead').addClass('filters');

                                    clonedRow.find('th').each(function() {
                                        $(this).removeClass('sorting sorting_asc sorting_desc');
                                        $(this).css('pointer-events', 'auto');
                                        $(this).off('click.DT');
                                    });

                                    clonedRow.find('th').each(function(i) {
                                        var title = $(this).text();
                                        var input = $('<input type="text" style = "text-align: center;" placeholder="Cerca ' + title + '" />').appendTo($(this).empty());

                                        input.on('keyup change', function() {
                                            if (table.column(i).search() !== this.value) {
                                                table.column(i).search(this.value).draw();
                                            }
                                        });
                                    });
                                },
                                columnDefs: [{
                                    targets: 0,
                                    visible: true
                                }]
                            });
                        }
                    };

                    xhttp.open("GET", "fetch_data.php?entity=" + entity, true);
                    xhttp.send();
                }

                function confirmDelete(id, entity) {
                    var htmlText = "";
                    if (entity != "fatture") {
                        htmlText = '<h4>Tutte le Entità Dipendenti Verranno Impostate su Inattive</h4><p style="margin-top: 20px;">Seleziona la data di fine</p><input id="datePicker1" class="swal2-input delete_date" style = "margin-top: -10px; height: 45px; text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 20px; background-color: white">';
                    }

                    Swal.fire({
                        title: "Sei Sicuro di Eliminare?",
                        html: htmlText,
                        focusConfirm: false,
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si",
                        preConfirm: () => {
                            if (entity != "fatture") {
                                const datePickerElement = document.getElementById("datePicker1");
                                if (datePickerElement) {
                                    const date = flatpickrInstance.selectedDates[0];
                                    if (!date) {
                                        Swal.showValidationMessage("Seleziona una Data!");
                                        return null;
                                    }
                                    return date.toISOString().substring(0, 10);
                                } 
                            }
                            return "";
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {

                            Swal.fire({
                                title: "Eliminato!",
                                text: "Azione eseguita con successo",
                                icon: "success",
                                showConfirmButton: false
                            });
                            setTimeout(function() {
                                var dateValue = result.value || ""

                                var url = 'admin_delete.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent(entity) + '&dateValue=' + encodeURIComponent(dateValue);
                                window.location.href = url;

                            }, 2000);
                        }
                    });

                    const flatpickrInstance = flatpickr("#datePicker1", {
                        locale: 'it',
                        defaultDate: new Date(),
                        dateFormat: "Y-m-d",
                    });
                }

                function confirmActivation(id, entity) {
                    var htmlText = "";
                    if (entity !== "fatture") {
                        htmlText = '<h4>Tutte le Entità Principali Devono Essere Attive</h4>';
                    } else {
                        htmlText = '<p style="margin-top: 20px;">Seleziona la Data di Pagamento</p><input id="datePicker2" class="swal2-input paid_date" style="margin-top: -10px; height: 45px; text-align: center; background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 20px; background-color: white">';
                    }

                    Swal.fire({
                        title: "Sei Sicuro di Attivarlo?",
                        html: htmlText,
                        focusConfirm: false,
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "No",
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si",
                        preConfirm: () => {
                            if (entity == "fatture") {
                                const datePickerElement = document.getElementById("datePicker2");
                                if (datePickerElement) {
                                    const date = flatpickrInstance.selectedDates[0];
                                    if (!date) {
                                        Swal.showValidationMessage("Seleziona una Data!");
                                        return null;
                                    }
                                    return date.toISOString().substring(0, 10);
                                }
                            }
                            return "";
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var xhr = new XMLHttpRequest();
                            var dateValue = result.value || ""

                            xhr.open('GET', `admin_activization.php?id=${encodeURIComponent(id)}&entity=${encodeURIComponent(entity)}&dateValue=${encodeURIComponent(dateValue)}`);

                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    var response = JSON.parse(xhr.responseText);
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            title: "Attivato!",
                                            text: "L'entità è Impostata su Attiva",
                                            icon: "success",
                                            showConfirmButton: false
                                        });
                                        setTimeout(function() {
                                            var url = "admin_display_entities.php";
                                            window.location.href = url;
                                        }, 2000);
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: response.message,
                                            icon: "error",
                                            showConfirmButton: false
                                        });
                                        setTimeout(function() {
                                            var url = "admin_display_entities.php";
                                            window.location.href = url;
                                        }, 2000);
                                    }
                                } else {
                                    console.error('HTTP Request Failed:', xhr.status, xhr.statusText);
                                }
                            };

                            xhr.onerror = function() {
                                console.error('Network Error');
                            };

                            xhr.send();
                        }
                    });

                    const flatpickrInstance = flatpickr("#datePicker2", {
                        locale: 'it',
                        defaultDate: new Date(),
                        dateFormat: "Y-m-d",
                    });
                }
            </script>
            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>

</body>

</html>