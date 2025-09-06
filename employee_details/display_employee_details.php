<?php 

function showEmployees($row)
{
    $status = $row["E_ATTIVO"] == 1 ? 'ATTIVO' : 'INATTIVO';
    $color  = $row["E_ATTIVO"] == 1 ? 'green' : 'red';

    echo '
<form id="userForm" method="post">
        <div class="row"         
            style="background:url(\'images/logo/logo01_backgroundForm.png\'); background-color:white; background-size:contain; background-position:center; background-repeat:no-repeat;">
                <div class="col-12">
                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Nome</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_name" placeholder="Nome"  value="' . $row['NOME'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Cognome</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_cognome" placeholder="Cognome" value="' . $row['COGNOME'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Email</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_email" placeholder="Email" value="' . $row['EMAIL'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Data di Nascita</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_birthday" placeholder="Data di Nascita" value="' . $row['DATA_DI_NASCITA'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Codice Fiscale</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_codice_fiscale" placeholder="Codice Fiscale" value="' . $row['CODICE_FISCALE'] . '">
                        </div>
                    </div>
                    
                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Indirizzo</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_address" placeholder="Indirizzo" value="' . $row['INDIRIZZO'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Ruolo</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_role" placeholder="Ruolo" value="' . $row['RUOLO'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Ragione Sociale</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_ragione_sociale" placeholder="Ragione Sociale" value="' . $row['RAGIONE_SOCIALE'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">PIVA</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_piva" placeholder="PIVA" value="' . $row['PIVA'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Telefono</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_telephone" placeholder="Numero di Telefono" value="' . $row['TELEFONO'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Matricola</h5>
                        <div class="col-sm-4">
                            <input disabled type="number" class="form-control" name="employee_matricola" placeholder="Matricola" value="' . $row['MATRICOLA'] . '">
                        </div>
                    </div>
                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Qualifica</h5>
                        <div class="col-sm-4">
                            <input disabled type="number" class="form-control" name="employee_qualifica" placeholder="Qualifica" value="' . $row['QUALIFICA'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Mansione</h5>
                        <div class="col-sm-4">
                            <input disabled type="number" class="form-control" name="employee_mansione" placeholder="Mansione" value="' . $row['MANSIONE'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Contratto</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" name="employee_contratto" placeholder="Contratto" value="' . $row['CONTRATTO'] . '">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Assunto Il</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_assunto" placeholder="Assunto Il" value="' . $row['ASSUNTO_IL'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Data di Fine</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_left_date" placeholder="Data di Fine" value = "' . $row['DATA_FINE'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Visita Medica Idoneita</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_medica" placeholder="Visita Medica Idoneita" value="' . $row['VISITA_MEDICA_IDONEITA'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Ricevuta Cosegna DPI</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_dpi" placeholder="Ricevuta Cosegna DPI" value="' . $row['RICEVUTA_CONSEGNA_DPI'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Attestato Formazione Specifica</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_specifica" placeholder="Attestato Formazione Specifica" value="' . $row['ATTESTATO_FORMAZIONE_SPECIFICA'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Corso Formazione Informazione Base</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_informazione_base" placeholder="Corso Formazione Informazione Base" value="' . $row['CORSO_FORMAZIONE_INFORMAZIONE_BASE'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>

                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">Corso Utilizzo DPI CAT3</h5>
                        <div class="col-sm-4">
                            <input disabled readonly type="text" class="form-control" id="datePicker"
                                name="employee_cat3" placeholder="Corso Utilizzo DPI CAT3" value="' . $row['CORSO_UTILIZZO_DPI_CAT3'] . '"
                                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
                        </div>
                    </div>
            
                    <div class="mb-3 row d-flex justify-content-center">
                        <h5 class="card-title col-sm-2 col-form-label text-end">E Attivo</h5>
                        <div class="col-sm-4">
                            <input disabled type="text" class="form-control" style="font-weight:bold; color:' . $color . ';" value="' . $status . '" />
                        </div>
                    </div>				
                </div>
        </div>               
</form>
    ';
}