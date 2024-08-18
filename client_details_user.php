<?php
function showUsers($row)
{
$status = $row["E_ATTIVO"] == 1 ? 'ATTIVO' : 'INATTIVO';
$color = $row["E_ATTIVO"] == 1 ? 'green' : 'red';

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
    <form id="userForm" method="post">
        <div class="row">
            <div class="col"
                style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
    
                <div class=" mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Nome</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="user_first_name" value="' . $row['NOME'] . '"
                            placeholder="Nome" required>
                    </div>
                </div>
    
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Cognome</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="user_last_name" value="' . $row['COGNOME'] . '"
                            placeholder="Cognome" required>
                    </div>
                </div>
    
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">E-mail
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="email" placeholder="Email" name="user_email" value="' . $row['EMAIL'] . '"
                            class="form-control" required />
                    </div>
                </div>
    
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Numero
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" placeholder="Numero" name="user_number" class="form-control" value="' . $row["NUMERO"] . '"  required />
                    </div>
                </div>
            
    
            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Azienda Posizione
                </h5>
                <div class="col-sm-4">
                    <input disabled type="text" placeholder="Azienda Posizione" name="user_position" class="form-control" value="' .
    $row["AZIENDA_POSIZIONE"] . '" />
                </div>
            </div>
    
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data di
                Inizio
            </h5>
            <div class="col-sm-4">
                <input disabled readonly type="text" class="form-control" id="datePicker"
                    name="user_joined_date" placeholder="Data di Inizio" required value = "' . $row['DATA_INIZIO'] . '"
                    style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
            </div>
        </div>
    
        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Data di
                Fine
            </h5>
            <div class="col-sm-4">
                <input disabled readonly type="text" class="form-control" id="datePicker"
                    name="user_left_date" placeholder="Data di Fine" value = "' . $row['DATA_FINE'] . '"
                    style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
            </div>
        </div>
    
            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Ruole
                </h5>
                <div class="col-sm-4">
                    <div>
                    <input disabled type="text" placeholder="Ruole" name="user_role" class="form-control" value="' . $row["RUOLO"] . '" />
                              
                    </div>
                </div>
            </div>
    
            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Aziende</h5>
                <div class="col-sm-4">
                    <select disabled style="font-size: 1px !important;" multiple placeholder="Seleziona Azienda"
                        name="user_companies[]" id="multiple_select" data-allow-clear="1">' .
    showCompaniesNameDropDown("utenti") . '
                    </select>
                </div>
            </div>
            
            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">E Attivo</h5>

                <div class="col-sm-4">
                    <input disabled type="text" class="form-control" style="font-weight:bold; color:' . $color . ';" value="' . $status . '" />
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
                          
        $(function () {
        $(\'#multiple_select\').each(function () {
            $(this).select2({
                theme: \'bootstrap4\',
                width: \'style\',
                placeholder: $(this).attr(\'placeholder\'),
                allowClear: Boolean($(this).data(\'allow-clear\')),
                language: \'it\'
            });
        });
    });
    
    </script>';
}
