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

    .uploader .input-value {
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
<div class="modal fade text-left" id="mdl_documentos" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info white">
                <h4 class="modal-title" id="myModalLabel8">DOCUMENTOS DE [<span id="spanFacturacion"></span>]</h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formDocumentos">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input id="inputId" name="inputId" type="text" value="0" class="form-control border-primary hidden" disabled>
                            <input id="inputTipoDocumento" name="inputTipoDocumento" type="text" value="0" class="form-control border-primary hidden" disabled>
                            <div class="form-group row">
                                <label class="col-md-1 label-control" for="selectGasto">XML</label>
                                <div class="col-md-11">
                                    <div class="uploader">
                                        <div id="adjuntoXml" class="input-value"></div>
                                        <label for="inputAdjuntoXml"></label>
                                        <input id="inputAdjuntoXml" name="inputAdjuntoXml" class="upload" type="file" accept="application/xml">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-1 label-control" for="inputCosto">PDF</label>
                                <div class="col-md-11">
                                    <div class="uploader">
                                        <div id="adjuntoPdf" class="input-value"></div>
                                        <label for="inputAdjuntoPdf"></label>
                                        <input id="inputAdjuntoPdf" name="inputAdjuntoPdf" class="upload" type="file" accept="application/pdf">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="btnCerrar" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-warning">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
