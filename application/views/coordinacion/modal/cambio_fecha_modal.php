<div class="modal fade text-left" id="mdl_cambio_fecha" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">CAMBIAR FECHA DE ENTREGA</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_cambio_fecha">
                <div class="modal-body">
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
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <label class="col-md-3 label-control text-left" for="inputMotivo">Descripción (Motivo)</label>
                                <div class="col-md-9">
                                    <div class="input-group">
                                        <textarea id="inputMotivo" rows="5" class="form-control"></textarea>
                                    </div>
                                </div>                                                      
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="buttonCloseCambioFecha" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="buttonSaveCambioFecha" type="submit" class="btn grey btn-outline-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>