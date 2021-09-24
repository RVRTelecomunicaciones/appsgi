<link rel="stylesheet" type="text/css" href="<?= base_url();?>app-assets/vendors/css/extensions/toastr.css">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>app-assets/css/plugins/extensions/toastr.min.css">
<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Inicio</a>
                    </li>
                    <li class="breadcrumb-item"><a href="#">Tasaciones</a>
                    </li>
                </ol>
            </div>
        </div>
        <h3 class="content-header-title mb-0">Tasaciones de Locales Industriales</h3>
    </div>
</div>

<div class="content-body">
    <!-- Individual column searching (text inputs) table -->
    <section id="text-inputs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">LOCALES INDUSTRIALES</h4>
                        <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                <li><a data-action="reload" onClick="window.location.reload()"><i class="ft-rotate-cw"></i></a></li>
                                <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                <li><a data-action="close"><i class="ft-x"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-content collapse show">
                        <div class="card-body">
                            <table id="datatable-buttons" class="table table-striped table-bordered text-inputs-searching" style="width: 100%;">
                                <thead>
                                <tr>
                                    <td><input type="text" class="form-control" id="inputCoord"></td>
                                    <td><input type="text" class="form-control" id="inputSolicitante"></td>
                                    <td><input type="text" class="form-control" id="inputCliente"></td>
                                    <td><input type="text" class="form-control" id="inputPropietario"></td>
                                    <td><input type="text" class="form-control" id="inputUbicacion"></td>
                                    <td><input type="text" class="form-control" id="inputFTasacion" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control" id="inputZonificacion"></td>
                                    <td><input type="text" class="form-control" id="inputNPisos"></td>
                                    <td><input type="text" class="form-control" id="inputTerrenoArea"></td>
                                    <td><input type="text" class="form-control" id="inputTerrenoValor"></td>
                                    <td><input type="text" class="form-control" id="inputEdificacion"></td>
                                    <td><input type="text" class="form-control" id="inputValorC"></td>
                                    <td><input type="text" class="form-control" id="inputAreasComplementarias"></td>
                                </tr>
                                <tr>
                                    <th>Coord</th>
                                    <th>Solicitante</th>
                                    <th>Cliente</th>
                                    <th>Propietario</th>
                                    <th>Ubicación</th>
                                    <th>Fecha Tasación</th>
                                    <th>Zonificación</th>
                                    <th>N° Pisos</th>
                                    <th>Vista Local</th>
                                    <th>Terreno Área</th>
                                    <th>Terreno Valor Unit.</th>
                                    <th>Edificacion Área</th>
                                    <th>Valor comercial</th>
                                    <th>Aras Complementarias</th>
                                    <th>Ruta</th>
                                </tr>
                                </thead>
                                <tbody id="showdata">
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Individual column searching (text inputs) table -->
</div>

<?php $this->load->view("includes/include_script_datatable"); ?>
<script src="<?= base_url() ?>assets/js/system/tasacion/tasacionesLocalIndustrial.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
