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
                        <a href="<?= base_url('facturacion/informacion_facturacion') ?>">Información de Facturación</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content-body">
    <!-- Individual column searching (text inputs) table -->
    <section id="text-inputs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    	<h4 class="card-title">LISTADO DE COTIZACIONES</h4>
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

                            <div class="row">
                                <div class="col-md-2">
                                    ver
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <select id="selectQuantity" class="form-control">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <!--<div class="col-md-5">
                                            <a href="" class="btn btn-info">Nuevo <i class="fa fa-plus"></i></a>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_cotizacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr id="test">
                                                <td colspan="2"><input type="text" class="form-control" id="inputCotizacion"></td>
                                                <td><input type="text" class="form-control" id="inputSolicitante"></td>
                                                <td><input type="text" class="form-control" id="inputCliente"></td>
                                                <td>
													<select id="selectTServicio" class="js-example-programmatic-multi form-control" multiple="multiple">
                                                    <?php
                                                        if (count($tservicio) > 0){
                                                            foreach ($tservicio as $row) {
                                                                echo '<option value="'.$row->servicio_tipo_id.'">'.strtoupper($row->servicio_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="selectCoordinador" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($coordinador) > 0){
                                                            foreach ($coordinador as $row) {
                                                                echo '<option value="'.$row->coordinador_id.'">'.strtoupper($row->coordinador_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="selectVendedor" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($vendedor) > 0){
                                                            foreach ($vendedor as $row) {
                                                                echo '<option value="'.$row->vendedor_id.'">'.$row->vendedor_nombre.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" id="inputMonto"></td>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>COD. COTIZACIÓN</th>
                                                <th>SOLICITANTE </th>
                                                <th>CLIENTE</th>
                                                <th width="200">TIPO SERVICIO</th>
                                                <th>COORDINADOR</th>
                                                <th width="200">VENDEDOR</th>
                                                <th>MONTO</th>
                                                <th></th>
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
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $this->load->view("facturacion/modal/informacion_facturacion_modal"); ?>
<?php $this->load->view("facturacion/modal/informacion_facturacion_orden_servicio_modal"); ?>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("facturacion/include/cotizacion_informacion_facturacion_script"); ?>