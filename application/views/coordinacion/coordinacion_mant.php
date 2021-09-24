<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Coordinación</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('coordinacion') ?>">Coordinaciones</a>
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
                        <!--<h4 class="card-title" id="horz-layout-colored-controls">FACTURACIÓN - COMPROBANTE DE PAGO</h4>-->
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="reload" onClick="window.location.reload()"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collpase show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-md-3 col-lg-3">
                                    <div class="card box-shadow-0 border-primary">
                                        <div class="card-header card-head-inverse bg-primary" align="center">
                                            <h4 class="card-title">COTIZACIÓN <div id="cotizacionId" class="hidden"></div> <div id="detector" class="hidden">0</div></h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body" align="center">
                                                <h1><a id="cotizacion_correlativo" href></a></h1>
                                                <h3><strong>Monto</strong></h3>
                                                <h4 id="cotizacion_importe"></h4>
                                            </div>
                                        </div>
                                        <div class="card-header card-head-inverse bg-primary" align="center">
                                            <h4 class="card-title">COORDINACIONES</h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <table id="tbl_coordinaciones" class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>N°</th>
                                                            <th>ESTADO</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="float-right paginacion">
                                                            <a id="botonAñadirCoordinacion" href class="btn btn-sm btn-primary square float-right"><i class="ft ft-plus"></i> Añadir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-12 col-md-9 col-lg-9">
                                    <div class="card box-shadow-0 border-primary">
                                        <div class="card-header card-head-inverse bg-primary">
                                            <h4 class="card-title">COORDINACIÓN: <strong id="coordinacion_correlativo" style="color: #000000"></strong></h4>
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
                                                </ul>
                                                <form class="form form-horizontal" id="frm_coordinacion">
                                                    <div class="form-body">
                                                        <div class="tab-content px-1 pt-1">
                                                            <!-- BEGIN DATOS COORDINACIÓN -->
                                                            <div class="tab-pane active in" id="link1" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="true">
                                                                <div class="row">
                                                                    <div class="col-md-12">
                                                                        <div class="form-group row hidden">
                                                                            <input id="inputCoordinacionId" type="text" class="form-control border-primary" value="0" disabled>
                                                                        </div>

                                                                        <!--QUITAR HIDDEN PARA EL RIESGO-->
                                                                        <div class="form-group row">
                                                                            <div class="col-12">
                                                                                <button id="botonSaveCoordinacion" type="submit" class="btn btn-primary square float-right" style="margin-left: 10px;"><i class="ft ft-save"></i> Guardar</button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-2 col-sm-2 col-md-2 col-lg-2 label-control text-left" for="selectRiesgo">Riesgo</label>
                                                                            <div class="col-4 col-sm-4 col-md-3 col-lg-2">
                                                                                <div>
                                                                                    <select id="selectRiesgo" name="selectRiesgo" class="select2-diacritics2" required>
                                                                                        <option value="1">BAJO</option>
                                                                                        <option value="2">MEDIO</option>
                                                                                        <option value="3">ALTO</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div id="riesgo_text" class="col-6 col-sm-6 col-md-7 col-lg-8" style="text-align: justify;">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-12 col-sm-2 col-lg-2  label-control text-left" for="lblCoordinador">Coordinador</label>
                                                                            <div class= "col-12 col-sm-4 col-lg-4">
                                                                                <select id="selectCoordinador" name="selectCoordinador" class="select2-diacritics2" required>
                                                                                    <option value=""></option>
                                                                                    <?php
                                                                                        if (count($coordinador) > 0){
                                                                                            foreach ($coordinador as $row) {
                                                                                                echo '<option value="'.$row->coordinador_id.'">'.strtoupper($row->coordinador_nombre).'</option>';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </select>   
                                                                            </div>
                                                                            <label class="col-12 col-sm-2 col-lg-2 label-control text-left" for="selectEstado">Estado:</label>
                                                                            <div class="col-12 col-sm-4 col-lg-4">
                                                                                <select id="selectEstado" name="selectEstado" class="select2-diacritics2" required>
                                                                                    <?php
                                                                                        if (count($estado) > 0){
                                                                                            foreach ($estado as $row) {
                                                                                                echo '<option value="'.$row->estado_id.'">'.strtoupper($row->estado_nombre).'</option>';
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </select>                                                   
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputCliente">Cliente</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <input id="inputCliente" name="inputCliente" type="text" class="form-control border-primary" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-2" align="center">
                                                                                <div class="badge badge-danger round">
                                                                                    <a href="www.google.com.pe">Información</a>
                                                                                </div>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputSolicitante">Solicitante</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <input  id="inputSolicitante" name="inputSolicitante" type="text" class="form-control border-primary" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-2" align="center">
                                                                                <div class="badge badge-danger round">
                                                                                    <a href="www.google.com.pe">Información</a>
                                                                                </div>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputContacto">Contacto</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <input id="inputContacto" name="inputContacto" type="text" class="form-control border-primary" disabled>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-2" align="center">
                                                                                <div class="badge badge-danger round">
                                                                                    <a href="www.google.com.pe">Información</a>
                                                                                </div>
                                                                            </div>-->
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="inputFechaSolicitud">F. Solicitud</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2">
                                                                                <label id="inputFechaSolicitud" class="form-control" readonly></label>
                                                                            </div>
                                                                            <label class="col-sm-2 col-md-2 col-lg-1 label-control text-left" for="inputFechaAprobacion">F. Aprob.</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2">
                                                                                <label id="inputFechaAprobacion" class="form-control" readonly>&nbsp;</label>
                                                                            </div>
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="inputFechaEntregaCliente">F. Entrega al cliente</label>    
                                                                            <div class="col-sm-4 col-md-4 col-lg-3">
                                                                                <fieldset>
                                                                                    <div class="input-group-btn">
                                                                                        <input id="inputFechaEntregaCliente" name="inputFechaEntregaCliente" type="date" class="form-control">
                                                                                        <span id="changeFecha" class="input-group-btn">
                                                                                            <a id="lnkChangeFecha" href="" class="btn btn-secondary"><i class="fa fa-refresh"></i></a>
                                                                                        </span>
                                                                                    </div>
                                                                                </fieldset>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputSucursal">Sucursal</label>
                                                                            <div class="col-md-10">
                                                                                <input id="inputSucursal" name="inputSucursal" type="text" class="form-control border-primary">
                                                                            </div>                                                  
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="selectFormato">Formato</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <select id="selectFormato" name="selectFormato" class="select2-diacritics border-primary">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($formato) > 0){
                                                                                                foreach ($formato as $row) {
                                                                                                    echo '<option value="'.$row->formato_id.'">'.strtoupper($row->formato_nombre).'</option>';
                                                                                                }
                                                                                            }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="selectTServicio">Tipo de Servicio</label>
                                                                            <div class="col-md-10">
                                                                                <div class="input-group">
                                                                                    <textarea id="inputTServicio" rows="5" class="form-control" disabled>
                                                                                    </textarea>
                                                                                </div>
                                                                            </div>                                                                          
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-sm-2 col-md-2 col-lg-2 label-control text-left" for="selectTCambio">Tipo de Cambio</label>
                                                                            <div class="col-sm-4 col-md-4 col-lg-2">
                                                                                <div class="input-group">
                                                                                    <select id="selectTCambio" name="selectTCambio" class="select2-diacritics">
                                                                                        <option value=""></option>
                                                                                        <?php
                                                                                            if (count($tcambio) > 0){
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
                                                                                            <input id="rbInterior" name="radio_inspeccion" type="radio">
                                                                                            <label for="rbInterior">Interior</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="col-4 col-md-4">
                                                                                        <fieldset>
                                                                                            <input id="rbExterior" name="radio_inspeccion" type="radio" checked>
                                                                                            <label for="rbExterior">Exterior</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                    <div class="col-4 col-md-4">
                                                                                        <fieldset>
                                                                                            <input id="rbGabinete" name="radio_inspeccion" type="radio">
                                                                                            <label for="rbGabinete">Gabinete</label>
                                                                                        </fieldset>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row">
                                                                            <label class="col-md-2 label-control text-left" for="inputCoordinacionObservacion">Observación: (Coordinación)</label>
                                                                            <div class="col-md-10">
                                                                                <div class="position-relative has-icon-left">
                                                                                    <textarea id="inputCoordinacionObservacion" name="inputCoordinacionObservacion" rows="3" class="form-control" style="text-align: justify;"></textarea>
                                                                                    <div class="form-control-position">
                                                                                        <i class="ft-file"></i>
                                                                                    </div>
                                                                                </div>
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
                                                                            <div class="col-md-12">
                                                                                <a id="linkEditarInspeccion" href class="btn btn-sm btn-primary square float-right" style="margin-left: 10px;"><i class="ft ft-edit"></i> Editar</a>
                                                                                <a id="linkVerHoja" href class="btn btn-sm btn-info square float-right"><i class="ft ft-file"></i> Ver Hoja</a>
                                                                            </div>
                                                                            <table class="table table-bordered">
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td colspan="2"><strong>CONTACTO</strong></td>
                                                                                        <td width="120"><strong>FECHA</strong></td>
                                                                                        <td width="120"><strong>HORA</strong></td>
                                                                                        <td width="300"><strong>DIRECCIÓN</strong></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="2"><div id="infContacto" style="font-size: 1rem" align="left"></div></td>
                                                                                        <td><div id="infFecha" style="font-size: 1rem"></div></td>
                                                                                        <td><div id="infHora" style="font-size: 1rem"></div></td>
                                                                                        <td>
                                                                                            <div style="font-size: 1rem"><b id="infDepartamento"></b> <i class="fa fa-play" style="color: red;"></i> <b id="infProvincia"></b> <i class="fa fa-play" style="color: red;"></i> <b id="infDistrito"></b></div>
                                                                                            <hr>
                                                                                            <div id="infDireccion" align="left" style="font-size: 1rem"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="100"><strong>PERITO</strong></td>
                                                                                        <td colspan="4"><div id="infPerito" align="left" style="font-size: 1rem"></div></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td width="100"><strong>CONTROL DE CALIDAD</strong></td>
                                                                                        <td colspan="4"><div id="infCCalidad" align="left" style="font-size: 1rem"></div></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td colspan="5">
                                                                                            <div align="left"><strong>OBSERVACIÓN: </strong></div>
                                                                                            <div id="infObservacion" align="left" style="font-size: 1rem"></div>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <?php if ($this->session->userdata('usu_id') == 67) { ?>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <button id="buttonNuevaInspeccion" type="button" class="btn btn-info btn-sm">Nueva Inspección <i class="fa fa-plus"></i></button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-12">
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
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <div class="form-group row">
                                                                                <label class="col-md-3 label-control text-left" for="selectDigitadorDetalle">Digitador</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <select id="selectDigitadorDetalle" name="selectDigitadorDetalle" class="select2-diacritics border-primary">
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group row">
                                                                                <label class="col-md-3 label-control text-left" for="selectControlCalidadDetalle">Control Calidad</label>
                                                                                <div class="col-md-9">
                                                                                    <div class="input-group">
                                                                                        <select id="selectControlCalidadDetalle" name="selectControlCalidadDetalle" class="select2-diacritics border-primary">
                                                                                        </select>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <!-- END INSPECCIÓN -->
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
<?php $this->load->view("coordinacion/modal/cambiar_fecha_modal"); ?>
<?php $this->load->view("coordinacion/modal/reproceso_modal"); ?>
<?php $this->load->view("coordinacion/modal/inspeccion_modal"); ?>
<?php $this->load->view("coordinacion/modal/hoja_coordinacion_modal"); ?>
<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("coordinacion/include/coordinacion_mant_script"); ?>