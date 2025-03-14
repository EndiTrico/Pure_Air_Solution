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

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="images/logo/small_logo.png" />

    <title>Crea Entità</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="wrapper">
        <?php include "admin_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "admin_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <h1 class="h3 mb-3">Crea Entità</h1>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_user.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Utente
                                                    </a>
                                                </div>
                                            </div>

                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_department.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Reparto
                                                    </a>
                                                </div>
                                            </div>
                                          
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_impianto.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Impianto
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class=" col-12 col-lg-4">
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_company.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Azienda
                                                    </a>
                                                </div>
                                            </div>

                                            <div class=" card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_bank_account.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Conto Bancario
                                                    </a>
                                                </div>
                                            </div>

                                            <div class=" card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_employee.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea un Dipendente
                                                    </a>
                                                </div>
                                            </div>
                                          
                                        </div>

                                        <div class=" col-12 col-lg-4">
                                            <div class="card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_structure.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea una Struttura
                                                    </a>
                                                </div>
                                            </div>

                                            <div class=" card w-100">
                                                <div class="card-header">
                                                    <a href="admin_create_bill.php"
                                                        class="btn btn-primary btn-lg btn-block text-center d-flex align-items-center justify-content-center"
                                                        style="font-size: 28px; height: 200px; font-weight: bold;">Crea una Fattura
                                                    </a>
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

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>