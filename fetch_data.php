<?php
// Assuming you have already established a MySQL connection
include 'database/config.php';
include 'database/opendb.php';

$entity = $_GET['entity'];
$search = $_GET['search'];

$query = "SELECT * FROM $entity";
if (!empty($search)) {
    // Assuming you sanitize the input to prevent SQL injection
    $query .= " WHERE first_name LIKE '%$search%'";
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    while ($fieldinfo = mysqli_fetch_field($result)) {
        echo '<th>' . $fieldinfo->name . '</th>';
    }
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $value) {
            echo '<td>' . $value . '</td>';
        }
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No data found</p>';
}

mysqli_free_result($result);
include 'database/closedb.php';
?>
