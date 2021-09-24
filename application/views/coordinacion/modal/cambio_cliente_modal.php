<div class="modal fade text-left" id="mdl_change_cliente" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8"><i class="fa fa-user"></i> CAMBIAR CLIENTE</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_change_cliente">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row">
                                <div class="col-6">
                                    <fieldset>
                                        <input id="radioNaturalModal" name="radio_cliente_tipo" type="radio" checked>
                                        <label for="radioNaturalModal">Natural</label>
                                    </fieldset>
                                </div>
                                <div class="col-6">
                                    <fieldset>
                                        <input id="radioJuridicoModal" name="radio_cliente_tipo" type="radio">
                                        <label for="radioJuridicoModal">Jurídico</label>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="form-group">
                                <label id="labelClienteModal" for="selectClienteModal">Ape. y Nombres</label>
                                <select id="selectClienteModal" name="selectClienteModal" class="form-control"></select>
                            </div>
                            <!--<div id="divConcatoModal" class="form-group hidden">
                                <label for="selectContactoModal">Contacto</label>
                                <select id="selectContactoModal" name="selectContactoModal" class="form-control"></select>
                            </div>-->
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="buttonCloseChangeCliente" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="buttonSaveChangeCliente" type="submit" class="btn grey btn-outline-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>