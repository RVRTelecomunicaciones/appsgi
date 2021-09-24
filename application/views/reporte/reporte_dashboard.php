<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Reportes
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
                    	<h4 class="card-title">REPORTES</h4>
                    	<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    	<div class="heading-elements">
                    		<ul class="list-inline mb-0">
                    			<li><a data-action="reload" onClick="window.location.reload()"><i class="ft-rotate-cw"></i></a></li>
                    			<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    		</ul>
                    	</div>
                    </div>
                    <!--<div class="card-content collapse show">
                        <div class="card-body">
                        </div>
                    </div>-->
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <!--<div class="col-md-3">
            <a href="">
                <div class="card">
                    <div class="card-header card-head-inverse bg-primary" align="center">
                        <h4 class="card-title">REPORTE DE INGRESOS</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1"><i class="fa fa-info-circle"></i></div>
                                <div class="col-md-10" align="justify">
                                    <p>Muestra los ingresos realizados por fecha y comprobante.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="">
                <div class="card">
                    <div class="card-header card-head-inverse bg-primary" align="center">
                        <h4 class="card-title">REPORTE DE EGRESOS</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1"><i class="fa fa-info-circle"></i></div>
                                <div class="col-md-10" align="justify">
                                    <p>Muestra los egresos relizados por fecha y proyecto</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>-->
        <!--<div class="col-md-3">
            <a href="">
                <div class="card">
                    <div class="card-header card-head-inverse bg-primary" align="center">
                        <h4 class="card-title">REPORTE DE RENTABILIDAD</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1"><i class="fa fa-info-circle"></i></div>
                                <div class="col-md-10" align="justify">
                                    <p>Muestra la rentabilidad obtenida por fecha y proyecto</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a href="">
                <div class="card">
                    <div class="card-header card-head-inverse bg-primary" align="center">
                        <h4 class="card-title">REPORTE DE EGRESOS</h4>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-1"><i class="fa fa-info-circle"></i></div>
                                <div class="col-md-10" align="justify">
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>-->
    </div>
    <!-- Individual column searching (text inputs) table -->
</div>
<?php //$this->load->view("administracion/modal/documentos_modal"); ?>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php //$this->load->view("administracion/include/administracion_script"); ?>