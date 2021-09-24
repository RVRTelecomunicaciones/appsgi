<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
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
                        <a href="<?= base_url('cotizacion') ?>">Cotizaciones</a>
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
    <section id="text-inputs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                            <h4 class="card-title">MANTENIMIENTO DE COTIZACIONES</h4>
                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                            <div class="heading-elements">
                                <ul class="list-inline mb-0">
                                    <li><a data-action="reload" onClick="window.location.reload()"><i class="ft-rotate-cw"></i></a></li>
                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                </ul>
                            </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="link-tab1" data-toggle="tab" href="#link1" aria-controls="link1" aria-expanded="true">GENERAL</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab2" data-toggle="tab" href="#link2" aria-controls="link2" aria-expanded="false">INVOLUCRADOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab3" data-toggle="tab" href="#link3" aria-controls="link3" aria-expanded="false">SERVICIOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab4" data-toggle="tab" href="#link4" aria-controls="link4">COSTOS</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab5" data-toggle="tab" href="#link5" aria-controls="link5">SEGUIMIENTO</a>
                                </li>
                            </ul>
                            <div id="buttons-content" class="row">
                                <div class="col-md-12">
                                    <a id="linkCoordinaciones" href class="btn btn-lg btn-info square float-right hidden" style="margin-left: 10px;"><i class="fa fa-list"></i> Coordinaciones</a>
                                    <a id="linkGrabarCotizacion" href class="btn btn-lg btn-primary square float-right" style="margin-left: 10px;"><i class="ft ft-save"></i> Guardar</a>
                                    <a id="linkCancelar" href class="btn btn-lg btn-warning square float-right"><i class="ft-x"></i> Cancelar</a>
                                </div>
                            </div>
                            <form class="form form-horizontal" id="formRegistroFinal">
                                <div class="form-body">
                                    <div class="tab-content px-1 pt-1">
                                        <!-- BEGIN GENERAL -->
                                        <div class="tab-pane active in" id="link1" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control text-left" for="inputCotizacionCorrelativo">Codigo de Cotización</label>
                                                        <div class="col-md-2">
                                                            <input type="text" id="inputIdCorrelativo" name="inputIdCorrelativo" class="form-control border-primary hidden" value="0" disabled>
                                                            <input type="text" id="inputCotizacionCorrelativo" class="form-control border-primary" name="inputCotizacionCorrelativo" value="[Nuevo]" style="text-align: right;" disabled>
                                                        </div>
                                                        
                                                        <label class="col-md-2 label-control text-left" for="checkActualizacion">Actualización</label>
                                                        <div class="col-md-1">
                                                            <input type="checkbox" id="checkActualizacion" name="checkActualizacion">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control text-left" for="selectTCotizacion">Tipo de Cotización</label>
                                                        <div class="col-md-2">
                                                            <select id="selectTCotizacion" name="selectTCotizacion" class="select2-diacritics2" class="form-control border-primary">
                                                            <?php
                                                                if (count($tcotizacion) > 0){
                                                                    foreach ($tcotizacion as $row) {
                                                                        echo '<option value="'.$row->cotizacion_tipo_id.'">'.strtoupper($row->cotizacion_tipo_nombre).'</option>';
                                                                    }
                                                                }s
                                                            ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 label-control text-left" for="inputCantidadInformes">Cantidad de Informes</label>
                                                        <div class="col-md-2">
                                                            <input type="number" id="inputCantidadInformes" class="form-control border-primary" name="inputCantidadInformes" style="text-align: right;" placeHolder="0" min="1" max="50">
                                                        </div>
                                                        <label class="col-md-2 label-control text-left" for="selectCotizacionEstado">Estado de Cotización</label>
                                                        <div class="col-md-2">
                                                            <select id="selectCotizacionEstado" name="selectCotizacionEstado" class="select2-diacritics2 form-control">
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
                                                        <label class="col-md-2 label-control text-left" for="selectTServicio">Tipo de Servicio</label>
                                                        <div class="col-md-10">
                                                            <select id="selectTServicio" class="form-control js-example-programmatic-multi" multiple="multiple">
                                                            <?php
                                                                if (count($tservicio) > 0){
                                                                    foreach ($tservicio as $row) {
                                                                        echo '<option value="'.$row->servicio_tipo_id.'">'.strtoupper($row->servicio_tipo_nombre).'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control text-left" for="solicitante">Adjunto (Propuesta)</label>
                                                        <div class="col-md-10">
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
                                                                    overflow: hidden;
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
                                                    </div>

                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control text-left" for="inputOrdenServicio">Orden de Compra / Servicio</label>
                                                        <div class="col-md-3">
                                                            <label id="inputOrdenServicio" class="form-control border-primary text-right">&nbsp;</label>
                                                        </div>
                                                        <label class="col-md-2 label-control text-left" for="inputOrdenServicioAdjunto">Adjunto (Orden de Compra / Servicio)</label>
                                                        <div class="col-md-5">
                                                            <div id="inputOrdenServicioAdjunto" class="form-control border-primary">&nbsp;</div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <a id="linkGenerarPropuesta" name="linkGenerarPropuesta" href class="btn btn-outline-info square hidden"><i class="fa fa-file-word-o"></i> Generar Word</a>
                                                        <?php if ($this->session->userdata('usu_id') == '67') { ?>
                                                        <a id="linkGenerarPropuesta2" name="linkGenerarPropuesta2" href class="btn btn-outline-info square"><i class="fa fa-file-word-o"></i> Generar Word Nueva</a>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <h4 class="form-section"><i class="fa fa-calendar"></i> FECHAS</h4>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="inputFSolicitud">De Solicitud</label>
                                                        <div class="col-md-6">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="date" id="inputFSolicitud" class="form-control border-primary" name="date" value="<?php echo date('Y-m-d'); ?>">
                                                                <div class="form-control-position">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a id="linkLimpiarFSolicitud" href="" class="btn btn-light">Limpiar</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="inputFEnvio">De Envío al Cliente</label>
                                                        <div class="col-md-6">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="date" id="inputFEnvio" class="form-control border-primary" name="date" value="<?php echo date('Y-m-d'); ?>" min="<?php echo date('Y-m-d'); ?>">
                                                                <div class="form-control-position">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a id="linkLimpiarFEnvio" href="" class="btn btn-light">Limpiar</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="inputFFinalizacion">De Aprobación</label>
                                                        <div class="col-md-6">
                                                            <div class="position-relative has-icon-left">
                                                                <input type="date" id="inputFFinalizacion" class="form-control border-primary" name="date" min="<?php echo date('Y-m-d'); ?>" readonly>
                                                                <div class="form-control-position">
                                                                    <i class="fa fa-calendar"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <a id="linkLimpiarFFinalizacion" href="" class="btn btn-light">Limpiar</a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="inputPlazo">Plazo de entrega</label>
                                                        <div class="col-md-6">
                                                            <input id="inputPlazo" name="inputPlazo" type="number" class="form-control border-primary text-right" placeHolder="0" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                        </div>
                                                        <div class="col-md-3">
                                                            Días Calendario
                                                        </div>
                                                    </div>
                                                    <div class="form-group row hidden">
                                                        <div class="col-md-12">
                                                            <div class="bs-callout-info callout-border-left mt-1 p-1">
                                                                <p>El cliente solicita servicio de Actualización del servicio anterior</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END GENERAL -->

                                        <!-- BEGIN INVOLUCRADOS -->
                                        <div class="tab-pane" id="link2" role="tabpanel" aria-labelledby="link-tab2" aria-expanded="true">
                                            Coordinador:  <span id="spanCoordinador"></span>
                                            <h4 class="form-section"></h4>
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-3">
                                                    <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <fieldset id="checkboxCliente">
                                                                    <input type="checkbox" name="checkCliente" id="checkCliente">
                                                                    <label for="rbSolicitante">Cliente</label>
                                                                </fieldset>
                                                            </div>
                                                            <div class="form-group row">
                                                                <fieldset id="checkboxSolicitante">
                                                                    <input type="checkbox" name="checkSolicitante" id="checkSolicitante">
                                                                    <label for="rbSolicitante">Solicitante</label>
                                                                </fieldset>
                                                            </div>
                                                            <div class="form-group row">
                                                                <fieldset id="checkboxPropietario">
                                                                    <input type="checkbox" name="checkPropietario" id="checkPropietario">
                                                                    <label for="rbSolicitante">Propietario</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <fieldset id="radioButtonCliente">
                                                                    <input type="radio" name="tipo_persona" id="radioJuridica" checked>
                                                                    <label for="rbSolicitante">Jurídico</label>
                                                                </fieldset>
                                                            </div>
                                                            <div class="form-group row">
                                                                <fieldset id="radioButtonSolicitante">
                                                                    <input type="radio" name="tipo_persona" id="radioNatural">
                                                                    <label for="rbSolicitante">Natural</label>
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-8">
                                                    <div class="form-group row">
                                                        <label id="labelInvolucrado" class="col-md-2 label-control" for="selectInvolucrado">Razón Social</label>
                                                        <div class="col-md-10">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn" id="button-addon3">
                                                                        <a id="linkNuevoInvolucrado" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                                    </span>
                                                                    <select id="selectInvolucrado" name="selectInvolucrado" class="select2-diacritics">
                                                                    </select>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                    </div>

                                                    <div id="divContacto" class="form-group row">
                                                        <label class="col-md-2 label-control" for="solicitante">Contacto</label>
                                                        <div id="gridContacto" class="col-md-10">
                                                            <fieldset>
                                                                <div class="input-group">
                                                                    <span class="input-group-btn" id="button-addon3">
                                                                        <a id="linkNuevoContacto" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                                    </span>
                                                                    <select id="selectContacto" name="selectContacto" class="select2-diacritics">
                                                                    </select>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <label id="labelMotivo" class="col-md-1 label-control hidden" for="solicitante">Motivo</label>
                                                        <div class="col-md-4">
                                                            <input id="inputMotivo" type="text" class="form-control border-primary hidden">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row float-right">
                                                        <div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                                            <a id="linkLimpiarInvolucrados" href="" class="btn btn-light square">Limpiar</a>
                                                            <a id="linkAñadirInvolucrados" href="" class="btn btn-primary square">Añadir</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-1"></div>
                                                <div class="col-md-10">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-light">
                                                            <tr>
                                                                <th width="80">ROL</th>
                                                                <th width="80">TIPO</th>
                                                                <th>RAZÓN SOCIAL / NOMBRE</th>
                                                                <th width="110">RUC / DNI</th>
                                                                <th width="200">TELÉFONO</th>
                                                                <th width="200">CORREO</th>
                                                                <th width="80">ACCIÓN</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="showInvolucrados" style="font-size: 1rem;">
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-1"></div>
                                            </div>
                                            <br>
                                            <h4 class="form-section"></h4>
                                            <div class="row">
                                                <div class="col-md-6"></div>
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control" for="selectVendedor">Vendedor</label>
                                                        <div class="col-md-6">
                                                            <select id="selectVendedor" name="selectVendedor" class="select2-diacritics">
                                                                <option value=""></option>
                                                            <?php
                                                                if (count($vendedor) > 0){
                                                                    foreach ($vendedor as $row) {
                                                                        echo '<option value="'.$row->vendedor_id.'">'.strtoupper($row->vendedor_nombre).'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 label-control" for="inputComisionVendedor">Comisión %</label>
                                                        <div class="col-md-2">
                                                            <input id="inputComisionVendedor" name="inputComisionVendedor" type="number" class="form-control border-primary text-right" value="0" max="100" disabled>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- END INVOLUCRADOS -->

                                        <!-- BEGIN SERVICIOS -->
                                        <div class="tab-pane" id="link3" role="tabpanel" aria-labelledby="link-tab3" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <div class="col-md-8">
                                                            <h4 class="form-section">SERVICIOS</h4>
                                                            <div class="form-group row">
                                                                <label class="col-md-2 label-control" for="selectServicio">Servicio</label>
                                                                <div class="col-md-10">
                                                                    <fieldset>
                                                                        <div class="input-group">
                                                                            <?php if ($this->session->userdata('usu_id') == '41' || $this->session->userdata('usu_id') == '67') { ?>
                                                                            <span class="input-group-btn" id="button-addon3">
                                                                                <a id="linkNuevoSubServicio" href="" class="btn btn-secondary"><i class="fa fa-plus"></i></a>
                                                                            </span>
                                                                            <?php } ?>
                                                                            <select id="selectServicio" name="selectServicio" class="select2-diacritics">
                                                                            </select>
                                                                        </div>
                                                                    </fieldset>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-2 label-control" for="solicitante">Cantidad</label>
                                                                <div class="col-md-2">
                                                                    <input id="inputCantidad" name="inputCantidad" type="number" class="form-control border-primary" style="text-align: right;" value="1" min="1">
                                                                </div>
                                                                <label class="col-md-1 label-control" for="inputCosto">Costo</label>
                                                                <div class="col-md-3">
                                                                    <input id="inputCosto" name="inputCosto" type="number" class="form-control border-primary" style="text-align: right;" placeHolder="0.00" min="0">
                                                                </div>
                                                                <div class="btn-group btn-group-sm" role="group">
                                                                    <a id="linkLimpiar" href="" class="btn btn-light square"><br>Limpiar</a>
                                                                    <a id="linkAñadir" href="" class="btn btn-primary square"><br>Añadir</a>
                                                                </div>
                                                            </div>
                                                            <table class="table table-bordered">
                                                                <thead class="thead-light">
                                                                    <tr>
                                                                        <th width="350">SERVICIO</th>
                                                                        <!--<th width="40">COSTO UNITARIO</th>-->
                                                                        <th width="40">CANTIDAD</th>
                                                                        <th width="100">SUBTOTAL</th>
                                                                        <th width="40">ACCIONES</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="showServicios" style="font-size: 1rem;"></tbody>
                                                                <tfoot id="showFootServicio"></tfoot>
                                                            </table>
															<hr style="background: black;">
                                                            <div class="form-group row">
                                                                <label class="col-md-12 label-control text-left" for="inputDatosAdicionales">Datos Adicionales</label>
                                                                <div class="col-md-12">
                                                                    <textarea id="inputDatosAdicionales" name="inputDatosAdicionales" class="form-control border-primary" rows="5"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <h4 class="form-section"><i class="fa fa-usd"></i> FORMA DE PAGO</h4>
                                                            <div class="form-group row">
                                                                <input id="inputIdPago" name="inputIdPago" type="text" class="form-control border-primary hidden" value="0" disabled>
                                                                <label class="col-md-3 label-control" for="selectDesglose">Desglose</label>
                                                                <div class="col-md-9">
                                                                    <select id="selectDesglose" name="selectDesglose" class="select2-diacritics2">
                                                                    <?php
                                                                        if (count($desglose) > 0){
                                                                            foreach ($desglose as $row) {
                                                                                echo '<option value="'.$row->desglose_id.'">'.$row->desglose_nombre.'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="solicitante">Tipo de Moneda</label>
                                                                <div class="col-md-3">
                                                                    <select id="selectMoneda" name="selectMoneda" class="select2-diacritics2">
                                                                    <?php
                                                                        if (count($moneda) > 0){
                                                                            foreach ($moneda as $row) {
                                                                                echo '<option value="'.$row->moneda_id.'" data-cambio="'.$row->moneda_monto.'">'.$row->moneda_simbolo.'</option>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                    </select>
                                                                </div>
                                                                <label class="col-md-2 label-control" for="solicitante">CON IGV</label>
                                                                <div class="col-md-1">
                                                                    <input id="checkCIGV" type="radio" name="igv" checked>
                                                                </div>
                                                                <label class="col-md-2 label-control" for="solicitante">SIN IGV</label>
                                                                <div class="col-md-1">
                                                                    <input id="checkSIGV" type="radio" name="igv">
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="solicitante">SUBTOTAL</label>
                                                                <div class="col-md-9">
                                                                    <input id="inputSubTotal" name="inputSubTotal" type="text" class="form-control border-primary" value="0.00" style="text-align: right;" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="solicitante"><i id="id_impuesto" class="hidden"><?php echo $impuesto->impuesto_id ; ?></i>IGV (<b id="impuesto"><?php echo $impuesto->impuesto_porcentaje; ?></b>)</label>
                                                                <div class="col-md-9">
                                                                    <input id="inputIgv" name="inputIgv" type="text" class="form-control border-primary" value="0.00" style="text-align: right;" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="solicitante">TOTAL</label>
                                                                <div class="col-md-9">
                                                                    <input id="inputTotal" name="inputTotal" type="text" class="form-control border-primary" value="0.00" style="text-align: right; font-size: 1.5rem; font-weight: bold;" disabled>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END SERVICIOS -->

                                        <!-- BEGIN COSTO PERITO -->
                                        <div class="tab-pane" id="link4" role="tabpanel" aria-labelledby="link-tab4" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <h4 class="form-section">COSTO PERITO</h4>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control" for="selectTipoPerito">Tipo Perito</label>
                                                        <div class="col-md-4">
                                                            <select id="selectTipoPerito" name="selectTipoPerito" class="select2-diacritics2" required>
                                                                <option value="1">OFICINA</option>
                                                                <option value="2">EXTERNO</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div id="row_perito" class="form-group row">
                                                        <label class="col-md-2 label-control" for="selectPerito">Perito</label>
                                                        <div class="col-md-5">
                                                            <select id="selectPerito" name="selectPerito" class="select2-diacritics" disabled>
                                                            <option value=""></option>
                                                            <?php
                                                                if (count($perito) > 0){
                                                                    foreach ($perito as $row) {
                                                                        echo '<option value="'.$row->perito_id.'">'.strtoupper($row->perito_nombre).'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                            </select>
                                                        </div>
                                                        <label class="col-md-2 label-control" for="inputCostoPerito">Costo Perito</label>
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <span class="input-group-addon font-weight-bold" id="basic-addon1">
                                                                </span>
                                                                <input id="inputCostoPerito" name="inputCostoPerito" type="number" class="form-control border-primary text-right" value="0.00" min="0" disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h4 class="form-section">COSTO VIÁTICO</h4>
                                                    <div class="form-group row">
                                                        <label class="col-md-2 label-control" for="inputImporteViatico">Importe</label>
                                                        <div class="col-md-3">
                                                            <div class="input-group">
                                                                <span class="input-group-addon font-weight-bold" id="basic-addon2"></span>
                                                                <input id="inputImporteViatico" name="inputImporteViatico" type="number" class="form-control border-primary text-right" value="0.00">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <span style="color: #FF0000; font-weight: bold;">Nota:</span>
                                                    <span >Los costos deberan ser ingresados en la moneda cotizada</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END COSTO PERITO -->

                                        <!-- BEGIN MENSAJES -->
                                        <div class="tab-pane" id="link5" role="tabpanel" aria-labelledby="link-tab5" aria-expanded="false">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    ver
                                                    <div class="form-group row">
                                                        <div class="col-12 col-sm-4 col-md-1 col-lg-1 col-xl-1">
                                                            <select id="selectQuantity" class="form-control">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-md-2 col-lg-2 col-xl-2">
                                                            <a id="lnkNuevo" href="" class="btn btn-info"><i class="ft-plus"></i> Nuevo Mensaje</a>
                                                        </div>
                                                        <div class="col-12 col-sm-4 col-md-9 col-lg-9 col-xl-9">
                                                            <!--<a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right"><i class="fa fa-print"></i> Imprimir</a>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table id="tbl_seguimiento" class="table table-striped table-bordered table-responsive" width="100%">
                                                        <thead>
                                                            <tr>
                                                                <th width="1000">MENSAJE</th>
                                                                <th width="350">USUARIO</th>
                                                                <th width="80">FECHA CREACIÓN</th>
                                                                <th width="80">FECHA PRÓXIMA</th>
                                                                <th width="120">ESTADO</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="text-left">
                                                        <span id="conteo"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="float-right paginacion"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END MENSAJES -->
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php //$this->load->view("cotizacion/modal/tservicio_modal"); ?>
<?php $this->load->view("cotizacion/modal/juridico_modal"); ?>
<?php $this->load->view("cotizacion/modal/natural_modal"); ?>
<?php $this->load->view("cotizacion/modal/contacto_modal"); ?>
<?php $this->load->view("cotizacion/modal/servicio_modal"); ?>
<?php $this->load->view("cotizacion/modal/seguimiento_modal"); ?>
<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("cotizacion/include/cotizacion_mantenimiento_script"); ?>