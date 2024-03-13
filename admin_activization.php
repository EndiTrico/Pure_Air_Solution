<?php

$id = $_GET['id'];
$entity = $_GET['entity'];

include 'database/config.php';
include 'database/opendb.php';

if ($entity == 'utenti') {
    $isActive = 1;
    $update = "UPDATE " . $entity .
        " SET E_ATTIVO = 1 
                WHERE UTENTE_ID = ?";
} else if ($entity == "strutture") {
    $sql = "SELECT c.E_ATTIVO 
            FROM STRUTTURE s
            JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID
            WHERE s.STRUTTURA_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE " . $entity .
        " SET E_ATTIVO = 1 
                WHERE STRUTTURA_ID = ?";
} else if ($entity == "reparti") {
    $sql = "SELECT c.E_ATTIVO 
            FROM REPARTI d
            JOIN AZIENDE c on d.AZIENDA_ID = c.AZIENDA_ID
            WHERE d.REPARTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive1);

    $stmt->fetch();
    $stmt->close();

    $sql = "SELECT s.E_ATTIVO 
            FROM REPARTI d
            JOIN STRUTTURE s on s.AZIENDA_ID = d.AZIENDA_ID
            WHERE d.REPARTO_ID = ?
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
            " SET E_ATTIVO = 1 
                    WHERE REPARTO_ID = ?";
    } else {
        $isActive = 0;
    }
} else if ($entity == "aziende") {
    $isActive = 1;

    $update = "UPDATE " . $entity .
        " SET E_ATTIVO = 1 
                WHERE AIENDA_ID = ?";
} else if ($entity == "banca conti") {
    $sql = "SELECT c.E_ATTIVO 
            FROM BANCA_CONTI s
            JOIN AZIENDE c on s.AZIENDA_ID = c.AZIENDA_ID
            WHERE s.BANCA_CONTO_ID = ?
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
    $stmt->bind_result($isActive);

    $stmt->fetch();
    $stmt->close();

    $update = "UPDATE " . $entity .
        " SET E_ATTIZVO = 1 
        WHERE BANCA_CONTO_ID = ?";
} else if ($entity == "fatture") {
    $isActive = 1;

    $update = "UPDATE " . $entity .
        " SET E_PAGATO = 1 
                WHERE FATTURA_ID = ?";
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
                confirmButtonText: "Si"
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
        confirmButtonText: "Si"
    }).then((result) => {
        if (result.isConfirmed) {
            var url = "admin_display_entities.php";
            window.location.href = url;        
        }
    });
</script>
';
}

header('Location: admin_display_entities.php');
exit();