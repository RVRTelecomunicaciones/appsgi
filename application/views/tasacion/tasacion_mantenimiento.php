<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)"><?= $modulo; ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('tasaciones/por-registrar/listado') ?>"><?= str_replace('-', ' ', $menu); ?></a>
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
                                    <div class="hidden">
                                        <label id="labelTasacionCodigo" class="form-control hidden" readonly="readonly">0</label>
                                        <select id="selectTipoTasacion" class="select2-diacritics2 form-control">
                                            <option value="">Seleccioné&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="1">Terreno&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="2">Casa&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="3">Departamento&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="4">Oficina&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="5">Local Comercial&nbsp;&nbsp;</option>
                                            <option value="6">Local Industrial&nbsp;&nbsp;&nbsp;</option>
                                            <option value="7">Vehículo&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="8">Maquinaria&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
                                            <option value="9">Otras Tasaciones</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <form id="frm_tasacion">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div class="form-group col-6">
                                                    <label class="text-left" for="inputCoordinacionCodigo">Código de Coordinación</label>
                                                    <input id="inputCoordinacionCodigo" type="text" class="form-control" disabled="disabled" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                </div>
                                                <div id="row_fecha_tasacion" class="form-group col-6">
                                                    <label class="text-left" for="inputFecha">Fecha de Tasación</label>
                                                    <input id="inputFecha" type="date" class="form-control text-right" name="date">
                                                </div>
                                                <div id="row_tipo_no_registrado" class="form-group col-12 hidden">
                                                    <label id="labelTipoNoRegistrado" class="text-left" for="selectTipoNoRegistrado">Tipo</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <select id="selectTipoNoRegistrado" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonTipoNoRegistrado" class="input-group-btn">
                                                                <a id="lnkNuevoTipoNoRegistrado" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_propietario" class="form-group col-md-12">
                                                    <label class="text-left" for="selectPropietario">Propietario</label>
                                                    <input id="selectPropietario" type="text" class="form-control">
                                                    <!--<fieldset id="fldSelectPropietario">
                                                        <div class="input-group">
                                                            <select id="selectPropietario" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonPropietario" class="input-group-btn">
                                                                <a id="lnkNuevoPropietario" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>-->
                                                </div>
                                                <div id="row_cliente" class="form-group col-md-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="text-left" for="labelCliente">Cliente</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div id="row_tipo_cliente" class="row">
                                                                <div class="col-6">
                                                                    <fieldset>
                                                                        <input id="radioClienteJuridico" type="radio" name="cliente_tipo" value="Juridica" checked>
                                                                        <label for="radioClienteJuridico"> Jurídico</label>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-6">
                                                                    <fieldset>
                                                                        <input id="radioClienteNatural" type="radio" name="cliente_tipo" value="Natural">
                                                                        <label for="radioClienteNatural"> Natural</label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label id="labelClienteCodigo" class="form-control hidden" readonly="readonly">&nbsp;</label>
                                                    <label id="labelClienteTipo" class="form-control hidden" readonly="readonly">&nbsp;</label>
                                                    <label id="labelCliente" class="form-control" readonly="readonly">&nbsp;</label>
                                                    <fieldset id="fldSelectCliente" class="hidden">
                                                        <div class="input-group">
                                                            <select id="selectCliente" class="form-control select2-diacritics"></select>
                                                            <span class="input-group-btn">
                                                                <button id="buttonNuevoCliente" type="button" class="btn grey btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_solicitante" class="form-group col-md-12">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <label class="text-left" for="labelCliente">Solicitante</label>
                                                        </div>
                                                        <div class="col-6">
                                                            <div id="row_tipo_solicitante" class="row">
                                                                <div class="col-6">
                                                                    <fieldset>
                                                                        <input id="radioSolicitanteJuridico" type="radio" name="solicitante_tipo" value="Juridica" checked>
                                                                        <label for="radioSolicitanteJuridico"> Jurídico</label>
                                                                    </fieldset>
                                                                </div>
                                                                <div class="col-6">
                                                                    <fieldset>
                                                                        <input id="radioSolicitanteNatural" type="radio" name="solicitante_tipo" value="Natural">
                                                                        <label for="radioSolicitanteNatural"> Natural</label>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <label id="labelSolicitanteCodigo" class="form-control hidden" readonly="readonly">&nbsp;</label>
                                                    <label id="labelSolicitanteTipo" class="form-control hidden" readonly="readonly">&nbsp;</label>
                                                    <label id="labelSolicitante" class="form-control" readonly="readonly">&nbsp;</label>
                                                    <fieldset id="fldSelectSolicitante" class="hidden">
                                                        <div class="input-group">
                                                            <select id="selectSolicitante" class="form-control select2-diacritics"></select>
                                                            <span class="input-group-btn">
                                                                <button id="buttonNuevoSolicitante" type="button" class="btn grey btn-outline-secondary"><i class="fa fa-plus"></i></button>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_direccion" class="form-group col-md-12">
                                                    <label class="text-left" for="inputDireccion">Dirección</label>
                                                    <input id="inputDireccion" type="text" class="form-control">
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
                                                <!--<div id="row_nota" class="form-group col-md-12">
                                                    <label> <b class="text-danger">Nota:</b> Verificar si el distrito si corresponde a la tasación (informe).</label>
                                                    <hr class="d-md-none d-lg-block">
                                                </div>-->
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="row">
                                                <div id="row_clase" class="form-group col-6 hidden">
                                                    <label id="labelTipoVehiculo" class="text-left" for="selectClase">Clase</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <select id="selectClase" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonClase" class="input-group-btn">
                                                                <a id="lnkNuevoClase" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_marca" class="form-group col-6 hidden">
                                                    <label id="labelMarca" class="text-left" for="selectMarca">Marca</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <select id="selectMarca" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonMarca" class="input-group-btn">
                                                                <a id="lnkNuevoMarca" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_modelo" class="form-group col-6 hidden">
                                                    <label id="labelModelo" class="text-left" for="selectModelo">Modelo</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <select id="selectModelo" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonModelo" class="input-group-btn">
                                                                <a id="lnkNuevoModelo" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_zonificacion" class="form-group col-6">
                                                    <label class="text-left" for="selectZonificacion">Zonificación</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <select id="selectZonificacion" class="form-control select2-diacritics"></select>
                                                            <span id="spanBotonZonificacion" class="input-group-btn">
                                                                <a id="lnkNuevoZonificacion" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div id="row_tipo_cambio" class="form-group col-6">
                                                    <label class="text-left" for="inputTipoCambio">Tipo de Cambio</label>
                                                    <input id="inputTipoCambio" type="number" class="form-control">
                                                </div>
                                                <div id="row_anio_fabricacion" class="form-group col-6 hidden">
                                                    <label class="text-left" for="inputAnioFabricacion">Año de Fabricación</label>
                                                    <input id="inputAnioFabricacion" type="number" class="form-control">
                                                </div>
                                                <div id="row_vsn" class="form-group col-6 hidden">
                                                    <label class="text-left" for="inputVSN">Valor Similar Nuevo (VSN)</label>
                                                    <input id="inputVSN" type="number" class="form-control">
                                                </div>
												<div id="row_local_tipo" class="form-group col-6 hidden">
                                                    <label class="text-left" for="selectTipoLocal">Tipo Local</label>
                                                    <select id="selectTipoLocal" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($tlocal) > 0){
                                                            foreach ($tlocal as $row) {
                                                                echo '<option value="'.$row->local_tipo_id.'">'.strtoupper($row->local_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div id="row_cultivo" class="form-group col-6 hidden">
                                                    <label class="text-left" for="selectTipoCultivo">Tipo Terreno</label>
                                                    <select id="selectTipoCultivo" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($cultivo) > 0){
                                                            foreach ($cultivo as $row) {
                                                                echo '<option value="'.$row->terreno_tipo_id.'">'.strtoupper($row->terreno_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div id="row_tipo_departamento" class="form-group col-6 hidden">
                                                    <label id="labelTipoDepartamento" lass="text-left" for="selectTipoDepartamento">Departamento tipo</label>
                                                    <select id="selectTipoDepartamento" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($tdepartamento) > 0){
                                                            foreach ($tdepartamento as $row) {
                                                                echo '<option value="'.$row->departamento_tipo_id.'">'.strtoupper($row->departamento_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <div id="row_area_terreno" class="form-group col-6">
                                                    <label class="text-left" for="inputAreaTerreno">Area de Terreno (m2)</label>
                                                    <input id="inputAreaTerreno" type="number" class="form-control">
                                                </div>
                                                <div id="row_vut" class="form-group col-6">
                                                    <label class="text-left" for="inputVUT">Valor Unitario de Terreno (VUT)</label>
                                                    <input id="inputVUT" type="number" class="form-control">
                                                </div>
                                                <div id="row_valor_comercial" class="form-group col-6">
                                                    <label class="text-left" for="inputValorComercial">Valor Comercial <b>(Informe)</b></label>
                                                    <input id="inputValorComercial" type="number" class="form-control">
                                                </div>
												<div id="row_valor_comercial_departamento" class="form-group col-6 hidden">
                                                    <label class="text-left" for="inputValorComercialDepartamento">Valor Comercial <b>(Departamento)</b></label>
                                                    <input id="inputValorComercialDepartamento" type="number" class="form-control text-right">
                                                </div>
                                                <div id="row_edificacion" class="form-group col-6 hidden">
                                                    <label class="text-left" for="inputAreaEdificacion">Area de Edificacion</label>
                                                    <input id="inputAreaEdificacion" type="number" class="form-control">
                                                </div>
                                                <div id="row_ocupada" class="form-group col-6 hidden">
                                                    <label id="labelAreaOcupada" class="text-left" for="inputAreaOcupada">Valor(m2) por Area Ocupada</label>
                                                    <input id="inputAreaOcupada" type="number" class="form-control">
                                                </div>
                                                <div id="row_antiguedad" class="form-group col-6 hidden">
                                                    <label class="text-left" for="inputAntiguedad">Antiguedad</label>
                                                    <input id="inputAntiguedad" type="number" class="form-control text-right">
                                                </div>
                                                <div id="row_observacion" class="form-group col-12">
                                                    <label class="text-left" for="inputObservacion">Observación</label>
                                                    <textarea id="inputObservacion" rows="6" class="form-control"></textarea>
                                                </div>
                                                <div class="form-group col-12">
                                                    <label class="text-left" for="inputRutaInforme">Ruta del Informe</label>
                                                    <input id="inputRutaInforme" type="text" class="form-control" autocomplete="off">
                                                </div>
                                                <div id="row_latitud" class="form-group col-6">
                                                    <label class="text-left" for="inputLatitud">Latitud</label>
                                                    <input id="inputLatitud" type="number" class="form-control text-center" placeholder="0.000000">
                                                </div>
                                                <div id="row_longitud" class="form-group col-6">
                                                    <label class="text-left" for="inputLongitud">Longitud</label>
                                                    <input id="inputLongitud" type="number" class="form-control text-center" placeholder="0.000000">
                                                </div>
                                                <!--<div class="form-group col-12">
                                                    <label class="text-left" for="inputRutaInforme">Adjunto</label>
                                                    <style>
                                                        .upload {
                                                            display: none;
                                                        }
                                                        .uploader {
                                                            border: 1px solid #ccc;
                                                            width: auto;
                                                            position: relative;
                                                            height: 30px;
                                                            display: flex;
                                                            border: 1px solid #00B5B8!important;
                                                            border-radius: 0.25rem;
                                                        }
                                                        .uploader .input-value{
                                                            width: auto;
                                                            padding: 5px;
                                                            overflow:;
                                                            text-overflow: ellipsis;
                                                            line-height: 25px;
                                                            font-family: sans-serif;
                                                            font-size: 16px;
                                                        }
                                                        .uploader label {
                                                            cursor: pointer;
                                                            margin: 0;
                                                            width: 30px;
                                                            height: 30px;
                                                            position: absolute;
                                                            right: 0;
                                                            background: #c3e3fc url('https://www.interactius.com/wp-content/uploads/2017/09/folder.png') no-repeat center;
                                                            border-top-right-radius: 0.22rem;
                                                            border-bottom-right-radius: 0.22rem;
                                                            margin-top: -1px;
                                                            margin-right: -1px;
                                                        }
                                                    </style>
                                                    <div class="uploader">
                                                        <div id="adjunto" class="input-value"></div>
                                                        <label for="inputAdjunto"></label>
                                                        <input id="inputAdjunto" name="inputAdjunto" class="upload" type="file" accept="application/pdf">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label> <b class="text-danger">Nota:</b> Subir el pdf de la tasación.</label>
                                                </div>-->
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
<?php //$this->load->view("tasacion/modal/propietario_modal"); ?>
<?php //$this->load->view("tasacion/modal/cliente_modal"); ?>
<?php //$this->load->view("tasacion/modal/solicitante_modal"); ?>
<?php $this->load->view("tasacion/modal/involucrados_modal"); ?>
<?php $this->load->view("tasacion/modal/zonificacion_modal"); ?>
<?php $this->load->view("tasacion/modal/clase_modal"); ?>
<?php $this->load->view("tasacion/modal/marca_modal"); ?>
<?php $this->load->view("tasacion/modal/modelo_modal"); ?>
<?php $this->load->view("tasacion/modal/tipo_no_registrado_modal"); ?>
<?php $this->load->view("tasacion/include/tasacion_mantenimiento_script"); ?>
<?php $this->load->view("includes/include_script_form"); ?>