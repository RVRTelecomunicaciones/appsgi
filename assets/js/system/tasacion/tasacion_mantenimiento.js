(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });

        $('.select2-diacritics2').select2({
            theme: 'classic',
            width: '100%'
        });

        $('.select2-container--classic').css('width', '100%');

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const selectTipoTasacion = d.getElementById('selectTipoTasacion');
        const labelTasacionCodigo = d.getElementById('labelTasacionCodigo');
        const inputCoordinacionCodigo = d.getElementById('inputCoordinacionCodigo');
        /*const inputInspeccionCodigo = d.getElementById('inputInspeccionCodigo');*/
        const inputFecha = d.getElementById('inputFecha');
        
        const row_tipo_no_registrado = d.getElementById('row_tipo_no_registrado');
        const selectTipoNoRegistrado = d.getElementById('selectTipoNoRegistrado');
        
        const row_propietario = d.getElementById('row_propietario');
        const selectPropietario = d.getElementById('selectPropietario');

        const row_tipo_cliente = d.getElementById('row_tipo_cliente');
        const row_cliente = d.getElementById('row_cliente');
        const labelClienteCodigo = d.getElementById('labelClienteCodigo');
        const labelClienteTipo = d.getElementById('labelClienteTipo');
        const labelCliente = d.getElementById('labelCliente');
        const fieldCliente = d.getElementById('fldSelectCliente');
        const radioClienteJuridico = d.getElementById('radioClienteJuridico');
        const radioClienteNatural = d.getElementById('radioClienteNatural');

        const row_tipo_solicitante = d.getElementById('row_tipo_solicitante');
        const row_solicitante = d.getElementById('row_solicitante');
        const labelSolicitanteCodigo = d.getElementById('labelSolicitanteCodigo');
        const labelSolicitanteTipo = d.getElementById('labelSolicitanteTipo');
        const labelSolicitante = d.getElementById('labelSolicitante');
        const fieldSolicitante = d.getElementById('fldSelectSolicitante');
        const radioSolicitanteJuridico = d.getElementById('radioSolicitanteJuridico');
        const radioSolicitanteNatural = d.getElementById('radioSolicitanteNatural');

        const row_direccion = d.getElementById('row_direccion');
        const inputDireccion = d.getElementById('inputDireccion');
        
        const row_departamento = d.getElementById('row_departamento');
        const selectDepartamento = d.getElementById('selectDepartamento');

        const row_provincia = d.getElementById('row_provincia');
        const selectProvincia = d.getElementById('selectProvincia');

        const row_distrito = d.getElementById('row_distrito');
        const selectDistrito = d.getElementById('selectDistrito');

        const row_clase = d.getElementById('row_clase');
        const selectClase = d.getElementById('selectClase');

        const row_marca = d.getElementById('row_marca');
        const selectMarca = d.getElementById('selectMarca');

        const row_modelo = d.getElementById('row_modelo');
        const selectModelo = d.getElementById('selectModelo');

        const row_zonificacion = d.getElementById('row_zonificacion');
        const selectZonificacion = d.getElementById('selectZonificacion');

        const row_tipo_cambio = d.getElementById('row_tipo_cambio');
        const inputTipoCambio = d.getElementById('inputTipoCambio');

        const row_anio_fabricacion = d.getElementById('row_anio_fabricacion');
        const inputAnioFabricacion = d.getElementById('inputAnioFabricacion');

        const row_vsn = d.getElementById('row_vsn');
        const inputVSN = d.getElementById('inputVSN');
        
        const row_local_tipo = d.getElementById('row_local_tipo');
        const selectTipoLocal = d.getElementById('selectTipoLocal');

        const row_cultivo = d.getElementById('row_cultivo');
        const selectTipoCultivo = d.getElementById('selectTipoCultivo');

        const row_tipo_departamento = d.getElementById('row_tipo_departamento');
        const selectTipoDepartamento = d.getElementById('selectTipoDepartamento');

        const row_area_terreno = d.getElementById('row_area_terreno');
        const inputAreaTerreno = d.getElementById('inputAreaTerreno');

        const row_vut = d.getElementById('row_vut');
        const inputVUT = d.getElementById('inputVUT');

        const row_valor_comercial = d.getElementById('row_valor_comercial');
        const inputValorComercial = d.getElementById('inputValorComercial');

        const row_valor_comercial_departamento = d.getElementById('row_valor_comercial_departamento');
        const inputValorComercialDepartamento = d.getElementById('inputValorComercialDepartamento');

        const row_edificacion = d.getElementById('row_edificacion');
        const inputAreaEdificacion = d.getElementById('inputAreaEdificacion');

        const row_ocupada = d.getElementById('row_ocupada');
        const labelAreaOcupada = d.getElementById('labelAreaOcupada');
        const inputAreaOcupada = d.getElementById('inputAreaOcupada');

        const row_antiguedad = d.getElementById('row_antiguedad');
        const inputAntiguedad = d.getElementById('inputAntiguedad');

        const row_observacion = d.getElementById('row_observacion');
        const inputObservacion = d.getElementById('inputObservacion');

        const row_latitud = d.getElementById('row_latitud');
        const inputLatitud = d.getElementById('inputLatitud');

        const row_longitud = d.getElementById('row_longitud');
        const inputLongitud = d.getElementById('inputLongitud');

        //const botonNuevoPropietario = d.getElementById('lnkNuevoPropietario');
        const buttonNuevoCliente = d.getElementById('buttonNuevoCliente');
        const buttonNuevoSolicitante = d.getElementById('buttonNuevoSolicitante');
        const botonNuevoZonificacion = d.getElementById('lnkNuevoZonificacion');
        const botonNuevoClase = d.getElementById('lnkNuevoClase');
        const botonNuevoMarca = d.getElementById('lnkNuevoMarca');
        const botonNuevoModelo = d.getElementById('lnkNuevoModelo');
        const botonNuevoTipoNoRegistrado = d.getElementById('lnkNuevoTipoNoRegistrado');

        const obtenerDatosInspeccion = (inspeccion) => {
            let fd = new FormData();
            fd.append('inspeccion_codigo', inspeccion);

            ajax('post', '../tasaciones/search', fd)
                .then((response) => {
                    const records = response.records_find;
                    inputCoordinacionCodigo.value = records[0].coordinacion_correlativo;
                    /*inputInspeccionCodigo.value = records[0].inspeccion_id;*/
                    labelClienteCodigo.innerText = records[0].cliente_id;
                    labelClienteTipo.innerText = records[0].cliente_tipo;
                    labelCliente.innerText = records[0].cliente_nombre;
                    labelSolicitanteCodigo.innerText = records[0].solicitante_id;
                    labelSolicitanteTipo.innerText = records[0].solicitante_tipo;
                    labelSolicitante.innerText = records[0].solicitante_nombre;

                    listDepartamento(records[0].departamento_id, records[0].provincia_id, records[0].distrito_id);
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const obtenerDatosCoordinacion = (coordinacion) => {
            let fd = new FormData();
            fd.append('coordinacion_correlativo', coordinacion);

            ajax('post', '../tasaciones/searchCoordinacion', fd)
                .then((response) => {
                    const records = response.records_find;

                    if (records != false) {
                        inputCoordinacionCodigo.value = records[0].coordinacion_correlativo;
                        labelClienteCodigo.innerText = records[0].cliente_id;
                        labelClienteTipo.innerText = records[0].cliente_tipo;
                        labelCliente.innerText = records[0].cliente_nombre;
                        labelSolicitanteCodigo.innerText = records[0].solicitante_id;
                        labelSolicitanteTipo.innerText = records[0].solicitante_tipo;
                        labelSolicitante.innerText = records[0].solicitante_nombre;
                        
                        row_tipo_cliente.classList.add('hidden');
                        row_tipo_solicitante.classList.add('hidden');
                    } else {
                        row_tipo_cliente.classList.remove('hidden');
                        row_tipo_solicitante.classList.remove('hidden');

                        inputCoordinacionCodigo.value = coordinacion;

                        listarInvolucrados(radioClienteJuridico.checked == true ? 'J' : 'N', 'cliente');
                        listarInvolucrados(radioSolicitanteJuridico.checked == true ? 'J' : 'N', 'solicitante');

                        labelCliente.classList.add('hidden');
                        labelSolicitante.classList.add('hidden');

                        fieldCliente.classList.remove('hidden');
                        fieldSolicitante.classList.remove('hidden');
                    }

                    listDepartamento(15, 128, 1253);
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const listDepartamento = (departamento = false, provincia = false, distrito = false) => {
            ajax('post', `../ubigeo/searchUbigeoDepartamento`)
                .then((respuesta) => {
                    const records = respuesta.departamento_records;
                    if (records != false) {
                        const filas = records.map((item, index) => {
                            if (item.departamento_id == departamento)
                                return `<option value='${item.departamento_id}' selected>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.departamento_id}'>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDepartamento.innerHTML = '';
                        selectDepartamento.innerHTML = filas;

                        listProvincia(departamento, provincia, distrito);

                        $('#selectDepartamento').change(function(event) {
                            listProvincia(selectDepartamento.value);
                        });
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const listProvincia = (departamento = false, provincia = false, distrito = false) => {
            let fd = new FormData();
            fd.append('departamento_id', departamento);

            ajax('post', `../ubigeo/searchUbigeoProvincia`, fd)
                .then((respuesta) => {
                    const registros = respuesta.provincia_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.provincia_id == provincia)
                                return `<option value='${item.provincia_id}' selected>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.provincia_id}'>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectProvincia.innerHTML = '';
                        selectProvincia.innerHTML = filas;
                        
                        listDistrito(provincia, distrito);

                        if (provincia == false) {
                            $('#selectProvincia').prop('selectedIndex', 0).change();
                        } else {
                            $('#selectProvincia').change(function(event) {
                                listDistrito(selectProvincia.value);
                            });
                        }

                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const listDistrito = (provincia = false, distrito = false) => {
            let fd = new FormData();
            fd.append('provincia_id', provincia);

            ajax('post', `../ubigeo/searchUbigeoDistrito`, fd)
                .then((respuesta) => {
                    const registros = respuesta.distrito_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.distrito_id == distrito)
                                return `<option value='${item.distrito_id}' selected>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.distrito_id}'>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDistrito.innerHTML = '';
                        selectDistrito.innerHTML = filas;

                        if (distrito == false)
                            $('#selectDistrito').prop('selectedIndex', 0).change();
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        $('#selectTipoTasacion').change(function (e) {
            if (this.value == 1) {
                ocultar(this.value);
                row_cultivo.classList.remove('hidden');
            } else if (this.value == 2) {
                ocultar(this.value);
            } else if (this.value == 3 || this.value == 4) {
                ocultar(this.value);
                row_edificacion.classList.remove('hidden');
                row_ocupada.classList.remove('hidden');
                
                if (this.value == 3) {
                    row_tipo_departamento.classList.remove('hidden');
                    row_valor_comercial_departamento.classList.remove('hidden');
                    row_antiguedad.classList.remove('hidden');
                }
            } else if (this.value == 5) {
                ocultar(this.value);
                row_local_tipo.classList.remove('hidden');
                row_edificacion.classList.remove('hidden');
                row_ocupada.classList.remove('hidden');
            } else if (this.value == 6) {
                ocultar(this.value);
                row_edificacion.classList.remove('hidden');
            } else if (this.value == 7 || this.value == 8) {
                ocultar(this.value);
                row_clase.classList.remove('hidden');
                row_marca.classList.remove('hidden');
                row_modelo.classList.remove('hidden');
                row_anio_fabricacion.classList.remove('hidden');
                row_vsn.classList.remove('hidden');
				
                listClase(filtersClase(5,1));
                listMarca(filtersMarca(5,1));
                listModelo(filtersModelo(5,1));
            } else if (this.value == 9) {
                ocultar(this.value);

                listTipoNoRegistrado(filtersTipoNoRegistrado(5,1));
            } else {
                ocultar(this.value);
            }
        });
        
        const ocultar = (x) => {
            row_local_tipo.classList.add('hidden');
            row_cultivo.classList.add('hidden');
            row_valor_comercial_departamento.classList.add('hidden');
            row_tipo_departamento.classList.add('hidden');
            row_edificacion.classList.add('hidden');
            row_ocupada.classList.add('hidden');
            row_antiguedad.classList.add('hidden');
            row_tipo_no_registrado.classList.add('hidden');

            //row_fecha_tasacion.classList.remove('hidden');
            row_propietario.classList.remove('hidden');
            row_cliente.classList.remove('hidden');
            row_solicitante.classList.remove('hidden');
            row_direccion.classList.remove('hidden');
            row_tipo_cambio.classList.remove('hidden');
            row_valor_comercial.classList.remove('hidden');
            row_observacion.classList.remove('hidden');

            if (x == 7 || x == 8) {
                row_departamento.classList.add('hidden');
                row_provincia.classList.add('hidden');
                row_distrito.classList.add('hidden');
                //row_nota.classList.add('hidden');
                row_zonificacion.classList.add('hidden');
                row_area_terreno.classList.add('hidden');
                row_vut.classList.add('hidden');
                row_latitud.classList.add('hidden');
                row_longitud.classList.add('hidden');
            } else if (x == 9) {
                //row_fecha_tasacion.classList.add('hidden');
                row_propietario.classList.add('hidden');
                row_cliente.classList.add('hidden');
                row_solicitante.classList.add('hidden');
                row_direccion.classList.add('hidden');
                row_tipo_cambio.classList.add('hidden');
                row_valor_comercial.classList.add('hidden');

                row_departamento.classList.add('hidden');
                row_provincia.classList.add('hidden');
                row_distrito.classList.add('hidden');
                //row_nota.classList.add('hidden');
                row_zonificacion.classList.add('hidden');
                row_area_terreno.classList.add('hidden');
                row_vut.classList.add('hidden');
                row_latitud.classList.add('hidden');
                row_longitud.classList.add('hidden');

                row_clase.classList.add('hidden');
                row_marca.classList.add('hidden');
                row_modelo.classList.add('hidden');
                row_anio_fabricacion.classList.add('hidden');
                row_vsn.classList.add('hidden');

                row_tipo_no_registrado.classList.remove('hidden');
                row_observacion.classList.remove('hidden');

            } else {
                row_departamento.classList.remove('hidden');
                row_provincia.classList.remove('hidden');
                row_distrito.classList.remove('hidden');
                //row_nota.classList.remove('hidden');
                row_zonificacion.classList.remove('hidden');
                row_area_terreno.classList.remove('hidden');
                row_vut.classList.remove('hidden');
                row_latitud.classList.remove('hidden');
                row_longitud.classList.remove('hidden');

                row_clase.classList.add('hidden');
                row_marca.classList.add('hidden');
                row_modelo.classList.add('hidden');
                row_anio_fabricacion.classList.add('hidden');
                row_vsn.classList.add('hidden');
            }
        }

        if (sessionStorage.getItem('data') != null) {
            const objData = JSON.parse(sessionStorage.getItem('data'));

            if (objData.inspeccion != null) {
                $('#selectTipoTasacion').val(objData.tipo).trigger('change');
                obtenerDatosInspeccion(objData.inspeccion);
                row_tipo_cliente.classList.add('hidden');
                row_tipo_solicitante.classList.add('hidden');
            } else if (objData.tasacion_id != null) {
                labelTasacionCodigo.innerText = objData.tasacion_id;
                $('#selectTipoTasacion').val(objData.tipo_tabla).trigger('change');
                inputCoordinacionCodigo.value = objData.informe_id;
                inputFecha.value = objData.tasacion_fecha;
                
                selectPropietario.value = objData.propietario_nombre;
                labelClienteCodigo.innerText = objData.cliente_id;
                labelClienteTipo.innerText = objData.cliente_tipo;
                labelCliente.innerText = objData.cliente_nombre;
                labelSolicitanteCodigo.innerText = objData.solicitante_id;
                labelSolicitanteTipo.innerText = objData.solicitante_tipo;
                labelSolicitante.innerText = objData.solicitante_nombre;

                inputDireccion.value = objData.ubicacion;

                listDepartamento(objData.departamento_id, objData.provincia_id, objData.distrito_id);

                inputTipoCambio.value = objData.tipo_cambio;
                $('#selectTipoCultivo').val(objData.tipo_id).trigger('change');
                $('#selectTipoDepartamento').val(objData.tipo_id).trigger('change');
                $('#selectTipoLocal').val(objData.tipo_id).trigger('change');
                inputAnioFabricacion.value = objData.antiguedad;
                inputVSN.value = objData.valor_similar_nuevo;
                inputAreaTerreno.value = objData.terreno_area;
                inputVUT.value = objData.terreno_valorunitario;
                inputValorComercial.value = objData.valor_comercial;
                inputValorComercialDepartamento.value = objData.valor_comercial_departamento;
                inputAreaEdificacion.value = objData.edificacion_area;
                inputAreaOcupada.value = objData.valor_ocupada;
                inputAntiguedad.value = objData.antiguedad;
                inputObservacion.value = objData.observacion;
                inputRutaInforme.value = objData.ruta_informe;
                inputLatitud.value = objData.mapa_latitud;
                inputLongitud.value = objData.mapa_longitud;

                row_tipo_cliente.classList.add('hidden');
                row_tipo_solicitante.classList.add('hidden');
            } else if (objData.correlativo != null) {
                $('#selectTipoTasacion').val(objData.tipo).trigger('change');
                obtenerDatosCoordinacion(objData.correlativo);
            }
        } else {
            window.location.href = d.referrer;
        }

        /*botonNuevoPropietario.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlPropietario").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });*/

        const frm_involucrado = d.getElementById('frm_involucrado');

        buttonNuevoCliente.addEventListener('click', e => {
            frm_involucrado.reset();
            listarDocumentoTipo('cliente');
            ocultarControles('cliente');
            $('#mdl_involucrados #myModalLabel8').html('REGISTRO DE CLIENTES');
            $('#mdl_involucrados #labelInvolucrado').html('cliente');
            $('#mdl_involucrados #labelInvolucradoTipo').html(radioClienteJuridico.checked ? 'Juridica' : 'Natural');

            $('#mdl_involucrados').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        radioClienteJuridico.addEventListener('change', e => {
            if (radioClienteJuridico.checked)
                listarInvolucrados('J', 'cliente');
        });

        radioClienteNatural.addEventListener('change', e => {
            if (radioClienteNatural.checked)
                listarInvolucrados('N', 'cliente');
        });

        $('#selectCliente').on('change', function (e) {
            if ($(this).val() == '') {
                labelClienteCodigo.innerText = '0';
                labelClienteTipo.innerText = '';
            } else {
                labelClienteCodigo.innerText = $(this).find(":selected").data("id");
                labelClienteTipo.innerText = $(this).find(":selected").data("tipo");
            }
        });

        buttonNuevoSolicitante.addEventListener('click', e => {
            frm_involucrado.reset();
            listarDocumentoTipo('solicitante');
            ocultarControles('solicitante');
            $('#mdl_involucrados #myModalLabel8').html('REGISTRO DE SOLICITANTES');
            $('#mdl_involucrados #labelInvolucrado').html('solicitante');
            $('#mdl_involucrados #labelInvolucradoTipo').html(radioSolicitanteJuridico.checked ? 'Juridica' : 'Natural');

            $('#mdl_involucrados').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });

            $('#selectTipoDocumento').val('4').trigger('change');
        });

        radioSolicitanteJuridico.addEventListener('change', e => {
            if (radioSolicitanteJuridico.checked)
                listarInvolucrados('J', 'solicitante');
        });

        radioSolicitanteNatural.addEventListener('change', e => {
            if (radioSolicitanteNatural.checked)
                listarInvolucrados('N', 'solicitante');
        });

        $('#selectSolicitante').on('change', function (e) {
            if ($(this).val() == '') {
                labelSolicitanteCodigo.innerText = '0';
                labelSolicitanteTipo.innerText = '';
            } else {
                labelSolicitanteCodigo.innerText = $(this).find(":selected").data("id");
                labelSolicitanteTipo.innerText = $(this).find(":selected").data("tipo");
            }
        });

        botonNuevoZonificacion.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlZonificacion").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoClase.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlClase").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoMarca.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlMarca").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoModelo.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlModelo").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoTipoNoRegistrado.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlTNRegistrado").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        const crudTasacion = () => {
            const apiRestMantenimiento = labelTasacionCodigo.innerText == '0' ? 'insertTasacion' : 'updateTasacion';

            const fd = new FormData();
            fd.append('tasacion_codigo', labelTasacionCodigo.innerText)
            fd.append('tasacion_tipo', selectTipoTasacion.value)
            fd.append('tasacion_correlativo', inputCoordinacionCodigo.value)
            fd.append('tasacion_fecha', inputFecha.value)
            fd.append('tasacion_propietario', selectPropietario.value.trim())
            fd.append('tasacion_cliente', labelClienteCodigo.innerText)
            fd.append('tasacion_cliente_tipo', labelClienteTipo.innerText)
            fd.append('tasacion_solicitante', labelSolicitanteCodigo.innerText)
            fd.append('tasacion_solicitante_tipo', labelSolicitanteTipo.innerText)
            fd.append('tasacion_ubicacion', inputDireccion.value)
            fd.append('tasacion_ubigeo', selectDistrito.value)
            fd.append('tasacion_zonificacion', selectZonificacion.value)
            fd.append('tasacion_tipo_cambio', inputTipoCambio.value)
            fd.append('tasacion_area_terreno', inputAreaTerreno.value)
            fd.append('tasacion_valor_unitario', inputVUT.value)
            fd.append('tasacion_valor_comercial', inputValorComercial.value)
            fd.append('tasacion_observacion', inputObservacion.value)
            fd.append('tasacion_ruta', inputRutaInforme.value)
            fd.append('tasacion_latitud', inputLatitud.value)
            fd.append('tasacion_longitud', inputLongitud.value)
            //fd.append('file', inputFile.files[0]);

            /*ADICIONALES*/
            fd.append('tasacion_tipo_no_registrado', selectTipoNoRegistrado.value)
            fd.append('tasacion_local_tipo', selectTipoLocal.value)
            fd.append('tasacion_cultivo', selectTipoCultivo.value)
            fd.append('tasacion_valor_comercial_departamento', inputValorComercialDepartamento.value)
            fd.append('tasacion_departamento_tipo', selectTipoDepartamento.value)
            fd.append('tasacion_area_edificacion', inputAreaEdificacion.value)
            fd.append('tasacion_area_ocupada', inputAreaOcupada.value)
            fd.append('tasacion_antiguedad', inputAntiguedad.value)

            fd.append('tasacion_clase', selectClase.value)
            fd.append('tasacion_marca', selectMarca.value)
            fd.append('tasacion_modelo', selectModelo.value)
            fd.append('tasacion_fabricacion', inputAnioFabricacion.value)
            fd.append('tasacion_vsn', inputVSN.value)

            /**/
            const objData = JSON.parse(sessionStorage.getItem('data'));
            if (objData.correlativo != null)
                fd.append('tasacion_action', 'nuevo');

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        })
                        .then(() => {
                            if (sessionStorage.getItem('data') != null) {
                                const objData = JSON.parse(sessionStorage.getItem('data'));
                    
                                if(objData.tasacion_id == null) {
                                    window.location.href = 'listado';
                                } else{
                                    let data = {
                                        coordinacion: inputCoordinacionCodigo.value
                                    };

                                    sessionStorage.setItem('data', JSON.stringify(data));
                                    window.location.href = 'detalle';
                                }
                            }
                        });
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const botonGuardar = d.querySelector('#btnSave');
        const botonCancelar = d.querySelector('#btnCancelar');
        botonGuardar.addEventListener('click', e => {
            e.preventDefault();
            if (selectTipoTasacion.value == '') {
                selectTipoTasacion.focus();
                swal({
                    text: 'Seleccioné tipo de tasación',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputCoordinacionCodigo.value == '') {
                inputCoordinacionCodigo.focus();
                swal({
                    text: 'Ingresé el código de la coordinación a registrar',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectTipoNoRegistrado.value == '' && selectTipoTasacion.value == 9) {
                selectTipoNoRegistrado.focus();
                swal({
                    text: 'Seleccioné tipo',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputFecha.value == '' && selectTipoTasacion.value < 9) {
                inputFecha.focus();
                swal({
                    text: 'Seleccioné fecha de tasación',
                    timer: 1500,
                    buttons: false
                });
            }/* else if (selectCliente.value == '' && selectTipoTasacion.value < 9) {
                selectCliente.focus();
                swal({
                    text: 'Seleccioné cliente',
                    timer: 1500,
                    buttons: false
                });
            }*/ else if (selectPropietario.value == '' && selectTipoTasacion.value < 9) {
                selectPropietario.focus();
                swal({
                    text: 'Seleccioné propietario',
                    timer: 1500,
                    buttons: false
                });
            }/* else if (selectSolicitante.value == '' && selectTipoTasacion.value < 9) {
                selectSolicitante.focus();
                swal({
                    text: 'Seleccioné solicitante',
                    timer: 1500,
                    buttons: false
                });
            }*/ else if (inputDireccion.value == '' && selectTipoTasacion.value < 9) {
                inputDireccion.focus();
                swal({
                    text: 'Ingresé ubicación',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectDepartamento.value == '' && selectTipoTasacion.value < 7) {
                inputDireccion.focus();
                swal({
                    text: 'Seleccioné Departamento',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectProvincia.value == '' && selectTipoTasacion.value < 7) {
                selectProvincia.focus();
                swal({
                    text: 'Seleccioné provincia',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectDistrito.value == '' && selectTipoTasacion.value < 7) {
                selectDistrito.focus();
                swal({
                    text: 'Seleccioné distrito',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectZonificacion.value == '' && selectTipoTasacion.value < 7) {
                selectZonificacion.focus();
                swal({
                    text: 'Seleccioné zonificación',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectClase.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectClase.focus();
                swal({
                    text: 'Seleccioné Clase',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectMarca.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectMarca.focus();
                swal({
                    text: 'Seleccioné marca',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectModelo.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectModelo.focus();
                swal({
                    text: 'Seleccioné modelo',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputTipoCambio.value == '' && selectTipoTasacion.value < 9) {
                inputTipoCambio.focus();
                swal({
                    text: 'Ingresé tipo de cambio',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectTipoTasacion.value == 1 && selectTipoCultivo.value == '') {
                selectTipoCultivo.focus();
                swal({
                    text: 'Seleccioné tipo de cultivo',
                    timer: 1500,
                    buttons: false
                });
            } /*else if (selectTipoTasacion.value == 5 && selectVistaLocal.value == '') {
                selectTipoCultivo.focus();
                swal({
                    text: 'Seleccioné vista del local',
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value == 3 || selectTipoTasacion.value == 4) && selectVistaLocal.value == '') {
                selectVistaLocal.focus();
                swal({
                    text: `Seleccioné tipo de ${selectTipoTasacion.value == 3 ? 'departamento' : 'oficina'}`,
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value == 3 || selectTipoTasacion.value == 4) && inputPisoUbicacion.value == '') {
                inputPisoUbicacion.focus();
                swal({
                    text: 'Ingresé piso de ubicación',
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value >= 2 && selectTipoTasacion.value <= 6) && inputCantidadPisos.value == '') {
                inputCantidadPisos.focus();
                swal({
                    text: 'Ingresé cantidad de pisos',
                    timer: 1500,
                    buttons: false
                });
            }*/ else if (inputAreaTerreno.value == '' && selectTipoTasacion.value < 7) {
                inputAreaTerreno.focus();
                swal({
                    text: 'Ingresé area de terreno (m2)',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputVUT.value == '' && selectTipoTasacion.value < 7) {
                inputVUT.focus();
                swal({
                    text: 'Ingresé valor unitario de terreno (VUT)',
                    timer: 1500,
                    buttons: false
                });
            } else if ((inputAnioFabricacion.value == '' || inputAnioFabricacion.value == 0) && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                inputAnioFabricacion.focus();
                swal({
                    text: 'Ingresé año de fabricación',
                    timer: 1500,
                    buttons: false
                });
            } else if ((inputVSN.value == '' || inputVSN.value == 0) && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                inputVSN.focus();
                swal({
                    text: 'Ingresé valor similar nuevo (VSN)',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputValorComercial.value == '' && selectTipoTasacion.value < 9) {
                inputValorComercial.focus();
                swal({
                    text: 'Ingresé valor comercial',
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value >= 3 && selectTipoTasacion.value <= 6) && inputAreaEdificacion.value == '') {
                inputAreaEdificacion.focus();
                swal({
                    text: 'Ingresé area de edificación',
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value >= 3 && selectTipoTasacion.value <= 5) && inputAreaOcupada.value == '') {
                inputAreaOcupada.focus();
                swal({
                    text: 'Ingresé valor area de ocupada',
                    timer: 1500,
                    buttons: false
                });
            }/* else if ((selectTipoTasacion.value == 2 || selectTipoTasacion.value == 4 || selectTipoTasacion.value == 6) && selectAreaComplementaria.value == '') {
                selectAreaComplementaria.focus();
                swal({
                    text: 'Seleccioné area complementaria',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectTipoTasacion.value == 4 && inputCantidadEstacionamiento.value == '') {
                inputCantidadEstacionamiento.focus();
                swal({
                    text: 'Ingresé cantidad de estacionamientos',
                    timer: 1500,
                    buttons: false
                });
            }*/ else if (inputRutaInforme.value == '') {
                inputRutaInforme.focus();
                swal({
                    text: 'Ingresé ruta del informe',
                    timer: 1500,
                    buttons: false
                });
            } else if ((inputLatitud.value == '' || inputLongitud.value == '') && selectTipoTasacion.value < 7 || (inputLatitud.value == 0 || inputLongitud.value == 0) && selectTipoTasacion.value < 7) {
                inputRutaInforme.focus();
                swal({
                    text: 'Ingresé coordenada válida',
                    timer: 1500,
                    buttons: false
                });
            }/* else if (inputFile.value == '') {
                inputFile.focus();
                swal({
                    text: 'Falta seleccionar adjunto',
                    timer: 1500,
                    buttons: false
                });
            }*/ else {
            	botonGuardar.classList.add('disabled');
                crudTasacion();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            swal({
                title: '¿ Esta seguro de cancelar la operación ?',
                text: 'al presionar "OK", se cancelara el registro y será redireccionado al listado de tasaciones',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'listado';
                }
            });
        });
    })
})(document);