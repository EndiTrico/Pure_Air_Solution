<?php
function showJob($row)
{

echo '
<style>
.alert {
    margin-left: 20px
}

.passwordCheck {
    margin-right: 10px;
}

.fa {
    font-size: 1rem;
    margin-left: 1px;
    border-color: lightgray;
}

#btnToggle {
    border-color: darkgray;
    background-color: white;
}

.select2-container .select2-search--inline .select2-search__field{
    margin-left: -6px !important;
    padding-left: 14px !important;    
}

.select2-selection__rendered{
    padding-top: 5px !important;
}

.form-select {
    color: #6d6f72 !important;
}

</style>
<form id="jobForm" method="post">
    <div class="row"         
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Cantiere
            </h5>
            <div class="col-sm-4">
                <input disabled type="text" placeholder="Cantiere"
                    name="job_construction" class="form-control" value="' . $row['CANTIERE'] . '" />
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data del Lavoro
            </h5>
            <div class="col-sm-4">
                <input disabled readonly type="text" class="form-control" id="datePicker"
                    name="job_data" placeholder="Data del Lavoro"  value = "' . $row['DATA_LAVORO'] . '"
                    style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: #e9ecef">
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data Creato
            </h5>
            <div class="col-sm-4">
                <input disabled readonly type="text" class="form-control" id="datePicker"
                    name="job_data" placeholder="Data Creato"  value = "' . $row['DATA_CREATO'] . '"
                    style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: #e9ecef">
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Nome e Cognome
            </h5>
            <div class="col-sm-4">
                <input disabled type="text" placeholder="Nome e Cognome"
                    name="job_construction" class="form-control" value="' . $row['NOME_E_COGNOME'] . '" />
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Informazioni</h5>
            <div class="col-sm-4">
                <textarea disabled class="form-control" name="job_information" rows="5"
                    placeholder="Informazioni">' . $row['INFORMAZIONI'] . '</textarea>
            </div>
        </div>
        
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/i18n/it.js"></script>

<script>
const flatpickrInstance = flatpickr("#datePicker", {
locale: "it",
dateFormat: "Y-m-d",
});
</script>';
}
