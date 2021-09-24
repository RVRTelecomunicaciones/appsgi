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

        const radioSolicitante = d.querySelector('#rbSolicitante');
        const radioCliente = d.querySelector('#rbCliente');
        const radioOtros = d.querySelector('#rbOtros');

        const divSolicitante = d.querySelector('#row_solicitante');
        const divCliente = d.querySelector('#row_cliente');
        const divOtros = d.querySelector('#row_otros');
        const divTPersona = d.querySelector('#row_tipo_persona')

        const checkMonto = d.querySelector('#chk_monto_cambio');
        const checkPorcentaje = d.querySelector('#checkPorcentaje');
        const checkNroAceptacion = d.querySelector('#checkNroAceptacion');

        const inputMonto = d.querySelector('#monto_facturar');
        const inputOtros = d.querySelector('#otros_id');
        const inputOtrosNombre = d.querySelector('#otros_nombre');
        const inputOtrosTipo = d.querySelector('#otros_tipo');
        const inputAtencion = d.querySelector('#atencionA');
        const inputCorreo = d.querySelector('#correo');
        const inputConcepto = d.querySelector('#concepto');
        const inputCodigoTasacion = d.querySelector('#inputCodigoTasacion');
        const inputObservacion = d.querySelector('#observacion');
        const inputPorcentaje = d.querySelector('#inputPorcentaje');

        const botonBuscarOtros = d.querySelector('#btn_search');
        const botonCancelar = d.querySelector('#btn_cancelar');

        const selectSolicitante = d.querySelector('#selectSolicitante');
        const selectCliente = d.querySelector('#selectCliente');
        const selectTipoComprobante = d.querySelector('#selectTipoComprobante');
        const selectTPersona = d.querySelector('#selectTPersona');

        const inputNroAceptacion = d.querySelector('#inputNroAceptacion');

        //METODO AJAX PARA OBTENER DATOS
        ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const listarComprobante = () => {
            ajax('post', `comprobanteReporte`)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    const record_comprobante = respuesta;
                    if (record_comprobante != false) {
                        const fila_comprobante = record_comprobante.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.id}'>${item.nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.id}'>${item.nombre.toUpperCase()}</option>` 
                        }).join('');

                        $('#selectTipoComprobante').html(fila_comprobante);
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }
        listarComprobante();

        radioSolicitante.addEventListener('change', e => {
            if (!divCliente.classList.contains('hidden'))
                divCliente.classList.add('hidden');

            if (!divOtros.classList.contains('hidden'))
                divOtros.classList.add('hidden');

            if (!botonBuscarOtros.classList.contains('disabled'))
                botonBuscarOtros.classList.add('disabled');

            divSolicitante.classList.remove('hidden');
            divTPersona.classList.add('hidden');
            selectTPersona.value = 0;
        });

        radioCliente.addEventListener('change', e => {
            if (!divSolicitante.classList.contains('hidden'))
                divSolicitante.classList.add('hidden');

            if (!divOtros.classList.contains('hidden'))
                divOtros.classList.add('hidden');

            if (!botonBuscarOtros.classList.contains('disabled'))
                botonBuscarOtros.classList.add('disabled');

            divCliente.classList.remove('hidden');
            divTPersona.classList.add('hidden');
            selectTPersona.value = 0;
        });

        radioOtros.addEventListener('change', e => {
            if (!divSolicitante.classList.contains('hidden'))
                divSolicitante.classList.add('hidden');

            if (!divCliente.classList.contains('hidden'))
                divCliente.classList.add('hidden');

            botonBuscarOtros.classList.remove('disabled');
            divOtros.classList.remove('hidden');
            divTPersona.classList.remove('hidden');
            selectTPersona.value = 0;
        });

        checkMonto.addEventListener('change', e =>{
            if (checkMonto.checked){
                inputMonto.removeAttribute('disabled');
                checkPorcentaje.setAttribute('disabled', '');
            }
            else{
                inputMonto.setAttribute('disabled', '');
                checkPorcentaje.removeAttribute('disabled');
            }
        });

        botonBuscarOtros.addEventListener('click', e => {
            e.preventDefault();
            const tabJuridico = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab4');
            const botonClasificacionCancelar = d.querySelector('#tabVerticalLeft1 #linkCancelar');
            const botonActividadCancelar = d.querySelector('#tabVerticalLeft2 #linkCancelar');
            const botonGrupoCancelar = d.querySelector('#tabVerticalLeft3 #linkCancelar');
            const botonInvolucradoJuridicoCancelar = d.querySelector('#tabVerticalLeft4 #linkCancelar');
            const botonInvolucradoNaturalCancelar = d.querySelector('#mdlNatural #linkCancelar');

            limpiarEtiquetasFiltrado();

            if (selectTPersona.value == 0) {
                /*BEGIN RESET MODAL*/
                botonClasificacionCancelar.click();
                botonActividadCancelar.click();
                botonGrupoCancelar.click();
                botonInvolucradoJuridicoCancelar.click();
                tabJuridico.click();

                listClasificacion(filtersClasificacion(1));
                listActividad(filtersActividad(1));
                listGrupo(filtersGrupo(1));
                listInvolucrado(filtersInvolucrado(1));
                /*END RESET MODAL*/
                $('#mdlJuridico').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });
            } else {
                /*BEGIN RESET MODAL*/
                botonInvolucradoNaturalCancelar.click();
                listInvolucradoNatural(filtersInvolucradoNatural(1));
                /*END RESET MODAL*/
                $('#mdlNatural').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });
            }
        });

        checkPorcentaje.addEventListener('change', e => {
            if(checkPorcentaje.checked) {
                inputPorcentaje.removeAttribute('disabled');
                //checkMonto.setAttribute('disabled', '')
                let importe = monto_facturar * (inputPorcentaje.value/100);
                inputMonto.value = numeral(importe).format('0.00');
            } else {
                inputPorcentaje.setAttribute('disabled', '');
                //checkMonto.removeAttribute('disabled');
                inputPorcentaje.value = 50;
                inputMonto.value = numeral(monto_facturar).format('0.00');
            }
        });

        inputPorcentaje.addEventListener('change', e => {
            let importe = monto_facturar * (inputPorcentaje.value/100);
            inputMonto.value = numeral(importe).format('0.00');
        });

        inputPorcentaje.addEventListener('click', e => {
            let importe = monto_facturar * (inputPorcentaje.value/100);
            inputMonto.value = numeral(importe).format('0.00');
        });

        checkNroAceptacion.addEventListener('change', e => {
            if(checkNroAceptacion.checked) {
                inputNroAceptacion.value = '';
                inputNroAceptacion.setAttribute('disabled', '');
            } else {
                inputNroAceptacion.removeAttribute('disabled');
            }
        });

        const limpiarEtiquetasFiltrado = () => {
            const inputsMdl = d.querySelectorAll("#tableRegistro input");
            const selectsMdl = d.querySelectorAll("#tableRegistro select");

            inputsMdl.forEach(input => {
                input.value = '';
            });

            selectsMdl.forEach(select =>{
                select.value = '';
            });
        }

        const form = d.querySelector('#frmRegistro');
        form.addEventListener('submit', e => {
            e.preventDefault();
            let text;
            let nro_documento;
            let inicio;
            let fin;
            let longitud;

            if (rbSolicitante.checked)
                text = selectSolicitante.options[selectSolicitante.selectedIndex].text;

            if (rbCliente.checked)
                text = selectCliente.options[selectCliente.selectedIndex].text;

            if (rbOtros.checked)
                text = inputOtrosNombre.value;

            inicio = text.indexOf('[');
            fin = text.indexOf(']');
            nro_documento = text.substring(inicio + 1, fin);
            longitud = nro_documento.length;
            //Number.isInteger(nro_documento);

            if (selectTipoComprobante.value == 1 && longitud < 11) {//(longitud < 11 || Number.isInteger(nro_documento) == false)) {
                selectTipoComprobante.focus();
                swal({
                    text: 'El número de documento del cliente a facturar no es válido, por favor modifiqué su ruc ...',
                    timer: 3000,
                    buttons: false
                });
            } else if (!d.getElementById('row_orden').classList.contains('hidden') && inputNroAceptacion.value == '' && checkNroAceptacion.checked == false) {
                inputNroAceptacion.focus();
                swal({
                    title: 'Ingresé número de aceptación',
                    text: 'De no contar con un número de aceptación marque la casilla que se encuentra al costado del campo de texto',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudInformacionFactura();
            }
        });

        const crudInformacionFactura = () => {

            //

            let subtotal = igv_tipo == 'sin' ? Number(inputMonto.value) : Number(inputMonto.value) / 1.18;
            let igv = igv_tipo == 'sin' ? Number(inputMonto.value) * 0.18 : Number(inputMonto.value) - subtotal;
            let total = igv_tipo == 'sin' ? Number(subtotal + igv) : Number(inputMonto.value);

            let solicitante_tipo = $('#selectSolicitante').find(":selected").attr('data-tipo');
            let cliente_facturado_tipo = rbSolicitante.checked == true ? $('#selectSolicitante').find(":selected").attr('data-tipo') : rbCliente.checked == true ? $('#selectCliente').find(":selected").attr('data-tipo') : inputOtrosTipo.value

            const fd = new FormData();
            fd.append('ad_tipo_documento', selectTipoComprobante.value);
            fd.append('cotizacion_id', cotizacion_id);
            fd.append('solicitante_id', selectSolicitante.value);
            fd.append('solicitante_tipo', solicitante_tipo);
            fd.append('facturado_por', rbSolicitante.checked == true ? 1 : rbCliente.checked == true ? 2 : 3);
            fd.append('cliente_facturado_id', rbSolicitante.checked == true ? selectSolicitante.value : rbCliente.checked == true ? selectCliente.value : inputOtros.value);
            fd.append('cliente_facturado_tipo', cliente_facturado_tipo);
            fd.append('servicio_tipo_id', servicio_tipo_id);
            fd.append('igv_tipo', igv_tipo);
            fd.append('ad_subtotal', subtotal);
            fd.append('ad_igv', igv);
            fd.append('ad_total', total);
            fd.append('ad_porcentaje', checkPorcentaje.checked == true ? 1 : 0);
            fd.append('ad_porcentaje_num', checkPorcentaje.checked == true ? inputPorcentaje.value : 0);
            fd.append('ad_atencion', inputAtencion.value);
            fd.append('ad_correo', inputCorreo.value);
            fd.append('ad_concepto', inputConcepto.value);
            fd.append('ad_nro_aprobacion', inputNroAceptacion.value);
            fd.append('ad_codigo_tasacion', inputCodigoTasacion.value);
            fd.append('ad_observacion', inputObservacion.value);
            fd.append('estado_id', 1);

            ajax('post', `insertInformacionFactura`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        sessionStorage.clear();
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        })
                        .then(
                            () => window.location.href = 'informacion_facturacion'
                        );
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: '',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonCancelar.addEventListener('click', e => {
            swal({
                    title: '¿Esta seguro de Cancelar?',
                    text: 'Al aceptar será redirecionado al listado',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        window.location.href = 'informacion_facturacion';
                        sessionStorage.clear();
                    }
                });
            });
    })
})(document);

window.onload = function(){
    if (sessionStorage.getItem('informacionFactura') != null) {
        const objCotizacion = JSON.parse(sessionStorage.getItem('informacionFactura'));

        cotizacion_id = objCotizacion.cotizacion_id;
        servicio_tipo_id = objCotizacion.servicio_tipo_id;
        igv_tipo = objCotizacion.igv_tipo;
        monto_facturar = objCotizacion.cotizacion_monto;
        existe_pago_partes = objCotizacion.ad_porcentaje;
        porcentaje = objCotizacion.ad_porcentaje_num;

        document.getElementById('spanCotizacionCodigo').innerHTML = objCotizacion.cotizacion_correlativo;
        document.getElementById('inputServicioTipo').value = objCotizacion.servicio_tipo_nombre.toUpperCase();
        document.getElementById('basic-addon5').innerHTML = objCotizacion.moneda_simbolo;
        document.getElementById('inputCodigoTasacion').value = objCotizacion.cotizacion_coordinaciones;
        if (objCotizacion.orden_servicio != ''){
            document.getElementById('inputOrden').value = objCotizacion.orden_servicio;
            document.getElementById('row_orden').classList.remove('hidden');
        }
        

        if (objCotizacion.ad_porcentaje == 1) {
            document.getElementById('inputPorcentaje').value = 100 - porcentaje;
            document.getElementById('inputPorcentaje').setAttribute('max', 100 - porcentaje);
            document.getElementById('checkPorcentaje').setAttribute('checked', '');
            document.getElementById('checkPorcentaje').setAttribute('disabled', '');
            document.getElementById('inputPorcentaje').removeAttribute('disabled');

            document.getElementById('monto_facturar').value = numeral(monto_facturar * (100 - porcentaje)/100).format('0.00');
        } else {
            document.getElementById('monto_facturar').value = monto_facturar;
            //document.getElementById('monto_facturar').setAttribute('max', monto_facturar);
        }

        ajax('post', `searchInvServ/${objCotizacion.cotizacion_id}`)
            .then((respuesta) => {
                const record_involucrado = respuesta.involucrados;
                const record_servicio = respuesta.servicios;
                if (record_involucrado != false) {
                    const fila_cliente = record_involucrado.map((item, index) => {
                        if (item.rol_id == 1)
                            return `<option value='${item.involucrado_id}' data-tipo='${item.involucrado_tipo_nombre}'>${item.involucrado_nombre.toUpperCase()} [${item.involucrado_documento}]</option>` 
                    }).join('');

                    const fila_solicitante = record_involucrado.map((item, index) => {
                        if (item.rol_id == 2)
                            return `<option value='${item.involucrado_id}' data-tipo='${item.involucrado_tipo_nombre}'>${item.involucrado_nombre.toUpperCase()} [${item.involucrado_documento}]</option>` 
                    }).join('');

                    $('#selectCliente').html(fila_cliente);
                    $('#selectSolicitante').html(fila_solicitante);
                }

                if (record_servicio != false) {
                    const fila_servicio = record_servicio.map((item, index) => {
                        return `<tr>
                                    <td style='font-size: 1rem'>${index+1}</td>
                                    <td style='font-size: 1rem'><div align='left'>${ item.servicio_id == 0 ? item.servicio_descripcion.toUpperCase() : item.servicio_nombre.toUpperCase()}</div></td>
                                    <td style='font-size: 1rem'><div align='right'>${item.moneda_simbolo} ${numeral(item.servicio_costo).format('0.00')}${item.servicio_igv_letra}</div></td>
                                </tr>`
                        }).join('');

                        $('#tblServicios tbody').html(fila_servicio);
                }
            })
            .catch(() => {
                console.log('Promesa no cumplida')
            })
    }
}
