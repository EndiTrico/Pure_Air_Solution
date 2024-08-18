<?php 
echo '
<form id="bankAccountForm" method="post"
    style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
    <div class="row">
        <div class="row">
            <div class="col-12">

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Il Nome Della
                        Banca<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="bank_name" placeholder="Il Nome Della Banca"
                            value="' . $row['BANCA_NOME'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Aziende <span style="color:red;">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <select class="form-select mb-3" name = "company_name" required> ' .
                            showCompaniesNameDropDown("banca conti") . '</select>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">IBAN<span style="color:red;">*</span>
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="bank_iban" placeholder="IBAN"  value="' . $row['IBAN'] . '"  required>
                    </div>
                </div>

    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Inizio<span style="color:red;">*</span>
        </h5>
        <div class="col-sm-4">
            <input readonly type="text" class="form-control" id="datePicker"
                name="bank_joined_date" placeholder="Data di Inizio" required value = "' . $row['DATA_INIZIO'] . '"
                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Fine
        </h5>
        <div class="col-sm-4">
            <input readonly type="text" class="form-control" id="datePicker"
                name="bank_left_date" placeholder="Data di Fine" value = "' . $row['DATA_FINE'] . '"
                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
        </div>
    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_bank_account" id="upadteBankAccountButton" class="btn btn-success btn-lg">Aggiorna il
                    Conto
                    Bancario</button>
            </div>
        </div>
    </div>
</form>';