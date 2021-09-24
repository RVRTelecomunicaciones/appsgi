<div class="modal fade text-left" id="mdlJuridico" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
	<div id="divCambioClass" class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
			<div class="modal-header bg-primary white">
				<h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE INVOLUCRADOS JURÍDICOS</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
						<div class="nav-vertical">
							<ul class="nav nav-tabs nav-left nav-border-left">
								<li class="nav-item hidden">
									<a class="nav-link" id="baseVerticalLeft1-tab1" data-toggle="tab" aria-controls="tabVerticalLeft11" href="#tabVerticalLeft1" aria-expanded="true">Clasificación</a>
								</li>
								<li class="nav-item hidden">
									<a class="nav-link" id="baseVerticalLeft1-tab2" data-toggle="tab" aria-controls="tabVerticalLeft12" href="#tabVerticalLeft2" aria-expanded="false">Actividad</a>
								</li>
								<li class="nav-item hidden">
									<a class="nav-link" id="baseVerticalLeft1-tab3" data-toggle="tab" aria-controls="tabVerticalLeft13" href="#tabVerticalLeft3" aria-expanded="false">Grupo</a>
								</li>
								<li class="nav-item">
									<a class="nav-link active" id="baseVerticalLeft1-tab4" data-toggle="tab" aria-controls="tabVerticalLeft14" href="#tabVerticalLeft4" aria-expanded="false">Jurídico</a>
								</li>
							</ul>
							<div class="tab-content px-1">
								<!-- BEGIN CLASIFICACIÓN -->
								<div class="tab-pane" id="tabVerticalLeft1" aria-expanded="true" aria-labelledby="baseVerticalLeft1-tab1" style="overflow: hidden;">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-md-2 label-control" for="inputDescripcion">Descripción</label>
												<div class="col-md-10">
													<input id="inputId" type="text" class="form-control border-primary hidden" value="0">
													<input id="inputDescripcion" type="text" class="form-control border-primary">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-1 label-control" for="checkEstado">Activo</label>
												<div class="col-md-1">
													<input id="checkEstado" type="checkbox" checked>
												</div>
												<div class="col-md-10">
													<div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
														<a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
														<a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="tableRegistro" class="table table-striped table-bordered">
												<thead>
													<tr>
														<td colspan="2">
															<input id="inputSearchDescripcion" type="text" class="form-control border-primary">
														</td>
														<td>
															<select id="selectSearchEstado" class="form-control border-primary">
																<option value=""></option>
																<option value="1">Activo</option>
																<option value="0">Inactivo</option>
															</select>
														</td>
													</tr>
													<tr>
														<th>#</th>
														<th>DESCRIPCIÓN</th>
														<th width="120">ESTADO</th>
														<th width="60">ACCIONES</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											</div>
											
										</div>
									</div>
									<div class="row">
		                                <div class="col-md-6">
		                                    <div class="text-left">
		                                        <span id="conteo"></span>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div id="paginacion" class="float-right"></div>
		                                </div>
		                            </div>
								</div>
								<!-- END CLASIFICACIÓN -->

								<!-- BEGIN ACTIVIDAD -->
								<div class="tab-pane" id="tabVerticalLeft2" aria-labelledby="baseVerticalLeft1-tab2" style="overflow: hidden;">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-md-2 label-control" for="inputDescripcion">Descripción</label>
												<div class="col-md-10">
													<input id="inputId" type="text" class="form-control border-primary hidden" value="0">
													<input id="inputDescripcion" type="text" class="form-control border-primary">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-1 label-control" for="checkEstado">Activo</label>
												<div class="col-md-1">
													<input id="checkEstado" type="checkbox" checked>
												</div>
												<div class="col-md-10">
													<div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
														<a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
														<a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="tableRegistro" class="table table-striped table-bordered">
												<thead>
													<tr>
														<td colspan="2">
															<input id="inputSearchDescripcion" type="text" class="form-control border-primary">
														</td>
														<td>
															<select id="selectSearchEstado" class="form-control border-primary">
																<option value=""></option>
																<option value="1">Activo</option>
																<option value="0">Inactivo</option>
															</select>
														</td>
													</tr>
													<tr>
														<th>#</th>
														<th>DESCRIPCIÓN</th>
														<th width="120">ESTADO</th>
														<th width="60">ACCIONES</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											</div>
											
										</div>
									</div>
									<div class="row">
		                                <div class="col-md-6">
		                                    <div class="text-left">
		                                        <span id="conteo"></span>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div id="paginacion" class="float-right"></div>
		                                </div>
		                            </div>
								</div>
								<!-- END ACTIVIDAD -->

								<!-- BEGIN GRUPO -->
								<div class="tab-pane" id="tabVerticalLeft3" aria-labelledby="baseVerticalLeft1-tab3" style="overflow: hidden;">
									<div class="row">
										<div class="col-md-12">
											<div class="form-group row">
												<label class="col-md-2 label-control" for="inputDescripcion">Descripción</label>
												<div class="col-md-10">
													<input id="inputId" type="text" class="form-control border-primary hidden" value="0">
													<input id="inputDescripcion" type="text" class="form-control border-primary">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-md-1 label-control" for="checkEstado">Activo</label>
												<div class="col-md-1">
													<input id="checkEstado" type="checkbox" checked>
												</div>
												<div class="col-md-10">
													<div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
														<a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
														<a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="tableRegistro" class="table table-striped table-bordered">
												<thead>
													<tr>
														<td colspan="2">
															<input id="inputSearchDescripcion" type="text" class="form-control border-primary">
														</td>
														<td>
															<select id="selectSearchEstado" class="form-control border-primary">
																<option value=""></option>
																<option value="1">Activo</option>
																<option value="0">Inactivo</option>
															</select>
														</td>
													</tr>
													<tr>
														<th>#</th>
														<th>DESCRIPCIÓN</th>
														<th width="120">ESTADO</th>
														<th width="60">ACCIONES</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											</div>
											
										</div>
									</div>
									<div class="row">
		                                <div class="col-md-6">
		                                    <div class="text-left">
		                                        <span id="conteo"></span>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div id="paginacion" class="float-right"></div>
		                                </div>
		                            </div>
								</div>
								<!-- BEGIN GRUPO -->

								<!-- BEGIN INVOLUCRADO -->
								<div role="tabpanel" class="tab-pane active" id="tabVerticalLeft4" aria-labelledby="baseVerticalLeft1-tab4" style="overflow: hidden;">
									<div class="row">
										<div class="col-md-12">
											<form id="formInvolucrado">
												<div class="form-group row">
													<label class="col-md-1 label-control" for="inputRazonSocial">Razón Social</label>
													<div class="col-md-7">
														<input id="inputId" type="text" class="form-control border-primary hidden" value="0" disabled>
														<input id="inputRazonSocial" name="inputRazonSocial" type="text" class="form-control border-primary">
													</div>
													<label class="col-md-1 label-control" for="inputRuc">Ruc</label>
													<div class="col-md-3">
														<fieldset>
															<div class="input-group">
																<span class="input-group-btn" id="button-addon3">
																	<a id="linkBuscarRuc" class="btn btn-secondary" style="color: white;"><i class="fa fa-search"></i></a>
																</span>
																<input id="inputRuc" name="inputRuc" type="text" class="form-control border-primary" minlength="11" maxlength="11" style="text-align: right;">
															</div>
														</fieldset>
													</div>
												</div>
												<div class="form-group row">
													<label class="col-md-1 label-control" for="inputDireccion">Dirección Fiscall</label>
													<div class="col-md-7">
														<input id="inputDireccion" name="inputDireccion" type="text" class="form-control border-primary">
													</div>
													<label class="col-md-1 label-control" for="inputTelefono">Teléfono</label>
													<div class="col-md-3">
														<input id="inputTelefono" name="inputTelefono" type="text" class="form-control border-primary" style="text-align: right;">
													</div>
												</div>

												<!--<div class="form-group row">
													<label class="col-md-1 label-control" for="selectClasificacion">Clasificación</label>
													<div class="col-md-3">
														<select id="selectClasificacion" name="selectClasificacion" class="select2-diacritics">
														</select>
													</div>
													<label class="col-md-1 label-control" for="selectActividad">Actividad</label>
													<div class="col-md-3">
														<select id="selectActividad" name="selectActividad" class="select2-diacritics">
														</select>
													</div>
													<label class="col-md-1 label-control" for="selectGrupo">Grupo</label>
													<div class="col-md-3">
														<select id="selectGrupo" name="selectGrupo" class="select2-diacritics">
														</select>
													</div>
												</div>-->

												<div class="form-group row">
													<label class="col-md-1 label-control" for="checkEstado">Activo</label>
													<div class="col-md-1">
														<input id="checkEstado" name="checkEstado" type="checkbox" checked>
													</div>
													<div class="col-md-10">
														<div class="btn-group btn-group-sm float-right" role="group" aria-label="Basic example">
															<a id="linkCancelar" href="" class="btn btn-light square">Cancelar</a>
															<a id="linkAñadir" href="" class="btn btn-primary square">Añadir</a>
														</div>
													</div>
												</div>
											</form>
										</div>
									</div>
									<div class="row">
										<div class="col-md-12">
											<div class="table-responsive">
												<table id="tableRegistro" class="table table-striped table-bordered">
												<thead>
													<tr>
														<td colspan="2">
															<input id="inputSearchRazonSocial" type="text" class="form-control border-primary">
														</td>
														<td>
															<input id="inputSearchDocumento" type="text" class="form-control border-primary">
														</td>
														<!--<td>
															<input id="inputSearchClasificacion" type="text" class="form-control border-primary">
														</td>
														<td>
															<input id="inputSearchActividad" type="text" class="form-control border-primary">
														</td>
														<td>
															<input id="inputSearchGrupo" type="text" class="form-control border-primary">
														</td>-->
														<td>
															<input id="inputSearchDireccion" type="text" class="form-control border-primary">
														</td>
														<td>
															<!--<input id="inputSearchTelefono" type="text" class="form-control border-primary">-->
														</td>
														<td>
															<select id="selectSearchEstado" class="form-control border-primary">
																<option value=""></option>
																<option value="1">Activo</option>
																<option value="0">Inactivo</option>
															</select>
														</td>
													</tr>
													<tr>
														<th>#</th>
														<th>RAZÓN SOCIAL</th>
														<th>RUC</th>
														<!--<th>CLASIFICACIÓN</th>
														<th>ACTIVIDAD</th>
														<th>GRUPO</th>-->
														<th>DIRECCIÓN</th>
														<th>TELÉFONO</th>
														<th width="120">ESTADO</th>
														<th width="60">ACCIONES</th>
													</tr>
												</thead>
												<tbody>
												</tbody>
											</table>
											</div>
											
										</div>
									</div>
									<div class="row">
		                                <div class="col-md-6">
		                                    <div class="text-left">
		                                        <span id="conteo"></span>
		                                    </div>
		                                </div>
		                                <div class="col-md-6">
		                                    <div id="paginacion" class="float-right"></div>
		                                </div>
		                            </div>
								</div>
								<!-- END INVOLUCRADO -->
							</div>
						</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
				<!--<button type="button" class="btn btn-outline-primary">Save changes</button>-->
			</div>
		</div>
	</div>
</div>