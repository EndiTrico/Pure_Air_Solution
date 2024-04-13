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