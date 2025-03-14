<?php

function showCompaniesNameDropDown()
{
   include 'database/config.php';
    include 'database/opendb.php';
  
    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE WHERE E_ATTIVO = 1";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $companyDropDown .= '<option value="' . htmlspecialchars($row['AZIENDA_ID']) . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
   
    } else {
        $companyDropDown .= '<option disabled>Error fetching data</option>';
    }

    $companyDropDown .= '</select>';

    $stmt->close();
    
    include 'database/closedb.php';

    return $companyDropDown;
}


function showAllCompanies()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $companyDropDown = '<select class="form-select mb-3" name="company_name" required>';
    $companyDropDown .= '<option value="" disabled selected>Seleziona un\'Azienda</option>';

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE WHERE E_ATTIVO = 1";
    $stmt = $conn->prepare($query);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $companyDropDown .= '<option value="' . htmlspecialchars($row['AZIENDA_ID']) . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
   
    } else {
        $companyDropDown .= '<option disabled>Error fetching data</option>';
    }

    $companyDropDown .= '</select>';

    $stmt->close();
    
    include 'database/closedb.php';

    return $companyDropDown;
}
function showCompanyName()
{
    include 'database/config.php';
    include 'database/opendb.php';

    $query = "SELECT AZIENDA_ID, AZIENDA_NOME FROM AZIENDE WHERE E_ATTIVO = 1";
    $company = mysqli_query($conn, $query);

    $companyDropDown = "";

    $companyDropDown .= '<select class="form-select mb-3" name = "company_name" id="company-dropdown" required>';
    $companyDropDown .= '<option value="" disabled selected>Seleziona un\'Azienda</option>';

    if ($company) {
        while ($row = mysqli_fetch_assoc($company)) {
            $companyDropDown .= '<option value="' . $row['AZIENDA_ID'] . '">' . htmlspecialchars($row['AZIENDA_NOME']) . '</option>';
        }
    } else {
        $companyDropDown .= "Errore: " . mysqli_error($conn);
    }

    $companyDropDown .= '</select>';

    include 'database/closedb.php';

    return $companyDropDown;
}