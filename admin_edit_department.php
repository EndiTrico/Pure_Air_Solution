<?php
echo '
<form id="departmentForm" method="post">
        <div class="row"
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Nome<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="department_name" placeholder="Nome" value="' . $row['REPARTO_NOME'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="department_address" value="' . $row['INDIRIZZO'] . '"  placeholder="Indirizzo">
                    </div>
                </div>


                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Azienda<span style="color:red;">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <select class="form-select mb-3" name = "company_name" id="company-dropdown" required>'
                            . showCompaniesNameDropDown('reparti') . '</select>                    
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Citta
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="department_city" value="' . $row['CITTA'] . '"  placeholder="Citta">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Struttura<span style="color:red;">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <select name="structure_name" id="structure_name" class="form-select mb-3" required>
                            <option disable selected value="">Seleziona una
                                Struttura</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Informazioni</h5>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="department_information" rows="3"
                            placeholder="Informazioni">' . $row['INFORMAZIONI'] . ' </textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_department" id="updateDepartmentButton" class="btn btn-success btn-lg">Aggiorna
                    il Reparto</button>
            </div>
        </div>
    
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js">
</script>
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