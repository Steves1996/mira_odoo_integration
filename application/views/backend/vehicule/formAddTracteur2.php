<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">
                          <?php $this->crud_model_document->leSelectAssurance("tracteur"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">
                          <?php $this->crud_model_document->leSelectCarteGrise("tracteur"); ?>
                            
                          </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte bleue</label>
                        <select class="carte_bleue form-control">
                          <?php $this->crud_model_document->leSelecCarteBleue("tracteur"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">
                          <?php $this->crud_model_document->leSelecVisiteTechnique("tracteur"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Taxe</label>
                        <select class="taxe form-control">
                          <?php $this->crud_model_document->leSelecTaxe("tracteur"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Acces port</label>
                       <select class="acces_port form-control">
                          <?php $this->crud_model_document->leSelectAccesPort(); ?>
                            
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Licence transport</label>
                        <select class="licence_transport form-control">
                          <?php $this->crud_model_document->leSelectLicenceTransport(); ?>
                            
                        </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Attestation non redevance</label>
                        <select class="attestation form-control">
                          <?php $this->crud_model_document->leSelectAttestation("tracteur"); ?>
                            
                        </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <br> 
                         <?php
                            if ($this->session->userdata('vehicule_ajout')=="true") {
                          echo ' <button type="button" class=" btn-primary btn-lg"  onclick="addTracteur(\'insert\');">Enregistrer</button>';} ?>
                      </div>
                    </div>

                 </div>