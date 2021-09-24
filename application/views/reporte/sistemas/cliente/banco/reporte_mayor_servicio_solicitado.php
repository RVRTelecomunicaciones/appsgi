<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('reporte') ?>">Reportes</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('reporte/sistemas') ?>">Sistemas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Cliente con más servicios realizados / Bancos
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
                    	<h4 class="card-title">REPORTE DE CLIENTE CON MÁS SERVICIOS REALIZADOS - BANCOS</h4>
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
                            <div class="row mb-1">
                                <div class="col-md-1">
                                    Año: <input id="inputAnio" type="number" value="2019" class="form-control" min="2018" max="<?php echo date("Y");?>">
                                </div>
                                <div class="col-md-2">
                                    Mes:</br>
                                    <select id="selectMes" class="select2-diacritics">
                                        <option value=""></option>
                                        <option value="1">ENERO</option>
                                        <option value="2">FEBRERO</option>
                                        <option value="3">MARZO</option>
                                        <option value="4">ABRIL</option>
                                        <option value="5">MAYO</option>
                                        <option value="6">JUNIO</option>
                                        <option value="7">JULIO</option>
                                        <option value="8">AGOSTO</option>
                                        <option value="9">SETIEMBRE</option>
                                        <option value="10">OCTUBRE</option>
                                        <option value="11">NOVIEMBRE</option>
                                        <option value="12">DICIEMBRE</option>
                                    </select>
                                </div>
                                <div class="col-md-9">
                                    <a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right mr-1"><i class="fa fa-print"></i> Imprimir</a>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <table id="tbl_mayor_servicio_cotizado" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>SERVICIO</th>
                                                <th>CANTIDAD</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="col-md-8">
                                    <div class="card">
                                        <!--<div class="card-header">
                                            <h4 class="card-title"></h4>
                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                            <div class="heading-elements">
                                                <ul class="list-inline mb-0">
                                                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>-->
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <canvas id="column-chart" height="400"></canvas>
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
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("reporte/sistemas/cliente/banco/include/mayor_servicio_solicitado_script"); ?>