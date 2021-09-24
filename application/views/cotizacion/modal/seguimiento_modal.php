<div class="modal fade text-left" id="mdl_seguimiento" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">NUEVO MENSAJE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group row">
                            <label class="col-md-2 label-control" for="inputMensaje">Mensaje</label>
                            <div class="col-md-10">
                                <textarea id="inputMensaje" rows="6" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 label-control" for="inputFechaProxima">Fecha Próxima</label>
                            <div class="col-md-10">
                                <div class="position-relative has-icon-left">
                                    <input id="inputFechaProxima" type="date" class="form-control border-primary" name="date">
                                    <div class="form-control-position">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnGuardar" type="submit" class="btn btn-warning">Guardar</button>
            </div>
        </div>
    </div>
</div>