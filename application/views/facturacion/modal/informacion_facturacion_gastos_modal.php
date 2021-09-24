<div class="modal fade text-left" id="mdl_gastos" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger white">
                <h4 class="modal-title" id="myModalLabel8">GASTOS DE LA COORDINACIÓN [<span id="spanCoordinacionCodigo"></span>]</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <form id="formInvolucrado">
                            <input id="inputDetalle" name="inputDetalle" type="text" value="0" class="form-control border-primary hidden" disabled>
                            <input id="inputCoordinacion" name="inputCoordinacion" type="text" class="form-control border-primary hidden" disabled>
                            <input id="inputCotizacion" name="inputCotizacion" type="text" class="form-control border-primary hidden" disabled>
                            <div class="form-group row">
                                <label class="col-md-2 label-control" for="selectGasto">Gasto</label>
                                <div class="col-md-10">
                                    <select id="selectGasto" name="selectGasto" class="select2-diacritics">
                                        <option value=""></option>
                                        <?php
                                            if (count($gasto) > 0) {
                                                foreach ($gasto as $row) {
                                                    echo '<option value="'.$row->gasto_id.'">'.$row->gasto_nombre.'</option>';
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 label-control" for="inputCosto">Importe</label>
                                <div class="col-md-7">
                                    <div class="input-group">
                                        <span class="input-group-btn btn-secondary">
                                            <select id="moneda_costo_perito" name="moneda_costo_perito" class="form-control" style="background-color: #404E67; color: white; border:0px;" disabled>
                                            <?php
                                                if (count($moneda) > 0) {
                                                    foreach ($moneda as $row) {
                                                        echo '<option value="'.$row->moneda_id.'" data-cambio="'.$row->moneda_monto.'">'.$row->moneda_simbolo.'</option>';
                                                    }
                                                }
                                            ?>
                                            </select>
                                        </span>
                                        <input id="inputCostoPerito" name="inputCostoPerito" type="number" class="form-control" style="text-align: right;" value="0" min="0" max="100000" step="1" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-group-sm float-right" role="group">
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
                            <table id="tableDetalleGasto" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th width="400">DESCRIPCIÓN</th>
                                        <th width="90">IMPORTE</th>
                                        <th>ACCIONES</th>
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
                <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>