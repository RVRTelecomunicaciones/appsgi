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
                        <a href="<?= base_url('reporte/coordinacion') ?>">Administración</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Terminados
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
                    	<h4 class="card-title">REPORTES DE COORDINACIONES TERMINADAS</h4>
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
                                            <!--<a id="lnkExportXls" href="" class="btn btn-outline-success square float-right"><i class="fa fa-file-excel-o"></i> Exportar Excel</a>-->

                                            <!--<a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right mr-1"><i class="fa fa-print"></i> Imprimir</a>-->

                                            <a id="lnkFiltros" href="" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</a>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 300px;">
                                                <div class="col-md-12">
                                                    <h6 class="dropdown-menu-header popover-header font-weight-bold mb-1">FILTRAR POR FECHA </h6>
                                                    <div class="center">
                                                        <div class="form-group row">
                                                            <label class="col-md-3" for="inputFechaDesde">DESDE</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="date" id="inputFechaDesde" name="inputFechaDesde" class="form-control form-control-sm border-primary" name="date">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="form-group row">
                                                            <label class="col-md-3" for="inputFechaHasta">HASTA</label>
                                                            <div class="col-md-9">
                                                                <div class="input-group">
                                                                    <input type="date" id="inputFechaHasta" name="inputFechaHasta" class="form-control form-control-sm border-primary" name="date">
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
                                            </tr>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2" width="60">COORD.</th>
                                                <th rowspan="2" width="100">ESTADO</th>
                                                <th rowspan="2">SOLICITANTE</th>
                                                <th rowspan="2">CLIENTE</th>
                                                <th rowspan="2">TIPO SERVICIO</th>
                                                <th rowspan="2" width="80">FECHA ENTREGA</th>
                                                <th colspan="2">AUDITORIA</th>
                                            </tr>
                                            <tr>
                                                <th>ESTADO</th>
                                                <th>FECHA</th>
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
</div>
<?php $this->load->view("includes/include_script_datatable"); ?>
<?php $this->load->view("reporte/administracion/terminadas/include/terminadas_script"); ?>