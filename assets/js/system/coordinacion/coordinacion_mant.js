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

        //VARIABLES
        /*BEGIN COORDINACION*/
        const divContacto = d.getElementById('infContacto');
        const divFecha = d.getElementById('infFecha');
        const divHora = d.getElementById('infHora');
        const divDepartamento = d.getElementById('infDepartamento');
        const divProvincia = d.getElementById('infProvincia');
        const divDistrito = d.getElementById('infDistrito');
        const divDireccion = d.getElementById('infDireccion');
        const divPerito = d.getElementById('infPerito');
        const divCCalidad = d.getElementById('infCCalidad');
        const divObservacion = d.getElementById('infObservacion');

        const inputCoordinacionId = d.getElementById('inputCoordinacionId');
        const cotizacionCorrelativo = d.getElementById('cotizacion_correlativo');
        const cotizacionImporte = d.getElementById('cotizacion_importe');
        const selectRiesgo = d.getElementById('selectRiesgo');
        const selectCoordinador = d.getElementById('selectCoordinador');
        const selectEstado = d.getElementById('selectEstado');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputContacto = d.getElementById('inputContacto');
        const inputFechaSolicitud = d.getElementById('inputFechaSolicitud');
        const inputFechaAprobacion = d.getElementById('inputFechaAprobacion');
        const inputFechaEntregaCliente = d.getElementById('inputFechaEntregaCliente');
        const inputCliente = d.getElementById('inputCliente');
        const inputSucursal = d.getElementById('inputSucursal');
        const selectFormato = d.getElementById('selectFormato');
        //const selectTServicio = d.getElementById('selectTServicio');
        const inputTServicio = d.getElementById('inputTServicio');
        const selectTCambio = d.getElementById('selectTCambio');
        const radioInterior = d.getElementById('rbInterior');
        const radioExterior = d.getElementById('rbExterior');
        const radioGabinete = d.getElementById('rbGabinete');
        const inputCoordinacionObservacion = d.getElementById('inputCoordinacionObservacion');
        const strgCoordinacionCorrelativo = d.getElementById('coordinacion_correlativo');
        const tableCoord = d.querySelector('#tbl_coordinaciones tbody');
        const botonEditarModal = d.getElementById('linkEditarInspeccion');
        const botonAñadirCoordinacion = d.getElementById('botonAñadirCoordinacion');
        const botonSaveCoordinacion = d.getElementById('botonSaveCoordinacion');
        /*END COORDINACION*/

        /*BEGIN INSPECCION*/
        const inputInspeccionId = d.getElementById('inputInspeccionId');
        const selectPerito = d.getElementById('selectPerito');
        const selectDigitador = d.getElementById('selectDigitador');
        const selectCCalidad = d.getElementById('selectCCalidad');
        const inputInspeccionContacto = d.getElementById('inputInspeccionContacto');
        const inputInspeccionFecha = d.getElementById('inputInspeccionFecha');
        const radioHExacta = d.getElementById('radioHExacta');
        const inputHoraExacta = d.getElementById('inputHoraExacta');
        const inputMinutosExacta = d.getElementById('inputMinutosExacta');
        const selectMeridianoExacta = d.getElementById('selectMeridianoExacta');
        const radioHEstimada = d.getElementById('radioHEstimada');
        const inputHoraEstimada = d.getElementById('inputHoraEstimada');
        const inputMinutosEstimada = d.getElementById('inputMinutosEstimada');
        const selectMeridianoEstimada = d.getElementById('selectMeridianoEstimada');
        const trHEstimada = d.getElementById('trHEstimada');
        const inputInspeccionObservacion = d.getElementById('inputInspeccionObservacion');
        /*const selectDepartamento = d.getElementById('selectDepartamento');
        const selectProvincia = d.getElementById('selectProvincia');
        const selectDistrito = d.getElementById('selectDistrito');*/
        const selectUbigeDepartamento = d.getElementById('selectUbigeDepartamento');
        const selectUbigeoProvincia = d.getElementById('selectUbigeoProvincia');
        const selectUbigeoDistrito = d.getElementById('selectUbigeoDistrito');
        const inputLatitud = d.getElementById('inputLatitud');
        const inputLongitud = d.getElementById('inputLongitud');
        const inputDireccion = d.getElementById('inputDireccion')
        const inputRuta = d.getElementById('inputRuta');
        /*END INSPECCION*/
        const botonHojaCoordinacion = d.getElementById('linkVerHoja');
        const iframe = d.getElementById('ifrm_pdf');

        const botonCambiarFecha = d.getElementById('lnkChangeFecha');
        const inputNuevaFechaEntrega = d.getElementById('inputNuevaFechaEntrega');
        const spandetectorReproceso = d.getElementById('detector');

        const selectMotivo = d.querySelector('#mdl_reproceso #selectMotivo');
        const inputReprocesoDescripcion = d.querySelector('#mdl_reproceso #inputReprocesoDescripcion');
        const inputFechaNueva = d.querySelector('#mdl_reproceso #inputNuevaFechaEntrega');

        let usuario = d.getElementById('user_name').innerHTML;
        if (usuario == 'RICHARD A. RAMOS DAVILA' || usuario == 'RUSSELL F. VERGARA ROJAS') {
            botonCambiarFecha.classList.remove('hidden');
        }else{
            botonCambiarFecha.classList.add('hidden');
        }
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

        const listCoordinaciones = (idCotizacion, idCoordinacion = false, coordinacionCorrelativo = false) => {
            let fd = new FormData();
            fd.append('cotizacion_id', idCotizacion)

            ajax('post', `searchCoordinacionxCotizacion`, fd)
                .then((respuesta) => {
                    const registros = respuesta.coordinacion_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            return `<tr>
                                        <td><a id='lnkVerCoordinacion' href data-indice='${index}' style='${idCoordinacion == item.coordinacion_id || coordinacionCorrelativo == item.coordinacion_correlativo ? "color: #000000;" : ""}'>${item.coordinacion_correlativo}</a></td>
                                        <td>${item.coordinacion_estado_nombre}</td>
                                    </tr>`
                        }).join("");

                        //$('#tbl_coordinaciones tbody').html(filas);
                        tableCoord.innerHTML = filas;

                        const lnkVerCoordinacion = d.querySelectorAll('#lnkVerCoordinacion');

                        lnkVerCoordinacion.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;

                                inputCoordinacionId.value = registros[indice].coordinacion_id;
                                //labelCoordinador.innerHTML = registros[indice].coordinador_nombre;
                                $('#selectRiesgo').val(registros[indice].riesgo_id).trigger('change');
                                $('#selectCoordinador').val(registros[indice].coordinador_id).trigger('change');
                                if (registros[indice].coordinacion_estado_id == '8')
                                    spandetectorReproceso.innerHTML = '1';
                                else
                                    spandetectorReproceso.innerHTML = '0';

                                $('#selectEstado').val(registros[indice].coordinacion_estado_id).trigger('change');
                                inputSolicitante.value = registros[indice].solicitante_nombre.toUpperCase();
                                inputContacto.value = registros[indice].contacto_nombre.toUpperCase();

                                inputFechaSolicitud.innerHTML = registros[indice].fecha_solicitud.replace(/-/g, '/');
                                inputFechaAprobacion.innerHTML = registros[indice].fecha_aprobacion.replace(/-/g, '/');

                                let arrFEntrega = registros[indice].fecha_entrega_cliente != '' ? registros[indice].fecha_entrega_cliente.split('-') : '';
                                inputFechaEntregaCliente.value = arrFEntrega != '' ? arrFEntrega[2] + '-' + arrFEntrega[1] + '-' + arrFEntrega[0] : '';

                                if (arrFEntrega != '') {
                                    inputNuevaFechaEntrega.setAttribute('min', calcularFecha('suma', arrFEntrega[2] + '/' + arrFEntrega[1] + '/' + arrFEntrega[0], 1));
                                    inputFechaNueva.setAttribute('min', calcularFecha('suma', arrFEntrega[2] + '/' + arrFEntrega[1] + '/' + arrFEntrega[0], 1));
                                } else {
                                    inputNuevaFechaEntrega.removeAttribute('min');
                                    inputFechaNueva.removeAttribute('min');
                                }

                                if (registros[indice].fecha_entrega_cliente == '' && (registros[indice].coordinacion_estado_id == 1 || registros[indice].coordinacion_estado_id == 6)) {
                                    inputFechaEntregaCliente.removeAttribute('readonly');
                                }else{
                                    inputFechaEntregaCliente.setAttribute('readonly', true);
                                }

                                inputCliente.value = registros[indice].cliente_nombre.toUpperCase();
                                inputSucursal.value = registros[indice].coordinacion_sucursal.toUpperCase();
                                $('#selectFormato').val(registros[indice].formato_id).trigger('change');
                                let TServicio = registros[indice].servicio_tipo_nombre.replace(', '," \n");
                                inputTServicio.value = TServicio;
                                $('#selectTCambio').val(registros[indice].tipo_cambio_id).trigger('change');

                                radioExterior.checked = registros[indice].tipo_inspeccion_id == 1 ? true : false;
                                radioInterior.checked = registros[indice].tipo_inspeccion_id == 2 ? true : false;
                                radioGabinete.checked = registros[indice].tipo_inspeccion_id == 3 ? true : false;
                                inputCoordinacionObservacion.value = registros[indice].coordinacion_observacion;
                                strgCoordinacionCorrelativo.innerHTML = registros[indice].coordinacion_correlativo;

                                const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
                                const datosCotizacion =
                                            {
                                                coordinacion_id: registros[indice].coordinacion_id,
                                                riesgo_id: registros[indice].riesgo_id,
                                                cotizacion_id: idCotizacion,
                                                cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                                moneda_simbolo: objCotizacion.moneda_simbolo,
                                                cotizacion_importe: objCotizacion.cotizacion_importe,
                                                coordinacion_correlativo: registros[indice].coordinacion_correlativo,
                                                coordinador_id: registros[indice].coordinador_id,
                                                coordinacion_estado_id: registros[indice].coordinacion_estado_id,
                                                solicitante_id: registros[indice].solicitante_id,
                                                solicitante_tipo: registros[indice].solicitante_tipo,
                                                solicitante_nombre: registros[indice].solicitante_nombre,
                                                contacto_id: registros[indice].contacto_id,
                                                contacto_nombre: registros[indice].contacto_nombre,
                                                fecha_solicitud: registros[indice].fecha_solicitud,
                                                fecha_aprobacion: registros[indice].fecha_aprobacion,
                                                fecha_entrega_cliente: registros[indice].fecha_entrega_cliente,
                                                cliente_id: registros[indice].cliente_id,
                                                cliente_tipo: registros[indice].cliente_tipo,
                                                cliente_nombre: registros[indice].cliente_nombre,
                                                coordinacion_sucursal: registros[indice].coordinacion_sucursal,
                                                formato_id: registros[indice].formato_id,
                                                servicio_tipo_nombre: registros[indice].servicio_tipo_nombre,
                                                tipo_cambio_id: registros[indice].tipo_cambio_id,
                                                tipo_inspeccion_id: registros[indice].tipo_inspeccion_id,
                                                coordinacion_observacion: registros[indice].coordinacion_observacion,
                                                inspeccion_id: registros[indice].inspeccion_id
                                            };

                                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));

                                if (registros[indice].inspeccion_id != '0') {
                                    listInspeccion(registros[indice].inspeccion_id);
                                    if(botonHojaCoordinacion.classList.contains('hidden'))
                                        botonHojaCoordinacion.classList.remove('hidden');
                                }
                                else {
                                    botonHojaCoordinacion.classList.add('hidden');

                                    divContacto.innerHTML = '';
                                    divFecha.innerHTML = '';
                                    divHora.innerHTML = '';
                                    divDireccion.innerHTML = '';
                                    divPerito.innerHTML = '';
                                    divCCalidad.innerHTML = '';
                                    divObservacion.innerHTML = '';

                                    divDepartamento.innerHTML = 'LIMA';
                                    divProvincia.innerHTML = 'LIMA';
                                    divDistrito.innerHTML = 'LIMA';

                                    inputInspeccionId.value = 0;

                                    listUbigeoDepartamento(15, 128, 1253);

                                    $('#selectPerito').val('').trigger('change');
                                    $('#selectDigitador').val('').trigger('change');
                                    $('#selectCCalidad').val('').trigger('change');
                                    inputInspeccionContacto.value = '';
                                    inputInspeccionFecha.value = '';
                                    radioHExacta.checked = true;
                                    trHEstimada.classList.add('hidden');
                                    inputHoraExacta.value = '00';
                                    inputMinutosExacta.value = '00';
                                    selectMeridianoExacta.value = 1;
                                    inputHoraEstimada.value = '00';
                                    inputMinutosEstimada.value = '00';
                                    selectMeridianoEstimada.value = 1;
                                    inputInspeccionObservacion.value = '';
                                    inputLatitud.value = '';
                                    inputLongitud.value = '';
                                    inputDireccion.value = '';
                                    inputRuta.value;
                                }

                                for (let i = 0; i < lnkVerCoordinacion.length; i++) {
                                    if (indice == i)
                                        lnkVerCoordinacion[i].style.color = "black";
                                    else
                                        lnkVerCoordinacion[i].style.color = null;
                                }
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const calcularFecha = (accion, fecha, cantidad_dia) => {
            let date = new Date(fecha);
            let dias = parseInt(cantidad_dia);

            if (accion == 'suma')
                date.setDate(date.getDate() + dias);
            else
                date.setDate(date.getDate() - dias);

            let dia = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
            let mes = date.getMonth() < 10 ? '0' + (date.getMonth() + 1)  : (date.getMonth() + 1);
            let fecha_nueva_min = date.getFullYear() + '-' + mes + '-' + dia;
            return fecha_nueva_min;
        }

        const listPeritos = () => {
            ajax('post', `../perito/searchPeritoCombo`)
                .then((respuesta) => {
                    const registros = respuesta.perito_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.perito_id}'>${item.perito_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.perito_id}'>${item.perito_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectPerito.innerHTML = '';
                        selectPerito.innerHTML = filas;

                        selectDigitador.innerHTML = '';
                        selectDigitador.innerHTML = filas.replace("<option value=''></option>", "");

                        $('#selectPeritoDetalle').html(filas);
                        $('#selectDigitadorDetalle').html(filas);
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const listControlCalidad = () => {
            ajax('post', `../calidad/searchControlCalidadCombo`)
                .then((respuesta) => {
                    const registros = respuesta.control_calidad_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                        if (index == 0)
                            return `<option value=''></option><option value='${item.control_calidad_id}'>${item.control_calidad_nombre.toUpperCase()}</option>`
                        else
                            return `<option value='${item.control_calidad_id}'>${item.control_calidad_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectCCalidad.innerHTML = '';
                        selectCCalidad.innerHTML = filas;

                        $('#selectControlCalidadDetalle').html(filas);
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        listPeritos();
        listControlCalidad();

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

                        selectUbigeoDepartamento.innerHTML = '';
                        selectUbigeoDepartamento.innerHTML = filas;

                        listUbigeoProvincia(false, idProvincia, idDistrito);

                        $('#selectUbigeoDepartamento').change(function(event) {
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
            fd.append('departamento_id', idDepartamento != false ? idDepartamento : selectUbigeoDepartamento.value)

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

                        selectUbigeoProvincia.innerHTML = '';
                        selectUbigeoProvincia.innerHTML = filas;

                        listUbigeoDistrito(false, idDistrito);
                        
                        if (idProvincia == false) {
                            $('#selectUbigeoProvincia').prop('selectedIndex', 0).change();
                            //$('#selectUbigeoProvincia').val(1).trigger('change');
                        } else {
                            $('#selectUbigeoProvincia').change(function(event) {
                                listUbigeoDistrito();
                            });
                        }

                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const listUbigeoDistrito = (idProvincia = false, idDistrito = false) => {
            let fd = new FormData();
            fd.append('provincia_id', idProvincia != false ? idProvincia : selectUbigeoProvincia.value)

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

                        selectUbigeoDistrito.innerHTML = '';
                        selectUbigeoDistrito.innerHTML = filas;

                        if (idDistrito == false)
                            $('#selectUbigeoDistrito').prop('selectedIndex', 0).change();
                            //$('#selectUbigeoDistrito').val(1).trigger('change');
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        listUbigeoDepartamento();
        /*END UBIGEO FINAL*/

        $('#selectPerito').change(function(event) {
            $('#selectDigitador').val(selectPerito.options[selectPerito.selectedIndex].value).trigger('change');
        });

        const listInspeccion = (idInspeccion) => {
            let fd = new FormData();
            fd.append('accion', 'inspeccion_coordinacion')
            fd.append('inspeccion_id', idInspeccion)

            ajax('post', `../inspeccion/searchInspeccionCoordinacion`, fd)
                .then((respuesta) => {
                    const registros = respuesta.inspeccion_find;
                    if (registros != false) {
                        let arrFechaAprobacion = $('#inputFechaAprobacion').html().split('/');
                        let fecha_aprobacion = arrFechaAprobacion == '' ? '' : arrFechaAprobacion[2] + '-' + arrFechaAprobacion[1] + '-' + arrFechaAprobacion[0];
                        inputInspeccionFecha.setAttribute('min', fecha_aprobacion);

                        divContacto.innerHTML = registros[0].inspeccion_contacto.toUpperCase().replace(/(?:\r\n|\r|\n)/g, '<br />');
                        divFecha.innerHTML = registros[0].inspeccion_fecha;

                        let hora = registros[0].inspeccion_hora;
                        let caracter = hora.indexOf('-');
                        let arrHora = "";

                        if (caracter > 0){
                            arrHora = hora.split('-')
                            /*hora 1*/
                            let hourEnd1 = arrHora[0].indexOf(":")
                            let H1 = +arrHora[0].substr(0,hourEnd1)
                            let h1 = H1 % 12 || 12
                            let ampm1 = (H1 < 12 || H1 === 24) ? " AM" : " PM"
                            let hora1 = h1 + arrHora[0].substr(hourEnd1, 3) + ampm1
                            /*hora 2*/
                            let hourEnd2 = arrHora[1].indexOf(":")
                            let H2 = +arrHora[1].substr(0,hourEnd2)
                            let h2 = H2 % 12 || 12
                            let ampm2 = (H2 < 12 || H2 === 24) ? " AM" : " PM"
                            let hora2 = h2 + arrHora[1].substr(hourEnd2, 3) + ampm2

                            arrHora = hora1 + '-' + hora2
                        } else {
                            let hourEnd = hora.indexOf(":")
                            let H = +hora.substr(0,hourEnd)
                            let h = H % 12 || 12
                            let ampm = (H < 12 || H === 24) ? " AM" : " PM"
                            arrHora = h + hora.substr(hourEnd, 3) + ampm

                            /*arrHora = hora2*/
                        }

                        let tableHour = arrHora.split("-");
                        //divHora.innerHTML = tableHour[0] + "<br />a <br />" + tableHour[1];

                        if (tableHour.length > 1)
                            divHora.innerHTML = tableHour[0] + "<br /> a <br />" + tableHour[1];
                        else
                            divHora.innerHTML = arrHora;

                        divDepartamento.innerHTML = registros[0].departamento_nombre.toUpperCase();
                        divProvincia.innerHTML = registros[0].provincia_nombre.toUpperCase();
                        divDistrito.innerHTML = registros[0].distrito_nombre.toUpperCase();
                        divDireccion.innerHTML = registros[0].inspeccion_direccion.toUpperCase();
                        divPerito.innerHTML = registros[0].perito_nombre.toUpperCase();
                        divCCalidad.innerHTML = registros[0].control_calidad_nombre.toUpperCase();
                        divObservacion.innerHTML = registros[0].inspeccion_observacion.toUpperCase();

                        inputInspeccionId.value = idInspeccion;
                        $('#selectPerito').val(registros[0].perito_id == 0 ? '' : registros[0].perito_id).trigger('change');
                        $('#selectDigitador').val(registros[0].digitador_id == 0 ? '' : registros[0].digitador_id).trigger('change');
                        inputInspeccionContacto.value = registros[0].inspeccion_contacto;
                        $('#selectCCalidad').val(registros[0].control_calidad_id == 0 ? '' : registros[0].control_calidad_id).trigger('change');
                        inputInspeccionFecha.value = registros[0].inspeccion_fecha_normal;
                        
                        if (registros[0].hora_real_mostrar == 1) {
                            radioHExacta.checked = true;
                            let hora = arrHora.split(" ");
                            let hora2 = hora[0].split(":");
                            inputHoraExacta.value = hora2[0];
                            inputMinutosExacta.value = hora2[1];

                            selectMeridianoExacta.value = hora[1] == 'AM' ? 1 : 2;


                            inputHoraEstimada.value = '00';
                            inputMinutosEstimada.value = '00';
                            selectMeridianoEstimada.value = 1;
                            trHEstimada.classList.add('hidden');
                        }

                        if (registros[0].hora_estimada_mostrar == 1) {
                            radioHEstimada.checked = true;
                            trHEstimada.classList.remove('hidden');
                            let hora = arrHora.split("-");
                            let horaExac = hora[0].split(" ");
                            let horaEsti = hora[1].split(" ");
                            let horaExacta = horaExac[0].split(":");
                            let horaEstimada = horaEsti[0 ].split(":");

                            inputHoraExacta.value = horaExacta[0];
                            inputMinutosExacta.value = horaExacta[1];
                            inputHoraEstimada.value = horaEstimada[0];
                            inputMinutosEstimada.value = horaEstimada[1];

                            selectMeridianoExacta.value = horaExac[1] == 'AM' ? 1 : 2;
                            selectMeridianoEstimada.value = horaEsti[1] == 'AM' ? 1 : 2;
                        }
                        
                        listUbigeoDepartamento(registros[0].departamento_id, registros[0].provincia_id, registros[0].distrito_id);
                        inputLatitud.value = registros[0].inspeccion_latitud;
                        inputLongitud.value = registros[0].inspeccion_longitud;
                        inputDireccion.value = registros[0].inspeccion_direccion;
                        inputInspeccionObservacion.value = registros[0].inspeccion_observacion;
                        inputRuta.value = registros[0].inspeccion_ruta;
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        if (sessionStorage.getItem('dataCotizacion') != null) {
            const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
            d.getElementById('cotizacionId').innerHTML = objCotizacion.cotizacion_id;
            cotizacionCorrelativo.innerHTML = objCotizacion.cotizacion_correlativo;
            cotizacionImporte.innerHTML = objCotizacion.moneda_simbolo + ' ' + numeral(objCotizacion.cotizacion_importe).format('0,0.00');

            if (objCotizacion.fecha_entrega_cliente == '' && (objCotizacion.coordinacion_estado_id == 1 || objCotizacion.coordinacion_estado_id == 6)) {
                inputFechaEntregaCliente.removeAttribute('readonly');
            }else{
                inputFechaEntregaCliente.setAttribute('readonly', true);
            }

            $('#selectRiesgo').val('').trigger('change');
            $('#selectCoordinador').val('').trigger('change');
            $('#selectEstado').val('').trigger('change');

            listCoordinaciones(objCotizacion.cotizacion_id, objCotizacion.coordinacion_id);

            if (objCotizacion.coordinacion_id != null) {

                inputCoordinacionId.value = objCotizacion.coordinacion_id;
                $('#selectRiesgo').val(objCotizacion.riesgo_id).trigger('change');
                $('#riesgo_text').html(objCotizacion.riesgo_id == 1 ? 'Cumple con el proceso normal de tasación y deberá ser visado por el perito auditor y un perito principal.' : objCotizacion.riesgo_id == 2 ? 'Cumple con el proceso normal de tasación y deberá ser visado por el perito auditor y los dos peritos principales.' : 'Se debe revisar en comité, integrado por los dos peritos principales, el perito auditor, el perito ejecutor.');
                $('#selectCoordinador').val(objCotizacion.coordinador_id).trigger('change');
                $('#selectEstado').val(objCotizacion.coordinacion_estado_id).trigger('change');
                inputSolicitante.value = objCotizacion.solicitante_nombre.toUpperCase();
                inputContacto.value = objCotizacion.contacto_nombre.toUpperCase();

                inputFechaSolicitud.innerHTML = objCotizacion.fecha_solicitud.replace(/-/g,'/');
                inputFechaAprobacion.innerHTML = objCotizacion.fecha_aprobacion.replace(/-/g,'/');

                let arrFEntrega = objCotizacion.inputFechaEntregaCliente != '' ? objCotizacion.fecha_entrega_cliente.split('-') : '';
                inputFechaEntregaCliente.value = arrFEntrega != '' ? arrFEntrega[2] + '-' + arrFEntrega[1] + '-' + arrFEntrega[0] : '';
                if (arrFEntrega != '') {
                    inputNuevaFechaEntrega.setAttribute('min', calcularFecha('suma', arrFEntrega[2] + '/' + arrFEntrega[1] + '/' + arrFEntrega[0], 1));
                    inputFechaNueva.setAttribute('min', calcularFecha('suma', arrFEntrega[2] + '/' + arrFEntrega[1] + '/' + arrFEntrega[0], 1));
                } else {
                    inputNuevaFechaEntrega.removeAttribute('min');
                    inputFechaNueva.removeAttribute('min');
                }

                inputCliente.value = objCotizacion.cliente_nombre.toUpperCase();
                inputSucursal.value = objCotizacion.coordinacion_sucursal.toUpperCase();
                $('#selectFormato').val(objCotizacion.formato_id).trigger('change');
                let TServicio = objCotizacion.servicio_tipo_nombre.replace(', '," \n");
                inputTServicio.value = TServicio;
                $('#selectTCambio').val(objCotizacion.tipo_cambio_id).trigger('change');

                radioExterior.checked = objCotizacion.tipo_inspeccion_id == 1 ? true : false;
                radioInterior.checked = objCotizacion.tipo_inspeccion_id == 2 ? true : false;
                radioGabinete.checked = objCotizacion.tipo_inspeccion_id == 3 ? true : false;
                inputCoordinacionObservacion.value = objCotizacion.coordinacion_observacion;
                strgCoordinacionCorrelativo.innerHTML = objCotizacion.coordinacion_correlativo;

                if (objCotizacion.inspeccion_id != '0') {
                    inputInspeccionId.value = objCotizacion.inspeccion_id;
                    listInspeccion(objCotizacion.inspeccion_id);
                    if(botonHojaCoordinacion.classList.contains('hidden'))
                        botonHojaCoordinacion.classList.remove('hidden');
                }
                else {
                    listUbigeoDepartamento(15, 128, 1253);
                    botonHojaCoordinacion.classList.add('hidden');
                    divDepartamento.innerHTML = 'LIMA';
                    divProvincia.innerHTML = 'LIMA';
                    divDistrito.innerHTML = 'LIMA';
                }
            }
        }

        $('#selectEstado').change(function () {
            const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));

            if (inputFechaEntregaCliente.value == '' && (this.value == 1 || this.value == 6)) {
                inputFechaEntregaCliente.removeAttribute('readonly');
            } else {
                if (this.value == 8 && spandetectorReproceso.innerHTML == '0' && objCotizacion.coordinacion_estado_id < 8) {
                    selectMotivo.value = '';
                    inputReprocesoDescripcion.value = '';
                    $('#mdl_reproceso').modal({
                        'show': true,
                        'keyboard': false,
                        'backdrop': 'static'
                    });
                    botonSaveCoordinacion.classList.add('hidden');
                } else {
                    botonSaveCoordinacion.classList.remove('hidden');
                }
                inputFechaEntregaCliente.setAttribute('readonly', true);
            }
        });

        $('#selectRiesgo').change(function () {
           switch (this.value) {
               case '1':
                    $('#riesgo_text').html('Cumple con el proceso normal de tasación y deberá ser visado por el perito auditor y un perito principal.');
                    //$('#riesgo_text').
                   break;
                case '2':
                    $('#riesgo_text').html('Cumple con el proceso normal de tasación y deberá ser visado por el perito auditor y los dos peritos principales');
                    break;
                case '3':
                    $('#riesgo_text').html('Se debe revisar en comité, integrado por los dos peritos principales, el perito auditor, el perito ejecutor.');
                    break;
               default:
                    $('#riesgo_text').html('');
                   break;
           }
        });

        const botonGuardarReproceso = d.querySelector('#mdl_reproceso #btnGuardar');
        const botonCerrarReprocesoModal = d.querySelector('#mdl_reproceso #btnCerrar');
        botonCerrarReprocesoModal.addEventListener('click', e => {
            const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
            $('#selectEstado').val(objCotizacion.coordinacion_estado_id).trigger('change');
            botonSaveCoordinacion.classList.remove('hidden');
        });

        botonGuardarReproceso.addEventListener('click', e => {
            e.preventDefault();
            if (selectMotivo.value == '') {
                swal({
                    text: 'Seleccioné Motivo ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputReprocesoDescripcion.value == ''){
                swal({
                    text: 'Ingresé descripción del reproceso ...',
                    timer: 1500,
                    buttons: false
                });
            } else {
                /*let date = new Date();
                let dia = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
                let mes = date.getMonth() < 10 ? '0' + (date.getMonth() + 1)  : (date.getMonth() + 1);
                let fecha_nueva = date.getFullYear() + '/' + mes + '/' + dia;*/
                
                const fd = new FormData();
                fd.append('reproceso_coordinacion_id', inputCoordinacionId.value)
                fd.append('reproceso_motivo_id', selectMotivo.value)
                fd.append('reproceso_desripcion', inputReprocesoDescripcion.value)
                fd.append('reproceso_estado_id', '8')
                //fd.append('reproceso_fecha_nueva', calcularFecha('suma', fecha_nueva, date.getDay() == 5 ? 3 : 1))
                fd.append('reproceso_fecha_nueva', inputFechaNueva.value)

                ajax('post', 'insertCoordinacionReproceso', fd)
                    .then((respuesta) => {
                        //console.log(respuesta);
                        if (respuesta.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Guardado',
                                    text: 'Se guardo correctamente ...',
                                    timer: 1500,
                                    buttons: false
                                });

                                const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
                                let coordinacion = d.getElementById('coordinacion_correlativo');
                                listCoordinaciones(objCotizacion.cotizacion_id, false, coordinacion.innerText);

                                const datosCotizacion =
                                            {
                                                coordinacion_id: objCotizacion.coordinacion_id,
                                                cotizacion_id: objCotizacion.cotizacion_id,
                                                cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                                moneda_simbolo: objCotizacion.moneda_simbolo,
                                                cotizacion_importe: objCotizacion.cotizacion_importe,
                                                coordinacion_correlativo: objCotizacion.coordinacion_correlativo,
                                                coordinador_id: objCotizacion.coordinador_id,
                                                coordinacion_estado_id: selectEstado.value,
                                                solicitante_id: objCotizacion.solicitante_id,
                                                solicitante_tipo: objCotizacion.solicitante_tipo,
                                                solicitante_nombre: objCotizacion.solicitante_nombre,
                                                contacto_id: objCotizacion.contacto_id,
                                                contacto_nombre: objCotizacion.contacto_nombre,
                                                fecha_solicitud: objCotizacion.fecha_solicitud,
                                                fecha_entrega_cliente: inputNuevaFechaEntrega.value,
                                                cliente_id: objCotizacion.cliente_id,
                                                cliente_tipo: objCotizacion.cliente_tipo,
                                                cliente_nombre: objCotizacion.cliente_nombre,
                                                coordinacion_sucursal: objCotizacion.coordinacion_sucursal,
                                                formato_id: objCotizacion.formato_id,
                                                servicio_tipo_nombre: objCotizacion.servicio_tipo_nombre,
                                                tipo_cambio_id: objCotizacion.tipo_cambio_id,
                                                tipo_inspeccion_id: objCotizacion.tipo_inspeccion_id,
                                                coordinacion_observacion: objCotizacion.coordinacion_observacion,
                                                inspeccion_id: objCotizacion.inspeccion_id
                                            };

                                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));

                                botonCerrarReprocesoModal.click();
                                //location.reload();
                            } else {
                                swal({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo guardar, por favor informar al area de sistemas',
                                    timer: 1500,
                                    buttons: false
                                });
                            }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")  
                    })
            }
        });

        if (d.getElementById('lnkChangeFecha')) {
            const botonGuardarCambioFecha = d.getElementById('btnGuardarCambiarFecha');

            botonCambiarFecha.addEventListener('click', e => {
                e.preventDefault();

                $('#mdl_cambiarFecha').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });
            });

            botonGuardarCambioFecha.addEventListener('click', e => {
                e.preventDefault();
                const inputMotivo = d.getElementById('inputMotivo')
                if (inputNuevaFechaEntrega.value == '') {
                    swal({
                        text: 'Seleccioné la nueva fecha de entrega ...',
                        timer: 1500,
                        buttons: false
                    });
                } else if (inputMotivo.value == '') {
                    swal({
                        text: 'Seleccioné la nueva fecha de entrega ...',
                        timer: 1500,
                        buttons: false
                    });
                } else {
                    let fecha_anterior = inputNuevaFechaEntrega.getAttribute('min');
                    
                    const fd = new FormData();
                    //fd.append('cambio_tipo', botonGuardarCambioFecha.getAttribute('action'))
                    fd.append('cambio_coordinacion_id', inputCoordinacionId.value)
                    fd.append('cambio_fecha_anterior', inputNuevaFechaEntrega.getAttribute('min') ? calcularFecha('restar', fecha_anterior.replace(/-/g,'/'), 1) : '')
                    fd.append('cambio_fecha_nueva', inputNuevaFechaEntrega.value)
                    fd.append('cambio_desripcion', inputMotivo.value)

                    ajax('post', 'insertCambioFecha', fd)
                        .then((respuesta) => {
                            if (respuesta.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Guardado',
                                    text: 'Se guardo correctamente ...',
                                    timer: 1500,
                                    buttons: false
                                });
                                inputFechaEntregaCliente.value = inputNuevaFechaEntrega.value;
                                inputNuevaFechaEntrega.value = '';
                                inputNuevaFechaEntrega.removeAttribute('min');
                                inputMotivo.value = '';
                                d.querySelector('#mdl_cambiarFecha #btnCerrar').click();

                                const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));

                                const datosCotizacion =
                                            {
                                                coordinacion_id: objCotizacion.coordinacion_id,
                                                cotizacion_id: objCotizacion.cotizacion_id,
                                                cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                                moneda_simbolo: objCotizacion.moneda_simbolo,
                                                cotizacion_importe: objCotizacion.cotizacion_importe,
                                                coordinacion_correlativo: objCotizacion.coordinacion_correlativo,
                                                coordinador_id: objCotizacion.coordinador_id,
                                                coordinacion_estado_id: objCotizacion.coordinacion_estado_id,
                                                solicitante_id: objCotizacion.solicitante_id,
                                                solicitante_tipo: objCotizacion.solicitante_tipo,
                                                solicitante_nombre: objCotizacion.solicitante_nombre,
                                                contacto_id: objCotizacion.contacto_id,
                                                contacto_nombre: objCotizacion.contacto_nombre,
                                                fecha_solicitud: objCotizacion.fecha_solicitud,
                                                fecha_entrega_cliente: inputNuevaFechaEntrega.value,
                                                cliente_id: objCotizacion.cliente_id,
                                                cliente_tipo: objCotizacion.cliente_tipo,
                                                cliente_nombre: objCotizacion.cliente_nombre,
                                                coordinacion_sucursal: objCotizacion.coordinacion_sucursal,
                                                formato_id: objCotizacion.formato_id,
                                                servicio_tipo_nombre: objCotizacion.servicio_tipo_nombre,
                                                tipo_cambio_id: objCotizacion.tipo_cambio_id,
                                                tipo_inspeccion_id: objCotizacion.tipo_inspeccion_id,
                                                coordinacion_observacion: objCotizacion.coordinacion_observacion,
                                                inspeccion_id: objCotizacion.inspeccion_id
                                            };

                                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));
                                //location.reload();
                            } else {
                                swal({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se pudo guardar, por favor informar al area de sistemas',
                                    timer: 1500,
                                    buttons: false
                                });
                            }
                        })
                        .catch(() => {
                            console.log("Promesa no cumplida")
                        })
                }
            });
        }
        
        botonAñadirCoordinacion.addEventListener('click', e => {
            e.preventDefault();
            if (sessionStorage.getItem('dataCotizacion') != null) {
                const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
                
                const fd = new FormData();
                fd.append('cotizacion_id', objCotizacion.cotizacion_id)

                ajax('post', `insertCoordinacionGenerada`, fd)
                    .then((respuesta) => {
                        if (respuesta.success) {
                            listCoordinaciones(objCotizacion.cotizacion_id);
                        }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    });
            }
        });

        botonHojaCoordinacion.addEventListener('click', e => {
            e.preventDefault();
            if (d.getElementById('coordinacion_correlativo').innerHTML != '') {
                $('#mdl_hoja_coordinacion').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });

                
                let datos = {
                    cotizacion_id: d.getElementById('cotizacionId').innerHTML,
                    coordinacion_id: inputCoordinacionId.value,
                    inspeccion_id: inputInspeccionId.value
                }
                
                iframe.setAttribute('src', `hojaCoordinacion?data=${JSON.stringify(datos)}`);
            } else {
                swal({
                    text: 'Seleccioné coordinación ...',
                    timer: 1500,
                    buttons: false
                });
            }
        });

        $("#mdl_hoja_coordinacion").on('hidden.bs.modal', function () {
            iframe.removeAttribute('src');
        });

        botonEditarModal.addEventListener('click', e => {
            e.preventDefault();
            if (d.getElementById('coordinacion_correlativo').innerHTML != '') {
                
                if (inputFechaEntregaCliente.value == '') {
                    swal({
                        text: 'Ingresé fecha de entrega',
                        timer: 1500,
                        buttons: false
                    });
                    $('#link-tab1').click();
                    inputFechaEntregaCliente.focus();
                } else {
                    $('#mdl_inspeccion').modal({
                        'show': true,
                        'keyboard': false,
                        'backdrop': 'static'
                    });
                    const tabDatosGenerales = d.getElementById('lnkDatosGenerales');
                    tabDatosGenerales.click();
                }
            } else {
                swal({
                    text: 'Seleccioné coordinación ...',
                    timer: 1500,
                    buttons: false
                });
            }
        });

        radioHExacta.addEventListener('change', e => {
            if (radioHExacta.checked) {
                trHEstimada.classList.add('hidden');
            }
        });

        radioHEstimada.addEventListener('change', e =>{
            if (radioHEstimada.checked) {
                trHEstimada.classList.remove('hidden');
            }
        });

        inputHoraExacta.addEventListener('change', e => {
            inputHoraExacta.value = inputHoraExacta.value < 10 ? '0' + inputHoraExacta.value : inputHoraExacta.value;
        });

        inputMinutosExacta.addEventListener('change', e => {
            inputMinutosExacta.value = inputMinutosExacta.value < 10 ? '0' + inputMinutosExacta.value : inputMinutosExacta.value;
        });

        inputHoraEstimada.addEventListener('change', e => {
            inputHoraEstimada.value = inputHoraEstimada.value < 10 ? '0' + inputHoraEstimada.value : inputHoraEstimada.value;
        });

        inputMinutosEstimada.addEventListener('change', e => {
            inputMinutosEstimada.value = inputMinutosEstimada.value < 10 ? '0' + inputMinutosEstimada.value : inputMinutosEstimada.value;
        });

        const crudInspeccion = () => {
            const apiRestMantenimiento = inputInspeccionId.value == 0 ? '../inspeccion/insertInspeccion' : '../inspeccion/updateInspeccion';

            let fecha = new Date();
            let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            let yyyy = fecha.getFullYear();
            let fecha_actual = yyyy + '-' + mm + '-' + dd;

            let arrFecha = ['13','14','15','16','17','18','19','20','21','22','23','24'];

            let hora_exacta = '00:00';
            let hora_estimada = '00:00-00:00';

            if (selectMeridianoExacta.value == 2) {
                hora_exacta = arrFecha[Number(inputHoraExacta.value) - 1] + ':' + inputMinutosExacta.value;
            }
            else
                hora_exacta = inputHoraExacta.value + ':' + inputMinutosExacta.value;

            if (selectMeridianoEstimada.value == 2) {
                hora_estimada =  hora_exacta + '-' + arrFecha[Number(inputHoraEstimada.value) - 1] + ':' + inputMinutosEstimada.value;
            } else {
                hora_estimada =  hora_exacta + '-' + inputHoraEstimada.value + ':' + inputMinutosEstimada.value;
            }


            const fd = new FormData();
            fd.append('inspeccion_id', inputInspeccionId.value)
            fd.append('coordinacion_id', inputCoordinacionId.value)
            fd.append('perito_id', selectPerito.value)
            fd.append('digitador_id', selectDigitador.value)
            fd.append('control_calidad_id', selectCCalidad.value)
            fd.append('inspeccion_contacto', inputInspeccionContacto.value)
            fd.append('inspeccion_fecha', inputInspeccionFecha.value)
            fd.append('inspeccion_hora_real_mostrar', radioHExacta.checked == true ? 1 : 0)
            fd.append('inspeccion_hora_real', radioHExacta.checked == true || radioHEstimada.checked ? hora_exacta : '00:00')
            fd.append('inspeccion_hora_estimada_mostrar', radioHEstimada.checked == true ? 1 : 0)
            fd.append('inspeccion_hora_estimada', radioHEstimada.checked ? hora_estimada : '00:00-00:00')
            fd.append('ubigeo_distrito_id', selectUbigeoDistrito.value)
            fd.append('inspeccion_latitud', inputLatitud.value)
            fd.append('inspeccion_longitud', inputLongitud.value)
            fd.append('inspeccion_direccion', inputDireccion.value)
            fd.append('inspeccion_observacion', inputInspeccionObservacion.value)
            fd.append('inspeccion_ruta', inputRuta.value)
            if (inputInspeccionId.value != 0)
                fd.append('inspeccion_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                    .then((respuesta) => {
                        if (respuesta.success) {
                            //sessionStorage.clear();
                            swal({
                                icon: 'success',
                                title: 'Guardado',
                                text: inputInspeccionId.value == 0 ? 'Se guardo correctamente ...' : 'Se actualizo correctamente ...',
                                timer: 1500,
                                buttons: false
                            }).then(
                                () => $('#mdl_inspeccion').modal('hide'),listInspeccion(inputInspeccionId.value)
                            );
                            listInspeccion(inputInspeccionId.value == 0 ? respuesta.idInspeccion : inputInspeccionId.value);
                            if (sessionStorage.getItem('dataCotizacion') != null) {
                                const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
                                
                                const datosCotizacion =
                                            {
                                                coordinacion_id: objCotizacion.coordinacion_id,
                                                riesgo_id: registros[indice].riesgo_id,
                                                cotizacion_id: objCotizacion.cotizacion_id,
                                                cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                                moneda_simbolo: objCotizacion.moneda_simbolo,
                                                cotizacion_importe: objCotizacion.cotizacion_importe,
                                                /*BEGIN COORDINACIÓN*/
                                                coordinacion_correlativo: objCotizacion.coordinacion_correlativo,
                                                coordinador_id: objCotizacion.coordinador_id,
                                                coordinacion_estado_id: selectEstado.value,
                                                solicitante_id: objCotizacion.solicitante_id,
                                                solicitante_tipo: objCotizacion.solicitante_tipo,
                                                solicitante_nombre: objCotizacion.solicitante_nombre,
                                                contacto_id: objCotizacion.contacto_id,
                                                contacto_nombre: objCotizacion.contacto_nombre,
                                                fecha_solicitud: objCotizacion.fecha_solicitud,
                                                fecha_aprobacion: objCotizacion.fecha_aprobacion,
                                                fecha_entrega_cliente: inputFechaEntregaCliente.value,
                                                cliente_id: objCotizacion.cliente_id,
                                                cliente_tipo: objCotizacion.cliente_tipo,
                                                cliente_nombre: objCotizacion.cliente_nombre,
                                                coordinacion_sucursal: inputSucursal.value,
                                                formato_id: selectFormato.value,
                                                //servicio_tipo_id: selectTServicio.value,
                                                tipo_cambio_id: selectTCambio.value,
                                                tipo_inspeccion_id: radioExterior.checked == true ? '1' : radioInterior.checked == true ? '2' : '3',
                                                coordinacion_observacion: inputInspeccionObservacion.value,
                                                /*END COORDINACIÓN*/
                                                /*BEGIN INSPECCIÓN*/
                                                inspeccion_id: inputInspeccionId.value == 0 ? respuesta.idInspeccion : inputInspeccionId.value
                                                /*END INSPECCIÓN*/
                                            };

                                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));
                            }
                        } else {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: inputInspeccionId.value == 0 ? 'No se pudo guardar, por favor informar al area de sistemas' : 'No se pudo actualizar, por favor informar al area de sistemas',
                                timer: 1500,
                                buttons: false
                            });
                        }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    })
        }

        const formCoordinacion = d.getElementById('frm_coordinacion');
        const btnGuardarInspeccion = d.getElementById('btnGuardarInspeccion');

        btnGuardarInspeccion.addEventListener('click', e => {
            if (selectPerito.value == "") {
                swal({
                    text: 'Seleccioné perito ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectCCalidad.value == "") {
                swal({
                    text: 'Seleccioné Control de Calidad ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputInspeccionContacto.value == "") {
                swal({
                    text: 'Digité contacto ...',
                    timer: 1500,
                    buttons: false
                });
                inputInspeccionContacto.focus();
            } else if (inputInspeccionFecha.value == "") {
                swal({
                    text: 'Digité Fecha ...',
                    timer: 1500,
                    buttons: false
                });
                inputInspeccionFecha.focus();
            } else if ((radioHExacta.checked == true || radioHEstimada.checked == true) && inputHoraExacta.value == "") {
                swal({
                    text: 'Seleccioné hora exacta ...',
                    timer: 1500,
                    buttons: false
                });
                inputHoraExacta.focus();
            } else if ((radioHExacta.checked == true || radioHEstimada.checked == true) && inputMinutosExacta.value == "") {
                swal({
                    text: 'Seleccioné minuto exacto ...',
                    timer: 1500,
                    buttons: false
                });
                inputMinutosExacta.focus();
            } else if (radioHEstimada.checked == true && inputHoraEstimada.value == "") {
                swal({
                    text: 'Seleccioné hora estimado ...',
                    timer: 1500,
                    buttons: false
                });
                inputHoraEstimada.focus();
            } else if (radioHEstimada.checked == true && inputMinutosEstimada.value == "") {
                swal({
                    text: 'Seleccioné minuto estimado ...',
                    timer: 1500,
                    buttons: false
                });
                inputMinutosExacta.focus();
            } else if (inputLatitud.value == "" || inputLongitud.value == "") {
                swal({
                    text: 'Seleccioné coordenadas en el mapa ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectUbigeoDepartamento.value == "") {
                swal({
                    text: 'Seleccioné departamento ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectUbigeoProvincia.value == "") {
                swal({
                    text: 'Seleccioné provincia ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectUbigeoDistrito.value == "") {
                swal({
                    text: 'Seleccioné distrito ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputDireccion.value == "") {
                swal({
                    text: 'digité direccion ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputInspeccionFecha.value >= inputFechaEntregaCliente.value) {
                swal({
                    text: 'Fecha de inspección no puede ser mayor a la fecha de entrega',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudInspeccion();
            }
        });

        const crudCoordinacion = () => {
            const apiRestMantenimiento = inputCoordinacionId.value == 0 ? 'insertCoordinacion' : 'updateCoordinacion';

            let fecha = new Date();
            let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            let yyyy = fecha.getFullYear();
            let fecha_actual = yyyy + '-' + mm + '-' + dd;

            const fd = new FormData();
            fd.append('coordinacion_id', inputCoordinacionId.value)
            fd.append('riesgo_id', selectRiesgo.value)
            fd.append('coordinador_id', selectCoordinador.value)
            fd.append('solicitante_fecha', inputFechaSolicitud.value)
            fd.append('entrega_al_cliente_fecha', inputFechaEntregaCliente.value)
            fd.append('sucursal', inputSucursal.value)
            fd.append('modalidad_id', selectFormato.value)
            fd.append('tipo2_id', '0')
            fd.append('tipo_cambio_id', selectTCambio.value)
            fd.append('tipo_id', radioExterior.checked == true ? '1' : radioInterior.checked == true ? '2' : '3')
            fd.append('observacion', inputCoordinacionObservacion.value)
            fd.append('estado_id', selectEstado.value)

            if (inputCoordinacionId.value != 0)
                fd.append('coordinacion_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    console.log(respuesta);
                    if (respuesta.success) {
                        //sessionStorage.clear();
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputCoordinacionId.value == 0 ? 'Se guardo correctamente ...' : 'Se actualizo correctamente ...',
                            timer: 1500,
                            buttons: false
                        });

                        if (sessionStorage.getItem('dataCotizacion') != null) {
                            const objCotizacion = JSON.parse(sessionStorage.getItem('dataCotizacion'));
                            let coordinacion = d.getElementById('coordinacion_correlativo');
                            listCoordinaciones(objCotizacion.cotizacion_id, false, coordinacion.innerText);

                            const datosCotizacion =
                                        {
                                            coordinacion_id: objCotizacion.coordinacion_id,
                                            cotizacion_id: objCotizacion.cotizacion_id,
                                            cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                            moneda_simbolo: objCotizacion.moneda_simbolo,
                                            cotizacion_importe: objCotizacion.cotizacion_importe,
                                            coordinacion_correlativo: objCotizacion.coordinacion_correlativo,
                                            coordinador_id: selectCoordinador.value,
                                            coordinacion_estado_id: selectEstado.value,
                                            solicitante_id: objCotizacion.solicitante_id,
                                            solicitante_tipo: objCotizacion.solicitante_tipo,
                                            solicitante_nombre: objCotizacion.solicitante_nombre,
                                            contacto_id: objCotizacion.contacto_id,
                                            contacto_nombre: objCotizacion.contacto_nombre,
                                            fecha_solicitud: objCotizacion.fecha_solicitud,
                                            fecha_aprobacion: objCotizacion.fecha_aprobacion,
                                            fecha_entrega_cliente: inputFechaEntregaCliente.value,
                                            cliente_id: objCotizacion.cliente_id,
                                            cliente_tipo: objCotizacion.cliente_tipo,
                                            cliente_nombre: objCotizacion.cliente_nombre,
                                            coordinacion_sucursal: inputSucursal.value,
                                            formato_id: selectFormato.value,
                                            servicio_tipo_nombre: objCotizacion.servicio_tipo_nombre,
                                            tipo_cambio_id: selectTCambio.value,
                                            tipo_inspeccion_id: radioExterior.checked == true ? '1' : radioInterior.checked == true ? '2' : '3',
                                            coordinacion_observacion: inputInspeccionObservacion.value,
                                            inspeccion_id: objCotizacion.inspeccion_id
                                        };

                            sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));
                            
                            if (inputFechaEntregaCliente.value == '' && (selectEstado.value == 1 || selectEstado.value == 6)) {
                                inputFechaEntregaCliente.removeAttribute('readonly');
                            }else{
                                inputFechaEntregaCliente.setAttribute('readonly', true);
                            }
                        }
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: inputCoordinacionId.value == 0 ? 'No se pudo guardar, por favor informar al area de sistemas' : 'No se pudo actualizar, por favor informar al area de sistemas',
                            timer: 1500,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        formCoordinacion.addEventListener('submit', e => {
            e.preventDefault();
            /*if (selectEstado.value != 0) {
                swal({
                    text: 'Seleccioné Estado ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputFechaSolicitud.value != 0) {
                swal({
                    text: 'Seleccioné fecha de solicitud ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputFechaEntregaCliente.value != 0) {
                swal({
                    text: 'Seleccioné fecha de entrega al cliente ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectFormato.value != 0) {
                swal({
                    text: 'Seleccioné Formato ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectTServicio.value != 0) {
                swal({
                    text: 'Seleccioné tipo de servicio ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (selectTCambio.value != 0) {
                swal({
                    text: 'Seleccioné tipo de servicio ...',
                    timer: 1500,
                    buttons: false
                });
            } else if (radioInterior.checked == flase && radioExterior.checked == false && radioGabinete.checked == false) {
                swal({
                    text: 'Seleccioné tipo de inspeccion ...',
                    timer: 1500,
                    buttons: false
                });
            } else {*/
                crudCoordinacion();
            /*}*/
        });

        cotizacionCorrelativo.addEventListener('click', e => {
            e.preventDefault();
            sessionStorage.clear();

            const fd = new FormData();
            fd.append('cotizacion_id', d.getElementById('cotizacionId').innerHTML)

            ajax('post', '../cotizacion/searchCotizacionById', fd)
                .then((respuesta) => {
                    const datosCotizacion =
                                {
                                    cotizacion_id: respuesta.cotizacion_id,
                                    cotizacion_correlativo: respuesta.cotizacion_codigo,
                                    cotizacion_cantidad_informes: respuesta.cotizacion_cantidad_informe,
                                    cotizacion_actualizacion: respuesta.cotizacion_actualizacion,
                                    cotizacion_tipo_id: respuesta.tipo_cotizacion_id,
                                    servicio_tipo_id: respuesta.servicio_tipo_id,
                                    cotizacion_estado: respuesta.estado_id,
                                    cotizacion_adjunto: respuesta.cotizacion_adjunto,
                                    cotizacion_fecha_solicitud: respuesta.cotizacion_fecha_solicitud,
                                    cotizacion_fecha_envio_cliente: respuesta.cotizacion_fecha_envio_cliente,
                                    cotizacion_fecha_finalizacion: respuesta.cotizacion_fecha_finalizacion,

                                    coordinador_nombre: respuesta.coordinador_nombre,
                                    vendedor_id: respuesta.vendedor_id,
                                    vendedor_porcentaje_comision: respuesta.vendedor_porcentaje_comision,

                                    pago_id: respuesta.pago_id,
                                    desglose_id: respuesta.desglose_id,
                                    moneda_id: respuesta.moneda_id,

                                    cotizacion_igv_check: respuesta.cotizacion_igv_check,
                                    cotizacion_subtotal: respuesta.cotizacion_monto,
                                    cotizacion_igv_monto: Number(respuesta.cotizacion_total) - Number(respuesta.cotizacion_monto),
                                    cotizacion_total: respuesta.cotizacion_total,
                                    cotizacion_orden_servicio:respuesta.cotizacion_orden_servicio,
                                    cotizacion_plazo_entrega: respuesta.cotizacion_plazo_entrega,
                                    tipo_perito: respuesta.tipo_perito,
                                    perito_id: respuesta.perito_id,
                                    perito_costo: respuesta.perito_costo,
                                    viatico_importe: respuesta.viatico_importe,
                                    cotizacion_datos_adicionales: respuesta.datos_adicionales
                                };

                    sessionStorage.setItem('cotizacion', JSON.stringify(datosCotizacion));
                    window.location.href = '../cotizacion/mantenimiento';
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        });
    })
})(document);