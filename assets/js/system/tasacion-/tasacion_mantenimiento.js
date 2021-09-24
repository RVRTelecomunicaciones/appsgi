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
        const selectTipoPropiedad = d.getElementById('selectTipoPropiedad');
        const selectTipoDepartamento = d.getElementById('selectTipoDepartamento');
        const selectVistaLocal = d.getElementById('selectVistaLocal');
        const selectAreaComplementaria = d.getElementById('selectAreaComplementaria');
		const selectTipoEdificacion = d.getElementById('selectTipoEdificacion');
        const selectTipoVehiculo = d.getElementById('selectTipoVehiculo');
        const selectMarcaVehiculo = d.getElementById('selectMarcaVehiculo');
        const selectModeloVehiculo = d.getElementById('selectModeloVehiculo');
        const selectTraccionVehiculo = d.getElementById('selectTraccionVehiculo');

        const labelTipoDepartamento = d.getElementById('labelTipoDepartamento');
        const labelTipoVehiculo = d.getElementById('labelTipoVehiculo');
        const labelMarcaVehiculo = d.getElementById('labelMarcaVehiculo');
        const labelModeloVehiculo = d.getElementById('labelModeloVehiculo');
		const labelAreaOcupada = d.getElementById('labelAreaOcupada');

        const inputCodigoCoordinacion = d.getElementById('inputCodigoCoordinacion');
        const inputFechaTasacion = d.getElementById('inputFechaTasacion');
        const inputUbicacion = d.getElementById('inputUbicacion');
        const inputTipoCambio = d.getElementById('inputTipoCambio');
        const inputPisoUbicacion = d.getElementById('inputPisoUbicacion');
        const inputCantidadPisos = d.getElementById('inputCantidadPisos');
        const inputAreaTerreno = d.getElementById('inputAreaTerreno');
        const inputVUT = d.getElementById('inputVUT');
        const inputValorComercial = d.getElementById('inputValorComercial');
        const inputAreaEdificacion = d.getElementById('inputAreaEdificacion');
        const inputAreaOcupada = d.getElementById('inputAreaOcupada');
        const inputCantidadEstacionamiento = d.getElementById('inputCantidadEstacionamiento');
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

        /*BEGIN OCULTAR*/
        const row_departamento = d.getElementById('row_departamento');
        const row_provincia = d.getElementById('row_provincia');
        const row_distrito = d.getElementById('row_distrito');
        const row_zonificacion = d.getElementById('row_zonificacion');
        const row_area_terreno = d.getElementById('row_area_terreno');
        const row_vut = d.getElementById('row_vut');
        const row_propiedad = d.getElementById('row_propiedad');
        const row_cultivo = d.getElementById('row_cultivo');
        const row_vista = d.getElementById('row_vista');
        const row_tipo = d.getElementById('row_tipo');
        const row_piso_ubicacion = d.getElementById('row_piso_ubicacion');
        const row_piso_cantidad = d.getElementById('row_piso_cantidad');
        const row_edificacion = d.getElementById('row_edificacion');
		const row_tipo_edificacion = d.getElementById('row_tipo_edificacion');
        const row_ocupada = d.getElementById('row_ocupada');
        const row_complementaria = d.getElementById('row_complementaria');
        const row_estacionamiento = d.getElementById('row_estacionamiento');
        const row_latitud = d.getElementById('row_latitud');
        const row_longitud = d.getElementById('row_longitud');

        const row_tipo_vehiculo = d.getElementById('row_tipo_vehiculo');
        const row_marca_vehiculo = d.getElementById('row_marca_vehiculo');
        const row_modelo_vehiculo = d.getElementById('row_modelo_vehiculo');
        const row_traccion_vehiculo = d.getElementById('row_traccion_vehiculo');
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
                                return `<option value='${item.departamento_id}' selected>${item.departamento_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.departamento_id}'>${item.departamento_nombre.toUpperCase()}</option>`
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
                                return `<option value='${item.provincia_id}' selected>${item.provincia_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.provincia_id}'>${item.provincia_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectProvincia.innerHTML = '';
                        selectProvincia.innerHTML = filas;

                        listUbigeoDistrito(false, idDistrito);
                        
                        if (idProvincia == false) {
                            $('#selectProvincia').prop('selectedIndex', 0).change();
                            //$('#selectProvincia').val(1).trigger('change');
                        }/* else {
                            $('#selectProvincia').change(function(event) {
                                listUbigeoDistrito();
                            });
                        }*/

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
                                return `<option value='${item.distrito_id}' selected>${item.distrito_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.distrito_id}'>${item.distrito_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDistrito.innerHTML = '';
                        selectDistrito.innerHTML = filas;

                        if (idDistrito == false)
                            $('#selectDistrito').prop('selectedIndex', 0).change();
                            //$('#selectDistrito').val(1).trigger('change');
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        listUbigeoDepartamento();

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

        const listTipoMarcaModelo = (tipo) => {
            let fd = new FormData();
            fd.append('tipo', tipo)

            ajax('post', `../tvehiculo/tvehiculoSearch`, fd)
                .then((respuesta) => {
                    const registros = respuesta.tvehiculo_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value='${tipo == 'v' ? item.tipo_vehiculo_id : item.tipo_maquinaria_id}'>${tipo == 'v' ? item.tipo_vehiculo_nombre.toUpperCase() : item.tipo_maquinaria_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${tipo == 'v' ? item.tipo_vehiculo_id : item.tipo_maquinaria_id}'>${tipo == 'v' ? item.tipo_vehiculo_nombre.toUpperCase() : item.tipo_maquinaria_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectTipoVehiculo.innerHTML = '';
                        selectTipoVehiculo.innerHTML = filas;
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })

            ajax('post', `../marca/marcaSearch`, fd)
                .then((respuesta) => {
                    const registros = respuesta.marca_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value='${tipo == 'v' ? item.marca_vehiculo_id : item.tipo_maquinaria_id}'>${tipo == 'v' ? item.marca_vehiculo_nombre.toUpperCase() : item.marca_maquinaria_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${tipo == 'v' ? item.marca_vehiculo_id : item.marca_maquinaria_id}'>${tipo == 'v' ? item.marca_vehiculo_nombre.toUpperCase() : item.marca_maquinaria_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectMarcaVehiculo.innerHTML = '';
                        selectMarcaVehiculo.innerHTML = filas;
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })

            ajax('post', `../modelo/modeloSearch`, fd)
                .then((respuesta) => {
                    const registros = respuesta.modelo_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value='${tipo == 'v' ? item.modelo_vehiculo_id : item.tipo_maquinaria_id}'>${tipo == 'v' ? item.modelo_vehiculo_nombre.toUpperCase() : item.modelo_maquinaria_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${tipo == 'v' ? item.modelo_vehiculo_id : item.modelo_maquinaria_id}'>${tipo == 'v' ? item.modelo_vehiculo_nombre.toUpperCase() : item.modelo_maquinaria_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectModeloVehiculo.innerHTML = '';
                        selectModeloVehiculo.innerHTML = filas;
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })

            if (tipo == 'v') {
                ajax('post', `../traccion/traccionSearch`, fd)
                    .then((respuesta) => {
                        const registros = respuesta.traccion_records;
                        if (registros != false) {
                            const filas = registros.map((item, index) => {
                                if (index == 0)
                                    return `<option value=""></option><option value='${item.traccion_vehiculo_id}'>${item.traccion_vehiculo_nombre.toUpperCase()}</option>`
                                else
                                    return `<option value='${item.traccion_vehiculo_id}'>${item.traccion_vehiculo_nombre.toUpperCase()}</option>`
                            }).join("");

                            selectTraccionVehiculo.innerHTML = '';
                            selectTraccionVehiculo.innerHTML = filas;
                        }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    })
            }
        }

        $('#selectTipoTasacion').change(function(e) {
            if (this.value == 1) {
                ocultar(this.value);
                row_cultivo.classList.remove('hidden');
            } else if (this.value == 2) {
                ocultar(this.value);
                row_piso_cantidad.classList.remove('hidden');
                row_edificacion.classList.remove('hidden');
                row_complementaria.classList.remove('hidden');
            } else if (this.value == 3 || this.value == 4) {
                ocultar(this.value);
                row_tipo.classList.remove('hidden');
                row_piso_ubicacion.classList.remove('hidden');
                row_piso_cantidad.classList.remove('hidden');
                row_edificacion.classList.remove('hidden');
                row_ocupada.classList.remove('hidden');
                row_complementaria.classList.remove('hidden');
                row_estacionamiento.classList.remove('hidden');
                labelTipoDepartamento.innerHTML = this.value == 3 ? 'Departamento Tipo' : 'Oficina Tipo';
                
                if (this.value == 4)
                    row_propiedad.classList.remove('hidden');
            } else if (this.value == 5) {
                ocultar(this.value);
                row_vista.classList.remove('hidden');
                row_piso_cantidad.classList.remove('hidden');
                row_edificacion.classList.remove('hidden');
				row_tipo_edificacion.classList.remove('hidden');
                row_ocupada.classList.remove('hidden');
            } else if (this.value == 6) {
                ocultar(this.value);
                row_piso_cantidad.classList.remove('hidden');
                row_edificacion.classList.remove('hidden');
                row_complementaria.classList.remove('hidden');
            } else if (this.value == 7 || this.value == 8) {
                ocultar(this.value);
                row_tipo_vehiculo.classList.remove('hidden');
                row_marca_vehiculo.classList.remove('hidden');
                row_modelo_vehiculo.classList.remove('hidden');
                labelTipoVehiculo.innerHTML = this.value == 7 ? 'Tipo del Vehículo' : 'Tipo de la Maquinaria' ;
                labelMarcaVehiculo.innerHTML = this.value == 7 ? 'Marca del Vehículo' : 'Marca de la Maquinaria';
                labelModeloVehiculo.innerHTML = this.value == 7 ? 'Modelo del Vehículo' : 'Modelo de la Maquinaria';

                if (this.value == 7)
                    row_traccion_vehiculo.classList.remove('hidden');

                listTipoMarcaModelo(this.value == 7 ? 'v' : 'm');
            } else {
                ocultar(this.value);
            }
        });

        $('#selectTipoEdificacion').change(function(e) {
            labelAreaOcupada.innerHTML = this.value == 'O' ? 'Valor de Area Ocupada ' : 'Valor de Area Techada' ;
        });
		
		const ocultar = (x) => {
            row_propiedad.classList.add('hidden');
            row_cultivo.classList.add('hidden');
            row_vista.classList.add('hidden');
            row_tipo.classList.add('hidden');
            row_piso_ubicacion.classList.add('hidden');
            row_piso_cantidad.classList.add('hidden');
            row_edificacion.classList.add('hidden');
			row_tipo_edificacion.classList.add('hidden');
            row_ocupada.classList.add('hidden');
            row_complementaria.classList.add('hidden');
            row_estacionamiento.classList.add('hidden');

            if (x == 7 || x == 8) {
                row_departamento.classList.add('hidden');
                row_provincia.classList.add('hidden');
                row_distrito.classList.add('hidden');
                row_zonificacion.classList.add('hidden');
                row_area_terreno.classList.add('hidden');
                row_vut.classList.add('hidden');
                row_latitud.classList.add('hidden');
                row_longitud.classList.add('hidden');
                if (x == 8)
                    row_traccion_vehiculo.classList.add('hidden');
            } else {
                row_departamento.classList.remove('hidden');
                row_provincia.classList.remove('hidden');
                row_distrito.classList.remove('hidden');
                row_zonificacion.classList.remove('hidden');
                row_area_terreno.classList.remove('hidden');
                row_vut.classList.remove('hidden');
                row_latitud.classList.remove('hidden');
                row_longitud.classList.remove('hidden');

                row_tipo_vehiculo.classList.add('hidden');
                row_marca_vehiculo.classList.add('hidden');
                row_modelo_vehiculo.classList.add('hidden');
                row_traccion_vehiculo.classList.add('hidden');
                row_anio_fabricacion.classList.add('hidden');
                row_vsn.classList.add('hidden');
            }
        }

        const crudTasacion = () => {
            const apiRestMantenimiento = 'insertTasacion';

            const fd = new FormData();
            fd.append('tasacion_tipo', selectTipoTasacion.value)
            fd.append('tasacion_correlativo', inputCodigoCoordinacion.value)
            fd.append('tasacion_fecha', inputFechaTasacion.value)
            fd.append('tasacion_cliente', inputCliente.classList.contains('hidden') ? selectCliente.value : inputCliente.value)
            fd.append('tasacion_propietario', inputPropietario.classList.contains('hidden') ? selectPropietario.value : inputPropietario.value)
            fd.append('tasacion_solicitante', inputSolicitante.classList.contains('hidden') ? selectSolicitante.value : inputSolicitante.value)
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

            /*ADICIONALES*/
            fd.append('tasacion_propiedad', selectTipoPropiedad.value)
            fd.append('tasacion_cultivo', selectTipoCultivo.value)
            fd.append('tasacion_vista', selectVistaLocal.value)
            fd.append('tasacion_departamento_tipo', selectTipoDepartamento.value)
            fd.append('tasacion_piso_ubicacion', inputPisoUbicacion.value)
            fd.append('tasacion_cantidad_piso', inputCantidadPisos.value)
            fd.append('tasacion_area_edificacion', inputAreaEdificacion.value)
			fd.append('tasacion_tipo_edificacion', selectTipoEdificacion.value)
            fd.append('tasacion_area_ocupada', inputAreaOcupada.value)
            fd.append('tasacion_area_complementaria', selectAreaComplementaria.value)
            fd.append('tasacion_cantidad_estacinamiento', selectAreaComplementaria.value)

            fd.append('tasacion_tipo_vm', selectTipoVehiculo.value)
            fd.append('tasacion_marca_vm', selectMarcaVehiculo.value)
            fd.append('tasacion_modelo_vm', selectModeloVehiculo.value)
            fd.append('tasacion_traccion_v', selectTraccionVehiculo.value)
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
						window.location.href = '../tasacion';
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
            } else if (inputFechaTasacion.value == '') {
                inputFechaTasacion.focus();
                swal({
                    text: 'Seleccioné fecha de tasación',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputCliente.classList.contains('hidden') && selectCliente.value == '') {
                selectCliente.focus();
                swal({
                    text: 'Seleccioné cliente',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputPropietario.classList.contains('hidden') && selectPropietario.value == '') {
                selectPropietario.focus();
                swal({
                    text: 'Seleccioné propietario',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputSolicitante.classList.contains('hidden') && selectSolicitante.value == '') {
                selectSolicitante.focus();
                swal({
                    text: 'Seleccioné solicitante',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputUbicacion.value == '') {
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
            } else if (selectTipoVehiculo.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectTipoVehiculo.focus();
                swal({
                    text: selectTipoTasacion.value == 7 ? 'Seleccioné tipo vehículo' : 'Seleccioné tipo maquinaria',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectMarcaVehiculo.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectMarcaVehiculo.focus();
                swal({
                    text: 'Seleccioné marca',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectModeloVehiculo.value == '' && (selectTipoTasacion.value == 7 || selectTipoTasacion.value == 8)) {
                selectModeloVehiculo.focus();
                swal({
                    text: 'Seleccioné modelo',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputTipoCambio.value == '') {
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
            } else if (selectTipoTasacion.value == 5 && selectVistaLocal.value == '') {
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
            } else if (inputAreaTerreno.value == '' && selectTipoTasacion.value < 7) {
                inputAreaTerreno.focus();
                swal({
                    text: 'Ingresé cantidad de pisos',
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
            } else if (inputValorComercial.value == '') {
                inputValorComercial.focus();
                swal({
                    text: 'Ingresé valor comercial',
                    timer: 1500,
                    buttons: false
                });
            } else if ((selectTipoTasacion.value >= 2 && selectTipoTasacion.value <= 6) && inputAreaEdificacion.value == '') {
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
            } else if ((selectTipoTasacion.value == 2 || selectTipoTasacion.value == 4 || selectTipoTasacion.value == 6) && selectAreaComplementaria.value == '') {
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
            } else if (inputRutaInforme.value == '') {
                inputRutaInforme.focus();
                swal({
                    text: 'Ingresé ruta del informe',
                    timer: 1500,
                    buttons: false
                });
            } else if ((inputLatitud.value == '' || inputLongitud.value == '') || (inputLatitud.value == 0 || inputLongitud.value == 0) && selectTipoTasacion.value < 7) {
                inputRutaInforme.focus();
                swal({
                    text: 'Ingresé coordenada válida',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudTasacion();
            }
        });
		
        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            swal({
                title: '¿ Esta seguro de cancelar la operación ?',
                text: 'al cancelar el registro será redireccionado al listado de tasaciones',
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

            fieldCliente.classList.add('hidden');
            fieldPropietario.classList.add('hidden');
            fieldSolicitante.classList.add('hidden');

            inputCliente.value = objCoordinacion.cliente_nombre;
            inputPropietario.value = objCoordinacion.propietario_nombre;
            inputSolicitante.value = objCoordinacion.solicitante_nombre;

            inputCliente.setAttribute('readonly', 'readonly');
            inputPropietario.setAttribute('readonly', 'readonly');
            inputSolicitante.setAttribute('readonly', 'readonly');

            inputCliente.classList.remove('hidden');
            inputPropietario.classList.remove('hidden');
            inputSolicitante.classList.remove('hidden');
        }
    })
})(document);