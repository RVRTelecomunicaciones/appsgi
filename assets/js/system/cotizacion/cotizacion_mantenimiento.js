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
        ajaxMant = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        /*BEGIN SELECTS*/
        const selectCotizacionTipo = d.querySelector('#link1 #selectTCotizacion');
        const selectTServicio = d.querySelector('#link1 #selectTServicio');
        const selectVendedor = d.querySelector('#link2 #selectVendedor');
        const selectDesglose = d.querySelector('#link3 #selectDesglose');
        const selectCotizacionEstado = d.querySelector('#link1 #selectCotizacionEstado');
        const selectInvolucrado = d.querySelector('#link2 #selectInvolucrado');
        const selectContacto = d.querySelector('#link2 #selectContacto');
        const selectServicio = d.querySelector('#link3 #selectServicio');
        const selectMoneda = d.querySelector('#link3 #selectMoneda');
        const selectTPerito = d.querySelector('#link4 #selectTipoPerito');
        const selectPerito = d.querySelector('#link4 #selectPerito');
		const selectQuantity = d.querySelector('#link5 #selectQuantity');
        /*END SELECTS*/

        /*BEGIN CHECKBOXS*/
        const checkCotizacionActualizacion = d.querySelector('#link1 #checkActualizacion');
        const checkCliente = d.querySelector('#checkCliente');
        const checkSolicitante = d.querySelector('#checkSolicitante');
        const checkPropietario = d.querySelector('#checkPropietario');
        const checkCIGV = d.querySelector('#link3 #checkCIGV');
        const checkSIGV = d.querySelector('#link3 #checkSIGV');
        /*END CHECKBOXS*/

        /*BEIGN RADIOBUTTONS*/
        const radioJuridica = d.querySelector('#radioJuridica');
        const radioNatural = d.querySelector('#radioNatural');
        /*END RADIOBUTTONS*/

        /*BEGIN DIVS*/
        const divContacto = d.querySelector('#divContacto');
        /*END DIVS*/

        /*BEGIN LABELS*/
        const labelInvolucrado = d.querySelector('#labelInvolucrado');
        /*END LABELS*/

        /*BEGIN INPUTS*/
        const inputCotizacionId = d.querySelector('#link1 #inputIdCorrelativo');
        const inputCotizacionCorrelativo = d.querySelector('#link1 #inputCotizacionCorrelativo');
        const inputCotizacionCantidad = d.querySelector('#link1 #inputCantidadInformes');
        const inputCotizacionFSolicitud = d.querySelector('#link1 #inputFSolicitud');
        const inputCotizacionFEnvio = d.querySelector('#link1 #inputFEnvio');
        const inputCotizacionFFinalizacion = d.querySelector('#link1 #inputFFinalizacion');
        const inputOrdenServicio = d.querySelector('#link1 #inputOrdenServicio');
        const inputPlazo = d.querySelector('#link1 #inputPlazo');

        const inputVendedorPorcentaje = d.querySelector('#link2 #inputComisionVendedor');

        const inputPagoId = d.querySelector('#link3 #inputIdPago');
        const inputServicioCantidad = d.querySelector('#link3 #inputCantidad');
        const inputServicioCosto = d.querySelector('#link3 #inputCosto');
        const inputDatosAdicionales = d.querySelector('#link3 #inputDatosAdicionales');
        const inputSubTotal = d.querySelector('#link3 #inputSubTotal');
        const inputIgv = d.querySelector('#link3 #inputIgv');
        const inputTotal = d.querySelector('#link3 #inputTotal');
        const inputPeritoCosto = d.querySelector('#link4 #inputCostoPerito');
        const inputImporteViatico = d.querySelector('#link4 #inputImporteViatico');
		const inputMensaje = d.querySelector('#mdl_seguimiento #inputMensaje');
        const inputFechaProxima = d.querySelector('#mdl_seguimiento #inputFechaProxima');
        /*BEGIN INPUTS*/

        /*BEGIN BUTTONS*/
        const botonLimpiarFSolicitud = d.querySelector('#linkLimpiarFSolicitud');
        const botonLimpiarFEnvio = d.querySelector('#linkLimpiarFEnvio');
        const botonLimpiarFFinalizacion = d.querySelector('#linkLimpiarFFinalizacion');
        const botonLimpiarInvolucrados = d.querySelector('#linkLimpiarInvolucrados');
        const botonAñadirInvolucrados = d.querySelector('#linkAñadirInvolucrados');
        const botonNuevoInvolucrado = d.querySelector('#linkNuevoInvolucrado');
        const botonNuevoContacto = d.querySelector('#linkNuevoContacto');
        const botonNuevoTServicio = d.querySelector('#link1 #linkNuevoTServicio');
        const botonServicioLimpiar = d.querySelector('#link3 #linkLimpiar');
        const botonServicioAñadir = d.querySelector('#link3 #linkAñadir');
        const botonCancelarGeneral = d.querySelector('#linkCancelar');
		const botonNuevoMensaje = d.querySelector('#link5 #lnkNuevo');
        const botonImprimirMensaje = d.querySelector('#link5 #lnkImprimir');
        const botonGuardarMensaje = d.querySelector('#mdl_seguimiento #btnGuardar');
        const botonCerrarMensaje = d.querySelector('#mdl_seguimiento #btnCerrar');
        /*BEGIN BUTTONS*/

        /*BEGIN OTROS*/
        const tbodyInvolucrados = d.querySelector('#link2 #showInvolucrados');
        const tbodyServicio = d.querySelector('#link3 #showServicios');
        const tFootServicio = d.querySelector('#link3 #showFootServicio');

        const tabGeneral = d.querySelector('#link-tab1');
        const tabInvolucrados = d.querySelector('#link-tab2');
        const tabServicios = d.querySelector('#link-tab3');
        const tabCostos = d.querySelector('#link-tab4');
        const tabSeguimientos = d.querySelector('#link-tab5');
        const buttonsContent = d.querySelector('#buttons-content');
        const spanMonedaPerito = d.querySelector('#link4 #basic-addon1');
        const spanMonedaViatico = d.querySelector('#link4 #basic-addon2');
        /*END*/

        const gridContacto = d.getElementById('gridContacto');
        const labelMotivo = d.getElementById('labelMotivo');
        const inputMotivo = d.getElementById('inputMotivo');
        
        /* IMPUESTO */
        const impuesto_codigo = d.getElementById('id_impuesto').innerText;
        const impuesto_porcentaje = d.getElementById('impuesto').innerText;

        tabGeneral.addEventListener('click', e => {
            if (buttonsContent.classList.contains('hidden'))
                buttonsContent.classList.remove('hidden');
        });

        tabInvolucrados.addEventListener('click', e => {
            if (buttonsContent.classList.contains('hidden'))
                buttonsContent.classList.remove('hidden');
        });

        tabServicios.addEventListener('click', e => {
            if (buttonsContent.classList.contains('hidden'))
                buttonsContent.classList.remove('hidden');
        });

        tabCostos.addEventListener('click', e => {
            if (buttonsContent.classList.contains('hidden'))
                buttonsContent.classList.remove('hidden');
        });

        tabSeguimientos.addEventListener('click', e => {
            buttonsContent.classList.add('hidden');
        });

        /*BEGIN GENERAL*/
        $('#selectCotizacionEstado').on('change', function () {
            if ($(this).val() == 3 && inputCotizacionFEnvio.value != "") {
                inputCotizacionFFinalizacion.removeAttribute('readonly');
            } else {
                inputCotizacionFFinalizacion.setAttribute('readonly', true);
            }
        });

        inputCotizacionFSolicitud.addEventListener('change', e => {
            inputCotizacionFEnvio.setAttribute('min', inputCotizacionFSolicitud.value);
            inputCotizacionFEnvio.value = inputCotizacionFSolicitud.value;
            if (inputCotizacionFSolicitud.value == '') {
                inputCotizacionFEnvio.setAttribute('readonly', true);
            } else {
                inputCotizacionFEnvio.removeAttribute('readonly');
            }
        });

        botonLimpiarFSolicitud.addEventListener('click', e =>{
        	e.preventDefault();
        	inputCotizacionFSolicitud.value = '';
        });

        inputCotizacionFEnvio.addEventListener('change', e => {
            inputCotizacionFFinalizacion.setAttribute('min', inputCotizacionFEnvio.value);
        });

        botonLimpiarFEnvio.addEventListener('click', e =>{
        	e.preventDefault();
        	inputCotizacionFEnvio.value = '';
        });

        inputCotizacionFFinalizacion.addEventListener('change', e => {
        });

        botonLimpiarFFinalizacion.addEventListener('click', e =>{
        	e.preventDefault();
        	inputCotizacionFFinalizacion.value = '';
        });
        /*END GENERAL*/

        /*BEGIN TIPO DE SERVICIO*/
        $('#link1 #selectTServicio').change(function(event) {
            const tservicio = $('#selectTServicio').val();

            listServiciosCombo(tservicio);
        });
        /*END TIPO DE SERVICIO*/

        /*BEGIN INVOLUCRADOS*/
        //METODO PARA LISTAR INVOLUCRADOS JURIDICOS
        listarInvolucradosJuridico = () => {
            // promesa crea un objeto y este tiene metodos
            ajaxMant('get', `involucradoReporte/J`)
                .then((respuesta) => {
                    var registrosJuridica = respuesta;
                    const filas = registrosJuridica.map((item, indice) => {
                    	const datos =	{
                    						involucrado_id: registrosJuridica[indice].involucrado_id,
                    						involucrado_tipo_nombre: registrosJuridica[indice].involucrado_tipo_nombre,
                                            involucrado_nombre: registrosJuridica[indice].involucrado_nombre,
                                            involucrado_documento: registrosJuridica[indice].involucrado_documento,
                                            involucrado_telefono: registrosJuridica[indice].involucrado_telefono,
                                            involucrado_correo: registrosJuridica[indice].involucrado_correo
                    					}
                    	const objJuridico = JSON.stringify(datos)
                    	if (indice == 0)
                    		return `<option value=''></option><option value='${item.involucrado_id}' data-datos='${objJuridico}'>${item.involucrado_nombre.toUpperCase()} (${item.involucrado_documento})</option>`
                    	else
                    		return `<option value='${item.involucrado_id}' data-datos='${objJuridico}'>${item.involucrado_nombre.toUpperCase()} (${item.involucrado_documento})</option>`
                    }).join('');

                    selectInvolucrado.innerHTML = '';
                    selectInvolucrado.innerHTML = filas;
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }

        //METODO PARA LISTAR INVOLUCRADOS NATURALES
        listarInvolucradosNatural = () => {
            // promesa crea un objeto y este tiene metodos
            ajaxMant('get', `involucradoReporte/N`)
                .then((respuesta) => {
                    var registrosNatural = respuesta;
                    
                    const filas = registrosNatural.map((item, indice) => {
                    	const datos =	{
                    						involucrado_id: registrosNatural[indice].involucrado_id,
                    						involucrado_tipo_nombre: registrosNatural[indice].involucrado_tipo_nombre,
                                            involucrado_nombre: registrosNatural[indice].involucrado_nombre,
                                            involucrado_documento: registrosNatural[indice].involucrado_documento,
                                            involucrado_telefono: registrosNatural[indice].involucrado_telefono,
                                            involucrado_correo: registrosNatural[indice].involucrado_correo
                    					}
                    	const objNatural = JSON.stringify(datos)
                    	if (indice == 0)
                    		return `<option value=''></option><option value='${item.involucrado_id}' data-datos='${objNatural}'>${item.involucrado_nombre.toUpperCase()} (${item.involucrado_documento})</option>`
                    	else
                    		return `<option value='${item.involucrado_id}' data-datos='${objNatural}'>${item.involucrado_nombre.toUpperCase()} (${item.involucrado_documento})</option>`
                    }).join('');

                    selectInvolucrado.innerHTML = '';
                    selectInvolucrado.innerHTML = filas;
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }

        //METODO PARA LISTAR SELECT CONTACTO
        listarContacto = (idJuridica) => {
        	if (idJuridica != '') {

	            ajaxMant('get', 'contactoReporte/'+ idJuridica)
	                .then((respuesta) => {
	                    const registros = respuesta;
	                    const filas = registros.map((item, indice) => {
	                    	const datos =	{
                    						contacto_id: registros[indice].contacto_id,
                                            contacto_nombre: registros[indice].contacto_nombre,
                                            contacto_cargo: registros[indice].contacto_cargo,
                                            contacto_telefono: registros[indice].contacto_telefono,
                                            contacto_correo: registros[indice].contacto_correo
                    					}
                    		const objContacto = JSON.stringify(datos)
	                    	if (indice == 0) {
		                        return `<option value=""></option><option value='${item.contacto_id}' data-datos='${objContacto}'>${item.contacto_nombre.toUpperCase()}</option>`
		                    }else{
		                    	return `<option value='${item.contacto_id}' data-datos='${objContacto}'>${item.contacto_nombre.toUpperCase()}</option>`
		                    }
	                    }).join('');

	                    selectContacto.innerHTML = '';
	                    selectContacto.innerHTML = filas;
	                })
	                .catch(() => {
	                    console.log('Promesa no cumplida')
	                })
	            }else{
	            	selectContacto.innerHTML = '';
	            }
        }

        //METODO PARA DESMARCAR CHECKBOXS
        limpiarCheckBoxs = () =>{
        	const checkBoxs = d.querySelectorAll('#formRegistroFinal input[type="checkbox"]:checked');
        	checkBoxs.forEach(checks => {
        		checks.checked = false;
        	});
        }

        //METODO PARA VALIDACIÓN DE DATOS
        validarInvolucrados = () =>{
        	if (!checkCliente.checked && !checkSolicitante.checked && !checkPropietario.checked) {
        		swal({
        			icon: 'info',
        			title: 'Información',
        			text: 'Falta seleccionar información',
        			timer: 3000,
        			buttons: false
        		});
        		return true;
        	} else if (selectInvolucrado.value == '') {
        		swal({
	        	    icon: 'info',
	        	    title: 'Información',
	        	    text: 'Seleccioné Involucrado',
	        	    timer: 3000,
	        	    buttons: false
	        	});
	        	return true;
			} else if (radioJuridica.checked && selectContacto.value == '') {
        		swal({
	        	    icon: 'info',
	        	    title: 'Información',
	        	    text: 'Seleccioné Contacto',
	        	    timer: 3000,
	        	    buttons: false
	        	});
	        	return true;
			} else if (radioJuridica.checked && selectContacto.value == '0' && inputMotivo.value == '') {
        		swal({
	        	    icon: 'info',
	        	    title: 'Información',
	        	    text: 'Ingresé motivo por el involucrado no tiene contacto',
	        	    timer: 3000,
	        	    buttons: false
                });
                inputMotivo.focus();
	        	return true;
			}
        }

        radioJuridica.addEventListener('change', e => {
        	if (radioJuridica.checked) {
        		labelInvolucrado.innerHTML = 'Razón Social';
        		divContacto.classList.remove('hidden');
        		listarInvolucradosJuridico();
        		listarContacto('');
        	}
        	limpiarCheckBoxs();
        });

        radioNatural.addEventListener('change', e => {
        	if (radioNatural.checked) {
        		labelInvolucrado.innerHTML = 'Nombre';
        		divContacto.classList.add('hidden');
        		listarInvolucradosNatural();
        	}
        	limpiarCheckBoxs();
        });
        
        $('#selectInvolucrado').change(function(event) {
        	if(radioJuridica.checked)
	        	listarContacto(this.value);
        });

        $('#selectContacto').change(function(event) {
            if(this.value == 0) {
                gridContacto.classList.remove('col-md-10');
                gridContacto.classList.add('col-md-5');

                labelMotivo.classList.remove('hidden');
                inputMotivo.classList.remove('hidden');
            } else {
                gridContacto.classList.remove('col-md-5');
                gridContacto.classList.add('col-md-10');

                labelMotivo.classList.add('hidden');
                inputMotivo.classList.add('hidden');
            }
        });
        
        botonLimpiarInvolucrados.addEventListener('click', e =>{
        	e.preventDefault();
        	
        	if (radioJuridica.checked){
        		listarInvolucradosJuridico();
        		listarContacto('');
        	}else{
        		listarInvolucradosNatural();
        	}
        	
        	limpiarCheckBoxs();
        });

        listarInvolucradosJuridico();

        botonAñadirInvolucrados.addEventListener('click', e =>{
        	e.preventDefault();

        	if(!validarInvolucrados()) {

	        	//OBTENIENDO DATOS (INVOLUCRADO - CONTACTO)
	        	const datosInvolucrado = selectInvolucrado.options[selectInvolucrado.selectedIndex].dataset.datos;
	        	const datosContacto = selectContacto.length === 0 ? undefined : selectContacto.options[selectContacto.selectedIndex].dataset.datos;
	        	
	        	//CONVIRTIENDO DATA EN JSON
	        	const objInvolucrado = datosInvolucrado === undefined ? '' : JSON.parse(datosInvolucrado);
	        	const objContacto = datosContacto === undefined ? '' : JSON.parse(datosContacto);

	        	const rol = checkCliente.checked ? 'Cliente' : checkSolicitante.checked ? 'Solicitante' : 'Propietario';

	        	if (validarInvolucradosDuplicados(objInvolucrado, rol)){
	        		swal({
	        			icon: 'info',
	        			title: 'Información',
	        			text: `Ya se ingreso ${rol}`,
	        			timer: 3000,
	        			buttons: false
	        		});
	        	}else{

		        	var jsonInvolucrados;

		        	if (checkCliente.checked)
		        		jsonInvolucrados = insertDataTable('Cliente', objInvolucrado, objContacto);

					if (checkSolicitante.checked)
						jsonInvolucrados = insertDataTable('Solicitante', objInvolucrado, objContacto);

					if (checkPropietario.checked)
						jsonInvolucrados = insertDataTable('Propietario', objInvolucrado, objContacto);

					listarTableInvolucrados(jsonInvolucrados);
                }
                
				if (radioJuridica.checked){
	        		listarInvolucradosJuridico();
	        		listarContacto('');
	        	}else{
	        		listarInvolucradosNatural();
                }
                
	        	limpiarCheckBoxs();
        	}
        });

        listarTableInvolucrados = (jsonInvolucrados) =>{
        	tbodyInvolucrados.innerHTML = '';
			jsonInvolucrados.forEach(function (row) {
				const data = {
					id: row.involucrado_id,
					tipo: row.involucrado_tipo_nombre,
					rol: row.rol_nombre
				}
				const datos = JSON.stringify(data);
				tbodyInvolucrados.insertAdjacentHTML('beforeend', `	<tr>
															<td><div style='font-size: 0.875rem;'>${row.rol_nombre}</div></td>
															<td><div style='font-size: 0.875rem;'>${row.involucrado_tipo_nombre}</div></td>
															<td>
																<div align='left' style='font-size: 0.875rem;'>${row.involucrado_nombre}</div>
																${
																	row.involucrado_tipo_nombre == 'Juridica' ? `<div align='left'><span style='color: #61b6d9;'>Contacto: </span>${row.contacto_nombre}</div><div align='left'><span style='color: #61b6d9;'>Cargo: </span>${row.contacto_cargo}</div>` : `` 
																}
																</td>
																<td><div style='font-size: 0.875rem;'>${row.involucrado_documento}</div></td>
																<td><div style='font-size: 0.875rem;'>${row.involucrado_tipo_nombre == 'Natural' ? row.involucrado_telefono : row.contacto_telefono}</div></td>
																<td><div style='font-size: 0.875rem;'>${row.involucrado_tipo_nombre == 'Natural' ? row.involucrado_correo : row.contacto_correo}</div></td>
																<td><div style='font-size: 1.2rem;'><a id='linkDeleteInvolucrados' href='' data-indice='${datos}'><i class="fa fa-trash"></i></a></div></td>
				   											</tr>`);
			});

            const botonDeleteInvolucrados = d.querySelectorAll('#linkDeleteInvolucrados');
            botonDeleteInvolucrados.forEach(boton => {
                boton.addEventListener('click', e =>{
                    e.preventDefault();
                    const datos = JSON.parse(boton.dataset.indice);
                            
                    var jsonInvolucrados = JSON.parse(sessionStorage.getItem('sessInvolucrados'));

                    var indice;
                    jsonInvolucrados.forEach( function(row, index) {
                        if (row.involucrado_id === datos.id && row.involucrado_tipo_nombre === datos.tipo && row.rol_nombre === datos.rol) {
                            indice = index;
                        }
                    });

                    jsonInvolucrados.splice(indice,1);
                            
                    sessionStorage.setItem('sessInvolucrados', JSON.stringify(jsonInvolucrados));
                    
                    boton.closest('tr').remove();
                });
            });
        }

        //METODO PARA INSERTAR A LA TABLA
        insertDataTable = (rol, objInvolucrado, objContacto) => {
        	var jsonInvolucrados = JSON.parse(sessionStorage.getItem('sessInvolucrados')) || [ ];

        	var Involucrados = {
                                    id: 0,                    
        							involucrado_id: objInvolucrado.involucrado_id,
                                    rol_id: rol == 'Cliente' ? 1 : rol == 'Solicitante' ? 2 : 3,
        							rol_nombre: rol,
        							involucrado_tipo_nombre: objInvolucrado.involucrado_tipo_nombre,
        							involucrado_nombre: objInvolucrado.involucrado_nombre,
        							involucrado_documento: objInvolucrado.involucrado_documento,
        							involucrado_telefono: objInvolucrado.involucrado_telefono,
        							involucrado_correo: objInvolucrado.involucrado_correo,
        							contacto_id: objContacto === '' ? 0 : objContacto.contacto_id,
        							contacto_nombre: objContacto === '' ? '' : objContacto.contacto_nombre,
        							contacto_cargo: objContacto === '' ? '' : objContacto.contacto_cargo,
                                    contacto_telefono: objContacto === '' ? '' : objContacto.contacto_telefono,
                                    contacto_correo: objContacto === '' ? '' : objContacto.contacto_correo
					        	}

			jsonInvolucrados.push(Involucrados);
			sessionStorage.setItem('sessInvolucrados', JSON.stringify(jsonInvolucrados));

			return jsonInvolucrados;		
        }

        //METODO PARA VALIDAR INSERCIÓN DE DUPLICADOS
        const validarInvolucradosDuplicados = (inv, rol) => {
        	var json = JSON.parse(sessionStorage.getItem('sessInvolucrados')) || [];

        	var x = false;
        	json.forEach(function (row) {
        		if (row.rol_nombre === rol) {
        			x = true;
        		}
			});
			return x;
        }

        botonNuevoInvolucrado.addEventListener('click', e => {
            e.preventDefault();
            const tabJuridico = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab4');
            const botonClasificacionCancelar = d.querySelector('#tabVerticalLeft1 #linkCancelar');
            const botonActividadCancelar = d.querySelector('#tabVerticalLeft2 #linkCancelar');
            const botonGrupoCancelar = d.querySelector('#tabVerticalLeft3 #linkCancelar');
            const botonInvolucradoJuridicoCancelar = d.querySelector('#tabVerticalLeft4 #linkCancelar');
            const botonInvolucradoNaturalCancelar = d.querySelector('#mdlNatural #linkCancelar');

            limpiarEtiquetasFiltrado();

            if (radioJuridica.checked) {
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

        botonNuevoContacto.addEventListener('click', e => {
            e.preventDefault();
            if (selectInvolucrado.value != '') {
                $('#mdlContacto').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });
            } else {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Seleccioné involucrado para registrar contacto',
                    timer: 3000,
                    buttons: false
                });
            }
        });

        $('#link2 #selectVendedor').change(function(event) {
            inputVendedorPorcentaje.value = 0;
            if (selectVendedor.value != '')
                inputVendedorPorcentaje.removeAttribute('disabled');
            else
                inputVendedorPorcentaje.setAttribute('disabled', '');
        });
        /*END INVOLUCRADOS*/

        /*BEGIN SERVICIOS*/
        botonServicioLimpiar.addEventListener('click', e => {
            e.preventDefault();
            $('#link3 #selectServicio').val('').trigger('change');
            inputServicioCantidad.value = '1';
            inputServicioCosto.value = '0.00';
        });

        botonServicioAñadir.addEventListener('click', e =>{
            e.preventDefault();
            if (inputServicioCosto.value == '' || inputServicioCosto.value == 0) {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: inputServicioCosto.value == '' ? 'Ingrese costo' : 'El costo no puede ser 0',
                    timer: 3000,
                    buttons: false
                });
                inputCosto.focus();
            } else {
                /*if (!validarServiciosDuplicados(selectServicio.value)){*/
                    const datos = JSON.parse(selectServicio.options[selectServicio.selectedIndex].dataset.datos);
                    dataServicio = {
                                        id: 0,
                                        servicio_id: selectServicio.value,
                                        servicio_nombre: datos.servicio_nombre,
                                        servicio_descripcion: datos.servicio_descripcion,
                                        servicio_cantidad: inputServicioCantidad.value,
                                        servicio_costo: inputServicioCosto.value
                                    }
                    const jsonServicios = insertarTablaServicio(dataServicio);
                    listarTableServicios(jsonServicios);
                    botonServicioLimpiar.click();
                /*} else {
                    swal({
                        icon: 'info',
                        title: 'Información',
                        text: 'El servicio ya ha sido añadido, por favor intente con otro',
                        timer: 3000,
                        buttons: false
                    });
                }*/
            }
        });

        const insertarTablaServicio = (data) =>{
            var jsonServicios = JSON.parse(sessionStorage.getItem('sessServicios')) || [ ];            
            jsonServicios.push(data);
            sessionStorage.setItem('sessServicios', JSON.stringify(jsonServicios));

            return jsonServicios;
        }
        
        listarTableServicios = (jsonServicios) =>{
            tbodyServicio.innerHTML = '';
            tFootServicio.innerHTML = '';
            let sub_total = 0;
            jsonServicios.forEach(function (row, index) {
                const data = {
                    id: row.servicio_id
                }
                const objServicio = JSON.stringify(data);
                tbodyServicio.insertAdjacentHTML('beforeend', ` <tr>
                                                                    <td><div align='left' style='font-size: 0.875rem;'>${row.id == 0 && row.servicio_id != 0 ? row.servicio_nombre : row.id > 0 && row.servicio_id != 0 ? row.servicio_nombre : row.servicio_descripcion}</div></td>
                                                                    <td><div style='font-size: 0.875rem;'><input id='inputTableCantidad' type='number' data-datos='${objServicio}' value='${row.servicio_cantidad}' min='1' style='text-align: right;'/></div></td>
                                                                    <td><div align='right' style='font-size: 0.875rem;'><input id='inputTableSubTotal' type='number' data-datos='${objServicio}' value='${numeral(row.servicio_costo).format('0.00')}' min='1' style='text-align: right;'/></div></td>
                                                                    <td><div style='font-size: 1.2rem;'><a id='linkDeleteServicios' href='' data-datos='${objServicio}'><i class="fa fa-trash"></i></a></div></td>
                                                                </tr>`);
                //sub_total += Number(row.servicio_costo * row.servicio_cantidad);
                //<!--<td><div align='right' style='font-size: 0.875rem;'>${numeral(row.servicio_costo * row.servicio_cantidad).format('0,0.00')}</div></td>-->
                sub_total += Number(row.servicio_costo);
                
            });

            
            tFootServicio.insertAdjacentHTML('beforeend', `<tr id='trTotal'>
                                                                <td colspan="2" align="right">TOTAL</td>
                                                                <td><div id='divTotal' align='right' style='font-size: 1rem; font-weight: bold;'>${numeral(sub_total).format('0,0.00')}</div></td>
                                                            </tr>`);

            calcularTotal(sub_total);


            const inputTableCantidad = d.querySelectorAll('#inputTableCantidad');
            inputTableCantidad.forEach( input => {
                input.addEventListener('change', e =>{
                    const dataServicio = [ ];
                    const data = JSON.parse(input.dataset.datos);
                    const jsonServicios = JSON.parse(sessionStorage.getItem('sessServicios'));

                    jsonServicios.forEach( function(row, index) {
                        if (row.servicio_id === data.id) {
                            newData = {
                                id: row.id,
                                servicio_id: row.servicio_id,
                                servicio_nombre: row.servicio_nombre,
                                servicio_descripcion: '',
                                moneda_id: row.moneda_id,
                                moneda_simbolo: row.moneda_simbolo,
                                servicio_cantidad: input.value,
                                servicio_costo: row.servicio_costo
                            }
                            dataServicio.push(newData);
                        } else {
                            newData = {
                                id: row.id,
                                servicio_id: row.servicio_id,
                                servicio_nombre: row.servicio_nombre,
                                servicio_descripcion: '',
                                moneda_id: row.moneda_id,
                                moneda_simbolo: row.moneda_simbolo,
                                servicio_cantidad: row.servicio_cantidad,
                                servicio_costo: row.servicio_costo
                            }
                            dataServicio.push(newData);
                        }
                    });
                    //alert(JSON.stringify(dataServicio));
                    sessionStorage.setItem('sessServicios', JSON.stringify(dataServicio));
                });
            });

            const inputTableSubTotal = d.querySelectorAll('#inputTableSubTotal');
            inputTableSubTotal.forEach( input => {
                input.addEventListener('change', e =>{
                    let subtotal = 0;
                    const dataServicio = [ ];
                    const data = JSON.parse(input.dataset.datos);
                    const jsonServicios = JSON.parse(sessionStorage.getItem('sessServicios'));
                    input.value = numeral(input.value).format('0.00');

                    jsonServicios.forEach( function(row, index) {
                        if (row.servicio_id === data.id) {
                            newData = {
                                id: row.id,
                                servicio_id: row.servicio_id,
                                servicio_nombre: row.servicio_nombre,
                                servicio_descripcion: '',
                                moneda_id: row.moneda_id,
                                moneda_simbolo: row.moneda_simbolo,
                                servicio_cantidad: row.servicio_cantidad,
                                servicio_costo: input.value
                            }
                            dataServicio.push(newData);
                            subtotal += parseFloat(input.value);
                        } else {
                            newData = {
                                id: row.id,
                                servicio_id: row.servicio_id,
                                servicio_nombre: row.servicio_nombre,
                                servicio_descripcion: '',
                                moneda_id: row.moneda_id,
                                moneda_simbolo: row.moneda_simbolo,
                                servicio_cantidad: row.servicio_cantidad,
                                servicio_costo: row.servicio_costo
                            }
                            dataServicio.push(newData);
                            subtotal += parseFloat(input.value);
                        }
                    });
                    //alert(JSON.stringify(dataServicio));
                    const divTotal = d.querySelector('#link3 #divTotal');
                    divTotal.innerHTML = numeral(subtotal).format('0,0.00');
                    calcularTotal(subtotal);
                    sessionStorage.setItem('sessServicios', JSON.stringify(dataServicio));
                });
            });
            const botonDeleteServicios = d.querySelectorAll('#linkDeleteServicios');
            botonDeleteServicios.forEach(boton => {
                boton.addEventListener('click', e =>{
                    e.preventDefault();
                    const data = JSON.parse(boton.dataset.datos);
                            
                    const jsonServicios = JSON.parse(sessionStorage.getItem('sessServicios'));

                    let indice;
                    jsonServicios.forEach( function(row, index) {
                        if (row.servicio_id === data.id) {
                            indice = index;
                        }
                    });

                    jsonServicios.splice(indice,1);
                                
                    sessionStorage.setItem('sessServicios', JSON.stringify(jsonServicios));
                                
                    boton.closest('tr').remove();
                    if (Object.keys(jsonServicios).length != 0) {
                        var sub_total = 0;
                        jsonServicios.forEach(function (row, index) {
                            sub_total += Number(row.servicio_costo);
                        });

                        const divTotal = d.querySelector('#link3 #divTotal');
                        divTotal.innerHTML = numeral(sub_total).format('0,0.00');
                        calcularTotal(sub_total);
                    } else {
                        const trTotal = d.querySelector('#link3 #trTotal');
                        trTotal.remove();
                        calcularTotal();
                    }
                });
            });
        }

        //METODO PARA VALIDAR INSERCIÓN DE DUPLICADOS
        /*const validarServiciosDuplicados = (id) => {
            var json = JSON.parse(sessionStorage.getItem('sessServicios')) || [];

            var x = false;
            json.forEach(function (row) {
                if (row.servicio_id === id) {
                    x = true;
                }
            });
            return x;
        }*/

        const calcularTotal = (subT = 0) => {
            const divTotal = d.querySelector('#link3 #divTotal');
            const impuesto = parseFloat(impuesto_porcentaje) / 100;
            
            if (divTotal != undefined) {
                let subtotal = subT == 0 ? parseFloat(divTotal.innerText.replace(/,/g,'')) : subT;
                let igv;

                if (checkCIGV.checked) {
                    //igv = subtotal - (subtotal / 1.18);
                    igv = subtotal - (subtotal / (1 + impuesto));
                    inputSubTotal.value = numeral(subtotal / (1 + impuesto)).format('0,0.00');
                    inputIgv.value = numeral(igv).format('0,0.00');
                    inputTotal.value = numeral(subtotal).format('0,0.00');
                } else if (checkSIGV.checked) {
                    //igv = subtotal * 0.18;
                    igv = subtotal * impuesto;
                    inputSubTotal.value = numeral(subtotal).format('0,0.00');
                    inputIgv.value = numeral(igv).format('0,0.00');
                    inputTotal.value = numeral(subtotal + igv).format('0,0.00');
                }
            } else {
                inputSubTotal.value = numeral('0').format('0,0.00');
                inputIgv.value = numeral('0').format('0,0.00');
                inputTotal.value = numeral('0').format('0,0.00');
            }
        }

        $('#link3 #selectMoneda').change(function(event) {
            spanMonedaPerito.innerHTML = '';
            spanMonedaViatico.innerHTML = '';
            spanMonedaPerito.innerHTML = selectMoneda.options[selectMoneda.selectedIndex].text;
            spanMonedaViatico.innerHTML = selectMoneda.options[selectMoneda.selectedIndex].text;
        });

        checkCIGV.addEventListener('change', e => {
            if (checkCIGV.checked) {
                calcularTotal();
            }
        });

        checkSIGV.addEventListener('change', e => {
            if (checkSIGV.checked) {
                calcularTotal();
            }
        });

        listServiciosCombo = (tservicio) => {
            const fd = new FormData();
            fd.append('servicio_tipo_id', tservicio)

            ajaxMant('post', `../servicio/searchServicioCombo`, fd)
                .then((respuesta) => {
                    const records = respuesta.servicio_records;

                    if (records != false) {
                        const filas = records.map((item,index) => {

                            const datos =   {
                                servicio_id: item.servicio_id,
                                servicio_nombre: item.servicio_nombre,
                                servicio_descripcion: ''
                            }

                            const objServicio = JSON.stringify(datos);

                            if (index == 0)
                                return `<option value=''></option><option value='${item.servicio_id}' data-datos='${objServicio}'>${item.servicio_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.servicio_id}' data-datos='${objServicio}'>${item.servicio_nombre.toUpperCase()}</option>`
                        }).join('');

                        selectServicio.innerHTML = '';
                        selectServicio.innerHTML = filas;
                    } else {
                        selectServicio.innerHTML = '';
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }
        /*END SERVICIOS*/

        /*BEGIN COSTO PERITO*/
        $('#link4 #selectTipoPerito').change(function(event) {
            if (selectTPerito.value == 2){
                selectPerito.removeAttribute('disabled');
                inputPeritoCosto.removeAttribute('disabled');

                $('#link4 #selectPerito').val('').trigger('change');
                selectPerito.setAttribute('required', '');
                inputPeritoCosto.setAttribute('required', '');
                inputPeritoCosto.value = numeral('0').format('0.00');
            } else {
                selectPerito.setAttribute('disabled', '');
                inputPeritoCosto.setAttribute('disabled', '');

                $('#link4 #selectPerito').val('').trigger('change');
                selectPerito.removeAttribute('required');
                inputPeritoCosto.removeAttribute('required');
                inputPeritoCosto.value = numeral('0').format('0.00');
            }
        });

        inputCostoPerito.addEventListener('change', e => {
            inputCostoPerito.value = numeral(inputCostoPerito.value).format('0.00');
        });

        inputImporteViatico.addEventListener('change', e => {
            inputImporteViatico.value = numeral(inputImporteViatico.value).format('0.00');
        });
        /*END COSTO PERITO*/

        /*BEGIN SEGUIMIENTO*/
        const listSeguimiento = (filters) => {
			if(filters.get('cotizacion_id') != 'undefined') {
				// promesa crea un objeto y este tiene metodos
				ajaxMant('post', `../seguimiento/searchSeguimiento`, filters)
					.then((respuesta) => {
						//console.log(respuesta.cotizacion);
						const registros = respuesta.seguimiento_records;
						if (registros != false) {
							const filas = registros.map((item, index) => {
								let clase = ""
								switch (item.estado_nombre) {
									case 'Aprobado':
										clase = "badge badge-success"
										break;
									case 'Pendiente':
										clase = "badge badge-danger"
										break;
									case 'En Espera':
										clase = "badge badge-warning"
										break;
									default:
										clase = "badge badge-secondary"
										break;
								}
								return `<tr>
											<td>${item.seguimiento_mensaje}</td>
											<td>${item.coordinador_nombre}</td>
											<td>${item.seguimiento_fecha_creacion}</td>
											<td>${item.seguimiento_fech_proxima}</td>
											<td><div class="${clase}">${item.estado_nombre}</div></td>
										</tr>`
							}).join("");

							$('#tbl_seguimiento tbody').html(filas);

							//alert(filters.get('quantity'));
							//paginacion
							linkseleccionado = Number(filters.get('num_page'));
							//total registros
							totalregistros = respuesta.total_records;
							//cantidad de registros por pagina
							cantidadregistros = respuesta.quantity;

							numerolinks = Math.ceil(totalregistros/cantidadregistros);
							paginador = "<ul class='pagination'>";
							if(linkseleccionado > 1)
							{
								paginador += "<li class='page-item'><a id='link' class='page-link' href='1'>&laquo;</a></li>";
								paginador += "<li class='page-item'><a id='link' class='page-link' href='" + (linkseleccionado - 1) +"' '>&lsaquo;</a></li>";
							}
							else
							{
								paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
								paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
							}
							//muestro de los enlaces 
							//cantidad de link hacia atras y adelante
							cant = 2;
							//inicio de donde se va a mostrar los links
							pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
							//condicion en la cual establecemos el fin de los links
							if (numerolinks > cant)
							{
								//conocer los links que hay entre el seleccionado y el final
								pagRestantes = numerolinks - linkseleccionado;
								//defino el fin de los links
								pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
							}
							else 
							{
								pagFin = numerolinks;
							}

							for (var i = pagInicio; i <= pagFin; i++) {
								if (i == linkseleccionado)
									paginador +="<li class='page-item active'><a id='link' data-index='" + (pagInicio - 1) + "' class='page-link' href='" + i + "'>" + i + "</a></li>";
								else
									paginador +="<li class='page-item'><a id='link' data-index='" + (pagInicio - 1) + "' class='page-link' href='" + i + "'>" + i + "</a></li>";
							}
							//condicion para mostrar el boton sigueinte y ultimo
							if(linkseleccionado < numerolinks)
							{
								paginador += "<li class='page-item'><a id='link' class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
								paginador += "<li class='page-item'><a id='link' class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";
							}
							else
							{
								paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
								paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
							}
							
							paginador +="</ul>";

							const spanMostrarRegistros = d.querySelector('#conteo');
							spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
							

							$(".paginacion").html(paginador);

							const link_pagination = d.querySelectorAll('#link');

							link_pagination.forEach(link => {
								link.addEventListener('click', function(e){
									e.preventDefault();
									const num_page = link.getAttribute('href');
									validarData(num_page);
								})
							});
						}
					})
					.catch(() => {
						console.log("Promesa no cumplida")
					})
			}
        }

        const filters = (quantity, link) => {
            let sessCotizacion = JSON.parse(sessionStorage.getItem('cotizacion')) || [];

            const fd = new FormData()
            fd.append('accion', 'cotizacion')
            fd.append('cotizacion_id', sessCotizacion.cotizacion_id)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listSeguimiento(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listSeguimiento(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listCotizacion(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_seguimiento tbody').html('<tr><td colspan="6"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_seguimiento tbody').html('<tr><td colspan="6"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        botonNuevoMensaje.addEventListener('click', e => {
            e.preventDefault();
			let sessCotizacion = JSON.parse(sessionStorage.getItem('cotizacion')) || [];
            if (Object.keys(sessCotizacion).length > 0 ) {
				inputMensaje.value = '';
				inputFechaProxima.value = '';
				$('#mdl_seguimiento').modal({
					'show': true,
					'keyboard': false,
					'backdrop': 'static'
				});
			} else {
                swal({
                    text: 'Generé una cotización para que pueda hacer uso del seguimiento',
                    timer: 3000,
                    buttons: false
                });
            }
        });

        const crudSeguimiento = () => {
            let sessCotizacion = JSON.parse(sessionStorage.getItem('cotizacion')) || [];
            let fecha = new Date();
            let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            let yyyy = fecha.getFullYear();
            let fecha_actual = yyyy + '-' + mm + '-' + dd;

            const fd = new FormData();
            fd.append('cotizacion_id', sessCotizacion.cotizacion_id);
            fd.append('estado_id', sessCotizacion.cotizacion_estado);
            fd.append('mensaje', inputMensaje.value);
            fd.append('fecha_proxima', inputFechaProxima.value);

            ajaxMant('post', `../seguimiento/insertSeguimiento`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });
                        botonCerrarMensaje.click();
                        validarData(1);
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonGuardarMensaje.addEventListener('click', e => {
            if (inputMensaje.value == '' && inputMensaje.value.length <= 5) {
                swal({
                    text: 'ingrese mensaje',
                    timer: 3000,
                    buttons: false
                });
                inputMensaje.focus();
            } else if (inputFechaProxima.value == '') {
                swal({
                    text: 'ingrese mensaje',
                    timer: 3000,
                    buttons: false
                });
                inputFechaProxima.focus();
            } else {
                crudSeguimiento();
            }
        });

        selectQuantity.addEventListener('change', e => {
            validarData(1);
        });
        /*END SEGUIMIENTO*/

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

        /*BEGIN COTIZACIÓN*/
        const botonGrabar = d.querySelector('#linkGrabarCotizacion');
        botonGrabar.addEventListener('click', e => {
            e.preventDefault();
            const jsonInvolucrados = JSON.parse(sessionStorage.getItem('sessInvolucrados')) || [];
            const jsonServicios = JSON.parse(sessionStorage.getItem('sessServicios')) || [];
            const objCotizacion = JSON.parse(sessionStorage.getItem('cotizacion')) || [];

            let rol_cliente = 0;
            let rol_solicitante = 0;
            let rol_propietario = 0;

            if (Object.keys(jsonInvolucrados).length != 0) {
                jsonInvolucrados.forEach(function(row, index) {
                    if (row.rol_id == 1)
                        rol_cliente += 1;

                    if (row.rol_id == 2)
                        rol_solicitante += 1;

                    if (row.rol_id == 3)
                        rol_propietario += 1;
                });
            }

            if (rol_cliente == 0 || rol_solicitante == 0) {
                swal({
                        icon: 'info',
                        title: 'Información',
                        text: rol_cliente == 0 ? 'Ingrese involucrado con rol [Cliente]' : rol_solicitante == 0 ? 'Ingrese involucrado con rol [Solicitante]' : '',
                        timer: 3000,
                        buttons: false
                    });
            } else if (Object.keys(jsonServicios).length == 0) {
                swal({
                        icon: 'info',
                        title: 'Información',
                        text: 'No se a ingresado serrvicio',
                        timer: 3000,
                        buttons: false
                    });
            } else if (inputCotizacionCantidad.value == '' || inputCotizacionCantidad.value == 0) {
                swal({
                        icon: 'info',
                        title: 'Información',
                        text: inputCotizacionCantidad.value == '' ? 'Ingrese cantidad de informes' : 'La cantidad de informe no puede ser 0',
                        timer: 3000,
                        buttons: false
                    });
                inputCantidadInformes.focus();
            } else if (selectTServicio.value == '') {
                swal({
                        icon: 'info',
                        title: 'Información',
                        text: 'Seleccioné tipo de Servicio',
                        timer: 3000,
                        buttons: false
                    });
            } else if (selectCotizacionEstado.value == 3 && inputCotizacionFFinalizacion.value == '') {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingresé fecha de aprobación',
                    timer: 3000,
                    buttons: false
                });
            } else if (selectCotizacionEstado.value == 4 && objCotizacion.cotizacion_estado != 4) {
                swal({
                        title: '¿ Porque se destimara esta cotización ?',
                        content: 'input',
                        icon: 'warning',
                        buttons: true,
                        dangerMode: true
                    })
                    .then((value) => {
						if (value == null) throw 'final'
						
                        if (inputCotizacionId.value == '0')
                            throw { accion: 'validar', tipo: 'cotizacion' };
                        else if (value == '')
                            throw { accion: 'validar', tipo: 'input' };
                        else {
                            let fd = new FormData();
                            fd.append('accion', 'desestimar')
                            fd.append('cotizacion_id', inputCotizacionId.value)
                            fd.append('mensaje', value)
                            fd.append('estado_id', selectCotizacionEstado.value)

                            ajaxMant('post', '../seguimiento/insertSeguimiento', fd)
                                .then((respuesta) => {
                                    if (respuesta.success) {
                                        swal({
                                            icon: 'success',
                                            title: 'Guardado',
                                            text: 'Se ha guardado correctamente ...',
                                            timer: 3000,
                                            buttons: false
                                        });
                                        sessionStorage.clear();
                                        window.location = '../cotizacion';
                                    } else {
                                        throw { accion: 'error', tipo: 'registro' }
                                    }
                                })
                                .catch(() => {
									console.log('Promesa no cumplida');
                                    //throw { accion: 'error', tipo: 'ajax' }
                                })
                        }
                    })
                    .catch(err => {
                        if (err.accion == 'validar') {
                            if (err.tipo == 'cotiziacion') {
                                swal({
                                    text: 'no se puede crear cotización con el estado desestimado'
                                });
                            } else if (err.tipo == 'input') {
                                swal({
                                    text: 'ingresé un motivo válido ...'
                                });
                            }
                        } else if (err.accion == 'error') {
                            if (err.tipo == 'registro') {
                                swal({
                                    text: 'error en el registro ...'
                                });
                            } else if (err.tipo == 'ajax') {
                                console.log('error en el procesamiento (AJAX) ...');
                                swal.stopLoading();
                                swal.close();
                            }
                        } else {
							swal.stopLoading();
                            swal.close();
						}
                    });
            } else if (inputPlazo.value == '' || inputPlazo.value == 0) {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: inputPlazo.value == '' ? 'Ingrese plazo' : 'El plazo no puede ser 0',
                    timer: 3000,
                    buttons: false
                });
                inputPlazo.focus();
            } else if (selectVendedor.value == 0) {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Seleccioné vendedor',
                    timer: 3000,
                    buttons: false
                });
                inputCosto.focus();
            } else {
                /*botonGrabar.classList.add('disabled');
                crudCotizacion();*/
                if (selectCotizacionEstado.value == 3 && objCotizacion.cotizacion_estado == '' || selectCotizacionEstado.value == 3 && objCotizacion.cotizacion_estado == '1') {
                    let mensaje = inputCotizacionCantidad.value == 1 ? 'Nota: Se generará ' + inputCotizacionCantidad.value + ' coordinación...' : 'Nota: Se generarán ' + inputCotizacionCantidad.value + ' coordinaciones...';
                    swal({
                        //icon: 'info',
                        title: '¿Esta seguro de grabar la cotización?',
                        text: mensaje,
                        buttons: true,
                        dangerMode: true
                    }).then((willDelete) => {
                        if (willDelete) {
                            botonGrabar.classList.add('disabled');
                            crudCotizacion();
                        }
                    });
                } else {
                    botonGrabar.classList.add('disabled');
                    crudCotizacion();
                }
            }
        });
        
        const inputFile = d.querySelector('#inputAdjunto');
        const divAdjunto = d.querySelector('#adjunto');
        inputFile.addEventListener('change', e => {   
            /*let sizeByte = inputFile.files[0].size;
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
            }else{*/
                divAdjunto.innerHTML = '';
                divAdjunto.insertAdjacentText('afterbegin', inputFile.files[0].name);
            /*}*/
        });
        
        const crudCotizacion = () => {
            let apiRestMantenimiento = inputCotizacionId.value == 0 ? 'insertCotizacion' : 'updateCotizacion';

            let fecha = new Date();
            let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            let yyyy = fecha.getFullYear();
            let fecha_actual = yyyy + '-' + mm + '-' + dd;

            const diference = (obj1, obj2) => {
                return obj1.filter((a) => {
                    return obj2.filter((b) => {
                        return b.id == a.id;
                    }).length == 0
                })
            }

            const diferenceUpdate = (obj1, obj2) => {
                return obj1.filter((a) => {
                    return obj2.filter((b) => {
                        return b.id == a.id && b.servicio_cantidad == a.servicio_cantidad && b.servicio_costo == a.servicio_costo;
                    }).length == 0
                })
            }

            let sessInvolucrados = JSON.parse(sessionStorage.getItem('sessInvolucrados')) || [];
            let sessInvolucradosOld = JSON.parse(sessionStorage.getItem('sessInvolucradosOld')) || [];
            let sessServicios = JSON.parse(sessionStorage.getItem('sessServicios')) || [];
            let sessServiciosOld = JSON.parse(sessionStorage.getItem('sessServiciosOld')) || [];
			let sessTServicio = JSON.parse(sessionStorage.getItem('cotizacion')) || [];

            const intersect = (item) => {
                return sessInvolucradosOld.find(x => x.id == item.id);
            }
            
            const fd = new FormData();
            fd.append('cotizacion_id', inputCotizacionId.value);
            fd.append('cotizacion_cantidad', inputCotizacionCantidad.value);
            fd.append('cotizacion_actualizacion', checkCotizacionActualizacion.checked == true ? 1 : 0);
            fd.append('tipo_cotizacion_id', selectCotizacionTipo.value);
            fd.append('servicio_tipo_id', $('#selectTServicio').val());
            /* motivo por el cual se esta registrado al involucrado sin contacto */
            fd.append('motivo', inputMotivo.value);
            fd.append('estado_id', selectCotizacionEstado.value);
            fd.append('cotizacion_fecha_solicitud', inputCotizacionFSolicitud.value);
            fd.append('cotizacion_fecha_envio_cliente', inputCotizacionFEnvio.value);
            fd.append('cotizacion_fecha_finalizacion', inputCotizacionFFinalizacion.value);
            fd.append('plazo', inputPlazo.value);
            fd.append('vendedor_id', selectVendedor.value);
            fd.append('vendedor_porcentaje_comision', inputVendedorPorcentaje.value);
            fd.append('desglose_id', selectDesglose.value);
            fd.append('tipo_perito', selectTPerito.value);
            fd.append('perito_id', selectPerito.value);
            fd.append('perito_costo', inputPeritoCosto.value);
            fd.append('viatico_importe', inputImporteViatico.value);
            fd.append('datos_adicionales', inputDatosAdicionales.value);
            fd.append('file', inputFile.files[0]);
            fd.append('involucrados', inputCotizacionId.value != 0 ? JSON.stringify(diference(sessInvolucrados, sessInvolucradosOld)) : sessionStorage.getItem('sessInvolucrados'));
            fd.append('servicios', inputCotizacionId.value != 0 ? JSON.stringify(diference(sessServicios, sessServiciosOld)) : sessionStorage.getItem('sessServicios'));
            fd.append('meneda_id', selectMoneda.value);
            fd.append('igv', checkCIGV.checked == true ? 'con' : 'sin');
            fd.append('moneda_id', selectMoneda.value);
            fd.append('pago_id', inputCotizacionId.value != 0 ? inputPagoId.value : 0)
            fd.append('pago_tipo_cambio', selectMoneda.options[selectMoneda.selectedIndex].dataset.cambio);
            fd.append('pago_subtotal', checkCIGV.checked == true ? Number(inputTotal.value.replace(/,/g,'')) : Number(inputSubTotal.value.replace(/,/g,'')));
            fd.append('pago_total', Number(inputTotal.value.replace(/,/g,'')));
            fd.append('pago_fecha', fecha_actual);
            fd.append('impuesto_id', impuesto_codigo);
            if (inputCotizacionId.value != 0){
                fd.append('cotizacion_fecha_update', fecha_actual);
                fd.append('involucradosInt', JSON.stringify(sessInvolucrados.filter(intersect)));
                fd.append('involucradosOld', JSON.stringify(diference(sessInvolucradosOld, sessInvolucrados)));
                fd.append('serviciosOld', JSON.stringify(diference(sessServiciosOld, sessServicios)));
                fd.append('servicioUpdate', JSON.stringify(diferenceUpdate(sessServicios, sessServiciosOld)));
				fd.append('servicio_tipo_id_old', sessTServicio.servicio_tipo_id)
            }

            ajaxMant('post', `${apiRestMantenimiento}`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success == 'session') {
                        swal({
                            icon: 'error',
                            title: 'Sesión Expirada',
                            //text: 'asd',
                            timer: 3000,
                            buttons: false
                        });
                    } else if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputCotizacionId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });
                        sessionStorage.clear();
                        const loc = window.location;
                        const pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/'));
                        setTimeout(window.location.href = loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length)),10000);
                        botonGrabar.classList.remove('disabled');
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputCotizacionId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                        botonGrabar.classList.remove('disabled');
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const botonCoordinaciones = d.querySelector('#linkCoordinaciones');
        botonCoordinaciones.addEventListener('click', e => {
            e.preventDefault();
            const objCotizacion = JSON.parse(sessionStorage.getItem('cotizacion')) || [];
            if (objCotizacion.length != 0) {
                sessionStorage.clear();
                /*const datosCotizacion = {
                                            cotizacion_id: objCotizacion.cotizacion_id,
                                            cotizacion_correlativo: objCotizacion.cotizacion_correlativo,
                                            moneda_simbolo: selectMoneda.options[selectMoneda.selectedIndex].text,
                                            cotizacion_importe: checkSIGV.checked == true ? inputSubTotal.value : inputTotal.value
                                        };

                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));
                window.location.href = '../coordinacion/mantenimiento';*/

                const data = {
                    cotizacion_codigo: objCotizacion.cotizacion_id,
                    coordinacion_codigo: 0
                };

                sessionStorage.setItem('data', JSON.stringify(data));
                window.location.href = '../coordinacion/coordinaciones/registro';
            }
        });

        const botonGenerarPropuesta = d.querySelector('#linkGenerarPropuesta');
        botonGenerarPropuesta.addEventListener('click', e => {
            e.preventDefault();
            window.open(`generarPropuestaCotizacionWord?cotizacion_codigo=`+inputCotizacionCorrelativo.value);
        });

        const botonGenerarPropuesta2 = d.querySelector('#linkGenerarPropuesta2');
        botonGenerarPropuesta2.addEventListener('click', e => {
            e.preventDefault();
            //window.open(`propuestaWord?cotizacion_codigo=`+inputCotizacionCorrelativo.value);
            window.open(`propuestaWord`);
        });

        botonCancelarGeneral.addEventListener('click', e => {
            e.preventDefault();
            swal({
                title: '¿ Esta seguro de cancelar la operación ?',
                text: 'al cancelar el registro será redireccionado al listado de cotizaciones',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = '../cotizacion';
                }
            });
        });
        /*END COTIZACIÓN*/
    })
})(document);

