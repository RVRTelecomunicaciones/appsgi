<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a id="linkModulo" href="javascript:void(0)"><?= $modulo; ?></a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url($modulo.'/coordinaciones/listado') ?>">Coordinaciones</a>
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
                    <!--<div class="card-header">
                        <h4 class="card-title" id="horz-layout-colored-controls">FACTURACIÓN - COMPROBANTE DE PAGO</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload" onClick="window.location.reload()"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>-->
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                    <div class="card box-shadow-0">
                                        <div class="card-header card-head-inverse bg-primary" align="center">
                                            <h4 class="card-title">COTIZACIÓN
                                            <div id="cotizacionCodigo" class="hidden"></div></h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body" align="center">
                                                <h1><a id="cotizacionCorrelativo" href></a></h1>
                                                <h4>SERVICIO</h4>
                                                <h5 id="cotizacionServicioTipo"></h5>
                                            </div>
                                        </div>
                                        <div class="card-header card-head-inverse bg-primary" align="center">
                                            <h4 class="card-title">COORDINACIONES</h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <?php //if ($this->session->userdata('usu_id') == 41 || $this->session->userdata('usu_id') == 67) { ?>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button id="buttonNewCoordinacion" type="button" class="btn btn-primary btn-sm">Nueva Coordinación<i class="ft ft-plus"></i></button>
                                                    </div>
                                                </div>
                                                <?php //} ?>
                                                <table id="tbl_coordinacion" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>ESTADO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                                    <div class="card box-shadow-0">
                                        <div class="card-header card-head-inverse bg-primary">
                                            <h4 class="card-title">COORDINACIÓN: <strong id="coordinacionCorrelativo" style="color: #000000"></strong></h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="link-tab1" data-toggle="tab" href="#link1" aria-controls="link1" aria-expanded="true">DATOS COORDINACIÓN</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab2" data-toggle="tab" href="#link2" aria-controls="link2" aria-expanded="false">INSPECCIÓN</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="link-tab3" data-toggle="tab" href="#link3" aria-controls="link3" aria-expanded="false">BITÁCORA</a>
                                                    </li>
                                                </ul>
                                                <form id="frm_coordinacion" class="form form-horizontal">
                                                    <div class="form-body">
                                                        <div class="tab-content px-1 pt-1">
                                                            <!-- BEGIN DATOS COORDINACIÓN -->
                                                            <div class="tab-pane active in" id="link1" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="true">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group row hidden">
                                                                            <input id="inputCodigo" type="text" class="form-control" value="0" disabled>
                                                                        </div>

                                                                        <div class="form-group row">
                                                                            <div class="col-12">
                                                                                <button id="buttonSaveCoordinacion" type="submit" class="btn grey btn-outline-primary square float-right" style="margin-left: 10px;"><i class="ft ft-save"></i> Guardar</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-2 col-sm-2 col-md-2 col-lg-2 label-control text-left" for="selectRiesgo">Riesgo</label>
                                                                            <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                                                                                <div class="input-group">
                                                                                    <select id="selectRiesgo" class="select2-diacritics2 form-control" required>
                                                                                        <option value="1">BAJO</option>
                                                                                        <option value="2">MEDIO</option>
                                                                                        <option value="3">ALTO</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div id="divRiesgo" class="col-6 col-sm-6 col-md-7 col-lg-8" style="text-align: justify;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-12 col-sm-2 col-lg-2" for="selectCoordinador">Coordinador</label>
                                                                            <div class="col-12 col-sm-4 col-lg-4">
                                                                                <div class="input-group">
                                                                                    <select id="selectCoordinador" class="select2-diacritics2 form-control">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($coordinador) > 0) {
                                                                                                foreach ($coordinador as $row) {
                                                                                                    echo '<option value="'.$row->coordinador_id.'">'.strtoupper($row->coordinador_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <label class="col-12 col-sm-2 col-lg-2" for="selectEstado">Estado</label>
                                                                            <div class="col-12 col-sm-4 col-lg-4">
                                                                                <div class="input-group">
                                                                                    <select id="selectEstado" class="select2-diacritics2 form-control" data-estado="0">
                                                                                        <?php
                                                                                            if (count($estado) > 0) {
                                                                                                foreach ($estado as $row) {
                                                                                                    if ($row->estado_id == 3)
                                                                                                        echo '<option value="'.$row->estado_id.'" disabled="disabled">'.strtoupper($row->estado_nombre).'</option>';
                                                                                                    else
                                                                                                        echo '<option value="'.$row->estado_id.'">'.strtoupper($row->estado_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="labelCliente">Cliente</label>
                                                                            <div class="col-9 col-md-9">
                                                                                <div class="input-group">
                                                                                    <label id="labelCliente" class="form-control" readonly>&nbsp;</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-2 col-md-1" >
                                                                                <button id="buttonChangeCliente" type="button" class="btn btn-danger" style="width: 100%;" title="Cambiar Cliente"><i class="fa fa-refresh"></i></button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="labelSolicitante">Solicitante</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <label id="labelSolicitante" class="form-control" readonly>&nbsp;</label>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-2" align="center">
                                                                                <div class="badge badge-danger round">
                                                                                    <a href="www.google.com.pe">Información</a>
                                                                                </div>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="labelContacto">Contacto</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <label id="labelContacto" class="form-control" readonly>&nbsp;</label>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-2" align="center">
                                                                                <div class="badge badge-danger round">
                                                                                    <a href="www.google.com.pe">Información</a>
                                                                                </div>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left <?php echo $modulo == 'operaciones' ? 'hidden' : ''; ?>" for="labelFechaSolicitud">F. Solicitud</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2 <?php echo $modulo == 'operaciones' ? 'hidden' : ''; ?>">
                                                                                <label id="labelFechaSolicitud" class="form-control" readonly>&nbsp;</label>
                                                                            </div>
                                                                            <label class="col-sm-2 col-md-2 col-lg-1 label-control text-left <?php echo $modulo == 'operaciones' ? 'hidden' : ''; ?>" for="labelFechaAprobacion">F. Aprob.</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2 <?php echo $modulo == 'operaciones' ? 'hidden' : ''; ?>">
                                                                                <label id="labelFechaAprobacion" class="form-control" readonly>&nbsp;</label>
                                                                            </div>
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="inputFechaEntrega">F. Entrega al cliente</label>    
                                                                            <div class="col-sm-4 col-md-4 col-lg-3">
                                                                                <fieldset>
                                                                                    <div class="input-group-btn">
                                                                                        <input id="inputFechaEntrega" type="date" class="form-control">
                                                                                        <?php if ($this->session->userdata('usu_id') == 41 || $this->session->userdata('usu_id') == 67) {?>
                                                                                        <span class="input-group-btn">
                                                                                            <button id="buttonChangeFecha" type="button" class="btn grey btn-outline-secondary"><i class="fa fa-refresh"></i></button>
                                                                                        </span>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>
                                                                            <?php if ($modulo == 'operaciones'): ?>
                                                                                <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="inputFechaEntregaOperaciones">F. Entrega Operacioness</label>    
                                                                                <div class="col-sm-4 col-md-4 col-lg-3">
                                                                                    <input id="inputFechaEntregaOperaciones" type="date" class="form-control">
                                                                                </div>
                                                                                <?php else : ?>
                                                                                <input id="inputFechaEntregaOperaciones" type="hidden"  class="form-control">
                                                                            <?php endif ?>

                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputSucursal">Sucursal</label>
                                                                            <div class="col-md-10">
                                                                                <input id="inputSucursal" type="text" class="form-control">
                                                                            </div>                                                  
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="selectFormato">Formato</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <select id="selectFormato" class="select2-diacritics form-control">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($formato) > 0) {
                                                                                                foreach ($formato as $row) {
                                                                                                    echo '<option value="'.$row->formato_id.'">'.strtoupper($row->formato_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <!--<div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputServicioTipo">Tipo de Servicio</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <textarea id="inputServicioTipo" rows="5" class="form-control" disabled>
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>                                                                          
                                                                        </div>-->
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="selectTipoCambio">Tipo de Cambio</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2">
                                                                                <div class="input-group">
                                                                                    <select id="selectTipoCambio" class="select2-diacritics form-control">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($tcambio) > 0) {
                                                                                                foreach ($tcambio as $row) {
                                                                                                    echo '<option value="'.$row->tipo_cambio_id.'">'.strtoupper($row->tipo_cambio_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>                                                                      
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="solicitante">Tipo de Inspección</label>
                                                                            <div class="col-md-10">
                                                                                <div class="row skin skin-flat">
                                                                                    <div class="col-4 col-md-4">
                                                                                        <fieldset>
                                                                                            <input id="radioInterior" name="radio_inspeccion_tipo" type="radio">
                                                                                            <label for="radioInterior">Interior</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="col-4 col-md-4">
                                                                                        <fieldset>
                                                                                            <input id="radioExterior" name="radio_inspeccion_tipo" type="radio" checked>
                                                                                            <label for="radioExterior">Exterior</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="col-4 col-md-4">
                                                                                        <fieldset>
                                                                                            <input id="radioGabinete" name="radio_inspeccion_tipo" type="radio">
                                                                                            <label for="radioGabinete">Gabinete</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputObservacion">Observación: (Coordinación)</label>
                                                                            <div class="col-md-10">
                                                                                <textarea id="inputObservacion" rows="5" class="form-control" style="text-align: justify;"></textarea>
                                                                            </div>                                                  
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END DATOS COORDINACIÓN -->

                                                            <!-- BEGIN INSPECCIÓN -->
                                                            <div class="tab-pane" id="link2" role="tabpanel" aria-labelledby="link-tab2" aria-expanded="true">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group row">
                                                                            <button id="buttonNewInspeccion" type="button" class="btn grey btn-outline-info btn-sm">Nueva Inspección <i class="fa fa-plus"></i></button>
                                                                            <table id="tbl_inspeccion" class="table table-striped table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="30">#</th>
                                                                                        <th>INSPEC.</th>
                                                                                        <th>DIRECCIÓN</th>
                                                                                        <th>PERITO / INSPECTOR</th>
                                                                                        <th width="80">FECHA</th>
                                                                                        <th width="80">HORA</th>
                                                                                        <th>ESTADO</th>
                                                                                        <th width="100">ACCIONES</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="selectDigitador">Digitador</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <select id="selectDigitador" class="select2-diacritics form-control">
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
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="selectControlCalidad">Control de Calidad</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <select id="selectControlCalidad" class="select2-diacritics form-control">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($control_calidad) > 0) {
                                                                                                foreach ($control_calidad as $row) {
                                                                                                    echo '<option value="'.$row->control_calidad_id.'">'.strtoupper($row->control_calidad_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END INSPECCIÓN -->
                                                            
                                                            <!-- BEGIN BITÁCORA -->
                                                            <div class="tab-pane" id="link3" role="tabpanel" aria-labelledby="link-tab3" aria-expanded="true">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group row">
                                                                            <button id="buttonNewBitacora" type="button" class="btn grey btn-outline-info btn-sm mr-1">Nuevo <i class="fa fa-plus"></i></button>
                                                                            <button id="buttonPrintBitacora" type="button" class="btn grey btn-outline-secondary btn-sm">Imprimir <i class="fa fa-print"></i></button>
                                                                            <table id="tbl_bitacora" class="table table-striped table-bordered">
                                                                                <thead>
                                                                                    <tr>
                                                                                        <th width="30">#</th>
                                                                                        <th width="250">USUARIO</th>
                                                                                        <th>DESCRIPCIÓN</th>
                                                                                        <th width="80">FECHA</th>
                                                                                        <th width="80">HORA</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- END BITÁCORA -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view("coordinacion/modal/cambio_cliente_modal"); ?>
<?php $this->load->view("coordinacion/modal/cambio_fecha_modal"); ?>
<?php $this->load->view("coordinacion/modal/reproces_modal"); ?>
<?php $this->load->view("coordinacion/modal/inspeccion_mantenimiento_modal"); ?>
<?php $this->load->view("coordinacion/modal/hoja_coordinacion_modal"); ?>
<?php $this->load->view("coordinacion/modal/bitacora_modal"); ?>
<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("coordinacion/include/coordinacion_mantenimiento_script"); ?>