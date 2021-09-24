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
                        <a href="<?= base_url('cotizacion') ?>">Cotizaciones</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Listado
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!--stats-->
<div class="row">
    <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="danger">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['pendiente'];
                                    }
                                ?>
                            </h3>
                            <span>Pendiente</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc danger font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="success">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['aprobado'];
                                    }
                                ?>
                            </h3>
                            <span>Aprobado</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc success font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media">
                        <div class="media-body text-left w-100">
                            <h3 class="secondary">
                                <?php
                                    if (count($conteo) > 0) {
                                        echo $conteo['desestimado'];
                                    }
                                ?>
                            </h3>
                            <span>Desestimado</span>
                        </div>
                        <div class="media-right media-middle">
                            <i class="icon-doc secondary font-large-2 float-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--/stats-->
<div class="content-body">
    <!-- Individual column searching (text inputs) table -->
    <section id="text-inputs">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    	<h4 class="card-title">REPORTE DE COTIZACIONES</h4>
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
                                        <div class="col-md-2">
                                            <a id="lnkNuevo" href="" class="btn btn-info <?= buscarPermisoEscritura(7, $this->session->userdata('usu_permiso')) == '1' ? '' : 'hidden'; ?>">Nueva Cotización <i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="col-md-9">
                                            <a id="lnkExportXls" href="" class="btn btn-outline-success square float-right"><i class="fa fa-file-excel-o"></i> Exportar Excel</a>

                                            <a id="lnkImprimir" href="" class="btn btn-outline-secondary square float-right mr-1"><i class="fa fa-print"></i> Imprimir</a>

                                            <a id="lnkFiltros" href="" class="btn btn-outline-secondary square float-right dropdown-toggle mr-1" data-toggle="dropdown"><i class="fa fa-filter"></i> Filtros</a>
                                            <div class="mega-dropdown-menu dropdown-menu" style="width: 320px;">
                                                <div class="col-md-12">
                                                    <h6 class="dropdown-menu-header popover-header font-weight-bold mb-1">FILTROS DE BÚSQUEDA</h6>
                                                    <div class="center">
                                                        <div class="row mb-1">
                                                            <div class="col-md-12">
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-addon">FECHA DE</span>
                                                                    <select id="selectFiltroFecha" name="selectFiltroFecha" class="form-control form-control-sm">
                                                                        <option value="">-- Seleccione --</option>
                                                                        <option value="1">Solicitud</option>
                                                                        <option value="2">Envío</option>
                                                                        <option value="3">Aprobación</option>
                                                                        <option value="4">Desestimación</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-sm">
                                                                    <span for="inputFiltroFechaDesde">DESDE</span>
                                                                    <input type="date" id="inputFiltroFechaDesde" name="inputFiltroFechaDesde" class="form-control border-primary form-control-sm" name="date" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group form-group-sm">
                                                                    <span for="inputFiltroFechaDesde">HASTA</span>
                                                                    <input type="date" id="inputFiltroFechaHasta" name="inputFiltroFechaHasta" class="form-control border-primary form-control-sm" name="date" required>
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
                                    <table id="tbl_cotizacion" class="table table-striped table-bordered table-responsive">
                                        <thead>
                                            <tr id="test">
                                                <td colspan="2"><input type="text" class="form-control" id="inputCotizacion"></td>
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
                                                <td>
                                                    <select id="selectVendedor" class="form-control">
                                                        <option value=""></option>
                                                    <?php
                                                        if (count($vendedor) > 0){
                                                            foreach ($vendedor as $row) {
                                                                echo '<option value="'.$row->vendedor_id.'">'.$row->vendedor_nombre.'</option>';
                                                            }
                                                        }
                                                    ?>
                                                    </select>
                                                </td>
                                                <td><input type="text" class="form-control" id="inputCliente"></td>
                                                <td><input type="text" class="form-control" id="inputSolicitante"></td>
                                                <td><input type="text" class="form-control" id="inputMonto"></td>
                                                <td colspan="4">
                                                </td>
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
                                            </tr>
                                            <tr>
                                                <th>#</th>
                                                <th>COD. COTIZACIÓN</th>
                                                <th width="100">TIPO SERVICIO</th>
                                                <th>COORDINADOR</th>
                                                <th width="100">VENDEDOR</th>
                                                <th>CLIENTE</th>
                                                <th>SOLICITANTE </th>
                                                <th id="montoSort" style="cursor: pointer;">MONTO <i id="montoIcon" class="fa"></i></th>
                                                <th width="80">FECHA DE SOLICITUD</th>
                                                <th width="80">FECHA DE ENVÍO</th>
                                                <th width="80">FECHA DE APROBACIÓN</th>
                                                <th width="80">FECHA DE DESESTIMACIÓN</th>
                                                <th>ESTADO</th>
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
<?php $this->load->view("cotizacion/include/cotizacion_script"); ?>
