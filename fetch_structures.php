<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_POST["id"];

if (!empty($id)) {
    $query = "SELECT STRUTTURA_ID, NAME FROM STRUTTURE WHERE AZIENDA_ID = ?";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['STRUTTURA_ID'] . '">' . $row['NAME'] . '</option>';
        }
    } else {
        echo '<option disabled selected value="">STRUTTURE Not Available</option>';
    }
}

include 'database/closedb.php';
