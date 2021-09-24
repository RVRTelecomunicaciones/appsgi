<div class="modal fade text-left" id="mdlTipoRegistro" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">¿ QUE DESEAS REGISTRAR ?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div id="row_informe" class="col-12 hidden">
                        <div class="form-group row">
                            <label class="text-left col-3" for="inputInformeCodigo">Código de Informe</label>
                            <div class="col-9">
                                <input id="inputInformeCodigo" type="text" class="form-control" disabled="disabled" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label id="labelCoordinacion" class="hidden"></label>
                        <label id="labelInspeccion" class="hidden"></label>

                        <div class="list-group">
                            <a id="linkTerreno" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE TERRENO</a>
                            <a id="linkCasa" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE CASA</a>
                            <a id="linkDepartamento" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE DEPARTAMENTO</a>
                            <a id="linkOficina" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE OFICINA</a>
                            <a id="linkLocalComercial" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE LOCAL COMERCIAL</a>
                            <a id="linkLocalIndustrial" href class="list-group-item list-group-item-action list-group-item-info text-center">REGISTRO DE LOCAL INDUSTRIAL</a>
                            <a id="linkVehiculo" href class="list-group-item list-group-item-action list-group-item-success text-center">REGISTRO DE VEHÍCULO</a>
                            <a id="linkMaquinaria" href class="list-group-item list-group-item-action list-group-item-success text-center">REGISTRO DE MAQUINARIA</a>
                            <a id="linkOtros" href class="list-group-item list-group-item-action list-group-item-danger text-center" style="font-weight: bold;">OTRAS TASACIONES</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>