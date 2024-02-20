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
        $query .= " WHERE CONCAT(name, ' ', company_ID, ' ', structure_ID) LIKE '%$search%'";
    }
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo ' 
                <div class="table-responsive">
                    <table class="table text-center">
                        <thead>
                            <tr>';

    while ($fieldinfo = mysqli_fetch_field($result)) {
        if($fieldinfo->name == 'PASSWORD'){
            continue;
        }
        $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));
        echo '<th>' . $fieldName . '</th>';
    }

    echo '<th>Actions</th>
            </tr>
                </thead>
                    <tbody>';
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $is_active = 0;
        $is_admin = "Admin";
        foreach ($row as $key => $value) {
            if ($key == 'IS_ACTIVE') {
                echo $value == 1 ? '<td><span class="badge-success-custom">Active</span></td>' :
                    '<td><span class="badge-danger-custom">Inactive</span></td>';
                $is_active = $value;
            } else if ($key =="PASSWORD"){
                continue;
            }
            else {
                echo '<td>' . $value . '</td>';
            }
            if($key == 'ROLE'){
                $is_admin = $value;
            }
        }
        echo '<td><a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        
        if ($is_active == 0 || ($is_admin == "Admin" && $entity == "users")) {
            echo '<button disabled class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Delete</button>';
        } else {
            echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Delete</button>';
        }
        echo '</td></tr>';
    }
    echo '</tbody>';
    echo '</table></div>';
} else {
    echo '<div class="col-12">
            <div class="card-header"><div style="margin-top: -20px; padding-top: 8px; height: 40px; font-size:20px; text-align:center; background-color: #fed48b; color: #d98b19; font-weight:bold" class="alert alert-danger" role="alert">No Data Found</div>                                                    
            </div>
        </div>';
}

mysqli_free_result($result);
include 'database/closedb.php';