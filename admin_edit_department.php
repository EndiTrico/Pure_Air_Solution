<?php
echo '
<form id="departmentForm" method="post">
    <div class="row">
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
                        <?php echo showCompanyName() ?>
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
    </div>
</form>';