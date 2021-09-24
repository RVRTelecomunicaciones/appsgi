<!doctype html>
<html>
<head>
    <title>Google Map Test Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?= base_url();?>assets/css/system/tasaciones_mapa/style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>app-assets/css/plugins/extensions/toastr.min.css">
    <style>
        html, body, .map {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>
    <div id="map" class="map"></div>
    <div class="modal fade text-left" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="myModalLabel1">Basic Modal</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
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
                                    <div class="form-group col-md-4">
                                        <p class="form-group"><strong>Area Terreno: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="terreno_area">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <p class="form-group"><strong>Valor Unit Terreno: </strong></p>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="terreno_valorunitario">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4">
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
                                            <input type="text" class="form-control" id="ruta_informe" disabled>
                                            <button onclick="Copiar()" class="btn btn-success" type="button" id="copyRuta">
                                                <span class="fa fa-folder-open fa-md" aria-hidden="true"></span>
                                            </button>
                                        </div>
                                    </div>
                            </div>
                        </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>                  
    </div>                                                   
    <script src="<?= base_url() ?>assets/js/system/tasacion/tasacionesCasaMapaTerreno2.js"></script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBrkygBTW5BHfNxdAxxErprHzpYbqhYeRo&callback=initMap" async defer>
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="<?= base_url() ?>app-assets/vendors/js/extensions/toastr.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    </body>
</html>