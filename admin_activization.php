<?php

$id = $_GET['id'];
$entity = $_GET['entity'];

include 'database/config.php';
include 'database/opendb.php';

if ($entity == 'users') {
    $sql = "SELECT c.IS_ACTIVE 
        FROM USERS u
        JOIN COMPANIES c on u.COMPANY_ID = c.COMPANY_ID
        WHERE u.USER_ID = ?
        LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE " . $entity .
        " SET IS_ACTIVE = 1 
                    WHERE USER_ID = ?";
} else if ($entity == "structures") {
    $sql = "SELECT c.IS_ACTIVE 
                FROM STRUCTURES s
                JOIN COMPANIES c on s.COMPANY_ID = c.COMPANY_ID
                WHERE s.STRUCTURE_ID = ?
                LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE " . $entity .
        " SET IS_ACTIVE = 1 
                    WHERE STRUCTURE_ID = ?";
} else if ($entity == "departments") {
    $sql = "SELECT c.IS_ACTIVE 
                FROM DEPARTMENTS d
                JOIN COMPANIES c on d.COMPANY_ID = c.COMPANY_ID
                WHERE d.DEPARTMENT_ID = ?
                LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive1);

    $stmt->fetch();
    $stmt->close();

    $sql = "SELECT c.IS_ACTIVE 
                FROM DEPARTMENTS d
                JOIN STRUCTURES s on s.COMPANY_ID = d.COMPANY_ID
                WHERE d.DEPARTMENT_ID = ?
                LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive2);

    $stmt->fetch();
    $stmt->close();

    if ($isActive1 == 1 && $isActive2 == 1) {
        $isActive = 1;
        $update = "UPDATE " . $entity .
            " SET IS_ACTIVE = 1 
                        WHERE DEPARTMENT_ID = ?";
    } else {
        $isActive = 0;
    }
} else {
    $isActive = 1;
    $update = "UPDATE " . $entity .
                " SET IS_ACTIVE = 1 
                WHERE COMPANY_ID = ?";
}

if ($isActive == 0) {
    include 'database/closedb.php';

    echo '<script>
            Swal.fire({
                title: "Error",
                text: "The parent entity is inactive. You need to make the parent entity active to use this command.",
                icon: "error",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "admin_display_entities.php";
                    window.location.href = url;   
                }
            });
    </script>';
} else {
    $stmt = $conn->prepare($update);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $stmt->close();

    include 'database/closedb.php';

    echo '<script>
    Swal.fire({
        title: "Activated!",
        text: "The entity is set to active",
        icon: "success",
        showCancelButton: false,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            var url = "admin_display_entities.php";
            window.location.href = url;        
        }
    });
</script>
';
}