<div class="row">
                   <div class="col-sm-6">
                      <div class="form-group">
                        <label>Assurance</label>
                        <select class="assurance form-control">
                          <?php $this->crud_model_document->leSelectAssurance("remorque"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte grise</label>
                        <select class="carte_grise form-control">
                          <?php $this->crud_model_document->leSelectCarteGrise("remorque"); ?>
                            
                          </select>
                      </div>
                    </div><div class="col-sm-6">
                      <div class="form-group">
                        <label>Carte bleue</label>
                        <select class="carte_bleue form-control">
                          <?php $this->crud_model_document->leSelecCarteBleue("remorque"); ?>
                            
                          </select>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label>Visite technique</label>
                        <select class="visite_technique form-control">
                          <?php $this->crud_model_document->leSelecVisiteTechnique("remorque"); ?>
                            
                          </select>
                      </div>
                    </div>
                    
                 </div>
                 <br> 
                  <?php
                            if ($this->session->userdata('vehicule_ajout')=="true") {
                          echo ' <button type="button" class=" btn-primary btn-lg"  onclick="addRemorque(\'insert\');">Enregistrer</button>'; } ?>