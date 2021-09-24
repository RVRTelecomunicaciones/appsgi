(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
    	const objComprobante = JSON.parse(sessionStorage.getItem('dastosComprobante')) || [];

    	if (objComprobante.length == 0) {
    		$('body').html('');
    		swal({
    			title: 'Acceso Denegado',
    			text: 'Usted sera redireccionado al listado de facturaciones',
    			timer: 3000,
    			buttons: false
    		})
    		.then(
    			() => window.location.href = 'facturaciones'
    		);
    	} else {
    		const labelCliente = d.querySelector('#lblCliente');
    		const labelTipoDocumento = d.querySelector('#lblTipoDocumento')
			const labelNroDocumento = d.querySelector('#lblNroDocumento');
			const labelDireccion = d.querySelector('#lblDireccion');
			const labelSubTotal = d.querySelector('#lblSubTotal');
			const labelIgv = d.querySelector('#lblIgv');
			const labelTotal = d.querySelector('#lblTotal');

			const inputFechaVencimiento = d.querySelector('#inputFechaVencimiento');
			const inputFechaEmision = d.querySelector('#inputFechaEmision');

			const selectTipoComprobante = d.querySelector('#selectMoneda');
			const selectMedioPago = d.querySelector('#selectMedioPago');
			const selectMoneda = d.querySelector('#selectMoneda');

			const strNumLetras = d.querySelector('#numero_letras');

			const tableBody = d.querySelector('#tblDescripcion tbody');

			const botonCancelar = d.querySelector('#btn_cancelar');
			
			const divOrdenAll = d.querySelector('#row_orden_all');
			const divNroAprobacion = d.querySelector('#row_nro_aceptacion');
			
			const spanOrdenServicio = d.querySelector('#spanOrdenServicio');
			const spanNroAceptacion = d.querySelector('#spanNroAceptacion');

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

			labelCliente.innerHTML = objComprobante.cliente_facturado_nombre.toUpperCase();
			labelTipoDocumento.innerHTML = objComprobante.cliente_facturado_tipo_documento;
    		labelNroDocumento.innerHTML = objComprobante.cliente_facturado_nro_documento;
    		labelDireccion.innerHTML = objComprobante.cliente_facturado_direccion == '' ? '&nbsp;' : objComprobante.cliente_facturado_direccion;

    		//selectTipoComprobante.value = objComprobante.tipo_comprobante_id;
    		$("#selectTipoComprobante").val(objComprobante.tipo_comprobante_id).trigger('change');
    		selectMoneda.value = objComprobante.moneda_id;
    		

    		tableBody.insertAdjacentHTML('beforeend',`
			    										<tr>
			    											<td>1</td>
			    											<td>
			    												<div align="left">${objComprobante.ad_codigo_tasacion}</div>
			    											</td>
			    											<td>
			    												<div align="left">${objComprobante.ad_concepto}</div>
			    											</td>
			    											<td>UNIDAD</td>
			    											<td>1</td>
			    											<td>
			    												<div align="right">${numeral(objComprobante.ad_subtotal).format('0,0.00')}</div>
			    											</td>
			    											<td>
			    												<div align="right">${numeral(objComprobante.ad_igv).format('0,0.00')}</div>
			    											</td>
			    											<td>
			    												<div align="right">${numeral(objComprobante.ad_total).format('0,0.00')}</div>
			    											</td>
			    										</tr>
										`);
			if (objComprobante.ad_orden_servicio != '') {
				divOrdenAll.classList.remove('hidden');
				spanOrdenServicio.innerHTML = objComprobante.ad_orden_servicio;
				if (objComprobante.ad_nro_aprobacion != '') {
					divNroAprobacion.classList.remove('hidden');
					spanNroAceptacion.innerHTML = objComprobante.ad_nro_aprobacion;
				} else {
					divNroAprobacion.classList.add('hidden');
					spanNroAceptacion.innerHTML = '';
				}
			} else {
				divOrdenAll.classList.add('hidden');
				spanOrdenServicio.innerHTML = '';
			}

    		//OBTENER MONTO EN LETRAS
    		const fd = new FormData();
        	fd.append('numero', objComprobante.ad_total)
        	fd.append('moneda', objComprobante.moneda_nombre)
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'convertirNumeroLetras', fd)
                .then((respuesta) => {
                    //console.log(respuesta);
                    strNumLetras.innerHTML = respuesta.numero.replace('ó', 'Ó');
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })


    		labelSubTotal.innerHTML = numeral(objComprobante.ad_subtotal).format('0,0.00');
    		labelIgv.innerHTML = numeral(objComprobante.ad_igv).format('0,0.00');
    		labelTotal.innerHTML = numeral(objComprobante.ad_total).format('0,0.00');


    		const form = d.querySelector('#frmRegistro');

    		form.addEventListener('submit', e => {
    			e.preventDefault();
    			crudEmision();
    		});

    		const crudEmision = () => {
                const apiRestMantenimiento = 'updateFacturacion';

                let fecha = new Date();
                let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
                let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
                let yyyy = fecha.getFullYear();
                let fecha_actual = yyyy + '-' + mm + '-' + dd;

                const fd = new FormData();
                fd.append('tipo_update', 'F')
                fd.append('ad_id', objComprobante.ad_id)
                fd.append('tipo_comprobante_id', objComprobante.tipo_comprobante_id)
                fd.append('ad_fecha_emision', inputFechaEmision.value)
                fd.append('ad_fecha_vencimiento', inputFechaVencimiento.value)
                fd.append('medio_pago_id', selectMedioPago.value)
                fd.append('estado_id', '2')
                fd.append('ad_fech_update', fecha_actual);

                ajax('post', apiRestMantenimiento, fd)
                    .then((respuesta) => {
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
                                () => window.location.href = 'facturaciones'
                            );
                        } else {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo actualizar, por favor informar al area de sistemas',
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
                      title: '¿ Esta seguro de Cancelar ?',
                      text: 'Al aceptar sera redirecionado al listado de facturaciones',
                      icon: 'warning',
                      buttons: true,
                      dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            window.location.href = 'facturaciones';
                            sessionStorage.clear();
                        }
                    });
            });
    	}
    })
})(document);