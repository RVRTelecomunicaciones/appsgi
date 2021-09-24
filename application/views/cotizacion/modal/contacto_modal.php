<div class="modal fade text-left" id="mdlContacto" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE CONTACTOS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formInvolucrado">
                            <div class="form-group row">
                                <label class="col-md-1 label-control" for="inputNombreCompleto">Apellidos y Nombres</label>
                                <div class="col-md-10">
                                    <input id="inputId" type="text" class="form-control border-primary hidden" value="0" disabled>
                                    <input id="inputNombreCompleto" name="inputNombreCompleto" type="text" class="form-control border-primary">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 label-control" for="inputCargo">Cargo</label>
                                <div class="col-md-6">
                                    <input id="inputCargo" name="inputCargo" type="text" class="form-control border-primary">
                                </div>
                                <label class="col-md-1 label-control" for="inputTelefono">Teléfono</label>
                                <div class="col-md-3">
                                    <input id="inputTelefono" name="inputTelefono" type="text" class="form-control border-primary" style="text-align: right;">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 label-control" for="inputCorreo">Correo</label>
                                <div class="col-md-6">
                                    <input id="inputCorreo" name="inputCorreo" type="text" class="form-control border-primary">
                                </div>
                                <label class="col-md-1 label-control" for="checkEstado">Activo</label>
                                <div class="col-md-1">
                                    <input id="checkEstado" name="checkEstado" type="checkbox" checked="checked">
                                </div>
                                <div class="col-md-2">
                                    <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
                                        <a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
                                        <a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableRegistro" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="2">
                                            <input id="inputSearchNombreCompleto" type="text" class="form-control border-primary">
                                        </td>
                                        <td>
                                            <input id="inputSearchCargo" type="text" class="form-control border-primary">
                                        </td>
                                        <td>
                                        </td>
                                        <td>
                                            <input id="inputSearchCorreo" type="text" class="form-control border-primary">
                                        </td>
                                        <td>
                                            <select id="selectSearchEstado" class="form-control border-primary">
                                                <option value=""></option>
                                                <option value="1">Activo</option>
                                                <option value="0">Inactivo</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>APELLIDOS Y NOMBRES</th>
                                        <th>CARGO</th>
                                        <th>TELÉFONO</th>
                                        <th>CORREO</th>
                                        <th width="120">ESTADO</th>
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
                            <span id="conteo"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="paginacion" class="float-right"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-outline-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>