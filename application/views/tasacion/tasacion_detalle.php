<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
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
                        Detalle
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
                        <h4 class="card-title">TASACIONES REGISTRADAS DE LA COORDINACIÓN [<strong id="strCoordinacion"></strong>]</h4>
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
                                    <table id="tbl_tasacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>TIPO</th>
                                                <th width="80">COORD.</th>
                                                <th width="80">FECHA</th>
                                                <th width="160">SOLICITANTE</th>
                                                <th width="160">CLIENTE</th>
                                                <th width="300">DIRECCIÓN</th>
                                                <th width="80">ZONIFICACIÓN</th>
                                                <th>AREA <br /> m2</th>
                                                <th>V.U.T <br /> USD</th>
                                                <th>VALOR <br /> COMERCIAL</th>
                                                <th>DATOS ADICCIONALES</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button id="buttonFinalizar" type="button" class="btn grey btn-outline-primary">Finalizar Actualización</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Individual column searching (text inputs) table -->
</div>
<?php //$this->load->view("tasacion/modal/tipo_registro_modal"); ?>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("tasacion/include/tasacion_detalle_script"); ?> <!-- falta script -->
