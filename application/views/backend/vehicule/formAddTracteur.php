<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Code</label>
                        <input type="text" class="form-control code" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Immatriculation</label>
                        <input type="text" class="form-control immatriculation" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>N° chassis</label>
                        <input type="text" class="form-control chassis" placeholder="Enter ...">
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Kilometrage</label>
                        <input type="text" class="form-control kilometrage" onkeypress="chiffres(event);" placeholder="Enter ...">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chauffeur</label>
                        <select class="chauffeur form-control">
                          <?php $this->crud_model_chauffeur->leSelectChauffeur("tracteur"); ?>
                            
                        </select>

                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Puissance</label>
                        <input type="text" class="form-control puissance" placeholder="Enter ..." onkeypress="chiffres(event);">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Remorque</label>
                        <select class="remorque form-control">
                          <?php $this->crud_model_document->leSelectRemorque("tracteur"); ?>
                            
                        </select>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Montant initialisation</label>
                        <input type="text" class="form-control montantInitialisation" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser" onkeyup ="formatMillier('montantInitialisation');">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Date initialisation</label>
                        <div class="input-group " id="" data-target-input="nearest" >
                                <input type="date" class="form-control datetimepicker-input dateInitialisation" data-target="#reservationdate" placeholder="date effet"/>
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Type</label>
                        <select class="typeTracteur form-control">
                          <option>Ancien</option>
                          <option>Nouveau</option>
                        </select>
                      </div>
                    </div>
                    
                    <div class="col-sm-6">
                            <div class="form-group">
                            <label>Type de Tracteur</label>
                            <select class="type_camion form-control">
                                <?php $this->crud_model_vehicule->leSelectTypeTracteur(); ?>
                                </select>
                          
                             </div>
                          </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>GPS</label>
                        <input type="text" class="form-control gps" onkeypress="chiffres(event);" placeholder="gps" onkeyup ="formatMillier('gps');">
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12"><h3 style="text-decoration: underline; text-align: center;">ROUES</h3>
                    <hr/></div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Chaussée</label>
                        <input type="text" class="form-control nbreRoue" onkeypress="chiffres(event);" placeholder="Nombre de roues à chausser">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>secour</label>
                        <input type="text" class="form-control nbreRoueSecours" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>
                 </div>