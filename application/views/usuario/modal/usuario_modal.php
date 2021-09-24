<div class="modal fade text-left" id="mdlUsuario" role="dialog" aria-labelledby="myModalLabel8" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title" id="myModalLabel8">MANTENIMIENTO DE USUARIOS</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="form-group col-12">
                                <label class="text-left" for="inputNombreCompleto">Ap. y Nombres</label>
                                <input id="inputId" type="text" class="form-control border-primary hidden" value="0" disabled>
                                <input id="inputNombreCompleto" name="inputNombreCompleto" type="text" class="form-control border-primary">
                            </div>

                            <div class="form-group col-12">
                                <label class="text-left" for="inputCorreo">Correo</label>
                                <input id="inputCorreo" name="inputCorreo" type="text" class="form-control border-primary">
                            </div>

                            <div class="form-group col-6">
                                <label class="text-left" for="selectRol">Area</label>
                                <select id="selectArea" class="form-control select2-diacritics"></select>
                            </div>

                            <div class="form-group col-6">
                                <label class="text-left" for="selectRol">Rol</label>
                                <select id="selectRol" class="form-control select2-diacritics"></select>
                            </div>

                            <div class="form-group col-12">
                                <div class="alert bg-primary alert-dismissible" role="alert" style="padding: 0.25rem 0.5rem; margin-bottom: -5px;">
                                    <center><strong>DATOS DE ACCESO <i class="fa fa-shield"></i></strong></center>
                                </div>
                            </div>

                            <div class="form-group col-6">
                                <label class="text-left" for="inputUsuario">Usuario</label>
                                <input id="inputUsuario" name="inputUsuario" type="text" class="form-control border-primary">
                            </div>
                            <div class="form-group col-6 position-relative">
                                <input id="inputClaveAnterior" type="password" class="form-control border-primary hidden">
                                <label class="text-left" for="inputClave">Contraseña</label>
                                <fieldset class="form-group position-relative">
                                    <input id="inputClave" name="inputClave" type="password" class="form-control border-primary" disabled>
                                    <div class="form-control-position">
                                        <i id="lnkChangePass" class="ft-edit" style="cursor: pointer;" title="Modificar contraseña"></i>
                                    </div>
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnCerrarUsuario" type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cerrar</button>
                <button id="btnGuardarUsuario" type="button" class="btn grey btn-outline-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>