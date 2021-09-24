<div class="modal fade text-left" id="mdl_inspeccion_detalle" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE INSPECCIÓN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frm_inspeccion">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="lnkDatosGenerales" data-toggle="tab" href="#linkDatosGenerales" aria-controls="linkDatosGenerales" aria-expanded="true">DATOS GENERALES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lnkUbigeo" data-toggle="tab" href="#linkUbicacion" aria-controls="linkUbicacion" aria-expanded="false">UBICACIÓN</a>
                                </li>
                            </ul>
                                <div class="form-body">
                                    <div class="tab-content px-1 pt-1">
                                        <!-- BEGIN DATOS GENERALES -->
                                        <div class="tab-pane active in" id="linkDatosGenerales" role="tabpanel" aria-labelledby="lnkDatosGenerales" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row hidden">
                                                        <label class="col-md-3 label-control text-left" for="inputId">Cogido</label>
                                                        <div class="col-md-9">
                                                            <input id="inputId" type="text" class="form-control border-primary" value="0" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-user"></i> ASIGNACIÓN DEL PERSONAL</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectPerito">Perito</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <select id="selectPerito" class="select2-diacritics border-primary">
                                                                    <option value=""></option>
                                                                    <?php
                                                                        if (count($peritos) > 0) {
                                                                            foreach ($peritos as $row) {
                                                                                echo '<option value="'.$row->perito_id.'">'.strtoupper($row->perito_nombre).'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft-users"></i> CONTACTO</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <textarea id="inputContacto" rows="5" class="form-control border-primary"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-calendar"></i> FECHA</strong>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-4 label-control text-left" for="inputFecha">Fecha</label>
                                                                <div class="col-md-8">
                                                                    <input id="inputFecha" type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-clock"></i> HORA</strong>
                                                        <div class="pull-right">
                                                            <select id="selectHoraTipo">
                                                                <option value="1">Exacta</option>
                                                                <option value="2">Estimada</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>HORA</th>
                                                                        <th></th>
                                                                        <th>MINUTOS</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>DESDE</td>
                                                                        <td><input id="inputHoraExacta" type="number" class="form-control border-primary" value="00" min="0" max="24"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosExacta" type="number" class="form-control border-primary" value="00" min="0" max="59"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoExacta" disabled>
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="trHEstimada" class="hidden">
                                                                        <td>HASTA</td>
                                                                        <td><input id="inputHoraEstimada" type="number" class="form-control border-primary" value="00" min="0" max="24"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosEstimada" type="number" class="form-control border-primary" value="00" min="0" max="59"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoEstimada" disabled>
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-file-text"></i> OBSERVACIONES</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <textarea id="inputInspeccionObservacion" rows="5" class="form-control border-primary"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END DATOS GENERALES -->

                                        <!-- BEGIN UBICACIÓN -->
                                        <div class="tab-pane" id="linkUbicacion" role="tabpanel" aria-labelledby="lnkUbigeo" aria-expanded="true">
                                            <!--Product sale & buyers -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectDepartamento">Departamento</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectDepartamento" name="selectDepartamento" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectProvincia">Provincia</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectProvincia" name="selectProvincia" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectDistrito">Distrito</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectDistrito" name="selectDistrito" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-12 label-control text-left" for="inputDireccion">Dirección <i style="color: red;">(Nota: No digitar departamento, provincia, ni distrito)</i></label>
                                                                <div class="col-md-12">
                                                                    <textarea id="inputDireccion" name="inputDireccion" rows="2" class="form-control border-primary"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Product sale & buyers -->
                                        </div>
                                        <!-- END UBICACIÓN -->
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="buttonCloseInspeccion" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="buttonSaveInspeccion" type="submit" class="btn grey btn-outline-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>