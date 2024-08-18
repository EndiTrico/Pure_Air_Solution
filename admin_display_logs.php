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

    <title>Logs</title>

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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
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

        *,
        *:before,
        *:after {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
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

                    <h1 class="h3 mb-3">Visualizza Logs</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
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
                window.onload = function() {
                    fetchData('logs');
                }

                          
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

                            filterWithDate(table);
                        }
                    };

                    xhttp.open("GET", "fetch_data.php?entity=" + entity, true);
                    xhttp.send();
                }

                function filterWithDate(table) {
                    var dataOraColIdx = table.column(':contains("Data Ora")').index();

                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var minDataOra = $('#minDataOra').val();
                            var maxDataOra = $('#maxDataOra').val();
                            
                            var dataCaricamento = data[dataOraColIdx];

                            dataCaricamento = dataCaricamento ? new Date(dataCaricamento) : null;

                            minDataOra = minDataOra ? new Date(minDataOra) : null;
                            maxDataOra = maxDataOra ? new Date(maxDataOra) : null;


                            if (
                                (
                                    (minDataOra === null || (dataCaricamento !== null && dataCaricamento >= minDataOra)) &&
                                    (maxDataOra === null || (dataCaricamento !== null && dataCaricamento <= maxDataOra))
                                )
                            ) {
                                return true;
                            }

                            return false;
                        }
                    );

                    $('#minDataOra, #maxDataOra').change(function () {
                        table.draw();
                    });

                    flatpickr("#minDataOra, #maxDataOra", {
                        locale: 'it',
                        enableTime: true,
                        time_24hr: true,  
                        enableSeconds: true,
                        dateFormat: "Y-m-d H:i:S"
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