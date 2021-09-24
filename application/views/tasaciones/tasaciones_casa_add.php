<!-- Page-Title -->
<div class="row">
    <div class="col-sm-12">
        <div class="page-title-box">
            <h4 class="page-title">Tasaciones</h4>
            <ol class="breadcrumb float-right">
                <li class="breadcrumb-item"><a href="#">Tasaciones</a></li>
                <li class="breadcrumb-item"><a href="#">Tasaciones por Registrar</a></li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h4 class="m-b-20 header-title"><b>REGISTRO DE TASACIÓNES DE CASA</b></h4>
            <form role="form">
                <div class="row">
                    <div class="col-md-12">
                        <div class="p-2">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label for="inputcoordinacion">Coordinación</label>
                                    <input type="text" class="form-control" id="coordinacion" readonly placeholder="Ingrese la Coordinación">
                                </div>
                                <div class="col-md-3">
                                    <label for="inputftasacion">Fecha de Tasación</label>
                                    <input type="date" class="form-control" id="fechaTasacion">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputsolicitante">Solicitante</label>
                                    <input type="text" class="form-control" id="solicitante" readonly placeholder="Ingrese al Solicitante">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-2">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="inputCliente">Cliente</label>
                                    <input type="email" class="form-control" id="cliente" readonly placeholder="Ingrese al Cliente">
                                </div>
                                <div class="col-md-6">
                                    <label for="inputPropietario">Propietario</label>
                                    <input type="email" class="form-control" id="propietario" readonly placeholder="Ingrese al Propietario">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-2">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Ubicación</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Ingresar la dirección del Inmueble">
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleInputEmail1">Zonificación</label>
                                    <select name="zonificacion" id="zonificacion" class="form-control">
                                            <?php echo $combo_zonificacion; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Areas Complementarias</label>
                                    <select class="form-control">
                                        <option>SI</option>
                                        <option>NO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-2">
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Departamento</label>
                                    <select class="form-control" id="mydepartamento">

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1" >Provincia</label>
                                    <select class="form-control" id="myprovincia">
                                      
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Distrito</label>
                                    <select class="form-control" id="mydistrito">
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Area de Terreno</label>
                                    <input type="number" class="form-control" id="areaTerreno" placeholder="Ingresar el Área de Terreno">
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Area de Edificación</label>
                                    <input type="number" class="form-control" id="areaEdificacion" placeholder="Ingresar el Área de Edificación">
                                </div>
                                <div class="col-md-2">
                                    <label for="exampleInputEmail1">Tipo de Cambio</label>
                                    <input type="number" class="form-control" id="tipoCambio" placeholder="Ingresar el Tipo de Cambio">
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                            <div class="p-2">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="exampleInputEmail1">Ruta de Informe</label>
                                        <input type="text" class="form-control" id="rutaInforme" placeholder="Ingresar la ruta del informe">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="exampleInputEmail1">Cantidad de Pisos</label>
                                        <input type="number" class="form-control" id="nPisos" placeholder="Ingresar el N° de Pisos">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="exampleInputEmail1">Valor Unitario de Terreno</label>
                                        <input type="number" class="form-control" id="unitarioTerreno" placeholder="Ingresar el Valor Unitario">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="exampleInputEmail1">Valor Comercial</label>
                                        <input type="number" class="form-control" id="valorComercial" placeholder="Ingresar el Valor Comercial">
                                    </div>

                                </div>
                            </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-2">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="exampleInputEmail1">Observación</label>
                                    <textarea class="form-control" rows="5" placeholder="Detallar Observación"></textarea>
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Latitud</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Latitud">
                                </div>
                                <div class="col-md-3">
                                    <label for="exampleInputEmail1">Longitud</label>
                                    <input type="number" class="form-control" id="exampleInputEmail1" placeholder="Ingresar Longitud">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="row justify-content-end">
                <div class="col-md-6" align="right">
                    <button type="submit" class="btn btn-danger waves-effect waves-light btn-lg text-right m-r-10">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-success waves-effect waves-light btn-lg text-right">
                        Grabar
                    </button>
                </div>
            </div>
        </div>
    </div> <!-- end card-box -->
</div> <!-- end col -->
<script src="<?= base_url() ?>assets/js/system/tasaciones_add.js"></script>

