<?php 
echo '
<form id="employeeForm" method="post" enctype="multipart/form-data">
    <div class="row" style="
      background: url(\'./images/logo/logo01_backgroundForm.png\');
      background-color: white;
      background-size: contain;
      background-position: center;
      background-repeat: no-repeat;
    ">
        <div class="row">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Nome<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['NOME'] . '" type="text" class="form-control" name="employee_first_name" placeholder="Nome"
                            required />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Cognome<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['COGNOME'] . '" type="text" class="form-control" name="employee_last_name" placeholder="Cognome"
                            required />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        E-mail<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['EMAIL'] . '" type="email" placeholder="Email" name="employee_email"  class="form-control"
                            required />
                    </div>
                </div>

				<div class="mb-3 row d-flex justify-content-center align-items-center">
    				<h5 class="card-title col-sm-2 col-form-label">Fotografia</h5>
    				<div class="col-sm-4 d-flex align-items-center">
                    	<label for="employee_photo" name ="file_upload" class="btn btn-info text-center" style="width: 20%;">Sfoglia</label>
                        <input type="file" id="employee_photo" name="employee_photo" class="d-none" accept="image/*">
                        <input type="text" name="file-name" id="file-name" class="form-control me-2" placeholder="Nessun file selezionato" readonly style="width: 80%;" value="' . $row['FOTOGRAFIA'] . '">
                        <button type="button" id="clear-file" class="btn btn-danger" style="width: 25%;">Cancella</button>
                    </div>
            	</div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Data di Nascita</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['DATA_DI_NASCITA'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_birthday"
                            placeholder="Data di Nascita"  
                            style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Codice Fiscale<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['CODICE_FISCALE'] . '" type="text" placeholder="Codice Fiscale" name="employee_code" class="form-control"
                             required />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['INDIRIZZO'] . '" type="text" placeholder="Indirizzo" name="employee_indirizzo" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Ruolo</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['RUOLO'] . '" type="text" placeholder="Ruolo" name="employee_role" class="form-control"  />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Ragiola Sociale</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['RAGIONE_SOCIALE'] . '" type="text" placeholder="Ragiola Sociale" name="employee_company" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">P. IVA</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['PIVA'] . '" type="text" placeholder="P. IVA" name="employee_iva" class="form-control"  />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['TELEFONO'] . '" type="text" placeholder="Telefono" name="employee_telephone" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Matricola<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['MATRICOLA'] . '" type="number" placeholder="Matricola" name="employee_number" class="form-control"
                             required />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Qualifica</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['QUALIFICA'] . '" type="text" placeholder="Qualifica" name="employee_qualification" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Mansione</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['MANSIONE'] . '" type="text" placeholder="Mansione" name="employee_position" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contratto</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['CONTRATTO'] . '" type="text" placeholder="Contratto" name="employee_contract" class="form-control"
                             />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Assunto Il<span style="color: red">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input required value="' . $row['ASSUNTO_IL'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_inizio_date"
                            placeholder="Assunto Il" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"
 							 />
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Data di Fine</h5>
                    <div class="col-sm-4">
                        <input value="' . $row['DATA_FINE'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_left_date"
                            placeholder="Data di Fine" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Visita Medica Idoneita
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['VISITA_MEDICA_IDONEITA'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_medical_date"
                            placeholder="Visita Medica Idoneita" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Ricevuta Cosegna DPI
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['RICEVUTA_CONSEGNA_DPI'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_cosegna_date"
                            placeholder="Ricevuta Cosegna DPI" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Attestato Formazione Specifica
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['ATTESTATO_FORMAZIONE_SPECIFICA'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_specifica_date"
                            placeholder="Attestato Formazione Specifica" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Corso Formazione Informazione Base
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['CORSO_FORMAZIONE_INFORMAZIONE_BASE'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_base_date"
                            placeholder="Corso Formazione Informazione Base" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">
                        Corso Utilizzo DPI Cat3
                    </h5>
                    <div class="col-sm-4">
                        <input value="' . $row['CORSO_UTILIZZO_DPI_CAT3'] . '" readonly type="text" class="form-control" id="datePicker" name="employee_cat3_date"
                            placeholder="Corso Utilizzo DPI Cat3" style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white"/>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <button name="update_employee" id="updateEmployeeButton" class="btn btn-success btn-lg">
                            Aggiorna il Dipendente
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>';
