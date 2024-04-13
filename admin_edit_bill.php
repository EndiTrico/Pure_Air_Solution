<?php
echo '
<form id="billForm" method="post">
    <div class="row"
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
        <div class="row">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Valore<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="value" oninput="calculateValueWithVAT()"
                            name="bill_value" placeholder="Valore" min=0 max=100000000000000000000000000 step="any"
                            value="' . $row['VALORE'] . '" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Aziende<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <select class="form-select mb-3" name = "company_name" required>' .
                            showCompaniesNameDropDown("fatture") . '</select>                    
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Data di
                        Fatturazione</h5>
                    <div class="col-sm-4">
                        <input readonly type="text" class="form-control" id="datePicker" name="bill_billing_date"
                            placeholder="Data di Fatturazione" value="' . $row['DATA_FATTURAZIONE'] . '" 
                            style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Valore Iva
                        Inclusa</h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="bill_withVAT" name="bill_withVAT" value="' . $row['VALORE_IVA_INCLUSA'] . '" 
                            placeholder="Valore Iva Inclusa" min=0 max=100000000000000000000000000 step="any" readonly>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">IVA (%)<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" id="VAT" oninput="calculateValueWithVAT()" 
                        value="' . $row['IVA'] . '" name="bill_VAT" placeholder="IVA" min="0" max="100" step="any" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Moneta<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <div class="form-group">
                        <select class="form-select mb-3" name="bill_currency" required>
                        <option value="USD" <?php if ($row["MONETA"] == "USD") echo "selected"; ?>United States Dollar (USD)</option>
                        <option value="EUR" <?php if ($row["MONETA"] == "EUR") echo "selected"; ?>Euro (EUR)</option>
                        <option value="JPY" <?php if ($row["MONETA"] == "JPY") echo "selected"; ?>Japanese Yen (JPY)</option>
                        <option value="GBP" <?php if ($row["MONETA"] == "GBP") echo "selected"; ?>British Pound Sterling (GBP)</option>
                        <option value="AUD" <?php if ($row["MONETA"] == "AUD") echo "selected"; ?>Australian Dollar (AUD)</option>
                        <option value="CAD" <?php if ($row["MONETA"] == "CAD") echo "selected"; ?>Canadian Dollar (CAD)</option>
                        <option value="CHF" <?php if ($row["MONETA"] == "CHF") echo "selected"; ?>Swiss Franc (CHF)</option>
                        <option value="CNY" <?php if ($row["MONETA"] == "CNY") echo "selected"; ?>Chinese Yuan (CNY)</option>
                        <option value="SEK" <?php if ($row["MONETA"] == "SEK") echo "selected"; ?>Swedish Krona (SEK)</option>
                        <option value="NZD" <?php if ($row["MONETA"] == "NZD") echo "selected"; ?>New Zealand Dollar (NZD)</option>
                        <option value="KRW" <?php if ($row["MONETA"] == "KRW") echo "selected"; ?>South Korean Won (KRW)</option>
                        <option value="SGD" <?php if ($row["MONETA"] == "SGD") echo "selected"; ?>Singapore Dollar (SGD)</option>
                        <option value="NOK" <?php if ($row["MONETA"] == "NOK") echo "selected"; ?>Norwegian Krone (NOK)</option>
                        <option value="MXN" <?php if ($row["MONETA"] == "MXN") echo "selected"; ?>Mexican Peso (MXN)</option>
                        <option value="INR" <?php if ($row["MONETA"] == "INR") echo "selected"; ?>Indian Rupee (INR)</option>
                        <option value="RUB" <?php if ($row["MONETA"] == "RUB") echo "selected"; ?>Russian Ruble (RUB)</option>
                        <option value="ZAR" <?php if ($row["MONETA"] == "ZAR") echo "selected"; ?>South African Rand (ZAR)</option>
                        <option value="BRL" <?php if ($row["MONETA"] == "BRL") echo "selected"; ?>Brazilian Real (BRL)</option>
                        <option value="TRY" <?php if ($row["MONETA"] == "TRY") echo "selected"; ?>Turkish Lira (TRY)</option>
                    </select>
                        </div>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Data di
                        Pagamento
                    </h5>
                    <div class="col-sm-4">
                        <input readonly type="text" class="form-control" id="datePicker1" name="bill_payment_date"
                            placeholder="Data di Pagamento" value="' . $row['DATA_PAGAMENTO'] . '" 
                            style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Descrizione
                    </h5>
                    <div class="col-sm-4">

                        <textarea class="form-control" name="bill_information" rows="3"
                            placeholder="Descrizione"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <button name="update_bill" id="updateBillButton" class="btn btn-success btn-lg">Aggiorna la
                            Fattura</button>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</form>

<script>
    function calculateValueWithVAT() {
        var value = parseFloat(document.getElementById("value").value);
        var billVAT = parseFloat(document.getElementById("VAT").value);

        if (isNaN(value)) {
            value = 0;
        }  
        if (isNaN(billVAT)) {
            billVAT = 0;
        }
    
        var valueWithVAT = (value * (1 + (billVAT / 100))).toFixed(2);

        document.getElementById("bill_withVAT").value = valueWithVAT;
    }
</script>'
;