<?php
function showDepartments($row, $id)
{
    $status = $row["E_ATTIVO"] == 1 ? 'ATTIVO' : 'INATTIVO';
    $color = $row["E_ATTIVO"] == 1 ? 'green' : 'red';

echo '
<form id="departmentForm" method="post">
        <div class="row"
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Nome</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="department_name" placeholder="Nome" value="' . $row['REPARTO_NOME'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Azienda
                    </h5>
                    <div class="col-sm-4">
                        <select disabled class="form-select mb-3" name = "company_name" id="company-dropdown" required>'
                            . showCompaniesNameDropDown('reparti') . '</select>                    
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Struttura
                    </h5>
                    <div class="col-sm-4">
                                                                    <select disabled name="structure_name" id="structure_name" class="form-select mb-3" required>
                                                                        <option disabled selected value="">Seleziona una
                                                                            Struttura</option> ' . showStructureDropDown("reparti") .'
                                                                    </select>
                    </div>
                </div>

                                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="department_address" value="' . $row['INDIRIZZO'] . '"  placeholder="Indirizzo">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Citta
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="department_city" value="' . $row['CITTA'] . '"  placeholder="Citta">
                    </div>
                </div>

                                    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Inizio
        </h5>
        <div class="col-sm-4">
            <input disabled readonly type="text" class="form-control" id="datePicker"
                name="department_joined_date" placeholder="Data di Inizio" required value = "' . $row['DATA_INIZIO'] . '"
                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Fine
        </h5>
        <div class="col-sm-4">
            <input disabled readonly type="text" class="form-control" id="datePicker"
                name="department_left_date" placeholder="Data di Fine" value = "' . $row['DATA_FINE'] . '"
                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
        </div>
    </div>
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Informazioni</h5>
                    <div class="col-sm-4">
                        <textarea disabled class="form-control" name="department_information" rows="3"
                            placeholder="Informazioni">' . $row['INFORMAZIONI'] . '</textarea>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">E Attivo</h5>

                <div class="col-sm-4">
                    <input disabled type="text" class="form-control" style="font-weight:bold; color:' . $color . ';" value="' . $status . '" />
                </div>
            </div>
            </div>
        </div>

    
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
            $("#company-dropdown").change(function() {
                var companyID = $(this).val();
                var post_id = \'id=\' + companyID;
                $.ajax({
                    type: "POST",
                    url: "fetch_structures.php",
                    data: post_id,
                    cache: false,
                    success: function(cities) {
                        $("#structure_name").html(cities);
                    }
                });
            });
    });
</script>';
}
