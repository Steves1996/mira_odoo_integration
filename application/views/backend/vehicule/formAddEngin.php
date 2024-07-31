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
                          <?php $this->crud_model_chauffeur->leSelectChauffeur("camion_benne"); ?>
                            
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
                            <label>Type de Camion</label>
                            <select class="type_camion form-control">
                                <?php $this->crud_model_vehicule->leSelectTypeEngin(); ?>
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
                        <label>secours</label>
                        <input type="text" class="form-control nbreRoueSecours" onkeypress="chiffres(event);" placeholder="Nombre de roues de secours">
                      </div>
                    </div>
                    </div>
                 </div>