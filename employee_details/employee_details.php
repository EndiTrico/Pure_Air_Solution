<?php
include '../nas/credentials.php';

$id = $_GET['id'];

function remoteFileExists($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Ignore SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Ignore SSL host verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, value: 5);
    curl_exec($ch);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

   //     echo "CURL ERROR: $curlError";
    return ($httpCode >= 200 && $httpCode < 400); 
}


function getImageURL($id)
{
    include '../database/config.php';
    include '../database/opendb.php';
    include '../nas/credentials.php';

    $nasDirectory = $baseUrlForImage . '/' . $imageRootPath;
    $query = "SELECT * FROM DIPENDENTI WHERE DIPENDENTE_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute(statement: $stmt);
    $result = mysqli_stmt_get_result($stmt);

    $imageURL = '';

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $imageName = $row['FOTOGRAFIA'] ?? '';

        if (empty($imageName)) {
            $imageURL = $nasDirectory . '/' . $defaultImage;
        } else {
            $nasFile = $nasDirectory . '/' . $imageName;
            if (!remoteFileExists($nasFile)) {
                $imageURL = $nasDirectory . '/' . $defaultImage;
              	echo 'INSIDE;';
            } else {
                $imageURL = $nasFile;
            }
        }
    }

    include '../database/closedb.php';

    return $imageURL; 
}

function showForm($id)
{
    include '../database/config.php';
    include '../database/opendb.php';
    include '../nas/credentials.php';

    $query = "SELECT * FROM DIPENDENTI WHERE DIPENDENTE_ID = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        include 'display_employee_details.php';

        showEmployees($row);
    }

    include '../database/closedb.php';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Dipendenti</title>
    <link href="../css/app.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="wrapper">
        <div class="main">
            <nav class="navbar navbar-expand navbar-light navbar-bg" style="height:62px">
                <h1 style="margin-top: 8px; color: #648cb0; font-weight: bold">Pure Air Solutions</h1>
            </nav>

            <main class="content">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <form id="userForm" method="post">
                                        <div class="row">
                                            <div class="col-12 col-lg-4">
                                                <h5 class="card-title mb-0" style="text-align:center;
                                                            font-size: 50px;
                                                            font-weight:bold;
                                                            margin-top: 37px;">
                                                </h5>

                                                <?php $imageURL = getImageURL($id); ?>

                                                <div style="display: flex; justify-content: center; align-items: center;">
                                                    <img src="<?php echo htmlspecialchars($imageURL, ENT_QUOTES, 'UTF-8'); ?>" 
                                                        alt="User Avatar" 
                                                        style="width: 400px; height: 400px; border-radius: 50%; object-fit: cover;">
                                                </div>
                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <?php showForm($id); ?> <!-- Only calling the form once -->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <?php include "../footer.php"; ?>
        </div>
    </div>
    <script src="../js/app.js"></script>
</body>
</html>
