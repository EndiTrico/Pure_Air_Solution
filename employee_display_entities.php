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
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

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
    <script type="text/javascript"
        src="https://cdn.datatables.net/fixedheader/3.1.7/js/dataTables.fixedHeader.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css">
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
            font-weight:bold;
        }

        .badge-danger-custom {
            background-color: #dc3545;
            color: #fff;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 999px;
            font-weight:bold;
        }
      
   	   .badge-warning-custom {
            background-color: #ffc107;
            color: #fff;
            font-size: 14px;
            padding: 5px 10px;
            border-radius: 999px;
         	font-weight:bold;
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
        <?php include "employee_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "employee_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Visualizza Entità</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
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
                $(document).ready(function() {
                    fetchData('registro_lavori'); // Replace with your desired entity
                });

                function fetchData(entity) {
                    var xhttp = new XMLHttpRequest();

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;

                            var table = $('#fetchTable').DataTable({
                                language: {
                                    "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Italian.json"
                                },
                                destroy: true,
                                orderCellsTop: true,
                                fixedHeader: false,
                                initComplete: function () {
                                    var api = this.api();

                                    var clonedRow = $('#fetchTable thead tr').clone(true).appendTo('#fetchTable thead').addClass('filters');

                                    clonedRow.find('th').each(function () {
                                        $(this).removeClass('sorting sorting_asc sorting_desc');
                                        $(this).css('pointer-events', 'auto');
                                        $(this).off('click.DT');
                                    });

                                    clonedRow.find('th').each(function (i) {
                                        var title = $(this).text();
                                        if (i !== $(this).siblings().length && title !== "Azioni") {
                                            var input = $('<input type="text" style="text-align: center;" placeholder="Cerca ' + title + '" />').appendTo($(this).empty());

                                            input.on('keyup change', function () {
                                                if (table.column(i).search() !== this.value) {
                                                    table.column(i).search(this.value).draw();
                                                }
                                            });
                                        } else {
                                            $(this).empty().html('&nbsp;');
                                        }
                                    });
                                },
                                columnDefs: [{
                                    targets: 0,
                                    visible: true
                                }]
                            });

                            filterWithDate(table);
                        }
                    };

                    xhttp.open("GET", "fetch_data.php?entity=" + entity, true);
                    xhttp.send();
                }

                function editEntity(id, entity) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('GET', `admin_edit.php?id=${encodeURIComponent(id)}&entity=${encodeURIComponent(entity)}`);
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            window.location.href = 'admin_edit.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent(entity);
                        } else {
                            console.error('Request failed with status code ' + xhr.status);
                        }
                    };
                    xhr.onerror = function () {
                        console.error('Network Error');
                    };

                    xhr.send();
                }

                function filterWithDate(table) {
                    var inizioColIdx = table.column(':contains("Data del Lavoro")').index();
                    var fineColIdx = table.column(':contains("Data Creato")').index();

                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var minLavoro = $('#minInizio').val();
                            var maxLavoro = $('#maxInizio').val();
                            var minCreato = $('#minFine').val();
                            var maxCreato = $('#maxFine').val();

                            var dataInizio = data[inizioColIdx];
                            var dataFine = data[fineColIdx];

                            dataInizio = dataInizio ? new Date(dataInizio) : null;
                            dataFine = dataFine ? new Date(dataFine) : null;

                            minLavoro = minLavoro ? new Date(minLavoro) : null;
                            maxLavoro = maxLavoro ? new Date(maxLavoro) : null;
                            minCreato = minCreato ? new Date(minCreato) : null;
                            maxCreato = maxCreato ? new Date(maxCreato) : null;

                            if (
                                (
                                    (minLavoro === null || (dataInizio !== null && dataInizio >= minLavoro)) &&
                                    (maxLavoro === null || (dataInizio !== null && dataInizio <= maxLavoro))
                                )

                                &&

                                (
                                    (minCreato === null || (dataFine !== null && dataFine >= minCreato)) &&
                                    (maxCreato === null || (dataFine !== null && dataFine <= maxCreato))
                                )
                            ) {
                                return true;
                            }
                            return false;
                        }
                    );

                    $('#minLavoro, #maxLavoro, #minCreato, #maxCreato').change(function () {
                        table.draw();
                    });

                    flatpickr("#minLavoro, #maxLavoro, #minCreato, #maxCreato", {
                        locale: 'it',
                        dateFormat: "Y-m-d"
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