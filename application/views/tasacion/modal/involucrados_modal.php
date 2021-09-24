<div class="modal fade text-left" id="mdl_involucrados" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8"></h4>
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
                                    <label id="labelInvolucrado" class="form-control"></label>
                                    <label id="labelInvolucradoTipo" class="form-control"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div id="row_paterno" class="form-group col-md-6">
                                    <label class="text-left" for="inputPaterno">Paterno</label>
                                    <input id="inputPaterno" name="inputPaterno" type="text" class="form-control border-primary">
                                </div>
                                <div id="row_materno" class="form-group col-md-6">
                                    <label class="text-left" for="inputMaterno">Materno</label>
                                    <input id="inputMaterno" name="inputMaterno" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label id="labelNombres" class="text-left" for="inputNombres">Nombres</label>
                                    <input id="inputNombres" name="inputNombres" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="row">
                                <div id="row_documento_tipo" class="form-group col-md-6">
                                    <label class="text-left" for="selectTipoDocumento">Tipo Documento</label>
                                    <select id="selectTipoDocumento" name="selectTipoDocumento" class="select2-diacritics"></select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="text-left" for="inputNroDocumento">Nro de Documento</label>
                                    <input id="inputNroDocumento" name="inputNroDocumento" type="number" class="form-control border-primary text-right" max="0">
                                </div>
                            </div>
                            <!--<div class="row">
                                <div class="form-group col-md-12">
                                    <label class="text-left" for="inputDireccion">Dirección</label>
                                    <input id="inputDireccion" name="inputDireccion" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="text-left" for="inputCorreo">Correo</label>
                                    <input id="inputCorreo" name="inputCorreo" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="text-left" for="inputTelefono">Teléfeno</label>
                                    <input id="inputTelefono" name="inputTelefono" type="text" class="form-control border-primary">
                                </div>
                            </div>-->
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="buttonInvolucradosCancelar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancelar</button>
                <button id="buttonInvolucradosGuardar" type="button" class="btn grey btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>