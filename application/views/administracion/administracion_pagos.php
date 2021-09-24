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
                        <a href="<?= base_url('administracion/facturaciones') ?>">Pagos</a>
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
                    	<h4 class="card-title">LISTADO DE FACTURACIONES</h4>
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
                                                                <label for="selectFiltroFecha">FECHA DE</label>
                                                                <select id="selectFiltroFecha" name="selectFiltroFecha" class="form-control">
                                                                    <option value="">-- Seleccione --</option>
                                                                    <option value="1">Emisión</option>
                                                                    <option value="2">Pago</option>
                                                                </select>
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
                                <!--<div class="col-md-10">
                                    <a id="lnkExportXls" href="" class="btn btn-info">Exportar</a>
                                </div>-->
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table id="tbl_facturacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <!--<tr id="test">
                                                <td colspan="2"><input type="text" class="form-control" id="inputCotizacion"></td>
                                                <td><input type="text" class="form-control" id="inputCorrelativoFactura"></td>
                                                <td><input type="text" class="form-control" id="inputCliente"></td>
                                                <td>
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
                                                <td>
                                                    <input type="text" class="form-control" id="inputConcepto">
                                                </td>
                                                <td colspan="5">
                                                    
                                                </td>
                                                <td colspan="2">
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
                                            </tr>-->
                                            <tr>
                                                <th>#</th>
                                                <th width="80">PROYECTO</th>
                                                <th>CLIENTE</th>
                                                <th>TIPO SERVICIO</th>
                                                <th width="100">COSTO DEL PROYECTO</th>
                                                <th>COMPROBANTE</th>
                                                <th width="80">FECHA EMISIÓN</th>
                                                <th width="100">IMPORTE FACTURADO</th>
                                                <th width="150">PERITO</th>
                                                <th width="100">GASTOS OPERATIVOS</th>
                                                <th>RENTABILIDAD</th>
                                                <th>VENDEDOR</th>
                                                <th>% VENDEDOR</th>
                                                <th>ACCIONES</th>
                                            </tr>
                                            <tr>
                                            	
                                            </tr>
                                        </thead>
                                        <tbody>
                                        	<tr>
                                        		<td rowspan="2">1</td>
                                        		<td rowspan="2">2018001396</td>
	                                        	<td rowspan="2">SAVAR AGENTES DE ADUANA S A</td>
	                                        	<td rowspan="2">INVENTARIO Y CONCILIACIÓN</td>
	                                        	<td rowspan="2">S/. 25,000.00</td>
	                                        	<td>B-1</td>
	                                        	<td>16/11/2018</td>
	                                        	<td>S/. 12,500.00</td>
	                                        	<td>
	                                        		MARCO MUGA
	                                        		<br>
										            <div><strong>Costo: </strong>S/. 6,000.00</div>
										            <div><strong>Estado: </strong>Pendiente</div>
										        </td>
										        <td rowspan="2">S/. 3,000.00</td>
										        <td rowspan="2">S/. 10,000.00</td>
										        <td rowspan="2">GIULIANA RAMON QUISURUCO</td>
										        <td rowspan="2">S/. 1,000.00</td>
										    </tr>
										    <tr>
										    	<td>B-2</td>
											    <td>20/11/2018</td>
											    <td>S/. 12,500.00</td>
											    <td>
										            MARCO MUGA
										            <br>
										            <div><strong>Costo: </strong>S/. 6,000.00</div>
										            <div><strong>Estado: </strong>Pendiente</div>
										        </td>
										     </tr>
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