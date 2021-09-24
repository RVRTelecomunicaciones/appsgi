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
                        <a href="<?= base_url('coordinacion') ?>">Coordinaciones</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- begin -->
<div class="row">
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['coordinar'];
                                    }
                                ?>
                            </h3>
                            <span>Por Coordinar</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['programacion'];
                                    }
                                ?>
                            </h3>
                            <span>En Inspección</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['proceso'];
                                    }
                                ?>
                            </h3>
                            <span>En Elaboración</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['espera'];
                                    }
                                ?>
                            </h3>
                            <span>En Espera</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['terminado'];
                                    }
                                ?>
                            </h3>
                            <span>Terminado</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-sm-4 col-xl-2 col-lg-2">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="primary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['reproceso'];
                                    }
                                ?>
                            </h3>
                            <span>Reproceso</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc primary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end -->

<div class="content-body">
    <!-- Individual column searching (text inputs) table -->
    <section id="text-inputs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">REPORTE DE COORDINACIONES</h4>
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
                                    ver
                                    <div class="form-group row">
                                        <div class="col-md-1">
                                            <select id="selectQuantity" class="form-control">
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                        <div class="col-md-11">
                                            <a id="lnkExportXls" href="" class="btn btn-outline-success square float-right"><i class="fa fa-file-excel-o"></i> Exportar Excel</a>

                                            <a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right mr-1"><i class="fa fa-print"></i> Imprimir</a>

                                            <a id="lnkFiltros" href="" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</a>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 300px;">
                                                <div class="col-md-12">
                                                    <h6 class="dropdown-menu-header popover-header font-weight-bold mb-1">FILTROS DE BÚSQUEDA</h6>
                                                    <div class="center">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <span class="input-group-addon">FECHA DE</span>
                                                                    <select id="selectFiltroFecha" name="selectFiltroFecha" class="form-control">
                                                                        <option value="">-- Seleccione --</option>
                                                                        <option value="3">Fecha de Entrega</option>
                                                                        <option value="2">Fecha Inspeccion</option>
                                                                        <!--<option value="4">Nueva Fecha de Entrega</option>-->
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputFiltroFechaDesde">DESDE</label>
                                                                <div class="position-relative has-icon-left">
                                                                    <input type="date" id="inputFiltroFechaDesde" name="inputFiltroFechaDesde" class="form-control border-primary" name="date" required>
                                                                    <div class="form-control-position">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputFiltroFechaHasta">HASTA</label>
                                                                <div class="position-relative has-icon-left">
                                                                    <input type="date" id="inputFiltroFechaHasta" name="inputFiltroFechaHasta" class="form-control border-primary" name="date" required>
                                                                    <div class="form-control-position">
                                                                        <i class="fa fa-calendar"></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row mt-1">
                                                            <div class="col-md-12">
                                                                <a id="lnkFiltroCancelar" href class="btn btn-secondary btn-sm float-right">Cancelar</a>
                                                                <a id="lnkFiltroBuscar" href class="btn btn-primary btn-sm float-right mr-1">Buscar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_coordinacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr id="test">
                                                <td colspan="2"><input type="text" class="form-control" id="inputCoordinacion"></td>
                                                <td>
                                                    <select id="selectEstado" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($estado) > 0){
                                                            foreach ($estado as $row) {
                                                                echo '<option value="'.$row->estado_id.'">'.$row->estado_nombre.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="inputSolicitante">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="inputCliente">
                                                </td>
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
                                                <td><input type="text" class="form-control" id="inputUbicacion"></td>
                                                <td>
                                                    <select id="selectPerito" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($perito) > 0){
                                                            foreach ($perito as $row) {
                                                                echo '<option value="'.$row->perito_id.'">'.strtoupper($row->perito_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="selectCCalidad" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($ccalidad) > 0){
                                                            foreach ($ccalidad as $row) {
                                                                echo '<option value="'.$row->control_calidad_id.'">'.strtoupper($row->control_calidad_nombre).'</option>';
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
                                                <td colspan="2"></td>
                                                <td>
                                                    <select id="selectRiesgo" class="form-control">
                                                        <option value=""></option>
                                                        <option value="1">BAJO</option>
                                                        <option value="2">MEDIO</option>
                                                        <option value="3">ALTO</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th id="thCoordinacion" width="60" class="<?= buscarPermisoEscritura(8, $this->session->userdata('usu_permiso')) == '1' || buscarPermisoEscritura(12, $this->session->userdata('usu_permiso')) ? '' : 'write'; ?>">COORD.</th>
                                                <th width="100">ESTADO</th>
                                                <th width="150">SOLICITANTE</th>
                                                <th width="150">CLIENTE</th>
                                                <th width="150">TIPO SERVICIO</th>
                                                <th>UBICACIÓN</th>
                                                <th width="100">PERITO</th>
                                                <th width="100">CONTROL DE CALIDAD</th>
                                                <th width="100">COORDINADOR</th>
                                                <th width="80">FECHA DE ENTREGA</th>
                                                <!--<th width="80">NUEVA FECHA DE ENTREGA</th>-->
                                                <th width="80">FECHA DE INSPECCIÓN</th>
                                                <th>RIESGO</th>
                                                <!--<th>DIAS</th>
                                                <th>ALERTA</th>-->
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
    <!-- Individual column searching (text inputs) table -->
</div>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("coordinacion/include/coordinacion_list_script"); ?>
