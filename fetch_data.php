<?php
// Assuming you have already established a MySQL connection
include 'database/config.php';
include 'database/opendb.php';
session_start();

$entity = $_GET['entity'];
$search = $_GET['search'];

$query = "";

if ($entity == "users") {
    $query = "SELECT u.USER_ID, u.FIRST_NAME, u.LAST_NAME, u.EMAIL, u.ROLE, u.IS_ACTIVE, c.COMPANY_NAME 
                FROM USERS u
                JOIN COMPANIES c ON c.COMPANY_ID = u.COMPANY_ID";
} else if ($entity == "companies") {
    $query = "SELECT COMPANY_ID, COMPANY_NAME, EMAIL, DATE_JOINED, DATE_LEFT, IS_ACTIVE 
                FROM COMPANIES";
} else if ($entity == "structures") {
    $query = "SELECT s.STRUCTURE_ID, s.STRUCTURE_NAME, s.IS_ACTIVE, c.COMPANY_NAME
                FROM STRUCTURES s
                JOIN COMPANIES c on s.COMPANY_ID = c.COMPANY_ID";
} else if ($entity == "departments") {
    $query = "SELECT d.DEPARTMENT_ID, d.DEPARTMENT_NAME, d.IS_ACTIVE, s.STRUCTURE_NAME, c.COMPANY_NAME
                FROM DEPARTMENTS d 
                JOIN STRUCTURES s ON d.STRUCTURE_ID = s.STRUCTURE_ID
                JOIN COMPANIES c on d.COMPANY_ID = c.COMPANY_ID";
}

if (!empty($search)) {
    if ($entity == "users") {
        $query .= " WHERE CONCAT(u.FIRST_NAME, ' ', u.LAST_NAME, ' ', u.EMAIL, ' ', u.ROLE, ' ', c.COMPANY_NAME) LIKE '%$search%'";
    } else if ($entity == "companies") {
        $query .= " WHERE CONCAT(COMPANY_NAME, ' ', EMAIL) LIKE '%$search%'";
    } else if ($entity == "structures") {
        $query .= " WHERE CONCAT(s.STRUCTURE_NAME, ' ', c.COMPANY_NAME) LIKE '%$search%'";
    } else if ($entity == "departures") {
        $query .= " WHERE CONCAT(d.DEPARTMENT_NAME, ' ', s.STRUCTURE_NAME, ' ', c.COMPANY_NAME) LIKE '%$search%'";   
    }
}

if (!empty($_SESSION['company_ID'])) {
    $query .= " AND COMPANY_ID = " . $_SESSION["company_ID"];
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    echo '<div class="table-responsive">
            <table class="table text-center">
                <thead>
                    <tr>';
    $columnIndex = 0;

    while ($fieldinfo = mysqli_fetch_field($result)) {
        if ($fieldinfo->name === 'PASSWORD' || strpos(strtolower($fieldinfo->name), 'id')) {
            continue;
        }

        $fieldName = ucwords(str_replace('_', ' ', strtolower($fieldinfo->name)));
        echo '<th>' . $fieldName . '</th>';
    }

    if ($_SESSION['role'] == 'Admin') {
        echo '<th>Actions</th>';
    }
    echo '</tr>
            </thead>
                <tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        $is_active = 0;
        $is_admin = "";

        foreach ($row as $key => $value) {
            if ($key == 'IS_ACTIVE') {
                echo $value == 1 ? '<td><span class="badge-success-custom">Active</span></td>' :
                    '<td><span class="badge-danger-custom">Inactive</span></td>';
                $is_active = $value;
            } else if (strpos(strtolower($key), 'id')){
                continue;
            }else {
                echo '<td>' . $value . '</td>';
            }

            if ($key == 'ROLE') {
                $is_admin = $value;
            }
        }

        if ($_SESSION['role'] == 'Admin') {
            echo '<td><a href="admin_edit.php?id=' . reset($row) . '&entity=' . $entity . '" class="btn btn-warning">Edit</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            if ($is_active == 0 || ($is_admin == "Admin" && $entity == "users")) {
                echo '<button disabled class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Delete</button>';
            } else {
                echo '<button class="btn btn-danger" onclick="confirmDelete(' . reset($row) . ', \'' . $entity . '\')">Delete</button>';
            }
            echo '</td></tr>';
        }
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