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
        <h3 class="content-header-title mb-0">Lista de Tasaciones</h3>
    </div>
</div>

<div class="card" style="">
    <div class="card-content">
        <div class="card-body">            
            <section class="basic-elements">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-1 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="basicInput">Coordinacion</label>
                                                <input type="text" class="form-control" id="coordinacion" >
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="helpInputTop">Solicitante</label>
                                                <input type="text" class="form-control" id="solicitante">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Cliente</label>
                                                <input type="text" class="form-control" id="cliente">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-3 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Propietario</label>
                                                <input type="text" class="form-control" id="propietario">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Fecha de Tasación</label>
                                                <input type="date" id="fechaTasacion" class="form-control" name="date">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-4 col-lg-6 col-md-12">
                                            <fieldset class="form-group">
                                                <label for="disabledInput">Dirección</label>
                                                <input type="text" class="form-control" id="direccion">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="roundText">Área de Terreno</label>
                                                <input type="text" class="form-control" id="areaTerreno">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="roundText">Valor Unitario de Terreno</label>
                                                <input type="text" class="form-control" id="valuniTerreno">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="roundText">Área de Edificación</label>
                                                <input type="text" class="form-control" id="areaEdificacion">
                                            </fieldset>
                                        </div>
                                        <div class="col-xl-2 col-lg-6 col-md-12 mb-1">
                                            <fieldset class="form-group">
                                                <label for="squareText">Valor Comercial</label>
                                                <input type="text" class="form-control" id="valorComercial">
                                            </fieldset>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-warning mr-1">
                        <i class="ft-x"></i> Cancel
                    </button>
                    <button id="myButton" type="submit" class="btn btn-primary">
                        <i class="fa fa-check-square-o"></i> Save
                    </button>
                </div>
            </section>

            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified" id="myTab">
                <li class="nav-item">
                    <a class="nav-link active" id="active-tab1" data-toggle="tab" href="#active1" aria-controls="active1" aria-expanded="true">Casa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab1" data-toggle="tab" href="#link1" aria-controls="link1" aria-expanded="false">Departamento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab2" data-toggle="tab" href="#link2" aria-controls="link2" aria-expanded="false">Local Comercial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab3" data-toggle="tab" href="#link3" aria-controls="link3" aria-expanded="false">Local Industrial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab4" data-toggle="tab" href="#link4" aria-controls="link4" aria-expanded="false">Oficina</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab5" data-toggle="tab" href="#link5" aria-controls="link5" aria-expanded="false">Terreno</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab6" data-toggle="tab" href="#link6" aria-controls="link6" aria-expanded="false">Vehiculos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab7" data-toggle="tab" href="#link7" aria-controls="link7" aria-expanded="false">Maquinaria</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="link-tab8" data-toggle="tab" href="#link8" aria-controls="link8" aria-expanded="false">Grifos</a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
                <div role="tabpanel" class="tab-pane active in" id="active1" aria-labelledby="active-tab1" aria-expanded="true">
                    <table id="datable1" class="table table-striped table-bordered text-inputs-searching" style="width: 100%;">
                        <thead>
                        <tr>
                            <td><input type="text" class="form-control" id="input01Coord"></td>
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
                            <th>Terreno Área</th>
                            <th>Terreno Valor Unit.</th>
                            <th>Edificacion Área</th>
                            <th>Valor comercial</th>
                            <th>Ruta</th>
                        </tr>
                        </thead>
                        <tbody id="showdata1">
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="link1" role="tabpanel" aria-labelledby="link-tab1" aria-expanded="false">
                    <table id="datable2" class="table table-striped table-bordered text-inputs-searching" style="width: 100%;">
                                <thead>
                                <tr>
                                    <td><input type="text" class="form-control" id="input02Coord"></td>
                                    <td><input type="text" class="form-control" id="inputSolicitante"></td>
                                    <td><input type="text" class="form-control" id="inputCliente"></td>
                                    <td><input type="text" class="form-control" id="inputPropietario"></td>
                                    <td><input type="text" class="form-control" id="inputUbicacion"></td>
                                    <td><input type="text" class="form-control" id="inputFTasacion" style="width: 80px;"></td>
                                    <td><input type="text" class="form-control" id="inputZonificacion"></td>
                                    <td><input type="text" class="form-control" id="inputNPisos"></td>
                                    <td><input type="text" class="form-control" id="inputDTipo"></td>
                                    <td><input type="text" class="form-control" id="inputTerrenoArea"></td>
                                    <td><input type="text" class="form-control" id="inputTerrenoValor"></td>
                                    <td><input type="text" class="form-control" id="inputEdificacion"></td>
                                    <td><input type="text" class="form-control" id="inputValorC"></td>
                                    <td><input type="text" class="form-control" id="inputValorO"></td>
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
                                    <th>Departamento (Tipo)</th>
                                    <th>Terreno Área</th>
                                    <th>Terreno Valor Unit.</th>
                                    <th>Edificacion Área</th>
                                    <th>Valor comercial</th>
                                    <th>Valor ocupado</th>
                                    <th>Ruta</th>
                                </tr>
                                </thead>
                                <tbody id="showdata2">
                                </tbody>
                    </table>
                </div>
                <div class="tab-pane" id="link4" role="tabpanel" aria-labelledby="link-tab4" aria-expanded="false">

                </div>
                <div class="tab-pane" id="link5" role="tabpanel" aria-labelledby="link-tab5" aria-expanded="false">

                </div>
                <div class="tab-pane" id="link6" role="tabpanel" aria-labelledby="link-tab6" aria-expanded="false">
                </div>

            </div>
        </div>
    </div>
</div>

<?php $this->load->view("includes/include_script_datatable"); ?>
<script src="<?= base_url() ?>assets/js/system/tasacion/tasacionesTerreno.js"></script>
<script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>