<div class="modal fade text-left" id="mdl_orden" tabindex="-1" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">ORDEN DE SERVICIO PARA LA COTIZACIÓN [<span id="spanCotizacionCodigo"></span>]</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-8">
                        <label class="label-control text-left" for="inputOrdenServicio">Orden de Compra / Servicio</label>
                        <input id="inputId" class="form-control border-primary hidden" type="text">
                        <input id="inputOrdenServicio" class="form-control border-primary text-right" type="text">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label class="label-control text-left" for="solicitante">Adjunto</label>
                        <div>
                            <style>
                                .upload {
                                    display: none;
                                }
                                .uploader {
                                    border: 1px solid #ccc;
                                    width: auto;
                                    position: relative;
                                    height: 30px;
                                    display: flex;
                                    border: 1px solid #00B5B8!important;
                                    border-radius: 0.25rem;
                                }
                                .uploader .input-value{
                                    width: auto;
                                    padding: 5px;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    line-height: 25px;
                                    font-family: sans-serif;
                                    font-size: 16px;
                                }
                                .uploader label {
                                    cursor: pointer;
                                    margin: 0;
                                    width: 30px;
                                    height: 30px;
                                    position: absolute;
                                    right: 0;
                                    background: #c3e3fc url('https://www.interactius.com/wp-content/uploads/2017/09/folder.png') no-repeat center;
                                    border-top-right-radius: 0.22rem;
                                    border-bottom-right-radius: 0.22rem;
                                    margin-top: -1px;
                                    margin-right: -1px;
                                }
                            </style>
                            <div class="uploader">
                                <div id="adjunto" class="input-value"></div>
                                <label for="inputAdjunto"></label>
                                <input id="inputAdjunto" name="inputAdjunto" class="upload" type="file" accept="application/pdf">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnSave" type="button" class="btn grey btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
