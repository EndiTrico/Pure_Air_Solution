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
                <h5 class="card-title col-sm-2 col-form-label">Password<span style="color:red;">*</span>
                </h5>
                <div class="col-sm-4">
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Password" name="user_password"
                            class="form-control" required />
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
                        </script>';