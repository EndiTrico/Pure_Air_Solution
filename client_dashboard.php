<?php
include 'auth_check.php';

include 'database/config.php';
include 'database/opendb.php';

function numberOfActiveEntitiesForClients($entity)
{
    include 'database/config.php';
    include 'database/opendb.php';
    
    $sql = "SELECT COUNT(*)
            FROM $entity
            WHERE E_ATTIVO = 1
                AND AZIENDA_ID = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
        
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $_SESSION['AZIENDA_ID']);

        mysqli_stmt_execute($stmt);
    
        mysqli_stmt_bind_result($stmt, $count);

        mysqli_stmt_fetch($stmt);
    
        include 'database/closedb.php';
        return $count;
    } else {
        include 'database/closedb.php';
        echo "<script>alert('Error occurred.')</script>";
        return -1;
    }

}


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

    <title>Welcome Client</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        .containercount {
            width: 28vmin;
            height: 28vmin;
            display: flex;
            align-items: center;
            flex-direction: column;
            justify-content: space-around;
            padding: 1em 0;
            position: relative;
            font-size: 16px;
            border-radius: 0.5em;
            background-color: #3f69a1;
            border-bottom: 10px solid lightgray;
            border-top: 2px solid lightgray;
            border-right: 2px solid lightgray;
            border-left: 2px solid lightgray;
            margin-left: 35px;
        }

        .containercount i {
            color: white;
            transform: scale(2);

        }

        span.num {
            color: white;
            display: grid;
            place-items: center;
            font-weight: 600;
            font-size: 3em;
            font-family: Verdana;
        }

        span.text {
            color: white;
            font-size: 1em;
            text-align: center;
            pad: 0.7em 0;
            font-weight: 400;
            line-height: 0;
            font-family: Verdana;
            font-weight: bold;
        }

        .center {
            display: flex;
            align-items: center;
        }

        .dashboard-title {
            font-size: 36px;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            color: #222e3c;
            margin-bottom: 40px;
        }

        .text-wrapper {
            text-align: center;
        }

        .welcome-msg {
            text-align: center;
            font-size: 36px;
            font-weight: bold;
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            color: #222e3c;
            font-style: italic;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6 .0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="wrapper">
        <?php include "client_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "client_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 d-flex justify-content-center">
                                            <div class="card-header">
                                                <h1 class="welcome-msg" style="margin-top: 80px">Welcome</h1>
                                                <h1 class="welcome-msg" style="margin-top: 50px">
                                                    <?php echo fullName() ?>
                                                </h1>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 d-flex justify-content-center">
                                            <div class="card-header">
                                                <img style="height: 300px;" src="img/client_dashboard.svg">
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-12 d-flex justify-content-center">
                                            <div class="card-header">
                                                <br><br>
                                                <h1 class="dashboard-title">Active Entities</h1>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 text-center text-md-left">
                                            <div class="containercount mx-auto">
                                                <i class="fa fa-UTENTI"></i>
                                                <span class="num"
                                                    data-val="<?php echo numberOfActiveEntitiesForClients('UTENTI'); ?>"></span>
                                                <div class="text-wrapper">
                                                    <span class="text">Active UTENTI</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 text-center text-md-left">
                                            <div class="containercount mx-auto">
                                                <i class="fa fa-cubes"></i>
                                                <span class="num"
                                                    data-val="<?php echo numberOfActiveEntitiesForClients('STRUTTURE'); ?>"></span>
                                                <div class="text-wrapper">
                                                    <span class="text">Active STRUTTURE</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-4 text-center text-md-left">
                                            <div class="containercount mx-auto">
                                                <i class="fa fa-sitemap"></i>
                                                <span class="num"
                                                    data-val="<?php echo numberOfActiveEntitiesForClients('REPARTI'); ?>"></span>
                                                <div class="text-wrapper">
                                                    <span class="text">Active REPARTI</span>
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

            <script>
                function showCountClient() {
                    var valueDisplays = document.querySelectorAll(".num");
                    var interval = 500;
                    valueDisplays.forEach((valueDisplay) => {
                        let startValue = 0;
                        let endValue = parseInt(valueDisplay.getAttribute("data-val"));
                        if (endValue != 0) {
                            let duration = Math.floor(interval / endValue);
                            let counter = setInterval(function () {
                                startValue += 1;
                                valueDisplay.textContent = startValue;
                                if (startValue == endValue) {
                                    clearInterval(counter);
                                }
                            }, duration);
                        } else {
                            valueDisplay.textContent = 0;
                        }
                    });
                }

                showCountClient();
            </script>

            <?php
            include "footer.php";
            ?>
        </div>
    </div>

    <script src="js/app.js"></script>

</body>

</html>