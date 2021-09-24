(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });

        $('.select2-diacritics2').select2({
        	theme: 'classic'
        });

        $('.select2-container--classic').css('width', '100%');

        //METODO AJAX PARA OBTENER DATOS
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
        const selectCliente = d.getElementById('selectCliente');
        const selectPropietario = d.getElementById('selectPropietario');
        const selectSolicitante = d.getElementById('selectSolicitante');
        const selectDepartamento = d.getElementById('selectDepartamento');
        const selectProvincia = d.getElementById('selectProvincia');
        const selectDistrito = d.getElementById('selectDistrito');
        const selectZonificacion = d.getElementById('selectZonificacion');
        const selectTipoCultivo = d.getElementById('selectTipoCultivo');
        const selectTipoLocal = d.getElementById('selectTipoLocal');
        const selectTipoDepartamento = d.getElementById('selectTipoDepartamento');
        const selectTipoNoRegistrado = d.getElementById('selectTipoNoRegistrado');
        const selectClase = d.getElementById('selectClase');
        const selectMarca = d.getElementById('selectMarca');
        const selectModelo = d.getElementById('selectModelo');

        const inputCodigoCoordinacion = d.getElementById('inputCodigoCoordinacion');
        const inputFechaTasacion = d.getElementById('inputFechaTasacion');
        const inputUbicacion = d.getElementById('inputUbicacion');
        const inputTipoCambio = d.getElementById('inputTipoCambio');
        const inputAreaTerreno = d.getElementById('inputAreaTerreno');
        const inputVUT = d.getElementById('inputVUT');
        const inputValorComercial = d.getElementById('inputValorComercial');
		const inputValorComercialDepartamento = d.getElementById('inputValorComercialDepartamento');
        const inputAreaEdificacion = d.getElementById('inputAreaEdificacion');
        const inputAreaOcupada = d.getElementById('inputAreaOcupada');
        const inputObservacion = d.getElementById('inputObservacion');
        const inputRutaInforme = d.getElementById('inputRutaInforme');
        const inputLatitud = d.getElementById('inputLatitud');
        const inputLongitud = d.getElementById('inputLongitud');

        /**/
        const inputCliente = d.getElementById('inputCliente');
        const inputPropietario = d.getElementById('inputPropietario');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const fieldCliente = d.getElementById('fldSelectCliente');
        const fieldPropietario = d.getElementById('fldSelectPropietario');
        const fieldSolicitante = d.getElementById('fldSelectSolicitante');
        /**/

        const inputAnioFabricacion = d.getElementById('inputAnioFabricacion');
        const inputVSN = d.getElementById('inputVSN');        

        const botonCancelar = d.getElementById('btnCancelar');
        const botonNuevoCliente = d.getElementById('lnkNuevoCliente');
        const botonNuevoPropietario = d.getElementById('lnkNuevoPropietario');
        const botonNuevoSolicitante = d.getElementById('lnkNuevoSolicitante');
        const botonNuevoZonificacion = d.getElementById('lnkNuevoZonificacion');
        const botonNuevoClase = d.getElementById('lnkNuevoClase');
        const botonNuevoMarca = d.getElementById('lnkNuevoMarca');
        const botonNuevoModelo = d.getElementById('lnkNuevoModelo');
        const botonNuevoTipoNoRegistrado = d.getElementById('lnkNuevoTipoNoRegistrado');

        const spanUser = d.getElementById('user_name');

        /*BEGIN OCULTAR*/
        const row_fecha_tasacion = d.getElementById('row_fecha_tasacion');
        const row_tipo_no_registrado = d.getElementById('row_tipo_no_registrado');
        const row_propietario = d.getElementById('row_propietario');
        const row_cliente = d.getElementById('row_cliente');
        const row_solicitante = d.getElementById('row_solicitante');
        const row_ubicacion = d.getElementById('row_ubicacion');
        const row_tipo_cambio = d.getElementById('row_tipo_cambio');
        const row_valor_comercial = d.getElementById('row_valor_comercial');
        const row_observacion = d.getElementById('row_observacion');

        const row_departamento = d.getElementById('row_departamento');
        const row_provincia = d.getElementById('row_provincia');
        const row_distrito = d.getElementById('row_distrito');
        const row_nota = d.getElementById('row_nota');
        const row_zonificacion = d.getElementById('row_zonificacion');
        const row_area_terreno = d.getElementById('row_area_terreno');
        const row_vut = d.getElementById('row_vut');
		const row_valor_comercial_departamento = d.getElementById('row_valor_comercial_departamento');
        const row_local_tipo = d.getElementById('row_local_tipo');
        const row_cultivo = d.getElementById('row_cultivo');
        const row_tipo = d.getElementById('row_tipo');
		const row_antiguedad = d.getElementById('row_antiguedad');
        const row_edificacion = d.getElementById('row_edificacion');
        const row_ocupada = d.getElementById('row_ocupada');
        const row_latitud = d.getElementById('row_latitud');
        const row_longitud = d.getElementById('row_longitud');

        const row_clase = d.getElementById('row_clase');
        const row_marca = d.getElementById('row_marca');
        const row_modelo = d.getElementById('row_modelo');
        const row_anio_fabricacion = d.getElementById('row_anio_fabricacion');
        const row_vsn = d.getElementById('row_vsn');
        /*END*/

        /*BEGIN UBIGEO FINAL*/
        const listUbigeoDepartamento = (idDepartamento = false, idProvincia = false, idDistrito = false) => {
            ajax('post', `../ubigeo/searchUbigeoDepartamento`)
                .then((respuesta) => {
                    const registros = respuesta.departamento_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.departamento_id == idDepartamento)
                                return `<option value='${item.departamento_id}' selected>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.departamento_id}'>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDepartamento.innerHTML = '';
                        selectDepartamento.innerHTML = filas;

                        listUbigeoProvincia(false, idProvincia, idDistrito);

                        $('#selectDepartamento').change(function(event) {
                            listUbigeoProvincia();
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const listUbigeoProvincia = (idDepartamento = false, idProvincia = false, idDistrito = false) => {
            let fd = new FormData();
            fd.append('departamento_id', idDepartamento != false ? idDepartamento : selectDepartamento.value)

            ajax('post', `../ubigeo/searchUbigeoProvincia`, fd)
                .then((respuesta) => {
                    const registros = respuesta.provincia_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.provincia_id == idProvincia)
                                return `<option value='${item.provincia_id}' selected>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.provincia_id}'>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectProvincia.innerHTML = '';
                        selectProvincia.innerHTML = filas;

                        listUbigeoDistrito(false, idDistrito);
                        
                        if (idProvincia == false) {
                            $('#selectProvincia').prop('selectedIndex', 0).change();
                        }
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const listUbigeoDistrito = (idProvincia = false, idDistrito = false) => {
            let fd = new FormData();
            fd.append('provincia_id', idProvincia != false ? idProvincia : selectProvincia.value)

            ajax('post', `../ubigeo/searchUbigeoDistrito`, fd)
                .then((respuesta) => {
                    const registros = respuesta.distrito_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.distrito_id == idDistrito)
                                return `<option value='${item.distrito_id}' selected>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.distrito_id}'>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDistrito.innerHTML = '';
                        selectDistrito.innerHTML = filas;

                        if (idDistrito == false)
                            $('#selectDistrito').prop('selectedIndex', 0).change();
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        $('#selectProvincia').change(function(event) {
            listUbigeoDistrito();
        });
        /*END UBIGEO FINAL*/

        botonNuevoCliente.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlCliente").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoPropietario.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlPropietario").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        botonNuevoSolicitante.addEventListener('click', e => {
            e.preventDefault();
            $("#mdlSolicitante").modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
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

        /*inputObservacion.addEventListener('keyup', e => {
			//e.preventDefault();
			this.value = this.value.toUpperCase();
        });*/

        $('#inputObservacion, #inputUbicacion').keyup(function(){
		    this.value = this.value.toUpperCase();
		});

        $('#selectTipoTasacion').change(function(e) {
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
                    row_tipo.classList.remove('hidden');
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
            row_tipo.classList.add('hidden');
            row_edificacion.classList.add('hidden');
            row_ocupada.classList.add('hidden');
            row_antiguedad.classList.add('hidden');
            row_tipo_no_registrado.classList.add('hidden');

            row_fecha_tasacion.classList.remove('hidden');
            row_propietario.classList.remove('hidden');
            row_cliente.classList.remove('hidden');
            row_solicitante.classList.remove('hidden');
            row_ubicacion.classList.remove('hidden');
            row_tipo_cambio.classList.remove('hidden');
            row_valor_comercial.classList.remove('hidden');
            row_observacion.classList.remove('hidden');

            if (x == 7 || x == 8) {
                row_departamento.classList.add('hidden');
                row_provincia.classList.add('hidden');
                row_distrito.classList.add('hidden');
                row_nota.classList.add('hidden');
                row_zonificacion.classList.add('hidden');
                row_area_terreno.classList.add('hidden');
                row_vut.classList.add('hidden');
                row_latitud.classList.add('hidden');
                row_longitud.classList.add('hidden');
            } else if (x == 9) {
                row_fecha_tasacion.classList.add('hidden');
                row_propietario.classList.add('hidden');
                row_cliente.classList.add('hidden');
                row_solicitante.classList.add('hidden');
                row_ubicacion.classList.add('hidden');
                row_tipo_cambio.classList.add('hidden');
                row_valor_comercial.classList.add('hidden');

                row_departamento.classList.add('hidden');
                row_provincia.classList.add('hidden');
                row_distrito.classList.add('hidden');
                row_nota.classList.add('hidden');
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
                row_nota.classList.remove('hidden');
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

        /*const inputFile = d.querySelector('#inputAdjunto');
        const divAdjunto = d.querySelector('#adjunto');
        inputFile.addEventListener('change', e => {   
            let sizeByte = inputFile.files[0].size;
            let siezekiloByte = parseInt(sizeByte / 1024);
            
            if (siezekiloByte >= 2048) {
                inputFile.value = '';
                swal({
                        icon: 'info',
                        title: 'PDF supera el tamaño maximo de 2MB',
                        text: 'Se abrirá pagina para comprimir pdf',
                        timer: 3000,
                        buttons: false
                    })
                .then(
                    () => window.open('https://www.ilovepdf.com/es/comprimir_pdf','_blank')
                );
            }else{
                //divAdjunto.innerHTML = '';
                //divAdjunto.insertAdjacentText('afterbegin', inputFile.files[0].name);
            }
        });*/

        const crudTasacion = () => {
            const apiRestMantenimiento = 'insertTasacion';

            const fd = new FormData();
            fd.append('tasacion_tipo', selectTipoTasacion.value)
            fd.append('tasacion_correlativo', inputCodigoCoordinacion.value)
            fd.append('tasacion_fecha', inputFechaTasacion.value)
            fd.append('tasacion_cliente', selectCliente.value)
            fd.append('tasacion_cliente_tipo', '')
            fd.append('tasacion_propietario', selectPropietario.value)
            fd.append('tasacion_solicitante', selectSolicitante.value)
            fd.append('tasacion_solicitante_tipo', '')
            fd.append('tasacion_ubicacion', inputUbicacion.value)
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

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });
                        if (spanUser.innerHTML == 'RICHARD A. RAMOS DAVILA' || spanUser.innerHTML == 'RUSSELL F. VERGARA ROJAS') {
                        	botonGuardar.classList.remove('disabled');
                        	window.location.href = '../tasacion/mantenimiento';
                        } else {
                        	botonGuardar.classList.remove('disabled');
							window.location.href = '../tasacion';
						}
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
        botonGuardar.addEventListener('click', e => {
            e.preventDefault();
            if (selectTipoTasacion.value == '') {
                selectTipoTasacion.focus();
                swal({
                    text: 'Seleccioné tipo de tasación',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputCodigoCoordinacion.value == '') {
                inputCodigoCoordinacion.focus();
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
            } else if (inputFechaTasacion.value == '' && selectTipoTasacion.value < 9) {
                inputFechaTasacion.focus();
                swal({
                    text: 'Seleccioné fecha de tasación',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectCliente.value == '' && selectTipoTasacion.value < 9) {
                selectCliente.focus();
                swal({
                    text: 'Seleccioné cliente',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectPropietario.value == '' && selectTipoTasacion.value < 9) {
                selectPropietario.focus();
                swal({
                    text: 'Seleccioné propietario',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectSolicitante.value == '' && selectTipoTasacion.value < 9) {
                selectSolicitante.focus();
                swal({
                    text: 'Seleccioné solicitante',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputUbicacion.value == '' && selectTipoTasacion.value < 9) {
                inputUbicacion.focus();
                swal({
                    text: 'Ingresé ubicación',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectDepartamento.value == '' && selectTipoTasacion.value < 7) {
                inputUbicacion.focus();
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
                    window.location.href = '../tasacion';
                }
            });
        });

        if (sessionStorage.getItem('dataCoordinacion') != null) {
            const objCoordinacion = JSON.parse(sessionStorage.getItem('dataCoordinacion'));

            $('#selectTipoTasacion').val(objCoordinacion.tipo_tasacion).trigger('change');
            $('#selectTipoTasacion').select2({containerCssClass : 'hidden'});
            inputCodigoCoordinacion.value = objCoordinacion.coordinacion_correlativo;
            inputCodigoCoordinacion.setAttribute('readonly', 'readonly');

            listUbigeoDepartamento(objCoordinacion.departamento_id,objCoordinacion.provincia_id,objCoordinacion.distrito_id);
        } else {
            listUbigeoDepartamento();
        }
    })
})(document);