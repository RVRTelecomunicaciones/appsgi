<div class="modal fade text-left" id="mdl_proceso" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">PROCESO</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="frm_involucrado">
                            <div class="row hidden">
                                <div class="col-md-12">
                                    <label id="labelProcesoCodigo" class="form-control"></label>
                                    <label id="labelCoordinacionCodigo" class="form-control"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label class="text-left" for="selectDevivarA">Derivar a</label>
                                    <select id="selectDevivarA" class="form-control">
                                        <option value="">- SELECCIONE -</option>
                                        <option value="1">DIGITADOR</option>
                                        <option value="2">CONTROL DE CALIDAD</option>
                                        <option value="3">AUDITOR</option>
                                        <option value="4" class="hidden">FINALIZAR</option>
                                    </select>
                                </div>
                                <div class="form-group col-12">
                                    <label class="text-left" for="inputObservacion">Observación</label>
                                    <textarea id="inputObservacion" rows="6" class="form-control"></textarea>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="buttonProcesoCancelar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button id="buttonProcesoGuardar" type="button" class="btn grey btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>