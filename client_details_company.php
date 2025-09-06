<?php

function showCompanies($row)
{
    $status = $row["E_ATTIVO"] == 1 ? 'ATTIVO' : 'INATTIVO';
    $color = $row["E_ATTIVO"] == 1 ? 'green' : 'red';

echo '
<form id="companyForm" method="post">
    <div class="row"         
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Nome</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_name" placeholder="Nome"  value="' . $row['AZIENDA_NOME'] . '" required>
                    </div>
                </div>


                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Partita
                        Iva</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_nipt" placeholder="Partita Iva" value="' . $row['PARTITA_IVA'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Codice
                        Fiscale</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_codice_fiscale"
                            placeholder="Codice Fiscale" value="' . $row['CODICE_FISCALE'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                        Pec</h5>
                    <div class="col-sm-4">
                        <input disabled type="email" class="form-control" name="company_address_pec" value="' . $row['INDIRIZZO_PEC'] . '" placeholder="Indirizzo"
                            required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_address" value="' . $row['INDIRIZZO'] . '" placeholder="Indirizzo">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Citta</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_city" value="' . $row['CITTA'] . '" placeholder="Citta">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 1
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_contact1" value="' . $row['CONTATTO_1'] . '" placeholder="Contatto 1">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 2
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_contact2" value="' . $row['CONTATTO_2'] . '" placeholder="Contatto 2">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 3
                    </h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_contact3" value="' . $row['CONTATTO_3'] . '" placeholder="Contatto 3">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 1</h5>
                    <div class="col-sm-4">
                        <input disabled type="number" class="form-control" name="company_telephone1"
                        value="' . $row['TELEFONO_1'] . '" placeholder="Numero di Telefono 1">
                    </div>
                </div>
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 2</h5>
                    <div class="col-sm-4">
                        <input disabled type="number" class="form-control" name="company_telephone2"
                        value="' . $row['TELEFONO_2'] . '" placeholder="Numero di Telefono 2">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 3</h5>
                    <div class="col-sm-4">
                        <input disabled type="number" class="form-control" name="company_telephone3"
                        value="' . $row['TELEFONO_3'] . '" placeholder="Numero di Telefono 3">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 1</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_email1" placeholder="Email 1" 
                        value="' . $row['EMAIL_1'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 2</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_email2" placeholder="Email 2"
                        value="' . $row['EMAIL_2'] . '" >
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 3</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_email3" placeholder="Email 3"
                        value="' . $row['EMAIL_3'] . '" >
                    </div>
                </div>

        <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Inizio
        </h5>
        <div class="col-sm-4">
            <input disabled readonly type="text" class="form-control" id="datePicker"
                name="company_joined_date" placeholder="Data di Inizio" required value = "' . $row['DATA_INIZIO'] . '"
                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Fine
        </h5>
        <div class="col-sm-4">
            <input disabled readonly type="text" class="form-control" id="datePicker"
                name="company_left_date" placeholder="Data di Fine" value = "' . $row['DATA_FINE'] . '"
                style="background: #E9ECEF url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px;">
        </div>
    </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Website</h5>
                    <div class="col-sm-4">
                        <input disabled type="text" class="form-control" name="company_website" placeholder="Website"
                        value="' . $row['WEBSITE'] . '" >
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Informazioni
                    </h5>
                    <div class="col-sm-4">
                        <textarea disabled class="form-control" name="company_information" rows="3"
                            placeholder="Informazioni">' . $row['INFORMAZIONI'] .'</textarea>
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
</form>';
}
