<?php
// Assuming you have already established a MySQL connection
include 'database/config.php';
include 'database/opendb.php';

$entity = $_GET['entity'];
$search = $_GET['search'];

$query = "SELECT * FROM $entity";
if (!empty($search)) {
    if ($entity == "users") {
        $query .= " WHERE CONCAT(first_name, ' ', last_name, ' ', email, ' ', role, ' ', company_ID) LIKE '%$search%'";
    } else if ($entity == "companies") {
        $query .= " WHERE CONCAT(name, ' ', email) LIKE '%$search%'";
    } else if ($entity == "structures") {
        $query .= " WHERE CONCAT(name, ' ', company_ID) LIKE '%$search%'";
    } else if ($entity == "departures") {
        $query .= " WHERE CONCAT(name, ' ', company_ID, structure_ID) LIKE '%$search%'";
    }
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    while ($fieldinfo = mysqli_fetch_field($result)) {
        echo '<th>' . $fieldinfo->name . '</th>';
    }

    echo '<th>Actions</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        foreach ($row as $key => $value) {
            if ($key == 'IS_ACTIVE') {
                echo $value == 1 ? '<td><span class="badge bg-success">Active</span></td>' :
                    '<td><span class="badge bg-danger">Inactive</span></td>';
            } else {
                echo '<td>' . $value . '</td>';
            }
        }

        echo '<td><a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<a class="btn btn-danger">Delete</a></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<div class="col-12">
        <div class="card-header"><div style="height: 30px; font-size:20px; text-align:center; background-color: #fed48b; color: #d98b19; font-weight:bold" class="alert alert-danger" role="alert">No Data Found</div>                                                    </div>
        </div>';
}

mysqli_free_result($result);
include 'database/closedb.php';
?>