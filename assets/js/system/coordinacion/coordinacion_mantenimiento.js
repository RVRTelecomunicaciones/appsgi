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

        //OTROS
        const modulo = d.getElementById('linkModulo').innerText.toLowerCase();
        const user = d.getElementById('user_codigo').innerText;
        const divCotizacionCodigo = d.getElementById('cotizacionCodigo');
        const linkcotizacionCorrelativo = d.getElementById('cotizacionCorrelativo');
        const labelCotizacionServicioTipo = d.getElementById('cotizacionServicioTipo');
        const tableBody = d.getElementById('tbl_coordinacion').getElementsByTagName('tbody')[0];

        const divCorrelativo = d.getElementById('coordinacionCorrelativo');
        const form = d.getElementById('frm_coordinacion');

        //REPROCESO
        const formReproceso = d.getElementById('frm_reproceso');
        const selectMotivo = d.getElementById('selectMotivo');
        const inputReprocesoDescripcion = d.getElementById('inputReprocesoDescripcion');
        const inputReprocesoNuevaFechaEntrega = d.getElementById('inputReprocesoNuevaFechaEntrega');
        const buttonCloseReproceso = d.getElementById('buttonCloseReproceso');

        //COORDINACION
        const inputCodigo = d.getElementById('inputCodigo');
        const selectRiesgo = d.getElementById('selectRiesgo');
        const divRiesgo = d.getElementById('divRiesgo');
        const selectCoordinador = d.getElementById('selectCoordinador');
        const selectEstado = d.getElementById('selectEstado');
        const labelCliente = d.getElementById('labelCliente');
        const labelSolicitante = d.getElementById('labelSolicitante');
        const labelContacto = d.getElementById('labelContacto');
        const labelFechaSolicitud = d.getElementById('labelFechaSolicitud');
        const labelFechaAprobacion = d.getElementById('labelFechaAprobacion');
        const inputFechaEntrega = d.getElementById('inputFechaEntrega');
        const inputFechaEntregaOperaciones = d.getElementById('inputFechaEntregaOperaciones');
        const inputSucursal = d.getElementById('inputSucursal');
        const selectFormato = d.getElementById('selectFormato');
        const selectTipoCambio = d.getElementById('selectTipoCambio');
        const radioInterior = d.getElementById('radioInterior');
        const radioExterior = d.getElementById('radioExterior');
        const radioGabinete = d.getElementById('radioGabinete');
        const inputObservacion = d.getElementById('inputObservacion');
        const selectDigitador = d.getElementById('selectDigitador');
        const selectControlCalidad = d.getElementById('selectControlCalidad');
        const buttonNewCoordinacion = d.getElementById('buttonNewCoordinacion');

        //INSPECCION
        const buttonNewInspeccion = d.getElementById('buttonNewInspeccion');

        listCoordinaciones = (cotizacion, coordinacion) => {
            let fd = new FormData();
            fd.append('action', 'cotizacion');
            fd.append('cotizacion_codigo', cotizacion)

            ajax('post', 'search', fd)
                .then((response) => {
                    let records = response.records_find;
                    if (records != false) {
                        cotizacionCodigo.innerHTML = records[0].cotizacion_id;
                        linkcotizacionCorrelativo.innerHTML = records[0].cotizacion_coorelativo;
                        labelCotizacionServicioTipo.innerHTML = records[0].servicio_tipo_nombre;
                        let row = records.map((item, index) => {
                            return `<tr>
		        						<!--<td>${index + 1}</td>-->
                                        <td><a id='lnkViewCoordinacion' href data-indice='${index}' style='${item.coordinacion_id == coordinacion ? "color: #000000;" : ""}'>${item.coordinacion_correlativo}</a></td>
                                        <td>${item.estado_nombre}</td>
                                    </tr>`
                        }).join('');
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;

                        const linkViewCoordinacion = d.querySelectorAll('#lnkViewCoordinacion');

                        linkViewCoordinacion.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = link.dataset.indice;
                                $('#link-tab1').click();
                                listCoordinaciones(records[indice].cotizacion_id, records[indice].coordinacion_id);
                            });
                        });
                    }
                })
                .then(() => {
                    if (coordinacion != 0) {
                        let fd = new FormData();
                        fd.append('action', 'maintenance')
                        fd.append('coordinacion_codigo', coordinacion);

                        ajax('post', 'search', fd)
                            .then((response) => {
                                let objResponse = response.records_find;

                                divCorrelativo.innerHTML = objResponse.coordinacion_correlativo;
                                inputCodigo.value = objResponse.coordinacion_id;
                                $('#selectRiesgo').val(objResponse.riesgo_id).trigger('change');
                                $('#selectCoordinador').val(objResponse.coordinador_id).trigger('change');
                                try {
                                    if (objResponse.estado_id == 6 && modulo != 'operaciones')
                                        inputFechaEntrega.removeAttribute('disabled');
                                    else
                                        inputFechaEntrega.setAttribute('disabled', true);
                                    
                                    if (objResponse.estado_id == 8)
                                        selectEstado.setAttribute('data-estado', '1')
                                    else
                                        selectEstado.setAttribute('data-estado', '0')

                                    $('#selectEstado').val(objResponse.estado_id).trigger('change');
                                } catch (error) { }

                                labelCliente.innerText = objResponse.cliente_nombre;
                                labelSolicitante.innerText = objResponse.solicitante_nombre;
                                labelContacto.innerText = objResponse.contacto_nombre.toUpperCase();
                                labelFechaSolicitud.innerText = objResponse.coordinacion_fecha_solicitud;
                                labelFechaAprobacion.innerText = objResponse.coordinacion_fecha_aprobacion;
                                inputFechaEntrega.value = objResponse.coordinacion_fecha_entrega_normal;
                                inputFechaEntregaOperaciones.value = objResponse.coordinacion_fecha_operaciones_normal;
                                inputSucursal.value = objResponse.coordinacion_sucursal;
                                $('#selectFormato').val(objResponse.modalidad_id).trigger('change');
                                $('#selectTipoCambio').val(objResponse.tipo_cambio_id).trigger('change');
                                radioExterior.checked = objResponse.tipo_inspeccion_id == 1 ? true : false;
                                radioInterior.checked = objResponse.tipo_inspeccion_id == 2 ? true : false;
                                radioGabinete.checked = objResponse.tipo_inspeccion_id == 3 ? true : false;
                                inputObservacion.value = objResponse.coordinacion_observacion.toUpperCase();
                                $('#selectDigitador').val(objResponse.digitador_id).trigger('change');
                                $('#selectControlCalidad').val(objResponse.control_calidad_id).trigger('change');

                                listInspeccion(objResponse.coordinacion_id);
                                listBitacora(objResponse.coordinacion_id);
                            })
                            .catch(() => {
                                console.log('Promesa no cumplida')
                            })
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }

        if (sessionStorage.getItem('data') != null) {
            const objData = JSON.parse(sessionStorage.getItem('data'));
            listCoordinaciones(objData.cotizacion_codigo, objData.coordinacion_codigo);
            
            if (modulo == 'operaciones' && user != 41 && user != 67) {
                $('#selectRiesgo').prop('disabled', true);
                $('#selectCoordinador').prop('disabled', true);
                inputFechaEntrega.setAttribute('disabled', true);
                inputSucursal.setAttribute('disabled', true);
                $('#selectFormato').prop('disabled', true);
                $('#selectTipoCambio').prop('disabled', true);
                radioInterior.setAttribute('disabled', true);
                radioExterior.setAttribute('disabled', true);
                radioGabinete.setAttribute('disabled', true);
                inputObservacion.setAttribute('disabled', true);
                
                buttonNewInspeccion.classList.add('hidden');
            }

            if (user != 17 && user != 41 && user != 67) {
                $('#selectDigitador').prop('disabled', true);
                $('#selectControlCalidad').prop('disabled', true);
            }
        } else {
            swal({
                text: 'No se a seleccinado coordinacion o cotización, sera redireccionado a la lista.ss',
                timer: 1000,
                buttons: false
            })
            .then(
                () => window.location.href = 'listado'
            );
        }

        linkcotizacionCorrelativo.addEventListener('click', e => {
            e.preventDefault();
            /*swal({
                text: 'En mantenimiento',
                timer: 1500,
                buttons: false
            });*/

            const fd = new FormData();
            fd.append('cotizacion_id', d.getElementById('cotizacionCodigo').innerHTML)

            ajax('post', '../../cotizacion/searchCotizacionById', fd)
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
                    window.location.href = '../../cotizacion/mantenimiento';
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        });

        $('#selectEstado').select2({
            theme: 'classic',
            width: '100%'
        }).on('change', function (e) {
            //var selected_element = $(e.currentTarget);
            //var select_val = selected_element.val();
            let select_val = selectEstado.value;

            $.each(this.options, function (i, item) {
                if (modulo != 'operaciones') {
                    /*switch (parseInt(select_val)) {
                        case 1:
                            if (item.value != 2 && item.value != 7) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 2:
                            if (item.value != 7 && item.value != 8) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 3:
                            if (item.value != 4) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 4:
                            if (item.value != 8) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 5:
                            if (item.value != 5) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 6:
                            if (item.value != 1) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 7:
                            if (item.value != 7) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 8:
                            if (item.value != 2 && item.value != 4) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                    }*/
                } else {
                    switch (parseInt(select_val)) {
                        case 7:
                            if (item.value != 2) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        case 8:
                            if (item.value != 2) {
                                $(item).prop('disabled', true); 
                            } else {
                                $(item).prop('disabled', false); 
                            }
                            break;
                        /*default:
                            $(item).prop('disabled', true);
                            break;*/
                    }
                    
                    $('#selectEstado').select2({
                        theme: 'classic',
                        width: '100%'
                    });
                }
            });

            if (select_val == 8) {
                let estado = selectEstado.dataset.estado;
                if (estado == 0) {
                    formReproceso.reset();
                    inputReprocesoNuevaFechaEntrega.setAttribute('min', calcularFecha('suma', inputFechaEntrega.value, 1));
                    $('#mdl_reproceso').modal({
                        'show': true,
                        'keyboard': false,
                        'backdrop': 'static'
                    });
                }
            }
        });

        $('#selectDigitador').select2({
            placeholder: 'Seleccione',
            theme: 'classic',
            allowClear: true,
            width: '100%'
        }).on('change', function(e) {
            var selected_element = $(e.currentTarget);
            var select_val = selected_element.val();
            
            $.each(selectControlCalidad.options, function(i, item) {
                if (item.value == select_val) {
                    $(item).prop('disabled', true);
                    $('#selectControlCalidad').val('').trigger('change');
                } else {
                    $(item).prop('disabled', false);
                }
            });
            $('#selectControlCalidad').select2({
                placeholder: 'Seleccione',
                theme: 'classic',
                allowClear: true,
                width: '100%'
            });
        });

        form.addEventListener('keypress', e => {
            if (e.keyCode == 13 || e.which == 13) {
                return false;
            }
        });

        const crudCoordinacion = () => {
            const apiRestMantenimiento = inputCodigo.value == 0 ? 'insert' : 'update';
            const fd = new FormData();
            fd.append('coordinacion_codigo', inputCodigo.value);
            fd.append('coordinacion_riesgo', selectRiesgo.value);
            fd.append('coordinacion_coordinador', selectCoordinador.value);
            fd.append('coordinacion_estado', selectEstado.value);
            fd.append('coordinacion_fecha_entrega', inputFechaEntrega.value);
            fd.append('coordinacion_fecha_entrega_operaciones', inputFechaEntregaOperaciones.value);
            fd.append('coordinacion_sucursal', inputSucursal.value);
            fd.append('coordinacion_formato', selectFormato.value);
            fd.append('coordinacion_tipo_cambio', selectTipoCambio.value);
            fd.append('coordinacion_tipo_inspeccion',   radioExterior.checked == true ? '1' : radioInterior.checked == true ? '2' : '3');
            fd.append('coordinacion_observacion', inputObservacion.value);
            fd.append('coordinacion_digitador', selectDigitador.value);
            fd.append('coordinacion_control_calidad', selectControlCalidad.value);

            /*if (modulo == 'operaciones' && inputFechaEntregaOperaciones.value > inputFechaEntrega.value) {
                swal({
                    text: 'La fecha de entrega por operaciones no debe ser mayor a la fecha de entrega al cliente...',
                    timer: 2000,
                    buttons: false
                });
            } else {*/
                ajax('post', apiRestMantenimiento, fd)
                    .then((response) => {
                        if (response.success) {
                            swal({
                                icon: 'success',
                                title: 'Guardado',
                                text: inputCodigo.value == 0 ? 'Se guardo correctamente' : 'Se actualizo correctamente',
                                timer: 2000,
                                buttons: false
                            })
                            .then(
                                () => $('#link-tab1').click()
                            );
                        } else {
                            swal({
                                icon: 'info',
                                text: inputCodigo.value == 0 ? 'Ocurrio un problema al guardar' : 'Ocurrio un problema al actualizar',
                                timer: 2000,
                                buttons: false
                            })
                            .then(
                                () => $('#link-tab1').click()
                            );
                        }
                        
                    })
                    .catch(() => {
                        console.log('Promesa no cumplida')
                    });
            //}
        }

        form.addEventListener('submit', e => {
            e.preventDefault();
            if (inputFechaEntrega.value == '' && selectEstado.value != 6 && inputFechaEntrega.value == '' && selectEstado.value != 5) {
                swal({
                    text: 'Seleccioné fecha de entrega',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#link-tab1').click()
                );
            /*} else if (selectDigitador.value == '' && selectEstado.value != 6 && selectDigitador.value == '' && selectEstado.value != 5 && selectDigitador.value == '' && selectEstado.value != 1 || user == 17) {*/
            /*} else if (selectDigitador.value == '' && user == 17) {
                swal({
                    text: 'Seleccioné digitador',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#link-tab2').click()
                );*/
            /*} else if (selectControlCalidad.value == '' && selectEstado.value != 6 && selectControlCalidad.value == '' && selectEstado.value != 5 && selectControlCalidad.value == '' && selectEstado.value != 1 || user == 17) {*/
            /*} else if (selectDigitador.value == '' && user == 17) {
                swal({
                    text: 'Seleccioné control de calidad',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#link-tab2').click()
                );*/
            } else {
                crudCoordinacion();
            }
        });

        $("#mdl_reproceso").on('hidden.bs.modal', function () {
            $('#selectEstado').val('4').trigger('change');
        });

        const calcularFecha = (accion, fecha, cantidad_dia) => {
            let format_date = fecha.replace(/-/g, '/');
            let date = new Date(format_date);
            let dias = parseInt(cantidad_dia);
            let ultimo_dia = new Date(date.getFullYear(), date.getMonth() + 1, 0);

            /*if (date.getDate() == ultimo_dia.getDate()) {
                dias = 2;
            }*/

            if (accion == 'suma')
                date.setDate(date.getDate() + dias);
            else
                date.setDate(date.getDate() - dias);

            let dia = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
            let mes = date.getMonth() < 10 ? '0' + (date.getMonth() + 1)  : (date.getMonth() + 1);
            let fecha_nueva_min = date.getFullYear() + '-' + mes + '-' + dia;
            return fecha_nueva_min;
        }

        const crudReproceso = (fd) => {
            ajax('post', 'reproceso', fd)
                .then((response) => {
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se guardo correctamente',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseReproceso.click(), listCoordinaciones(divCotizacionCodigo.innerHTML, inputCodigo.value)
                        );
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
                    console.log('Promesa no cumplida')
                });
        }

        formReproceso.addEventListener('submit', e => {
            e.preventDefault();
            if (selectMotivo.value == '') {
                swal({
                    text: 'Seleccioné motivo',
                    timer: 2000,
                    buttons: false
                })
                .then(
                    () => selectMotivo.focus()
                );
            } else if (inputReprocesoDescripcion.value == '') {
                swal({
                    text: 'Ingresé descripción de motivo',
                    timer: 2000,
                    buttons: false
                })
                .then(
                    () => inputReprocesoDescripcion.focus()
                );
            } else if (inputReprocesoNuevaFechaEntrega.value == '') {
                swal({
                    text: 'Seleccioné nueva fecha',
                    timer: 2000,
                    buttons: false
                })
                .then(
                    () => inputReprocesoNuevaFechaEntrega.focus()
                );
            } else {
                const fd = new FormData();
                fd.append('coordinacion_codigo', inputCodigo.value);
                fd.append('reproceso_motivo', selectMotivo.value);
                fd.append('reproceso_descripcion', inputReprocesoDescripcion.value);
                fd.append('reproceso_nueva_fecha', inputReprocesoNuevaFechaEntrega  .value);
                crudReproceso(fd);
            }
        });
        
        buttonNewCoordinacion.addEventListener('click', e => {
            if (sessionStorage.getItem('data') != null) {
                const objData = JSON.parse(sessionStorage.getItem('data'));

                swal({
                    title: '¿Cuantas coordinaciones desea crear?',
                    content: {
                        element: 'input',
                        attributes: {
                            type: 'number',
                            value: '1',
                            min: '1',
                            style: 'text-align: right; font-size: 15;'
                        }
                    },
                    buttons: {
                        cancel: {
                            text: 'Cancel',
                            value: 'cancel',
                            visible: true
                        },
                        confirm: {
                            text: 'OK',
                            className: 'swal-button--danger'
                        }
                    }
                }).then((value) => {
                    if (value != 'cancel') {
                        let cantidad = (!value || 0 === value.lenght) ? 1 : value;

                        const fd = new FormData();
                        fd.append('cotizacion_id', objData.cotizacion_codigo);
                        fd.append('cantidad', cantidad);

                        ajax('post', `insertCoordinacionGenerada`, fd)
                            .then((respuesta) => {
                                if (respuesta.success) {
                                    swal({
                                        icon: 'success',
                                        text: respuesta.text,
                                        timer: 2000,
                                        buttons: false
                                    }).then(() => {
                                        listCoordinaciones(objData.cotizacion_codigo, objData.coordinacion_codigo);
                                    });
                                } else {
                                    swal({
                                        text: respuesta.text,
                                        timer: 2000,
                                        buttons: false
                                    }).then(() => {
                                        window.location.href = '../../intranet/acceso';
                                    });
                                }
                            })
                            .catch(() => {
                                console.log("Promesa no cumplida")
                            });
                    }
                });
            }
        });
    })
})(document);