<?php 
echo '
<form id="structureForm" method="post">
        <div class="row" style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Nome<span style="color:red;">*</span></h5>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="structure_name" placeholder="Nome" required value="' . $row['STRUTTURA_NOME'] . '">
                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Indirizzo</h5>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="structure_address" placeholder="Indirizzo" value="' . $row['INDIRIZZO'] . '">
                </div>
            </div>

            <div class="mb-3 row row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Citta</h5>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="structure_city" placeholder="Citta" value="' . $row['CITTA'] . '">
                </div>
            </div>

            <div class="mb-3 row row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Aziende<span style="color:red;">*</span></h5>
                <div class="col-sm-4">
                <div> <select placeholder="Seleciona Azienda"
                name="company_name[]" id= "select" data-allow-clear="1">' .
showCompaniesNameDropDown("strutture") . '</select>
                </div>                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Informazioni</h5>
                <div class="col-sm-4">
                    <textarea class="form-control" name="structure_information" rows="3" placeholder="Informazioni"> ' . $row["INFORMAZIONI"] . '</textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="create_structure" id="createStructureButton" class="btn btn-success btn-lg">Crea una Struttura</button>
            </div>
        </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
$(function () {
    $(\'select\').each(function () {
        $(this).select2({
            theme: \'bootstrap4\',
            width: \'style\',
            placeholder: $(this).attr(\'placeholder\'),
            allowClear: Boolean($(this).data(\'allow-clear\')),
        });
    });
});

</script>';
