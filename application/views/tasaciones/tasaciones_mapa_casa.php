<!doctype html>
<html>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
<head><meta charset="gb18030">
    <title>Google Map Test Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/system/tasaciones_mapa/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>app-assets/vendors/css/extensions/toastr.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>app-assets/css/plugins/extensions/toastr.min.css">
	<style>
     #map {
		height: 100%;
		position: fixed !important;
		height: 100% !important;
    width: 100% !important;
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
        z-index: 1051 !important;
	}
	.form-group {
    margin-bottom: 0.5rem;
}
</style>
</head>

<body>

<div id="sidebar" class="sidebar sidebar-left">
    <!-- Nav tabs -->
    <div class="sidebar-tabs">
        <ul role="tablist">
            <li class="active">
                <a role="tab"><i class="fa fa-filter"></i></a>
            </li>
        </ul>
    </div>
    <!-- Tab panes -->
    <div class="sidebar-content">
        <!--        <form style="display: block;">-->
        <div class="sidebar-pane active" id="home">
            <h1 class="sidebar-header">
                Filter                        <span class="sidebar-close"><i class="fa fa-caret-left"></i></span>
            </h1>                       
            <div class="panel-body">
    

                    <label>
					<!-- onclick="checkboxAll(this);e" -->
                    <input checked="checked" type="checkbox"  name="check_all" id="check_all" value="-1"> Check All
                    </label>
                <div class="checkbox" style="height: 1019px; overflow-y: scroll;">
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion"  type="checkbox" id="check_terreno" value="1">
                        <!--<input checked="checked"  type="checkbox" id="idTerreno" value="1" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/terreno2.svg" alt="airport" title="airport"> Terreno                                
                    </label>
                    <br>
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion" type="checkbox" id="check_departamento" value="2">
                        <!--<input checked="checked"  type="checkbox" id="idDepartamento" value="2" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/departamento.svg" alt="station" title="station">Departamento
                    </label>
                    <br>
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion" type="checkbox" id="check_localcomercial" value="3">
                        <!--<input checked="checked"  type="checkbox" id="idDepartamento" value="2" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/industry2.svg" alt="station" title="station">Local Comercial
                    </label>
                    <br>
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion" type="checkbox" id="check_localindustrial" value="4">
                        <!--<input checked="checked"  type="checkbox" id="idDepartamento" value="2" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/industry.svg" alt="station" title="station">Local Industrial
                    </label>
                    <br>
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion" type="checkbox" id="check_oficina" value="5">
                        <!--<input checked="checked"  type="checkbox" id="idDepartamento" value="2" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/oficinastest.svg" alt="station" title="station">Oficina
                    </label>                    
					<br>
                    <label style="margin-right: 9px; margin-bottom: 10px;">
                        <input checked="checked" class="tipoTasacion" type="checkbox" id="check_casa" value="6">
                        <!--<input checked="checked"  type="checkbox" id="idDepartamento" value="2" onclick="verifyChecked()">-->
                        <img src="<?= base_url()?>assets/images/small/home.svg" alt="station" title="station">Casa
                    </label>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
		        <!-- <div id="map" class="map">
                </div> -->
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
      <span id="place-name"  class="title"></span><br>
      <span id="place-address"></span>
    </div>
                                                                        </div>
            </div>
           <!-- <div class="col-2">
                <div class="panel panel-primary">
                    <p>A</p>

                </div>
            </div>-->
        </div>
    </div>




    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">X</span>
                        </button>
                </div>
                <div class="modal-body">
                        <form action="#">
                            <fieldset disabled>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <p class="form-group"><strong>Solicitante: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="solicitante">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p class="form-group"><strong>Cliente: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cliente">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <p class="form-group"><strong>Dirección:</strong></p>
                                        <div class="form-group">
                                            <textarea class="form-control" id="ubicacion"  rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <p class="form-group"><strong>Area Terreno: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="terreno_area">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p class="form-group"><strong>Valor Unit Terreno: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="terreno_valorunitario">
                                        </div>
									</div>
									<div class="form-group col-md-6">
                                        <p class="form-group"><strong>Valor x Area Ocupada: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="departamento_valorocupado">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p class="form-group"><strong>Valor Comercial: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="valor_comercial">
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-row">
                                    <div class="form-group col">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="">Ruta</span>
                                            </div>
                                            <input type="text" class="form-control" id="ruta_informe" readonly>
                                            <button class="btn btn-success" type="button" id="copyRuta">
                                                <span class="fa fa-folder-open fa-md" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btnClose" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/@google/markerclustererplus@4.0.1/dist/markerclustererplus.min.js"></script>
    <script src="<?= base_url() ?>assets/js/system/tasacion/tasacionesCasaMapaTerreno.js"></script>
    <!-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script> -->


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>assets/js/system/tasacion/jquery-sidebar.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>

</body>
</html>