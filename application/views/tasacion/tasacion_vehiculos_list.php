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
                        <a href="<?= base_url('tasacion/vehiculos') ?>">Registradas</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Vehículos
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
                    	<h4 class="card-title">TASACIONES REGISTRADAS - VEHÍCULOS</h4>
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
                                            <div class="mega-dropdown-menu dropdown-menu">
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
                                                            <!--<div class="popover-header font-weight-bold mt-1 mb-1">ÁREA TOTAL (m2)</div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <input type="number" id="inputAreaDesde" class="form-control form-control-sm text-right" min="1" placeholder="Desde">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <input type="number" id="inputAreaHasta" class="form-control form-control-sm text-right" min="1" placeholder="Hasta">
                                                                </div>
                                                            </div>-->
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
                                                <td colspan="2"><input id="inputCoordinacion" type="text" class="form-control form-control-sm"></td>
                                                <td><input id="inputSolicitante" type="text" class="form-control form-control-sm"></td>
                                                <td><input id="inputCliente" type="text" class="form-control form-control-sm"></td>
                                                <td></td>
                                                <td>
                                                    <select id="selectClase" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                        <?php
                                                            if (count($clase) > 0){
                                                                foreach ($clase as $row) {
                                                                    if ($row->clase_id == 1) {
                                                                        echo '<option value="'.$row->clase_id.'">'.$row->clase_nombre.'</option>';
                                                                    } else {
                                                                        echo '<option value="'.$row->clase_id.'">'.strtoupper($row->clase_nombre).'</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="selectMarca" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                        <?php
                                                            if (count($marca) > 0){
                                                                foreach ($marca as $row) {
                                                                    if ($row->marca_id == 1) {
                                                                        echo '<option value="'.$row->marca_id.'">'.$row->marca_nombre.'</option>';
                                                                    } else {
                                                                        echo '<option value="'.$row->marca_id.'">'.strtoupper($row->marca_nombre).'</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select id="selectModelo" class="form-control select2-diacritics">
                                                        <option value=""></option>
                                                        <?php
                                                            if (count($modelo) > 0){
                                                                foreach ($modelo as $row) {
                                                                    if ($row->modelo_id == 1) {
                                                                        echo '<option value="'.$row->modelo_id.'">'.$row->modelo_nombre.'</option>';
                                                                    } else {
                                                                        echo '<option value="'.$row->modelo_id.'">'.strtoupper($row->modelo_nombre).'</option>';
                                                                    }
                                                                }
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th width="90">COORD.</th>
                                                <th>SOLICITANTE</th>
                                                <th>CLIENTE</th>
                                                <th width="80">FECHA TASACIÓN</th>
                                                <th width="140">CLASE</th>
                                                <th width="140">MARCA</th>
                                                <th width="140">MODELO</th>
                                                <th width="60">AÑO</th>
                                                <th>V.S.N ($)</th>
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
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("tasacion/include/tasacion_vehiculo_script"); ?>