<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('tasacion') ?>">Tasaciones</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Registro
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <section id="horizontal-form-layouts">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="horz-layout-colored-controls">REGISTRO DE TASACIONES</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li>
                                    <select id="selectTipoTasacion" class="select2-diacritics2">
                                        <option value="">&nbsp;--  Seleccioné  --&nbsp;</option>
                                        <option value="1">Terreno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        <option value="2">Casa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        <option value="3">Departamento&nbsp;&nbsp;</option>
                                        <option value="4">Oficina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        <option value="5">Local Comrecial</option>
                                        <option value="6">Local Industrial&nbsp;</option>
                                        <option value="7">Vehículo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                        <option value="8">Maquinaria&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                    </select>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form class="form form-horizontal" id="frmRegistro">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label class="text-left" for="inputCodigoCoordinacion">Código de Coordinación</label>
                                                    <input id="inputCodigoCoordinacion" type="text" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-left" for="inputFechaTasacion">Fecha de Tasación</label>
                                                    <div class="position-relative has-icon-left">
                                                        <input id="inputFechaTasacion" type="date" class="form-control text-right" name="date" value="<?php //echo date('Y-m-d'); ?>">
                                                        <div class="form-control-position">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="text-left" for="selectCliente">Cliente</label>
                                                    <input id="inputCliente" type="text" class="form-control hidden">
                                                    <fieldset id="fldSelectCliente">
                                                        <div class="input-group">
                                                            <select id="selectCliente" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonCliente" class="input-group-btn">
                                                                <a id="lnkNuevoCliente" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="text-left" for="selectPropietario">Propietario</label>
                                                    <input id="inputPropietario" type="text" class="form-control hidden">
                                                    <fieldset id="fldSelectPropietario">
                                                        <div class="input-group">
                                                            <select id="selectPropietario" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonPropietario" class="input-group-btn">
                                                                <a id="lnkNuevoPropietario" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="text-left" for="selectSolicitante">Solicitante</label>
                                                    <input id="inputSolicitante" type="text" class="form-control hidden">
                                                    <fieldset id="fldSelectSolicitante">
                                                        <div class="input-group">
                                                            <select id="selectSolicitante" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonSolicitante" class="input-group-btn">
                                                                <a id="lnkNuevoSolicitante" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="text-left" for="inputUbicacion">Ubicación</label>
                                                    <input id="inputUbicacion" type="text" class="form-control">
                                                </div>
                                                <div id="row_departamento" class="form-group col-md-4">
                                                    <label class="text-left" for="selectDepartamento">Departamento</label>
                                                    <select id="selectDepartamento" class="form-control select2-diacritics2"></select>
                                                </div>
                                                <div id="row_provincia" class="form-group col-md-4">
                                                    <label class="text-left" for="selectProvincia">Provincia</label>
                                                    <select id="selectProvincia" class="form-control select2-diacritics2"></select>
                                                </div>
                                                <div id="row_distrito" class="form-group col-md-4">
                                                    <label class="text-left" for="selectDistrito">Distrito</label>
                                                    <select id="selectDistrito" class="form-control select2-diacritics2"></select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div id="row_tipo_vehiculo" class="form-group col-md-6 hidden">
                                                    <label id="labelTipoVehiculo" class="text-left" for="selectTipoVehiculo">Tipo del Vehículo</label>
                                                    <select id="selectTipoVehiculo" class="form-control select2-diacritics">
                                                    </select>
                                                </div>
                                                <div id="row_marca_vehiculo" class="form-group col-md-6 hidden">
                                                    <label id="labelMarcaVehiculo" class="text-left" for="selectMarcaVehiculo">Marca del Vehículo</label>
                                                    <select id="selectMarcaVehiculo" class="form-control select2-diacritics">
                                                    </select>
                                                </div>
                                                <div id="row_modelo_vehiculo" class="form-group col-md-6 hidden">
                                                    <label id="labelModeloVehiculo" class="text-left" for="selectModeloVehiculo">Modelo del Vehículo</label>
                                                    <select id="selectModeloVehiculo" class="form-control select2-diacritics">
                                                    </select>
                                                </div>
                                                <div id="row_traccion_vehiculo" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectTraccionVehiculo">Tracción del Vehículo</label>
                                                    <select id="selectTraccionVehiculo" class="form-control select2-diacritics">
                                                    </select>
                                                </div>
                                                <div id="row_zonificacion" class="form-group col-md-6">
                                                    <label class="text-left" for="selectZonificacion">Zonificación</label>
                                                    <select id="selectZonificacion" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($zonificacion) > 0){
                                                            foreach ($zonificacion as $row) {
                                                                echo '<option value="'.$row->zonificacion_nombre.'">'.strtoupper($row->zonificacion_detalle).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-left" for="inputTipoCambio">Tipo de Cambio</label>
                                                    <input id="inputTipoCambio" type="number" class="form-control">
                                                </div>
                                                <div id="row_anio_fabricacion" class="form-group col-md-6">
                                                    <label class="text-left" for="inputAnioFabricacion">Año de Fabricación</label>
                                                    <input id="inputAnioFabricacion" type="number" class="form-control">
                                                </div>
                                                <div id="row_vsn" class="form-group col-md-6">
                                                    <label class="text-left" for="inputVSN">Valor Similar Nuevo (VSN)</label>
                                                    <input id="inputVSN" type="number" class="form-control">
                                                </div>
                                                <div id="row_propiedad" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectTipoCultivo">Tipo de Propiedad</label>
                                                    <select id="selectTipoPropiedad" class="form-control select2-diacritics2">
                                                        <option value="HORIZONTAL">HORIZONTAL</option>
                                                        <option value="EXCLUSIVA">EXCLUSIVA</option>
                                                    </select>
                                                </div>
                                                <div id="row_cultivo" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectTipoCultivo">Tipo Cultivo</label>
                                                    <select id="selectTipoCultivo" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($cultivo) > 0){
                                                            foreach ($cultivo as $row) {
                                                                echo '<option value="'.$row->cultivo_tipo_id.'">'.strtoupper($row->cultivo_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div id="row_vista" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectTipoCultivo">Vista Local</label>
                                                    <select id="selectVistaLocal" class="form-control select2-diacritics2">
                                                        <option value="1">INTERNA</option>
                                                        <option value="2">EXTERNA</option>
                                                    </select>
                                                </div>
                                                <div id="row_tipo" class="form-group col-md-6 hidden">
                                                    <label id="labelTipoDepartamento" lass="text-left" for="selectTipoDepartamento">ofi/dep tipo</label>
                                                    <select id="selectTipoDepartamento" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($tdepartamento) > 0){
                                                            foreach ($tdepartamento as $row) {
                                                                echo '<option value="'.$row->tipo_departamento_id.'">'.strtoupper($row->tipo_departamento_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div id="row_piso_ubicacion" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="inputPisoUbicacion">Piso Ubicación</label>
                                                    <input id="inputPisoUbicacion" type="number" class="form-control">
                                                </div>
                                                <div id="row_piso_cantidad" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="inputCantidadPisos">Cantidad de Pisos</label>
                                                    <input id="inputCantidadPisos" type="number" class="form-control">
                                                </div>
                                                <div id="row_area_terreno" class="form-group col-md-6">
                                                    <label class="text-left" for="inputAreaTerreno">Area de Terreno (m2)</label>
                                                    <input id="inputAreaTerreno" type="number" class="form-control">
                                                </div>
                                                <div id="row_vut" class="form-group col-md-6">
                                                    <label class="text-left" for="inputVUT">Valor Unitario de Terreno (VUT)</label>
                                                    <input id="inputVUT" type="number" class="form-control">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="text-left" for="inputValorComercial">Valor Comercial</label>
                                                    <input id="inputValorComercial" type="number" class="form-control">
                                                </div>
                                                <div id="row_edificacion" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="inputAreaEdificacion">Area de Edificacion</label>
                                                    <input id="inputAreaEdificacion" type="number" class="form-control">
                                                </div>
												<div id="row_tipo_edificacion" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectTipoEdificacion">Tipo Edificación</label>
                                                    <select id="selectTipoEdificacion" class="form-control select2-diacritics2">
                                                        <option value="O">OCUPADA</option>
                                                        <option value="T">TECHADA</option>
                                                    </select>
                                                </div>
                                                <div id="row_ocupada" class="form-group col-md-6 hidden">
                                                    <label id="labelAreaOcupada" class="text-left" for="inputAreaOcupada">Valor de Area Ocupada</label>
                                                    <input id="inputAreaOcupada" type="number" class="form-control">
                                                </div>
                                                <div id="row_complementaria" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="selectAreaComplementaria">Areas Complementarias</label>
                                                    <select id="selectAreaComplementaria" class="form-control select2-diacritics2">
                                                        <option value="0">NO</option>
                                                        <option value="1">SI</option>
                                                    </select>
                                                </div>
                                                <div id="row_estacionamiento" class="form-group col-md-6 hidden">
                                                    <label class="text-left" for="inputCantidadEstacionamiento">Cantidad de Estacionamientos</label>
                                                    <input id="inputCantidadEstacionamiento" type="number" class="form-control">
                                                </div>
                                                <div class="form-group col-12">
                                                    <label class="text-left" for="inputObservacion">Observación</label>
                                                    <!--<input id="inputObservacion" type="text" class="form-control">-->
													<textarea id="inputObservacion" rows="6" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label class="text-left" for="inputRutaInforme">Ruta del Informe</label>
                                                    <input id="inputRutaInforme" type="text" class="form-control">
                                                </div>
                                                <div id="row_latitud" class="form-group col-md-6">
                                                    <label class="text-left" for="inputLatitud">Latitud</label>
                                                    <input id="inputLatitud" type="number" class="form-control text-center" value="0.000000">
                                                </div>
                                                <div id="row_longitud" class="form-group col-md-6">
                                                    <label class="text-left" for="inputLongitud">Longitud</label>
                                                    <input id="inputLongitud" type="number" class="form-control text-center" value="0.000000">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions right">
                                    <button id="btnCancelar" type="button" class="btn btn-warning mr-1 btn-lg">
                                        <i class="ft-x"></i> Cancelar
                                    </button>
                                    <button id="btnSave" type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa fa-save"></i> Guardar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view("tasacion/modal/cliente_modal"); ?>
<?php $this->load->view("tasacion/modal/propietario_modal"); ?>
<?php $this->load->view("tasacion/modal/solicitante_modal"); ?>
<?php $this->load->view("tasacion/include/tasacion_mantenimiento_script"); ?>
<?php $this->load->view("includes/include_script_form"); ?>