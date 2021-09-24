<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('tasacion') ?>">Tasaciones</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('tasacion/inmuebles') ?>">Registradas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Inmuebles
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
                    	<h4 class="card-title">TASACIONES REGISTRADAS - INMUEBLES</h4>
                    	<a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                    	<div class="heading-elements">
                    		<ul class="list-inline mb-0">
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
                                            <!--<a id="lnkExportXls" href="" class="btn btn-outline-success square float-right"><i class="fa fa-file-excel-o"></i> Exportar Excel</a>

                                            <a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right mr-1"><i class="fa fa-print"></i> Imprimir</a>-->

                                            <button id="buttonFilters" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</button>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 380px;">
                                                <div class="col-lg-12">
                                                    <div class="popover-header font-weight-bold mb-1">FECHA DE TASACIÓN</div>
                                                    <div class="center">
                                                        <form id="frm_filtros">
                                                            <div class="row mt-1">
                                                                <div class="col-md-6">
                                                                    <label for="inputFechaDesde" class="col-form-label-sm">DESDE</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input id="inputFechaDesde" type="date" class="form-control form-control-sm text-right">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="inputFechaHasta" class="col-form-label-sm">HASTA</label>
                                                                    <div class="input-group input-group-sm">
                                                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                        <input id="inputFechaHasta" type="date" class="form-control form-control-sm text-right">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="popover-header font-weight-bold mt-1 mb-1">ÁREA TOTAL (m2)</div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="number" id="inputAreaDesde" class="form-control form-control-sm text-right" min="1" placeholder="Desde">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="number" id="inputAreaHasta" class="form-control form-control-sm text-right" min="1" placeholder="Hasta">
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_tasacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td colspan="2">
                                                    <select id="selectTipo" class="form-control">
                                                        <option value="">Seleccione</option>
                                                        <option value="TERRENO" data-icon="fa fa-map-signs text-success">Terreno</option>
                                                        <option value="CASA" data-icon="fa fa-home fa-lg">Casa</option>
                                                        <option value="DEPARTAMENTO" data-icon="fa fa-building text-danger">Departamento</option>
                                                        <option value="OFICINA" data-icon="fa fa-suitcase">Oficina</option>
                                                        <option value="LOCAL COMERCIAL" data-icon="fa fa-industry text-info">L. Comercial</option>
                                                        <option value="LOCAL INDUSTRIAL" data-icon="fa fa-industry text-warning">L. Industrial</option>
                                                    </select>
                                                </td>
                                                <td><input id="inputCoordinacion" type="text" class="form-control form-control-sm"></td>
                                                <td><input id="inputSolicitante" type="text" class="form-control form-control-sm"></td>
                                                <td><input id="inputCliente" type="text" class="form-control form-control-sm"></td>
                                                <td><input id="inputDireccion" type="text" class="form-control form-control-sm"></td>
                                                <td>
                                                    <select id="selectZonificacion" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($zonificacion) > 0){
                                                            foreach ($zonificacion as $row) {
                                                                if ($row->zonificacion_id == 0) {
                                                                    echo '<option value="'.$row->zonificacion_id.'">'.$row->zonificacion_abreviatura.'</option>';
                                                                } else {
                                                                    echo '<option value="'.$row->zonificacion_id.'">'.strtoupper($row->zonificacion_abreviatura.' - '.$row->zonificacion_nombre).'</option>';
                                                                }
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <!--<td colspan="8"></td>-->
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th width="110">TIPO</th>
                                                <th width="90">COORD.</th>
                                                <th width="160">SOLICITANTE</th>
                                                <th width="160">CLIENTE</th>
                                                <th width="200">DIRECCIÓN</th>
                                                <th>ZONIFICACIÓN</th>
                                                <th width="100">FECHA</th>
                                                <th>AREA m2</th>
                                                <th>V.U.T</th>
                                                <th>VALOR COMERCIAL</th>
                                                <th width="200">DATOS ADICCIONALES</th>
                                                <th>ACCIONES</th>
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
<?php //$this->load->view("tasacion/modal/tipo_tasacion_modal"); ?>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("tasacion/include/tasacion_inmuebles_script"); ?>