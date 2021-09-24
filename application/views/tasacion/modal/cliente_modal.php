<div class="modal fade text-left" id="mdlCliente" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE CLIENTES</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formCliente">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="text-left" for="inputNombreCompleto">Ap. y Nombres // Razón Social</label>
                                    <input id="inputId" type="text" class="form-control border-primary hidden" value="0" disabled>
                                    <input id="inputNombreCompleto" name="inputNombreCompleto" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label class="text-left" for="inputNroDocumento">Nro de Documento</label>
                                    <input id="inputNroDocumento" name="inputNroDocumento" type="number" class="form-control border-primary text-right" max="0">
                                </div>
                                
                                <div class="form-group col-md-8">
                                    <label class="d-none d-md-block">&nbsp;</label>
                                    <a id="linkCancelar" href class="btn btn-light square ml-1 float-right">Cancelar</a>
                                    <a id="linkAñadir" href class="btn btn-primary square float-right">Añadir</a>
                                </div>
                                <div class="col-md-12"><hr></div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tbl_tasacion_cliente" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="2">
                                            <input id="inputSearchNombre" type="text" class="form-control border-primary">
                                        </td>
                                        <td>
                                            <input id="inputSearchNroDocumento" type="number" class="form-control border-primary">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>APELLIDOS Y NOMBRES // RAZÓN SOCIAL</th>
                                        <th>NRO DE DOCUMENTO</th>
                                        <th width="60">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="text-left">
                            <span id="conteo_cliente"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="paginacion_cliente" class="float-right"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>