window.onload = function() {
	$('.js-example-programmatic-multi').select2({
        placeholder: 'Seleccioné tipo de servicio'
    });
	
    $('#link3 #selectMoneda').val('2').trigger('change');
    if (performance.navigation.type == 1 && sessionStorage.getItem('cotizacion') == null) {
        sessionStorage.removeItem('sessInvolucrados');
        sessionStorage.removeItem('sessServicios');
        $('#selectTServicio').val([62]).trigger('change');
        $('#link-tab5').addClass('hidden');
    } else if (sessionStorage.getItem('cotizacion') != null) {
        $('#link-tab5').removeClass('hidden');
        const objCotizacion = JSON.parse(sessionStorage.getItem('cotizacion'));
        servicio_tipo = objCotizacion.servicio_tipo_id;

        document.getElementById('linkGenerarPropuesta').classList.remove('hidden');

        document.getElementById('inputIdCorrelativo').value = objCotizacion.cotizacion_id;
        document.getElementById('inputCotizacionCorrelativo').value = objCotizacion.cotizacion_correlativo;
        document.getElementById('inputCantidadInformes').value = objCotizacion.cotizacion_cantidad_informes;
        document.getElementById('checkActualizacion').checked = objCotizacion.cotizacion_actualizacion == 0 ? false : true;
        $('#link1 #selectTCotizacion').val(objCotizacion.cotizacion_tipo_id).trigger('change');
		
        let arrTServicio = objCotizacion.servicio_tipo_id.split(',');
        $('#selectTServicio').val(arrTServicio).trigger('change');
        document.getElementById('inputDatosAdicionales').value = objCotizacion.cotizacion_datos_adicionales == undefined ? '' : objCotizacion.cotizacion_datos_adicionales;
        $('#link1 #selectCotizacionEstado').val(objCotizacion.cotizacion_estado).trigger('change');
        document.getElementById('inputOrdenServicio').innerHTML = objCotizacion.cotizacion_orden_servicio == '' ? '&nbsp;' : objCotizacion.cotizacion_orden_servicio;
        document.getElementById('inputPlazo').value = objCotizacion.cotizacion_plazo_entrega;

        if(objCotizacion.cotizacion_adjunto != '')
        {
            let adjunto = document.createElement('a');
            adjunto.innerHTML = objCotizacion.cotizacion_adjunto;
            adjunto.title = objCotizacion.cotizacion_adjunto;
            adjunto.href = '../../files/cotizacion/adjuntos/' + objCotizacion.cotizacion_adjunto;
            adjunto.setAttribute('target', '_BLANK');
            document.getElementById('adjunto').insertAdjacentElement('afterbegin', adjunto);
        }

        if(objCotizacion.cotizacion_orden_servicio_adjunto != '')
        {
            let adjunto = document.createElement('a');
            adjunto.innerHTML = objCotizacion.cotizacion_orden_servicio_adjunto;
            adjunto.title = objCotizacion.cotizacion_orden_servicio_adjunto;
            adjunto.href = '../../files/cotizacion/ordenes/' + objCotizacion.cotizacion_orden_servicio_adjunto;
            adjunto.setAttribute('target', '_BLANK');
            document.getElementById('inputOrdenServicioAdjunto').insertAdjacentElement('afterbegin', adjunto);
        }
        
        let arrFSolicitud = objCotizacion.cotizacion_fecha_solicitud != '' ? objCotizacion.cotizacion_fecha_solicitud.split('-') : '';
        document.getElementById('inputFSolicitud').value = arrFSolicitud != '' ? arrFSolicitud[2] + '-' + arrFSolicitud[1] + '-' + arrFSolicitud[0] : '';

        let arrFEnvio = objCotizacion.cotizacion_fecha_envio_cliente != '' ? objCotizacion.cotizacion_fecha_envio_cliente.split('-') : '';
        document.getElementById('inputFEnvio').value = arrFEnvio != '' ? arrFEnvio[2] + '-' + arrFEnvio[1] + '-' + arrFEnvio[0] : '';

        let arrFFinalizacion = objCotizacion.cotizacion_fecha_finalizacion != '' ? objCotizacion.cotizacion_fecha_finalizacion.split('-') : '';
        document.getElementById('inputFFinalizacion').value = arrFFinalizacion != '' ? arrFFinalizacion[2] + '-' + arrFFinalizacion[1] + '-' + arrFFinalizacion[0] : '';

        document.getElementById('spanCoordinador').innerHTML = objCotizacion.coordinador_nombre;
        $('#link2 #selectVendedor').val(objCotizacion.vendedor_id == '' ? 0 : objCotizacion.vendedor_id).trigger('change');
        document.getElementById('inputComisionVendedor').value = objCotizacion.vendedor_porcentaje_comision;
        document.getElementById('inputIdPago').value = objCotizacion.pago_id;
        $('#link3 #selectDesglose').val(objCotizacion.desglose_id).trigger('change');
        $('#link3 #selectMoneda').val(objCotizacion.moneda_id).trigger('change');
        document.getElementById('checkCIGV').checked = objCotizacion.cotizacion_igv_check == 'con' ? true : false;
        document.getElementById('checkSIGV').checked = objCotizacion.cotizacion_igv_check == 'sin' ? true : false;
        document.getElementById('inputSubTotal').value = objCotizacion.cotizacion_subtotal;
        document.getElementById('inputIgv').value = objCotizacion.cotizacion_igv_monto;
        document.getElementById('inputTotal').value = objCotizacion.cotizacion_total;

        $('#link4 #selectTipoPerito').val(objCotizacion.tipo_perito).trigger('change');
        $('#link4 #selectPerito').val(objCotizacion.perito_id).trigger('change');
        document.getElementById('inputCostoPerito').value = objCotizacion.perito_costo;
        if (objCotizacion.tipo_perito == 2) {
            document.querySelector('#link4 #selectPerito').removeAttribute('disabled');
            document.querySelector('#link4 #selectPerito').setAttribute('required', '');

            document.querySelector('#link4 #inputCostoPerito').removeAttribute('disabled');
        }
        document.getElementById('inputImporteViatico').value = objCotizacion.viatico_importe;

        ajaxMant('post', `searchInvServ/${objCotizacion.cotizacion_id}`)
            .then((respuesta) => {
                sessionStorage.setItem('sessInvolucrados', JSON.stringify(respuesta.involucrados));
                sessionStorage.setItem('sessServicios', JSON.stringify(respuesta.servicios));

                sessionStorage.setItem('sessInvolucradosOld', JSON.stringify(respuesta.involucrados));
                sessionStorage.setItem('sessServiciosOld', JSON.stringify(respuesta.servicios));

                listarTableInvolucrados(respuesta.involucrados);
                listarTableServicios(respuesta.servicios);
            })
            .catch(() => {
                console.log("Promesa no cumplida")
            })

        ajaxMant('post', `existeCoordinacion/${objCotizacion.cotizacion_id}`)
            .then((respuesta) => {
                if (respuesta.cantCoordinacion > 0) {
                    document.getElementById('linkCoordinaciones').classList.remove('hidden');
                }
            })
            .catch(() => {
                console.log("Promesa no cumplida")
            })
    } else {
        $('#selectTServicio').val([62]).trigger('change');
        $('#link-tab5').addClass('hidden');
    }
}



