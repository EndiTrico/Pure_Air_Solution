<form id="companyForm" method="post">
    <div class="row"         
        style="background:url(\'./images/logo/logo01_backgroundForm.png\'); background-color: white;  background-size: contain; background-position: center; background-repeat: no-repeat; ">
        <div class="row">
            <div class="col-12">
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Nome<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_name" placeholder="Nome" required>
                    </div>
                </div>


                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Partita
                        Iva<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_nipt" placeholder="Partita Iva" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Codice
                        Fiscale<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_codice_fiscale"
                            placeholder="Codice Fiscale" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                        Pec<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="email" class="form-control" name="company_address_pec" placeholder="Indirizzo"
                            required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Indirizzo
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_address" placeholder="Indirizzo">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Citta</h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_city" placeholder="Citta">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 1
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_contact1" placeholder="Contatto 1">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 2
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_contact2" placeholder="Contatto 2">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Contatto 3
                    </h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_contact3" placeholder="Contatto 3">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 1</h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="company_telephone1"
                            placeholder="Numero di Telefono 1">
                    </div>
                </div>
                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 2</h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="company_telephone2"
                            placeholder="Numero di Telefono 2">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Telefono 3</h5>
                    <div class="col-sm-4">
                        <input type="number" class="form-control" name="company_telephone3"
                            placeholder="Numero di Telefono 3">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 1<span style="color:red;">*</span></h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_email1" placeholder="Email 1" required>
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 2</h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_email2" placeholder="Email 2">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Email 3</h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_email3" placeholder="Email 3">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Website</h5>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" name="company_website" placeholder="Website">
                    </div>
                </div>

                <div class="mb-3 row d-flex justify-content-center">
                    <h5 class="card-title col-sm-2 col-form-label">Informazioni
                    </h5>
                    <div class="col-sm-4">
                        <textarea class="form-control" name="company_information" rows="3"
                            placeholder="Informazioni"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <button name="create_company" id="createUserButton" class="btn btn-success btn-lg">Crea un
                            Azienda</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>