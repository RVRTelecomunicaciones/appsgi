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
                        <a href="<?= base_url('facturacion/informacion_facturacion') ?>">Información de Factura</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Gastos
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
                    	<h4 class="card-title">COORDINACIONES DE LA COTIZACIÓN COTIZACIÓN [<span id="spanCotizacionCodigo"></span>]</h4>
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
                                <div class="col-md-12">
                                    <table id="tbl_coordinacion" class="table table-striped table-bordered table-responsive" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>COORDINACIÓN</th>
                                                <th width="300">SOLICITANTE </th>
                                                <th width="300">CLIENTE</th>
                                                <th width="300">PERITO</th>
                                                <th>IMPORTE GASTADO</th>
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
<?php $this->load->view("facturacion/modal/informacion_facturacion_gastos_modal"); ?>
<?php $this->load->view("includes/include_script_form"); ?>
<?php $this->load->view("facturacion/include/cotizacion_informacion_facturacion_gastos_script"); ?>