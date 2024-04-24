<?php echo '
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

.select2-search__field,
.select2-selection__choice {
    margin-top: 8.5px !important;
    margin-left: 7px !important;
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
                <h5 class="card-title col-sm-2 col-form-label">Nome<span style="color:red;">*</span></h5>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="user_first_name" value="' . $row['NOME'] . '"
                        placeholder="Nome" required>
                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Cognome<span style="color:red;">*</span></h5>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="user_last_name" value="' . $row['COGNOME'] . '"
                        placeholder="Cognome" required>
                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">E-mail<span style="color:red;">*</span>
                </h5>
                <div class="col-sm-4">
                    <input type="email" placeholder="Email" name="user_email" value="' . $row['EMAIL'] . '"
                        class="form-control" required />
                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Password
                </h5>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Password" name="user_password"
                            class="form-control" />
                        <div class="input-group-append">
                            <button type="button" onclick="togglePassword()" id="btnToggle"
                                class="btn btn-outline btn-xs btn-xs btn-2x"><i id="eyeIconPassword"
                                    class="fa fa-eye fa-xs"></i></button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-3 row d-flex justify-content-center">
                <h5 class="card-title col-sm-2 col-form-label">Numero<span style="color:red;">*</span>
                </h5>
                <div class="col-sm-4">
                    <input type="text" placeholder="Numero" name="user_number" class="form-control" value="' . $row["NUMERO"] . '"  required />
            </div>
            </div>
        

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Azienda Posizione
            </h5>
            <div class="col-sm-4">
                <input type="text" placeholder="Azienda Posizione" name="user_position" class="form-control" value="' .
                        $row["AZIENDA_POSIZIONE"] . '" />
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Inizio<span style="color:red;">*</span>
        </h5>
        <div class="col-sm-4">
            <input readonly type="text" class="form-control" id="datePicker"
                name="user_joined_date" placeholder="Data di Inizio" required value = "' . $row['DATA_INIZIO'] . '"
                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
        </div>
    </div>

    <div class="mb-3 row d-flex justify-content-center">
        <h5 class="card-title col-sm-2 col-form-label">Data di
            Finito
        </h5>
        <div class="col-sm-4">
            <input readonly type="text" class="form-control" id="datePicker"
                name="user_left_date" placeholder="Data di Finito" value = "' . $row['DATA_FINITO'] . '"
                style="background: url(\'data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22currentColor%22 stroke-width=%222%22 stroke-linecap=%22round%22 stroke-linejoin=%22round%22%3E%3Crect x=%223%22 y=%224%22 width=%2218%22 height=%2218%22 rx=%222%22 ry=%222%22/%3E%3Cline x1=%2216%22 y1=%222%22 x2=%2216%22 y2=%226%22/%3E%3Cline x1=%228%22 y1=%222%22 x2=%228%22 y2=%226%22/%3E%3Cline x1=%223%22 y1=%2210%22 x2=%2221%22 y2=%2210%22/%3E%3C/svg%3E\') no-repeat right 10px center; background-size: 16px; background-color: white">
        </div>
    </div>


        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Ruole<span style="color:red;">*</span>
            </h5>
            <div class="col-sm-4">
                <div>
                    <select data-allow-clear="1" name="user_role" class="form-select mb-3" required>
                        <option value="" style="margin-right:20px !important;" disabled selected hidden>Seleziona Ruolo
                        </option>
                        <option value="Admin" ' . ($row["RUOLO"]=="Admin" ? 'selected' : '' ) . '>Admin</option>
                        <option value="Cliente" ' . ($row["RUOLO"]=="Cliente" ? 'selected' : '' ) . '>Cliente</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mb-3 row d-flex justify-content-center">
            <h5 class="card-title col-sm-2 col-form-label">Aziende</h5>
            <div class="col-sm-4">
                <select style="font-size: 1px !important;" multiple placeholder="Seleziona Azienda"
                    name="user_companies[]" id="select" data-allow-clear="1">
                    <?php echo showAllCompanies(); ?>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <button name="update_user" id="updateUserButton"
                    class="btn btn-success btn-lg">Aggiorna</button>
            </div>
        </div>
    </div>
</form>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script> 
    $(function () {
        $(\' select\').each(function () { $(this).select2({ theme: \'bootstrap4\', width: \'style\', placeholder:
                        $(this).attr(\'placeholder\'), allowClear: Boolean($(this).data(\'allow-clear\')), }); }); });
                        </script>

                        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/it.js"></script>
<script>
const flatpickrInstance = flatpickr("#datePicker", {
    locale: \'it\',
    dateFormat: "Y-m-d",
});

$(function () {
    $(\'#multiple_select\').each(function () {
        $(this).select2({
            theme: \'bootstrap4\',
            width: \'style\',
            placeholder: $(this).attr(\'placeholder\'),
            allowClear: Boolean($(this).data(\'allow-clear\')),
        });
    });
});

let
    passwordInput = document.getElementById(\'password\');
iconPassword = document.getElementById(\'eyeIconPassword\');

function togglePassword() {
    if (passwordInput.type === \'password\') {
        passwordInput.type = \'text\';
        iconPassword.classList.add("fa-eye-slash");
    } else {
        passwordInput.type = \'password\';
        iconPassword.classList.remove("fa-eye-slash");
    }
}

</script>';