<?php 
echo '
<form id="impiantoForm" method="post">
    <div class="row"             
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
        
                <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Azienda<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
            <select class="form-select mb-3" name = "company_name" id="company-dropdown" required>'
            . showCompaniesNameDropDown('impianti') . '</select>
                            </div>           
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Struttura<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                    <option disable selected value="">Seleziona una
                        Struttura</option> ' . showStructureDropDown("impianti") . '
                </select>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Reparto</h5>
            <div class="col-sm-4">
                <select name="department_name" id="department_name" class="form-control form-select mb-3" required>
                    <option disable selected value="">Seleziona un
                        Reparto</option> ' . showDepartmentDropDown("impianti") . '
                </select>
            </div>
        </div>
        
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Nome di Impianto<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="impianto_nome" placeholder="Nome" value="' . $row['IMPIANTO_NOME'] . '" required>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Capacita Uta<span style="color:red;">*</span>
            </h5>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="impianto_capacita_uta" name="impianto_capacita_uta" 
                value="' . $row['CAPACITA_UTA'] . '"placeholder="Capacita Uta" min=0 max=100000000000000000000000000 step="any" required>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">
                Mandata<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="impianto_mandata" name="impianto_mandata" 
                value="' . $row['MANDATA'] . '" placeholder="Mandata" min=0 max=100000000000000000000000000 step="any" required>
            </div>
        </div>
        
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Ripresa<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="impianto_ripresa" name="impianto_ripresa" 
                value="' . $row['RIPRESA'] . '" placeholder="Ripresa" min=0 max=100000000000000000000000000 step="any" required>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Presa Aria
                Esterna<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="impianto_presa_aria_esterna" name="impianto_presa_aria_esterna" 
                value="' . $row['PRESA_ARIA_ESTERNA'] . '" placeholder="Presa Aria Esterna" min=0 max=100000000000000000000000000 step="any" required>
            </div>
        </div>
        
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Espulsione<span style="color:red;">*</span></h5>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="impianto_espulsione" name="impianto_espulsione" 
                value="' . $row['ESPULSIONE'] . '"placeholder="Espulsione" min=0 max=100000000000000000000000000 step="any" required>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Tipologia Ultima Attivita
            </h5>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="impianto_ultima_attivita" 
                value="' . $row['ULTIMA_ATTIVITA'] . '"placeholder="Tipologia Ultima Attivita">
            </div>
        </div>
        
       <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data Ultima Att</h5>
            <div class="col-sm-4">
                <input readonly type="text" class="form-control" id="datePicker" name="impianto_data_ultima_att" 
                    value="' . $row['DATA_ULTIMA_ATT'] . '"placeholder="Data Ultima Att" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white;">
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data di Inizio</h5>
            <div class="col-sm-4">
                <input readonly type="text" class="form-control" id="datePicker" name="impianto_data_inizio" 
                    value="' . $row['DATA_INIZIO'] . '" placeholder="Data di Inizio" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white;">
            </div>
        </div>
        
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data di Fine</h5>
            <div class="col-sm-4">
                <input readonly type="text" class="form-control" id="datePicker" name="impianto_data_fine" 
                    value="' . $row['DATA_FINE'] . '" placeholder="Data di Fine" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white;">
            </div>
        </div>
        
    </div>
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            <button name="update_impianto" id="updateImpiantoButton" class="btn btn-success btn-lg">Aggiorna
                l\'Impianto</button>
        </div>
    </div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>
<script type="text/javascript">

    function capitalizeFirstLetter(word) {
        return word.charAt(0).toUpperCase() + word.slice(1);
    }
    
        $(document).ready(function() {
            $("#company-dropdown").change(function() {
                var companyID = $(this).val();
                var post_id = "id=" + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_structures.php",
                    data: post_id,
                    cache: false,
                    success: function(structure) {
                        $("#structure_name").html(structure);
                        $("#structure_name").trigger("change");
                    }
                });
            });
        });
        $(document).ready(function() {
            $("#structure_name").change(function() {
                var companyID = $(this).val();
                var post_id = "id=" + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_departments.php",
                    data: post_id,
                    cache: false,
                    success: function(department) {
                        $("#department_name").html(department);
                    }
                });
            });
        });
</script>';