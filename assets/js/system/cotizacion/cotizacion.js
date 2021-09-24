(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        
        const apiRestBase = 'cotizacion';
        const apiRestListar = `${apiRestBase}/searchCotizacion`;
        const apiRestImpresion = `${apiRestBase}/impresion`;
        const apiRestExportExcel = `${apiRestBase}/reportCotizacionExcel`;
		
		$('.js-example-programmatic-multi').select2({
            placeholder: 'Seleccioné tipo de servicio',
            dropdownAutoWidth : true
        });

        //METODO AJAX PARA OBTENER DATOS
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== "get" && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        //METODO PARA LISTAR TABLA
        const listCotizacion = (filters) => {
            // promesa crea un objeto y este tiene metodos
            $('#tbl_cotizacion tbody').html('<tr><td colspan="13"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.cotizacion;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            let clase = ""
							let indiceComa = item.sercivio_tipo_nombre.lastIndexOf(',')
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
                                        <td>${respuesta.init+index}</td>
                                        <td>${lnkNuevo.classList.contains('hidden') ? item.cotizacion_codigo : `<a id='lnkVerCotizacion' href data-indice='${index}'>${item.cotizacion_codigo}</a>`}</td>
                                        <td>${indiceComa > 0 ? item.sercivio_tipo_nombre.substr(0,indiceComa) + '  Y ' + item.sercivio_tipo_nombre.substr(indiceComa + 2) : item.sercivio_tipo_nombre}</td>
                                        <td>${item.coordinador_nombre.toUpperCase()}</td>
                                        <td>${item.vendedor_nombre.toUpperCase()}</td>
                                        <td><div align='left'>${item.cliente_nombre.split('|').join('<br>').toUpperCase()}</div></td>
                                        <td><div align='left'>${item.solicitante_nombre.split('|').join('<br>').toUpperCase()}</div></td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.cotizacion_monto).format('0,0.00')}</div></td>
                                        <td>${item.cotizacion_fecha_solicitud}</td>
                                        <td>${item.cotizacion_fecha_envio_cliente}</td>
                                        <td>${item.cotizacion_fecha_finalizacion}</td>
                                        <td>${item.cotizacion_fecha_desestimacion}</td>
                                        <td><div class="${clase}">${item.estado_nombre}</div></td>
                                    </tr>`
                        }).join("");

                        $('#tbl_cotizacion tbody').html(filas);

                        //alert(filters.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filters.get('num_page'));
                        //total registros
                        totalregistros = respuesta.total_records_find;
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
                        //if (inputCotizacion.value == "" && selectTServicio.value == "" && selectCoordinador.value == "" && selectVendedor.value == "" && inputCliente.value == "" && inputSolicitante.value == "" && inputMonto.value == "" && inputFechaSolicitud.value == "" && inputFechaEnvio.value == "" && inputFechaAprovacion.value == "" && selectEstado.value == "")
                        if (inputCotizacion.value == "" && selectTServicio.value == "" && selectCoordinador.value == "" && selectVendedor.value == "" && inputCliente.value == "" && inputSolicitante.value == "" && inputMonto.value == "" && selectEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const linkVerCotizacion = d.querySelectorAll('#lnkVerCotizacion');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        linkVerCotizacion.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                var datosCotizacion =
                                            {
                                                cotizacion_id: registros[indice].cotizacion_id,
                                                cotizacion_correlativo: registros[indice].cotizacion_codigo,
                                                cotizacion_cantidad_informes: registros[indice].cotizacion_cantidad_informe,
                                                cotizacion_actualizacion: registros[indice].cotizacion_actualizacion,
                                                cotizacion_tipo_id: registros[indice].tipo_cotizacion_id,
                                                servicio_tipo_id: registros[indice].servicio_tipo_id,
                                                cotizacion_estado: registros[indice].estado_id,
                                                cotizacion_adjunto: registros[indice].cotizacion_adjunto,
                                                cotizacion_fecha_solicitud: registros[indice].cotizacion_fecha_solicitud,
                                                cotizacion_fecha_envio_cliente: registros[indice].cotizacion_fecha_envio_cliente,
                                                cotizacion_fecha_finalizacion: registros[indice].cotizacion_fecha_finalizacion,

                                                coordinador_nombre: registros[indice].coordinador_nombre,
                                                vendedor_id: registros[indice].vendedor_id,
                                                vendedor_porcentaje_comision: registros[indice].vendedor_porcentaje_comision,

                                                pago_id: registros[indice].pago_id,
                                                desglose_id: registros[indice].desglose_id,
                                                moneda_id: registros[indice].moneda_id,

                                                cotizacion_igv_check: registros[indice].cotizacion_igv_check,
                                                cotizacion_subtotal: registros[indice].cotizacion_monto,
                                                cotizacion_igv_monto: Number(registros[indice].cotizacion_total) - Number(registros[indice].cotizacion_monto),
                                                cotizacion_total: registros[indice].cotizacion_total,
                                                cotizacion_orden_servicio:registros[indice].cotizacion_orden_servicio,
                                                cotizacion_orden_servicio_adjunto:registros[indice].cotizacion_orden_servicio_adjunto,
                                                cotizacion_plazo_entrega: registros[indice].cotizacion_plazo_entrega,
                                                tipo_perito: registros[indice].tipo_perito,
                                                perito_id: registros[indice].perito_id,
                                                perito_costo: registros[indice].perito_costo,
                                                viatico_importe: registros[indice].viatico_importe,
                                                cotizacion_datos_adicionales: registros[indice].datos_adicionales
                                            };

                                sessionStorage.setItem('cotizacion', JSON.stringify(datosCotizacion));
                                window.location.href = 'cotizacion/mantenimiento';
                            });
                        });
                    } else {
                        $('#tbl_cotizacion tbody').html('<tr><td colspan="13"><div style="font-size: 1rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputCotizacion = d.querySelector('#inputCotizacion');
        const inputCliente = d.querySelector('#inputCliente');
        const inputSolicitante = d.querySelector('#inputSolicitante');
        const inputMonto = d.querySelector('#inputMonto');
        const inputFechaSolicitud = d.querySelector('#inputFechaSolicitud');
        const inputFechaEnvio = d.querySelector('#inputFechaEnvio');
        const inputFechaAprovacion = d.querySelector('#inputFechaAprovacion');
        const inputFiltroFechaDesde = d.querySelector('#inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.querySelector('#inputFiltroFechaHasta');

        //VARIABLES SELECTS
        const selectTServicio = d.querySelector('#selectTServicio');
        const selectCoordinador = d.querySelector('#selectCoordinador');
        const selectVendedor = d.querySelector('#selectVendedor');
        const selectEstado = d.querySelector('#selectEstado');
        const selectQuantity = d.querySelector('#selectQuantity');
        const selectFiltroFecha = d.querySelector('#selectFiltroFecha');

        //VALIABLE BOTON
        const botonNuevoCotizacion = d.querySelector('#lnkNuevo');
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.querySelector('#lnkExportXls');
        const botonFiltroBuscar = d.querySelector('#lnkFiltroBuscar');
        const botonFiltroCancelar = d.querySelector('#lnkFiltroCancelar');

        botonNuevoCotizacion.addEventListener('click', e => {
            e.preventDefault();
            sessionStorage.clear();
            window.location.href = 'cotizacion/mantenimiento';
        });

        botonFiltroBuscar.addEventListener('click', e => {
            e.preventDefault();
            /*if (selectFiltroFecha.value == '') {
                swal({
                    text: `Seleccione Tipo de Fecha`,
                    timer: 3000,
                    buttons: false
                });
            } else if (selectFiltroFecha.value != '' && inputFiltroFechaDesde.value == '' && inputFiltroFechaHasta.value == '') {
                swal({
                    text: `Seleccioné rango de fechas`,
                    timer: 3000,
                    buttons: false
                });
                inputFiltroFechaDesde.value = '';
            } else if (selectFiltroFecha.value != '' && inputFiltroFechaDesde.value > inputFiltroFechaHasta.value) {
                swal({
                    text: `Fecha de inicio [Desde] no debe ser mayor a la fecha final [Hasta] o no ha selecciono fecha final`,
                    timer: 3000,
                    buttons: false
                });
                inputFiltroFechaDesde.value = '';
            } else {
                validarData(1);
                lnkFiltros.click();
            }*/

            validarData(1);
            lnkFiltros.click();
        });

        botonFiltroCancelar.addEventListener('click', e => {
            e.preventDefault();
            selectFiltroFecha.value = '';
            inputFiltroFechaDesde.value = '';
            inputFiltroFechaHasta.value = '';
            validarData(1);
            lnkFiltros.click();
        });

        const filters = (quantity, link) => {
            const fd = new FormData()
            fd.append('cotizacion_codigo', inputCotizacion.value)
            fd.append('servicio_tipo_id', $('#selectTServicio').val())
            fd.append('coordinador_id', selectCoordinador.value)
            fd.append('vendedor_id', selectVendedor.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('solicitante_nombre', inputSolicitante.value)
            fd.append('cotizacion_moneda_monto', inputMonto.value)
            fd.append('tipo_fecha', selectFiltroFecha.value)
            fd.append('cotizacion_fecha_desde', inputFiltroFechaDesde.value)
            fd.append('cotizacion_fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('estado_id', selectEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listCotizacion(filters(selectQuantity.value,1));

        const validarData = (link = false) => {

            const fd = filters(selectQuantity.value, link)
            if (montoIcon.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'monto')
                fd.append('order_type', 'DESC')
            } else if (montoIcon.classList.contains('fa-sort-amount-asc')) {
                fd.append('order', 'monto')
                fd.append('order_type', 'ASC')
            }
            listCotizacion(fd);
        }

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputCotizacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

		$('#selectTServicio').change(function(event) {
            validarData(1);
        });

        selectCoordinador.addEventListener('change', e =>{
            validarData(1);
        });

        selectVendedor.addEventListener('change', e =>{
            validarData(1);
        });

        inputCliente.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        inputSolicitante.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        inputMonto.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        selectEstado.addEventListener('change', e =>{
            validarData(1);
        });

        botonImprimir.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `${apiRestImpresion}`);
            form.setAttribute('target', '_blank');
            
            let object = {
                            cotizacion_codigo: inputCotizacion.value,
                            servicio_tipo_id : $('#selectTServicio').val().toString(),
                            coordinador_id: selectCoordinador.value,
                            vendedor_id: selectVendedor.value,
                            cliente_nombre: inputCliente.value,
                            solicitante_nombre: inputSolicitante.value,
                            cotizacion_moneda_monto: inputMonto.value,
                            tipo_fecha: selectFiltroFecha.value,
                            cotizacion_fecha_desde: inputFiltroFechaDesde.value,
                            cotizacion_fecha_hasta: inputFiltroFechaHasta.value,
                            estado_id: selectEstado.value
                        };


            let inputFormCoordinacion = d.createElement('input');
            inputFormCoordinacion.type = 'text';
            inputFormCoordinacion.name = 'data';
            inputFormCoordinacion.value = JSON.stringify(object);
            form.appendChild(inputFormCoordinacion);

            d.body.appendChild(form);
            form.submit();
            d.body.removeChild(form);
        });

        botonExportXls.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `${apiRestExportExcel}`);
            form.setAttribute('target', '_blank');
            
            let object = {
                            cotizacion_codigo: inputCotizacion.value,
                            servicio_tipo_id : $('#selectTServicio').val().toString(),
                            //servicio_tipo_id: selectTServicio.value,
                            coordinador_id: selectCoordinador.value,
                            vendedor_id: selectVendedor.value,
                            cliente_nombre: inputCliente.value,
                            solicitante_nombre: inputSolicitante.value,
                            cotizacion_moneda_monto: inputMonto.value,
                            tipo_fecha: selectFiltroFecha.value,
                            cotizacion_fecha_desde: inputFiltroFechaDesde.value,
                            cotizacion_fecha_hasta: inputFiltroFechaHasta.value,
                            estado_id: selectEstado.value
                        };

            let inputFormCoordinacion = d.createElement('input');
            inputFormCoordinacion.type = 'text';
            inputFormCoordinacion.name = 'data';
            inputFormCoordinacion.value = JSON.stringify(object);
            form.appendChild(inputFormCoordinacion);

            d.body.appendChild(form);
            form.submit();
            d.body.removeChild(form);
        });

        const montoSort = d.getElementById('montoSort');
        const montoIcon = d.getElementById('montoIcon');

        montoSort.addEventListener('click', e => {
            if (montoIcon.classList.contains('fa-sort-amount-desc')) {
                montoIcon.classList.remove('fa-sort-amount-desc');
                montoIcon.classList.add('fa-sort-amount-asc');
            } else {
                montoIcon.classList.remove('fa-sort-amount-asc');
                montoIcon.classList.add('fa-sort-amount-desc');
            }
            validarData(1);
        })
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}