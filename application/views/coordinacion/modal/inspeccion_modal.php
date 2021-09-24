<style>
    #map {
        height: 400px;
    }
    
    #description {
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
    }

    #infowindow-content .title {
        font-weight: bold;
    }

    #infowindow-content {
        display: none;
    }

    #map #infowindow-content {
        display: inline;
    }

    .pac-card {
        margin: 10px 10px 0 0;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        background-color: #fff;
        font-family: Roboto;
    }

    #pac-container {
        padding: 12px;
        margin-right: 12px;
    }

    .pac-controls {
        display: inline-block;
        padding: 5px 11px;
    }

    .pac-controls label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 0 11px 0 13px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    #title {
        color: #fff;
        background-color: #4d90fe;
        font-size: 25px;
        font-weight: 500;
        padding: 6px 12px;
    }
    .pac-container {
        z-index: 10000 !important;
    }
</style>
<div class="modal fade text-left" id="mdl_inspeccion" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE INSPECCIÓN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--<form id="frm_inspeccion">-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="lnkDatosGenerales" data-toggle="tab" href="#linkDatosGenerales" aria-controls="linkDatosGenerales" aria-expanded="true">DATOS GENERALES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lnkUbigeo" data-toggle="tab" href="#linkUbicacion" aria-controls="linkUbicacion" aria-expanded="false">UBICACIÓN</a>
                                </li>
                            </ul>
                                <div class="form-body">
                                    <div class="tab-content px-1 pt-1">
                                        <!-- BEGIN DATOS GENERALES -->
                                        <div class="tab-pane active in" id="linkDatosGenerales" role="tabpanel" aria-labelledby="lnkDatosGenerales" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row hidden">
                                                        <label class="col-md-3 label-control text-left" for="inputInspeccionId">Cogido</label>
                                                        <div class="col-md-9">
                                                            <input id="inputInspeccionId" type="text" class="form-control border-primary" value="0" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-user"></i> ASIGNACIÓN DEL PERSONAL</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectPerito">Perito</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <select id="selectPerito" name="selectPerito" class="select2-diacritics border-primary">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectDigitador">Digitador</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <select id="selectDigitador" name="selectDigitador" class="select2-diacritics2 border-primary">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectCCalidad">Control Calidad</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <select id="selectCCalidad" name="selectCCalidad" class="select2-diacritics border-primary">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectContactos">Contactos</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <textarea id="inputInspeccionContacto" rows="5" class="form-control border-primary"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-calendar"></i> TIEMPOS</strong>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-4 label-control text-left" for="inputInspeccionFecha">Fecha</label>
                                                                <div class="col-md-8">
                                                                    <div class="position-relative has-icon-left">
                                                                        <input id="inputInspeccionFecha" name="inputInspeccionFecha" type="date" class="form-control">
                                                                        <div class="form-control-position">
                                                                            <i class="ft-message-square"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--<div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-clock"></i> HORA</strong>
                                                    </div>-->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-9 label-control text-left" for="selectFormato">Hora Exacta</label>
                                                                <div class="col-md-3">
                                                                    <input id="radioHExacta" name="hora" type="radio" checked>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group row">
                                                                <label class="col-md-9 label-control text-left" for="selectFormato">Hora Estimada</label>
                                                                <div class="col-md-3">
                                                                    <input id="radioHEstimada" name="hora" type="radio">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>HORA</th>
                                                                        <th></th>
                                                                        <th>MINUTOS</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td><input id="inputHoraExacta" type="number" class="form-control border-primary" value="00" min="0" max="12"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosExacta" type="number" class="form-control border-primary" value="00" min="0" max="60"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoExacta">
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="trHEstimada" class="hidden">
                                                                        <td><input id="inputHoraEstimada" type="number" class="form-control border-primary" value="00" min="0" max="12"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosEstimada" type="number" class="form-control border-primary" value="00" min="0" max="60"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoEstimada">
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-file-text"></i> OBSERVACIONES</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <textarea id="inputInspeccionObservacion" rows="5" class="form-control border-primary"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END DATOS GENERALES -->

                                        <!-- BEGIN UBICACIÓN -->
                                        <div class="tab-pane" id="linkUbicacion" role="tabpanel" aria-labelledby="lnkUbigeo" aria-expanded="true">
                                            <!--Product sale & buyers -->
                                            <div class="row match-height">
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title"><i class="ft ft-map-pin"></i> MAPA</h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div id="products-sales" class="height-400">
                                                                            <div class="pac-card" id="pac-card">
                                                                                <div>
                                                                                    <div id="title">
                                                                                        Dirección
                                                                                    </div>
                                                                                </div>
                                                                                <div id="pac-container">
                                                                                    <input id="pac-input" type="text" placeholder="Enter a location">
                                                                                </div>
                                                                            </div>
                                                                            <div id="map"></div>
                                                                            <div id="infowindow-content">
                                                                                <img src="" width="16" height="16" id="place-icon">
                                                                                <span id="place-name" class="title"></span><br>
                                                                                <span id="place-address"></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-md-12 label-control text-left" for="selectFormato">Latitud</label>
                                                                            <div class="col-md-12">
                                                                                <input id="inputLatitud" type="text" class="form-control border-primary text-center" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group row">
                                                                            <label class="col-md-12 label-control text-left" for="selectFormato">Longitud</label>
                                                                            <div class="col-md-12">
                                                                                <input id="inputLongitud" type="text" class="form-control border-primary text-center" disabled>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title"></h4>
                                                            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                        </div>
                                                        <div class="card-content px-1">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-md-12 label-control text-left" for="selectUbigeoDepartamento">Departamento</label>
                                                                        <div class="col-md-12">
                                                                            <div class="input-group">
                                                                                <select id="selectUbigeoDepartamento" name="selectUbigeoDepartamento" class="select2-diacritics2 border-primary">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-md-12 label-control text-left" for="selectUbigeoProvincia">Provincia</label>
                                                                        <div class="col-md-12">
                                                                            <div class="input-group">
                                                                                <select id="selectUbigeoProvincia" name="selectUbigeoProvincia" class="select2-diacritics2 border-primary">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group row">
                                                                        <label class="col-md-12 label-control text-left" for="selectUbigeoDistrito">Distrito</label>
                                                                        <div class="col-md-12">
                                                                            <div class="input-group">
                                                                                <select id="selectUbigeoDistrito" name="selectUbigeoDistrito" class="select2-diacritics2 border-primary">
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group row">
                                                                        <label class="col-md-12 label-control text-left" for="selectFormato">Dirección <i style="color: red;">(Nota: No digitar departamento, provincia, ni distrito)</i></label>
                                                                        <div class="col-md-12">
                                                                            <textarea id="inputDireccion" rows="2" class="form-control border-primary"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label class="col-md-12 label-control text-left" for="selectFormato">Ruta</label>
                                                                        <div class="col-md-12">
                                                                            <textarea id="inputRuta" rows="2" class="form-control border-primary"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Product sale & buyers -->
                                        </div>
                                        <!-- END UBICACIÓN -->
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnGuardarInspeccion" type="submit" class="btn btn-warning">Guardar</button>
                </div>
            <!--</form>-->
        </div>
    </div>
