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
                        <a href="<?= base_url($modulo.'/carga/digitador') ?>">Carga</a>
                    </li>
                    <li id="liTitulo" class="breadcrumb-item active">
                        Auditor
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
                        <h4 class="card-title">CARGA</h4>
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

                                            <!--<button id="buttonFilters" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</button>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 400px;">
                                                <div class="col-md-12">
                                                    <h6 class="dropdown-menu-header popover-header font-weight-bold mb-1">FILTROS DE BÚSQUEDA</h6>
                                                    <div class="center">
                                                        <form id="frm_filtros">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon">FECHA DE</span>
                                                                        <select id="selectFechaTipo" class="form-control form-control-sm">
                                                                            <option value="">-- Seleccione --</option>
                                                                            <option value="1">Fecha de Entrega</option>
                                                                            <option value="2">Fecha Inspeccion</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-1">
                                                                <div class="col-md-6">
                                                                    <label for="inputFechaDesde" class="col-form-label-sm">DESDE</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input id="inputFechaDesde" type="date" class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputFechaHasta" class="col-form-label-sm">HASTA</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input id="inputFechaHasta" type="date" class="form-control form-control-sm">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row mt-1">
                                                                <div class="col-md-12">
                                                                    <button id="buttonCancel" type="button" class="btn btn-secondary btn-sm float-right">Cancelar</button>
                                                                    <button id="buttonSearch" type="button" class="btn btn-primary btn-sm float-right mr-1">Buscar</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_coordinacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td colspan="2"><input type="text" class="form-control" id="inputCorrelativo"></td>
                                                <td>
                                                    <!--<select id="selectEstado" class="js-example-programmatic-multi" multiple="multiple">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($estado) > 0){
                                                            foreach ($estado as $row) {
                                                                echo '<option value="'.$row->estado_id.'">'.$row->estado_nombre.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>-->
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="inputSolicitante">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" id="inputCliente">
                                                </td>
                                                <td>
                                                    <select id="selectServicioTipo" class="js-example-programmatic-multi form-control" multiple="multiple">
                                                    <?php
                                                        if (count($tipo_servicio) > 0){
                                                            foreach ($tipo_servicio as $row) {
                                                                echo '<option value="'.$row->servicio_tipo_id.'">'.strtoupper($row->servicio_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" id="inputDireccion"></td>
                                                <td></td>
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
                                                    <select id="selectDigitador" class="form-control">
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
                                                    <select id="selectControlCalidad" class="form-control">
                                                        <option value=""></option>
                                                        <?php
                                                            if (count($control_calidad) > 0){
                                                                foreach ($control_calidad as $row) {
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
                                                <td></td>
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
                                                <th rowspan="2">#</th>
                                                <th width="60" rowspan="2" style="cursor: pointer;" class="icono" data-index="1">COORD. <i id="iconCoordinacion"></i></th>
                                                <th width="100" rowspan="2" style="cursor: pointer;" class="icono" data-index="2">ESTADO <i id="iconEstado"></i></th>
                                                <th width="150" rowspan="2" style="cursor: pointer;" class="icono" data-index="3">SOLICITANTE <i id="iconSolicitante"></i></th>
                                                <th width="150" rowspan="2" style="cursor: pointer;" class="icono" data-index="4">CLIENTE <i id="iconCliente"></i></th>
                                                <th width="100" rowspan="2" style="cursor: pointer;" class="icono" data-index="5">TIPO SERVICIO <i id="iconTipoServicio"></i></th>
                                                <th colspan="3">INSPECCIÓN</th>
                                                <th width="100" rowspan="2" style="cursor: pointer;" class="icono" data-index="6">DIGITADOR <i id="iconDigitador"></i></th>
                                                <th width="100" rowspan="2" style="cursor: pointer;" class="icono" data-index="7">CONTROL DE CALIDAD <i id="iconControlCalidad"></i></th>
                                                <th width="100" rowspan="2" style="cursor: pointer;" class="icono" data-index="8">COORDINADOR <i id="iconCoordinador"></i></th>
                                                <th width="80" rowspan="2" style="cursor: pointer;" class="icono" data-index="9">FECHA DE ENTREGA <i id="iconFechaEntrega"></i></th>
                                                <th rowspan="2" style="cursor: pointer;" class="icono" data-index="10">RIESGO<i id="iconRiesgo"></i></th>
                                                <th rowspan="2">ACCIONES</th>
                                            </tr>
                                            <tr>
                                                <th>UBICACIÓN</th>
                                                <th width="80">FECHA</th>
                                                <th>PERITO</th>
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
                                        <span id="spanCount"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="divPagination" class="float-right"></div>
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
<?php $this->load->view("operaciones/modal/proceso_modal"); ?>
<?php $this->load->view("operaciones/modal/observaciones_modal"); ?>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("operaciones/include/auditoria_script"); ?>
