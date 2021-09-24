<div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-2">
        <div class="row breadcrumbs-top">
            <div class="breadcrumb-wrapper col-12">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('intranet/inicio') ?>">Inicio</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Administración</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0)">Pago</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('administracion/pago_vendedor') ?>">Vendedor</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado
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
                    	<h4 class="card-title">LISTADO DE PAGO VENDEDOR</h4>
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

                                            <a id="lnkFiltros" href="" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</a>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 300px;">
                                                <div class="col-md-12">
                                                    <h6 class="dropdown-menu-header popover-header font-weight-bold mb-1">FILTROS DE BÚSQUEDA</h6>
                                                    <div class="center">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="selectFiltroEstadoPagoPerito">ESTADO DE PAGO</label>
                                                                <select id="selectFiltroEstadoPagoPerito" name="selectFiltroEstadoPagoPerito" class="form-control">
                                                                    <option value="">-- Seleccione --</option>
                                                                    <option value="0">Pendiente</option>
                                                                    <option value="1">Cancelado</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <label for="inputFiltroFechaDesde">FECHA DE PAGO: DESDE</label>
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
                                    <table id="tbl_pago_vendedor" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr>
                                                <td colspan="2"><input type="text" class="form-control" id="inputCotizacionCorrelativo"></td>
                                                <td><input type="text" class="form-control" id="inputCliente"></td>
                                                <td colspan="2">
                                                    <select id="selectTServicio" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($tservicio) > 0){
                                                            foreach ($tservicio as $row) {
                                                                echo '<option value="'.$row->servicio_tipo_id.'">'.strtoupper($row->servicio_tipo_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td colspan="2">
                                                    <select id="selectEstado" class="form-control">
                                                        <option value=""></option>
                                                        <option value="0">Pendiente</option>
                                                        <option value="1">Cancelado</option>
                                                    </select>
                                                </td>
                                                <td colspan="2"></td>
                                                <td colspan="2">
                                                    <select id="selectVendedor" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($vendedor) > 0){
                                                            foreach ($vendedor as $row) {
                                                                echo '<option value="'.$row->vendedor_id.'">'.strtoupper($row->vendedor_nombre).'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2" width="80">PROYECTO</th>
                                                <th rowspan="2">CLIENTE</th>
                                                <th rowspan="2">TIPO SERVICIO</th>
                                                <th rowspan="2" width="100">COSTO PROYECTO</th>
                                                <th rowspan="2">ESTADO</th>
                                                <th rowspan="2" width="80">COSTO PERITO</th>
                                                <th rowspan="2">GASTOS OPERATIVOS</th>
                                                <th rowspan="2" width="90">RENTAB.</th>
                                                <th colspan="4">VENDEDOR</th>
                                                <th rowspan="2">ACCIONES</th>
                                            </tr>
                                            <tr>
                                                <th width="150">NOMBRE Y APELLIDOS</th>
                                                <th width="90">COMISIÓN</th>
                                                <th width="80">ESTADO DE PAGO</th>
                                                <th width="80">FECHA DE PAGO</th>
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
<?php $this->load->view("administracion/include/administracion_pago_vendedor_script"); ?>