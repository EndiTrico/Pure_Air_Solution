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

    <title>PAS</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <link href="css/app.css" rel="stylesheet">

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
            border-bottom: 10px solid whitesmoke;
            border-top: 2px solid whitesmoke;
            border-right: 2px solid whitesmoke;
            border-left: 2px solid whitesmoke;
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
            padding: 0.7em 0;
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="wrapper">
        <?php include "employee_verticalNavBar.php"; ?>
        <div class="main">
            <?php include "employee_horizontalNavBar.php"; ?>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-12 col-lg-6 d-flex justify-content-center">
                                            <div class="card-header">
                                                <br><br>
                                                <h1 class="welcome-msg" style="margin-top: 80px">Dipendente</h1>
                                                <h1 class="welcome-msg" style="margin-top: 50px">
                                                    <?php echo fullName() ?>
                                                </h1>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 d-flex justify-content-center">
                                            <div class="card-header">
                                                <img style="height: 400px;" src="images/logo/medium_logo.png">
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
    <script>
        function showCount() {
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

        showCount();
    </script>
</body>

</html>