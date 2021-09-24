<!--<style>
    .no-gutters {
      margin-right: 0;
      margin-left: 0;

      > .col,
      > [class*="col-"] {
        padding-right: 0;
        padding-left: 0;
      }
    }
</style>-->
<div class="content-header row">
    <div class="content-header-left col-md-12 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Administracion</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('administracion/facturaciones') ?>">Facturación</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Emisión de Comprobante
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
                        <h4 class="card-title" id="horz-layout-colored-controls">FACTURACIÓN - COMPROBANTE DE PAGO</h4>
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
                                        <div class="col-12 col-sm-6 col-md-8">
                                            <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                <strong><i class="ft ft-file-text"></i> INFORMACIÓN GENERAL DEL DOCUMENTO</strong>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 col-md-4">
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-6 col-md-6">FECHA DE VENCIMIENTO</label>
                                                <div class="col-12 col-sm-6 col-md-6">
                                                    <input id="inputFechaVencimiento" type="date" class="form-control form-control-sm border-primary" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">NOMBRE CLIENTE</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
                                                    <label id="lblCliente" class="form-control border-primary"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-2">TIPO DOCUMENTO</label>
                                                <div class="col-12 col-sm-4">
                                                    <label id="lblTipoDocumento" class="form-control border-primary"></label>
                                                </div>
                                                <label class="col-12 col-sm-2">NRO DOCUMENTO</label>
                                                <div class="col-12 col-sm-4">
                                                    <label id="lblNroDocumento" class="form-control border-primary text-right"></label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-2">DIRECCIÓN CLIENTE</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-10">
                                                    <label id="lblDireccion" class="form-control border-primary"></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-12 col-lg-6 mb-1">
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-2 col-md-2 col-lg-12 col-xl-2">TIPO COMPROBANTE</label>
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-12 col-xl-4">
                                                    <select id="selectTipoComprobante" class="form-control" disabled>
                                                    <?php
                                                        if (count($comprobante) > 0) {
                                                            foreach ($comprobante as $row) {
                                                                echo '<option value="'.$row->id.'">' . strtoupper($row->nombre) . '</option>';
                                                                }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <label class="col-12 col-sm-2 col-md-2 col-lg-12 col-xl-2">SERIE Y NÚMERO</label>
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-12 col-xl-4">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><strong>001</strong></span>
                                                        <span class="input-group-addon"><strong>-</strong></span>
                                                        <label class="form-control border-primary text-right">0000000</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-2 col-md-2 col-lg-12 col-xl-2">MEDIO DE PAGO</label>
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-12 col-xl-4">
                                                    <select id="selectMedioPago" class="select2-diacritics" required>
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($mpago) > 0) {
                                                            foreach ($mpago as $row) {
                                                                echo '<option value="'.$row->medio_id.'">'.strtoupper($row->medio_abreviatura).'</option>';
                                                                }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                                <label class="col-12 col-sm-2 col-md-2 col-lg-12 col-xl-2">FECHA DE EMISIÓN</label>
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-12 col-xl-4">
                                                    <input id="inputFechaEmision" type="date" class="form-control border-primary" value="<?php echo date('Y-m-d'); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-2 col-md-2 col-lg-12 col-xl-2">TIPO DE MONEDA</label>
                                                <div class="col-12 col-sm-4 col-md-4 col-lg-12 col-xl-4">
                                                    <select id="selectMoneda" class="form-control" disabled>
                                                    <?php
                                                        if (count($moneda) > 0) {
                                                            foreach ($moneda as $row) {
                                                                echo '<option value="'.$row->moneda_id.'">'.strtoupper($row->moneda_nombre).' ('.$row->moneda_simbolo.')</option>';
                                                                }
                                                        }
                                                    ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-12 col-md-9">
                                            <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                <strong><i class="fa fa-list-alt"></i> DETALLE DEL COMPROBANTE</strong>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <div class="col-12">
                                                    <table id="tblDescripcion" class="table table-bordered mb-2">
                                                        <thead>
                                                            <tr>
                                                                <th width="10">#</th>
                                                                <th width="250">CÓDIGO</th>
                                                                <th>CONCEPTO</th>
                                                                <th width="50">UM</th>
                                                                <th width="50">CANT.</th>
                                                                <th width="90">SUB TOTAL</th>
                                                                <th width="90">I.G.V.</th>
                                                                <th width="90">TOTAL</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                        <tfooter>
                                                            <tr>
                                                                <td colspan="2">1 Registro</td>
                                                                <td colspan="6"></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-1">
                                                <div class="col-12">
                                                    <strong id="numero_letras" class="form-control form-control-sm">SON: CERO CON 00/100 SOLES</strong>
                                                </div>
                                            </div>
                                            <div id="row_orden_all" class="form-group row mb-1 hidden">
                                                <div class="col-12">
                                                    <label class="form-control form-control-sm">
                                                        <div class="mb-1">
                                                            <strong class="mr-1">Orden de Compra / Servicio:</strong>
                                                            <span id="spanOrdenServicio" class="mr-2"></span>
                                                        </div>
                                                        <div id="row_nro_aceptacion">
                                                            <strong class="mr-1">Número de Aceptación:</strong>
                                                            <span id="spanNroAceptacion"></span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-3">
                                            <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                <strong>IMPORTE</strong>
                                            </div>

                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 font-weight-bold text-right">SUB TOTAL:</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                    <label id="lblSubTotal" class="form-control form-control-sm" style="text-align: right;font-size: 1.1rem;">0.00</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 font-weight-bold text-right text-danger">DESCUENTO:</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                    <label id="lblDescuento" class="form-control form-control-sm text-danger" style="text-align: right;font-size: 1.1rem;">0.00</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 font-weight-bold text-right">IGV:</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                    <label id="lblIgv" class="form-control form-control-sm" style="text-align: right;font-size: 1.1rem;">0.00</label>
                                                </div>
                                            </div>
                                            <div class="form-group row mb-0">
                                                <label class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 font-weight-bold text-right">IMPORTE TOTAL:</label>
                                                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                    <label id="lblTotal" class="form-control form-control-sm font-weight-bold" style="text-align: right;font-size: 1.1rem;">0.00</label>
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

<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("administracion/include/administracion_emision_script"); ?>