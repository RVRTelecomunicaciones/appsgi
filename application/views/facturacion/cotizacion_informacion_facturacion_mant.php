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
                        <a href="<?= base_url('facturacion/informacion_facturacion') ?>">Información de Facturación</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Mantenimiento
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
                        <h4 class="card-title" id="horz-layout-colored-controls">INFORMACIÓN DEL COMPROBANTE PARA LA COTIZACIÓN [<span id="spanCotizacionCodigo"></span>]</h4>
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
                            <form class="form form-horizontal" id="frmRegistro">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12">
                                            <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                <strong><i class="ft ft-file-text"></i> DATOS GENERALES</strong>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row mb-1">
                                                <label class="col-sm-12 col-md-12 col-lg-12 col-xl-2 label-control font-weight-bold text-left" for="solicitante">Facturar por</label>
                                                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
                                                    <div class="row skin skin-flat">
                                                        <div class="col-md-12 col-lg-12 col-xl-3">
                                                            <fieldset>
                                                                <input type="radio" name="facturar_a" id="rbSolicitante">
                                                                <label for="rbSolicitante">Solicitante</label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-12 col-lg-12 col-xl-3">
                                                            <fieldset>
                                                                <input type="radio" name="facturar_a" id="rbCliente" checked>
                                                                <label for="rbCliente">Cliente</label>
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                                            <fieldset>
                                                                <input type="radio" name="facturar_a" id="rbOtros">
                                                                <label for="rbOtros">Otros</label>
                                                            </fieldset>
                                                        </div>
                                                        <div id="row_tipo_persona" class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-3 hidden">
                                                            <select id="selectTPersona" name="selectTPersona" class="form-control">
                                                                <option value="0">Jurídica</option>
                                                                <option value="1">Natural</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="row_solicitante" class="form-group row mb-1 hidden">
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="solicitante">Solicitante</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-10">
                                                    <select id="selectSolicitante" name="selectSolicitante" class="select2-diacritics2">
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div id="row_cliente" class="form-group row mb-1">
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="cliente">Cliente</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-10">
                                                    <select id="selectCliente" name="selectCliente" class="select2-diacritics2">
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="row_otros" class="form-group row mb-1 hidden">
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="otros">Otros</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-10">
                                                    <div class="input-group">
                                                        <input type="hidden" id="otros_id" class="form-control">
                                                        <input type="hidden" id="otros_tipo" class="form-control">
                                                        <input type="text" id="otros_nombre" class="form-control border-primary" name="otros" disabled>
                                                        <span class="input-group-btn">
                                                            <a id="btn_search" href class="btn btn-secondary disabled"><i class="fa fa-search"></i></a>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="inputServicioTipo">Tipo de Tasación</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-10">
                                                    <textarea id="inputServicioTipo" name="inputServicioTipo" class="form-control border-primary" rows="2" disabled></textarea>
                                                </div>
                                            </div>

                                            <div id="row_orden" class="form-group row hidden">
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="inputOrden">Orden de Servicio</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-4">
                                                    <input id="inputOrden" type="text" class="form-control border-primary" disabled>
                                                </div>
                                                <label class="col-12 col-sm-2 col-md-12 col-lg-2 label-control text-left" for="inputNroAceptacion">Nro de Aceptación</label>
                                                <div class="col-12 col-sm-10 col-md-12 col-lg-4">
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <input id="inputNroAceptacion" type="text" class="form-control border-primary text-right">
                                                            <span class="input-group-addon">
                                                                <input id="checkNroAceptacion" type="checkbox">
                                                            </span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row mb-1">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="selectTipoComprobante">Tipo de Documento</label>
                                                <div class="col-12 col-sm-4 col-md-8 col-lg-9 col-xl-4">
                                                    <select id="selectTipoComprobante" name="selectTipoComprobante" class="select2-diacritics" required>
                                                    </select>
                                                </div>
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="concepto">Pago en porcentaje</label>
                                                <div class="col-12 col-sm-4 col-md-8 col-lg-9 col-xl-4">
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <span class="input-group-addon" id="basic-addon2">
                                                                <input type="checkbox" name="checkPorcentaje" id="checkPorcentaje">
                                                            </span>
                                                            <input id="inputPorcentaje" name="inputPorcentaje" type="number" class="form-control border-primary" value="50" style="text-align: right;" min="20" max="50" step="10" disabled>
                                                            <span class="input-group-addon" id="basic-addon3"><i class="fa fa-percent"></i></span>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="concepto">Código de Tasación</label>
                                                <div class="col-12 col-sm-10 col-md-8 col-lg-9 col-xl-10">
                                                    <input id="inputCodigoTasacion" name="inputCodigoTasacion" type="text" class="form-control border-primary" disabled>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="concepto">Concepto</label>
                                                <div class="col-12 col-sm-10 col-md-8 col-lg-9 col-xl-10">
                                                    <textarea class="form-control border-primary" rows="3" id="concepto" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row mb-1">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-mail"></i> DATOS DE ENVÍO</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="atencionA">Con Atención a:</label>
                                                <div class="ol-12 col-sm-10 col-md-8 col-lg-9 col-xl-10">
                                                    <input type="text" id="atencionA" class="form-control border-primary" name="atencionA" required>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="correo">Correo:</label>
                                                <div class="ol-12 col-sm-10 col-md-8 col-lg-9 col-xl-10">
                                                    <input type="text" id="correo" class="form-control border-primary" name="correo" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-12 col-sm-2 col-md-4 col-lg-3 col-xl-2 label-control text-left" for="observacion">Observaciones:</label>
                                                <div class="ol-12 col-sm-10 col-md-8 col-lg-9 col-xl-10">
                                                    <textarea class="form-control border-primary" rows="6" id="observacion"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row mb-1">
                                                <div class="col-12 col-sm-12 col-md-12">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="fa fa-list-alt"></i> DETALLE DEL SERVICIO</strong>
                                                    </div>
                                                </div>
                                            </div>
                                            <table id="tblServicios" class="table table-striped table-bordered text-inputs-searching" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" style="font-size: 1rem">#</th>
                                                        <th style="font-size: 1rem">DESCRIPCIÓN DEL SERVICIO</th>
                                                        <th width="25%" style="font-size: 1rem">IMPORTE</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>

                                            <div class="row skin skin-square">
                                                <div class="col-sm-4 col-md-12 col-lg-3 col-lg-6"></div>
                                                <strong class="col-12 col-sm-3 col-md-4 col-lg-2 col-xl-2 label-control" for="monto_facturar">IMPORTE A FACTURAR</strong>
                                                <div class="col-12 col-sm-5 col-md-8 col-lg-6 col-xl-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon hidden" id="basic-addon4">
                                                            <input id="chk_monto_cambio" type="checkbox">
                                                        </span>
                                                        <span class="input-group-addon" id="basic-addon5">
                                                        </span>
                                                        <input id="monto_facturar" type="number" class="form-control border-primary" style="text-align: right;" min="0" max="100000" step="1" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions right">
                                    <button id="btn_cancelar" type="button" class="btn btn-warning mr-1 btn-lg">
                                        <i class="ft-x"></i> Cancelar
                                    </button>
                                    <button id="btn_save" type="submit" class="btn btn-primary btn-lg">
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
<?php $this->load->view("cotizacion/modal/juridico_modal"); ?>
<?php $this->load->view("cotizacion/modal/natural_modal"); ?>
<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("facturacion/include/cotizacion_informacion_facturacion_mantenimiento_script"); ?>