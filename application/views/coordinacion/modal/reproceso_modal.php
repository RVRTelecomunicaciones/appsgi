<div class="modal fade text-left" id="mdl_reproceso" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">REGISTRAR MOTIVO DEL REPROCESO</h4>
                <!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>-->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-left" for="selectMotivo">Motivo</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select id="selectMotivo" class="form-control" class="select2-diacritics2">
                                        <option value=""> Seleccioné </option>
                                        <?php
                                            if (count($motivo) > 0){
                                                foreach ($motivo as $row) {
                                                    echo '<option value="'.$row->motivo_id.'">'.strtoupper($row->motivo_nombre).'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>                                                      
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-left" for="inputReprocesoDescripcion">Descripción</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <textarea id="inputReprocesoDescripcion" rows="5" class="form-control"></textarea>
                                </div>
                            </div>                                                      
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-3 label-control text-left" for="inputNuevaFechaEntrega">Nueva Fecha</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <input id="inputNuevaFechaEntrega" type="date" class="form-control">
                                </div>
                            </div>                                                      
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <a id="btnGuardar" href="" class="btn grey btn-outline-warning" action="1">Guardar</a>
            </div>
        </div>
    </div>
</div>