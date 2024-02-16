<?php
include 'database/config.php';
include 'database/opendb.php';

//if (!empty($_POST["STRUCTURE_ID"])) {
    // Fetch city data based on the specific state 
    $query = "SELECT * FROM structures WHERE STRUCTURE_ID = " . $_POST['STRUCTURE_ID'] . " ";
    $result = mysqli_query($conn,$sql);

    // Generate HTML of city options list 
    if ($result->num_rows > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['STRUCTURE_ID'] . '">' . $row['NAME'] . '</option>';
        }
    } else {
        echo '<option value="">Structures Not Available</option>';
    }
//}
include 'database/closedb.php';
