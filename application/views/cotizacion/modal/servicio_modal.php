<div class="modal fade text-left" id="mdlServicio" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE SERVICIOS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label class="col-2 col-md-3 label-control" for="inputDescripcion">Descripción</label>
                            <div class="col-10 col-md-9">
                                <input id="inputId" type="text" class="form-control border-primary hidden" value="0" disabled>
                                <input id="inputDescripcion" name="inputDescripcion" type="text" class="form-control border-primary">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 col-md-3 label-control" for="checkEstado">Activo</label>
                            <div class="col-1 col-md-1">
                                <input id="checkEstado" name="checkEstado" type="checkbox" checked="checked">
                            </div>
                            <div class="col-7 col-md-6"></div>
                            <div class="col-2 col-md-2">
                                <div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
                                    <a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
                                    <a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="tableRegistro" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td colspan="2">
                                            <input id="inputSearchDescripcion" type="text" class="form-control border-primary">
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
                                        <th>DESCRIPCIÓN</th>
                                        <th width="110">ESTADO</th>
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
                <button id="btnClose" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>