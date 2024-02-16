<?php
include 'database/config.php';
include 'database/opendb.php';

$id = $_POST["id"];

if (!empty($id)) {

    $query = "SELECT * FROM structures WHERE COMPANY_ID = '$id'";
    $result = mysqli_query($conn, $query);

    // Generate HTML of city options list 
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['STRUCTURE_ID'] . '">' . $row['NAME'] . '</option>';
        }
    } else {
        echo '<option disable selected value="" >Structures Not Available</option>';
    }
}
include 'database/closedb.php';
