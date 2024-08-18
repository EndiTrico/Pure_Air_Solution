<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';
include 'fetch_companies.php';

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

    <title>Rapporti</title>

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






        .drop-zone {
            border: dashed 2px #1d3b55;
            border-radius: 5px;
            padding: 20px;
            color: #1d3b55;
            text-align: center;
            margin: 10px 0;
            cursor: pointer;
        }

        .drop-zone:hover {
            background-color: #1d3b55;
            color: white;
            font-weight: bold;

        }

        #file-upload {
            display: none;
        }

        .file-info {
            font-size: 0.85rem;
            color: #666;
            margin-top: 10px;
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

                    <h1 class="h3 mb-3">Visualizza Rapporti</h1>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-6">
                                            <div class="card-header">
                                                <a onclick="loadDirectory('pas')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Cartelle</a>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div class="card-header">
                                                <a onclick="fetchData('documenti')"
                                                    class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                    style="font-weight: bold;">Tabella</a>
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

                window.onload = function () {
                    const urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('load') && urlParams.has('path')) {
                        const path = urlParams.get('path');
                        loadDirectory(path);
                    }
                };

                function loadDirectory(path) {
                    var xhttp = new XMLHttpRequest();

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                        } else if (this.readyState == 4) {
                            alert('Errore durante il recupero delle cartelle');
                        }
                    };

                    xhttp.open("GET", "fetch_directories.php?path=" + encodeURIComponent(path), true);
                    xhttp.send();
                }

                $(document).ready(function () {
                    $(document).on('click', 'button.folder', function (event) {
                        event.preventDefault();
                        var path = $(this).data('path');
                        loadDirectory(path);
                    });

                });

                function fetchData(entity) {
                    var xhttp = new XMLHttpRequest();
                    var table;

                    xhttp.onreadystatechange = function () {
                        if (this.readyState == 4 && this.status == 200) {
                            document.getElementById("tableContainer").innerHTML = this.responseText;
                            table = $('#fetchTable').DataTable({
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
                                        if (i !== $(this).siblings().length && title !== "Azioni") {
                                            var title = $(this).text();
                                            var input = $('<input type="text" style = "text-align: center;" placeholder="Cerca ' + title + '" />').appendTo($(this).empty());

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

                function filterWithDate(table) {
                    var caricamentoColIdx = table.column(':contains("Data Caricamento")').index();
                    var cancellataColIdx = table.column(':contains("Data Cancellata")').index();

                    $.fn.dataTable.ext.search.push(
                        function (settings, data, dataIndex) {
                            var minCaricamento = $('#minCaricamento').val();
                            var maxCaricamento = $('#maxCaricamento').val();
                            var minCancellata = $('#minCancellata').val();
                            var maxCancellata = $('#maxCancellata').val();

                            var dataCaricamento = data[caricamentoColIdx];
                            var dataCancellata = data[cancellataColIdx];

                            dataCaricamento = dataCaricamento ? new Date(dataCaricamento) : null;
                            dataCancellata = dataCancellata ? new Date(dataCancellata) : null;

                            minCaricamento = minCaricamento ? new Date(minCaricamento) : null;
                            maxCaricamento = maxCaricamento ? new Date(maxCaricamento) : null;
                            minCancellata = minCancellata ? new Date(minCancellata) : null;
                            maxCancellata = maxCancellata ? new Date(maxCancellata) : null;

                            if (
                                (
                                    (minCaricamento === null || (dataCaricamento !== null && dataCaricamento >= minCaricamento)) &&
                                    (maxCaricamento === null || (dataCaricamento !== null && dataCaricamento <= maxCaricamento))
                                )

                                &&

                                (
                                    (minCancellata === null || (dataCancellata !== null && dataCancellata >= minCancellata)) &&
                                    (maxCancellata === null || (dataCancellata !== null && dataCancellata <= maxCancellata))
                                )
                            ) {
                                return true;
                            }

                            return false;
                        }
                    );

                    $('#minCaricamento, #maxCaricamento, #minCancellata, #maxCancellata').change(function () {
                        table.draw();
                    });

                    flatpickr("#minCaricamento, #maxCaricamento, #minCancellata, #maxCancellata", {
                        locale: 'it',
                        dateFormat: "Y-m-d"
                    });
                }

                function confirmDeleteFolder(id) {
                    const htmlText = '<h4>Tutte le Cartelle e Documenti Dipendenti Verranno Rimossi</h4>';

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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Eliminato!",
                                text: "Azione eseguita con successo",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                var url = 'admin_delete.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent("cartelle");
                                window.location.href = url;
                            }, 2000);
                        }
                    }).catch((error) => {
                        console.error("Errore durante la finestra di dialogo di conferma:", error);
                    });
                }

                function confirmDeleteFile(id, name) {
                    const htmlText = '<h4>Il documento, <b>' + name + '</b> verrà eliminato per sempre</h4>';

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
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: "Eliminato!",
                                text: "Azione eseguita con successo",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: false
                            });
                            setTimeout(function () {
                                var url = 'admin_delete.php?id=' + encodeURIComponent(id) + '&entity=' + encodeURIComponent("documenti");
                                window.location.href = url;
                            }, 2000);
                        }
                    }).catch((error) => {
                        console.error("Errore durante la finestra di dialogo di conferma:", error);
                    });
                }


                function confirmRenameFolder(currentPath) {
                    const htmlContent = `<p style="margin-top: 20px;">Inserisci il nuovo nome della cartella esistente:</p>
                                        <input id="newFolderName" class="swal2-input" placeholder="Nuovo nome della cartella">`;

                    Swal.fire({
                        title: "Rinomina Cartella",
                        html: htmlContent,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Chiudi",
                        confirmButtonText: "Rinominare",
                        preConfirm: () => {
                            const newFolderName = document.getElementById('newFolderName').value;
                            if (!newFolderName) {
                                Swal.showValidationMessage("Inserisci un Nome di Cartella Valido");
                                return false;
                            }
                            return newFolderName;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            renameFolder(result.value, currentPath);
                        }
                    });
                }


                function renameFolder(newFolderName, currentPath) {

                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'validate_rename_folder.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function () {
                        var data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            Swal.fire({
                                title: "Rinominato!",
                                text: "La tua cartella è stata rinominata",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `admin_display_reports.php?load=true&path=${encodeURIComponent(data.newPath)}`;
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Errore",
                                text: "Impossibile rinominare la cartella: " + data.message,
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: true
                            });
                        }

                    };

                    xhr.send('folderName=' + encodeURIComponent(newFolderName) + '&currentPath=' + encodeURIComponent(currentPath));
                }


                function confirmNewFolder(currentPath) {
                    const htmlContent = `<p style="margin-top: 20px;">Inserisci il nome della nuova cartella:</p>
                                        <input id="createFolderName" class="swal2-input" placeholder="Nome della nuova cartella">`;

                    Swal.fire({
                        title: "Nuova Cartella",
                        html: htmlContent,
                        focusConfirm: false,
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: "Chiudi",
                        confirmButtonText: "Crea",
                        preConfirm: () => {
                            const createFolderName = document.getElementById('createFolderName').value;
                            if (!createFolderName) {
                                Swal.showValidationMessage("Inserisci il nome della nuova cartella");
                                return false;
                            }
                            return createFolderName;
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            newFolder(result.value, currentPath);
                        }
                    });
                }


                function newFolder(newFolderName, currentPath) {
                    var fullPath = currentPath.replace(/\/$/, '');
                    var parentPath = fullPath.substring(0, fullPath.lastIndexOf('/'));
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'validate_new_folder.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                    xhr.onload = function () {
                        var data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            Swal.fire({
                                title: "Creata!",
                                text: "La tua cartella è stata creata",
                                icon: "success",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `admin_display_reports.php?load=true&path=${encodeURIComponent(currentPath)}`;
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Errore",
                                text: "Impossibile creare la cartella: " + data.message,
                                icon: "error",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: true
                            });
                        }

                    };

                    xhr.send('folderName=' + encodeURIComponent(newFolderName) + '&currentPath=' + encodeURIComponent(currentPath));
                }

                function confirmUploadFile(currentPath) {
                    Swal.fire({
                        title: 'Carica',
                        html: `
                                <div style="text-align: center;">
                                    I file verranno caricati qui: <strong>`+ currentPath + `</strong><br>
                                    Inserisci i file tramite trascinamento, oppure fai clic su "Seleziona il Documento".
                                    
                                    <div class="drop-zone" onclick="document.getElementById('file-upload').click()">
                                        Seleziona il Documento
                                        <input type="file" id="file-upload" multiple onchange="updateFileList(this.files)">
                                    </div>
                                    <div class="row" style="align-items: center; justify-content: center; margin-top: 20px;">
                                        <div class="col-sm-6">
                                            <div class="card-title">
                                                Azienda<span style="color:red;">*</span>
                                            </div>
                                            <div>
                                               <?php echo showCompanyName() ?>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="card-title">
                                                Struttura<span style="color:red;">*</span>
                                            </div>
                                            <div>
                                                <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                                                    <option disable selected value="">Seleziona una
                                                    Struttura</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="file-info" id="file-info"></div>
                                </div>
                            `,
                        showConfirmButton: true,
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        cancelButtonText: 'Chiudi',
                        confirmButtonText: 'Carica',
                        width: 800,
                        preConfirm: () => {
                            let azienda = document.getElementById('company-dropdown').value;
                            let struttura = document.getElementById('structure_name').value;
                            let fileInfo = document.getElementById('file-info');

                            if (fileInfo.innerHTML.includes('File Selezionato:') === false) {
                                Swal.showValidationMessage("Per favore, seleziona almeno un file.");
                                return false;
                            } else if (!azienda || azienda === "" || !struttura || struttura === "") {
                                Swal.showValidationMessage("Per favore, seleziona sia un'azienda che una struttura.");
                                return false;
                            }

                            return uploadFiles(currentPath, azienda, struttura);
                        }
                    });
                }

                function updateFileList(files) {
                    const fileInfo = document.getElementById('file-info');
                    fileInfo.innerHTML = '<strong>File Selezionato:</strong>';
                    Array.from(files).forEach(file => {
                        fileInfo.innerHTML += `<div>${file.name}</div>`;
                    });
                }

                function uploadFiles(currentPath, aziendaID, strutturaID) {
                    const files = document.getElementById('file-upload').files;
                    const formData = new FormData();
                    formData.append('uploadPath', currentPath);
                    formData.append('aziendaID', aziendaID);
                    formData.append('strutturaID', strutturaID);
                    for (let i = 0; i < files.length; i++) {
                        formData.append('filesToUpload[]', files[i]);
                    }

                    fetch('validate_upload_file.php', {
                        method: 'POST',
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            let message = data.map(item => {
                                if (item.status === 'success') {
                                    return `<div style="color: green; font-weight: bold;">${item.name}: ${item.message}</div>`;
                                } else {
                                    return `<div style="color: red; font-weight: bold;">${item.name}: ${item.message}</div>`;
                                }
                            }).join('<br>');
                            Swal.fire({
                                title: "Risultati Caricati",
                                html: message,
                                icon: "info",
                                confirmButtonColor: "#3085d6",
                                showConfirmButton: true
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = `admin_display_reports.php?load=true&path=${encodeURIComponent(currentPath)}`;
                                }
                            });
                        })
                        .catch(error => console.error('Errore:', error));
                }
                $(document).on('change', '#company-dropdown', function () {
                    var companyID = $(this).val();
                    var post_id = 'id=' + companyID;
                    $.ajax({
                        type: "POST",
                        url: "fetch_structures.php",
                        data: post_id,
                        cache: false,
                        success: function (response) {
                            $("#structure_name").html(response);
                        },
                        error: function (xhr, status, error) {
                            console.error("Errore nella richiesta AJAX:", xhr.responseText);
                        }
                    });
                });


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