</div>

<div class="modal fade text-left" id="mdl_inspeccion_detalle" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE INSPECCIÓN</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="frmInspeccion">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="lnkDatosGeneralesDetalle" data-toggle="tab" href="#linkDatosGeneralesDetalle" aria-controls="linkDatosGeneralesDetalle" aria-expanded="true">DATOS GENERALES</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lnkUbigeoDetalle" data-toggle="tab" href="#linkUbicacionDetalle" aria-controls="linkUbicacionDetalle" aria-expanded="false">UBICACIÓN</a>
                                </li>
                            </ul>
                                <div class="form-body">
                                    <div class="tab-content px-1 pt-1">
                                        <!-- BEGIN DATOS GENERALES -->
                                        <div class="tab-pane active in" id="linkDatosGeneralesDetalle" role="tabpanel" aria-labelledby="lnkDatosGeneralesDetalle" aria-expanded="true">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group row hidden">
                                                        <label class="col-md-3 label-control text-left" for="inputIdDetalle">Cogido</label>
                                                        <div class="col-md-9">
                                                            <input id="inputIdDetalle" name="inputIdDetalle" type="text" class="form-control border-primary" value="0" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-user"></i> ASIGNACIÓN DEL PERSONAL</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-3 label-control text-left" for="selectPeritoDetalle">Perito</label>
                                                        <div class="col-md-9">
                                                            <div class="input-group">
                                                                <select id="selectPeritoDetalle" name="selectPeritoDetalle" class="select2-diacritics border-primary">
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft-users"></i> CONTACTO</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <div class="input-group">
                                                                <textarea id="inputContactoDetalle" name="inputContactoDetalle" rows="5" class="form-control border-primary"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-calendar"></i> FECHA</strong>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-4 label-control text-left" for="inputFechaDetalle">Fecha</label>
                                                                <div class="col-md-8">
                                                                    <input id="inputFechaDetalle" name="inputFechaDetalle" type="date" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-clock"></i> HORA</strong>
                                                        <div class="pull-right">
                                                            <select id="selectHoraTipoDetalle">
                                                                <option value="1">Exacta</option>
                                                                <option value="2">Estimada</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <table class="table">
                                                                <thead>
                                                                    <tr>
                                                                        <th></th>
                                                                        <th>HORA</th>
                                                                        <th></th>
                                                                        <th>MINUTOS</th>
                                                                        <th></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>DESDE</td>
                                                                        <td><input id="inputHoraExactaDetalle" name="inputHoraExactaDetalle" type="number" class="form-control border-primary" value="00" min="0" max="24"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosExactaDetalle" name="inputMinutosExactaDetalle" type="number" class="form-control border-primary" value="00" min="0" max="59"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoExactaDetalle" disabled>
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                    <tr id="trHEstimadaDetalle" class="hidden">
                                                                        <td>HASTA</td>
                                                                        <td><input id="inputHoraEstimadaDetalle" type="number" class="form-control border-primary" value="00" min="0" max="24"></td>
                                                                        <td>:</td>
                                                                        <td><input id="inputMinutosEstimadaDetalle" type="number" class="form-control border-primary" value="00" min="0" max="59"></td>
                                                                        <td>
                                                                            <select id="selectMeridianoEstimadaDetalle" disabled>
                                                                                <option value="1">AM</option>
                                                                                <option value="2">PM</option>
                                                                            </select>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem">
                                                        <strong><i class="ft ft-file-text"></i> OBSERVACIONES</strong>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-md-12">
                                                            <textarea id="inputObservacionDetalle" rows="5" class="form-control border-primary"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END DATOS GENERALES -->

                                        <!-- BEGIN UBICACIÓN -->
                                        <div class="tab-pane" id="linkUbicacionDetalle" role="tabpanel" aria-labelledby="lnkUbigeoDetalle" aria-expanded="true">
                                            <!--Product sale & buyers -->
                                            <div class="row">
                                                <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectDepartamentoDetalle">Departamento</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectDepartamentoDetalle" name="selectDepartamentoDetalle" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectProvinciaDetalle">Provincia</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectProvinciaDetalle" name="selectProvinciaDetalle" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group row">
                                                            <label class="col-md-12 label-control text-left" for="selectDistritoDetalle">Distrito</label>
                                                            <div class="col-md-12">
                                                                <div class="input-group">
                                                                    <select id="selectDistritoDetalle" name="selectDistritoDetalle" class="select2-diacritics2 border-primary">
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group row">
                                                                <label class="col-md-12 label-control text-left" for="inputDireccionDetalle">Dirección <i style="color: red;">(Nota: No digitar departamento, provincia, ni distrito)</i></label>
                                                                <div class="col-md-12">
                                                                    <textarea id="inputDireccionDetalle" name="inputDireccionDetalle" rows="2" class="form-control border-primary"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/ Product sale & buyers -->
                                        </div>
                                        <!-- END UBICACIÓN -->
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button id="btnGuardarInspeccion" type="submit" class="btn btn-warning">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>