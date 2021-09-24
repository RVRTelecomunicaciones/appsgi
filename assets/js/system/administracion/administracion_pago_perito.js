(function(d) {
    d.addEventListener("DOMContentLoaded", () => {

        const apiRestListar = `searchPagoPeritos`;
        const apiRestImpresion = `impresionPagoPeritos`;
        const apiRestExportExcel = `reportPagoPeritosExcel`;

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


        var groupBy = function (miarray, prop) {
            return miarray.reduce(function(groups, item) {
                var val = item[prop];
                groups[val] = groups[val] || {
                                                cotizacion_id: item.cotizacion_id,
                                                cotizacion_codigo: item.cotizacion_codigo,
                                                cliente_nombre: item.cliente_nombre,
                                                servicio_tipo_nombre: item.servicio_tipo_nombre,
                                                moneda_simbolo: item.moneda_simbolo,
                                                cotizacion_importe_proyecto: item.cotizacion_importe_proyecto,
                                                perito_nombre: item.perito_nombre,
                                                perito_costo: item.perito_costo,
                                                perito_nombre: item.perito_nombre,
                                                cantidad_comprobantes_pendientes: item.cantidad_comprobantes_pendientes
                                            };
                /*groups[val].pv += item.pv;
                groups[val].ac += item.ac;
                groups[val].ev += item.ev;*/
                return groups;
            }, []);
        }

        //METODO PARA LISTAR TABLA
        const listPagoPeritos = (administracionPagoPeritosFilters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, administracionPagoPeritosFilters)
                .then((respuesta) => {
                    const registros = respuesta.pagos_peritos_records;
                    const registros_group = groupBy(registros,'cotizacion_id');
                    if (registros != false) {
                        let i = -1
                        const filas = registros_group.map((item, index) => {
                            i = i + 1
                            return `<tr>
                                        <td>${respuesta.init + i }</td>
                                        <td>${item.cotizacion_codigo}</td>
                                        <td>${item.cliente_nombre.toUpperCase()}</td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.cotizacion_importe_proyecto).format('0,0.00')}</div></td>
                                        <td>${item.perito_nombre.toUpperCase()}</td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.perito_costo).format('0,0.00')}</div></td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id)
                                                        return `<div style='font-weight: bold;' class='mb-1'>${subitem.tipo_comprobante_nombre_correlativo}</div>`
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id)
                                                        return `<div class='${subitem.estado_id == 1 ? 'badge badge-info' : subitem.estado_id == 2 ? 'badge badge-warning' : subitem.estado_id == 3 ? 'badge badge-success' : 'badge badge-danger'} mb-1'>${subitem.estado_nombre}</div>`
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && (subitem.estado_id == 3 || subitem.estado_id == 4))
                                                        return `<div class='mb-1'>${subitem.ad_fecha_emision_entrega}</div>`
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && (subitem.estado_id == 3 || subitem.estado_id == 4))
                                                        return `<div class='mb-1' align='right'>${subitem.moneda_simbolo} ${numeral(subitem.ad_total_facturado).format('0,0.00')}</div>`
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 3 && item.perito_costo != 0)
                                                        return `<div class='mb-1' align='right'>${subitem.moneda_simbolo} ${numeral(subitem.perito_costo_comprobante).format('0,0.00')}</div>`
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 3 && item.perito_costo != 0)
                                                        return `<div class='${subitem.estado_pago_perito_id == 0 ? "badge badge-danger" : "badge badge-success"} mb-1'>${subitem.estado_pago_perito}</div>`
                                                    /*else if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 4)
                                                        return `<div class='mb-1'>&nbsp;</div>`*/
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 3 && item.perito_costo != 0)
                                                        return `<div class='mb-1'>${subitem.estado_pago_perito_id == 0 ? `&nbsp;` : subitem.fecha_pago_perito}</div>`
                                                    /*else if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 4)
                                                        return `<div class='mb-1'>&nbsp;</div>`*/
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                        <td>
                                            ${
                                                registros.map(function(subitem, index) {
                                                    if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 3 && item.perito_costo != 0)
                                                        return `<div style='padding: 0px 5px 5px 5px;'>${subitem.estado_pago_perito_id == 1 ? `&nbsp;` : `<a id='lnkPagar' href class='btn btn-secondary btn-sm' data-indice='${index}' style='padding: 0.35em 0.4em;'> Pagar </a>`}</div>`
                                                    /*else if (item.cotizacion_id == subitem.cotizacion_id && subitem.estado_id == 4)
                                                        return `<div class='mb-1'>&nbsp;</div>`*/
                                                    else
                                                        return ``
                                                }).join("")
                                            }
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_pago_perito tbody').html(filas);

                        //paginacion
                        linkseleccionado = Number(administracionPagoPeritosFilters.get('num_page'));
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

                        for (let i = pagInicio; i <= pagFin; i++) {
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
                        //&& selectTServicio.value == "" && selectCoordinador.value == "" && selectVendedor.value == "" && inputCliente.value == "" && inputSolicitante.value == "" && inputMonto.value == ""
                        if (inputCotizacionCorrelativo.value == "" && inputCliente.value == "" && selectTServicio.value == "" && selectPerito.value == "" && selectEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const link_pagar = d.querySelectorAll('#lnkPagar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        link_pagar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = link.dataset.indice;

                                let fecha = new Date();
                                let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
                                let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
                                let yyyy = fecha.getFullYear();
                                let fecha_actual = yyyy + '-' + mm + '-' + dd;
                
                                const fd = new FormData();
                                fd.append('tipo_update', 'P')
                                fd.append('ad_id', registros[indice].ad_id)
                                fd.append('estado_pago_perito', '1')
                                fd.append('fecha_pago_perito', fecha_actual)


                                ajax('post', `updateFacturacion`, fd)
                                    .then((respuesta) => {
                                        if (respuesta.success) {
                                            swal({
                                                icon: 'success',
                                                title: 'Guardado',
                                                text: 'Se ha guardado correctamente ...',
                                                timer: 3000,
                                                buttons: false
                                            })
                                            .then(
                                                () => validarData(1)
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
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        //VARIABLES INPUTS
        const inputCotizacion = d.querySelector('#inputCotizacionCorrelativo');
        const inputCliente = d.querySelector('#inputCliente');
        const inputFiltroFechaDesde = d.querySelector('#inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.querySelector('#inputFiltroFechaHasta');

        //VARIABLES SELECTS
        const selectTServicio = d.querySelector('#selectTServicio');
        const selectPerito = d.querySelector('#selectPerito');
        const selectEstado = d.querySelector('#selectEstado');
        const selectQuantity = d.querySelector('#selectQuantity');
        const selectFiltroEstadoPagoPerito = d.querySelector('#selectFiltroEstadoPagoPerito');
        const selectFiltroFecha = d.querySelector('#selectFiltroFecha');

        //VARIABLES BUTTONS
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.querySelector('#lnkExportXls');
        const botonBuscarFiltro = d.querySelector('#lnkFiltroBuscar');
        const botonCancelarFiltro = d.querySelector('#lnkFiltroCancelar');

        const administracionPagoPeritosFilters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'full')
            fd.append('cotizacion_codigo', inputCotizacionCorrelativo.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('servicio_tipo_id', selectTServicio.value)
            fd.append('perito_id', selectPerito.value)
            fd.append('estado_id', selectEstado.value)
            fd.append('estado_pago_perito', selectFiltroEstadoPagoPerito.value)
            fd.append('fecha_tipo', selectFiltroFecha.value)
            fd.append('fecha_desde', inputFiltroFechaDesde.value)
            fd.append('fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listPagoPeritos(administracionPagoPeritosFilters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listPagoPeritos(administracionPagoPeritosFilters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listPagoPeritos(administracionPagoPeritosFilters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_pago_perito tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_pago_perito tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        selectFiltroFecha.addEventListener('change', e => {
            if (selectFiltroFecha.value != '') {
                inputFiltroFechaDesde.removeAttribute('disabled');
                inputFiltroFechaHasta.removeAttribute('disabled');
            } else {
                inputFiltroFechaDesde.setAttribute('disabled', '');
                inputFiltroFechaHasta.setAttribute('disabled', '');
            }
        });

        botonBuscarFiltro.addEventListener('click', e => {
            e.preventDefault();
            validarData(1);
            lnkFiltros.click();
        });

        botonCancelarFiltro.addEventListener('click', e => {
            e.preventDefault();
            selectFiltroEstadoPagoPerito.value = '';
            selectFiltroFecha.value = '';
            inputFiltroFechaDesde.value = '';
            inputFiltroFechaHasta.value = '';
            validarData(1);
            lnkFiltros.click();
        });

        botonExportXls.addEventListener('click', e => {
            e.preventDefault();
            let object = {
                accion: 'filtros',
                cotizacion_codigo: inputCotizacion.value,
                cliente_nombre: inputCliente.value,
                servicio_tipo_id: selectTServicio.value,
                perito_id: selectPerito.value,
                estado_id: selectEstado.value,
                estado_pago_perito: selectFiltroEstadoPagoPerito.value,
                fecha_tipo: selectFiltroFecha.value,
                fecha_desde: inputFiltroFechaDesde.value,
                fecha_hasta: inputFiltroFechaHasta.value
            };

            window.open(`${apiRestExportExcel}?data=`+JSON.stringify(object));
        });

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputCotizacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        inputCliente.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        selectTServicio.addEventListener('change', e =>{
            validarData(1);
        });

        selectPerito.addEventListener('change', e =>{
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
                            accion: 'filtros',
                            cotizacion_codigo: inputCotizacion.value,
                            cliente_nombre: inputCliente.value,
                            servicio_tipo_id: selectTServicio.value,
                            perito_id: selectPerito.value,
                            estado_id: selectEstado.value,
                            estado_pago_perito: selectFiltroEstadoPagoPerito.value,
                            fecha_tipo: selectFiltroFecha.value,
                            fecha_desde: inputFiltroFechaDesde.value,
                            fecha_hasta: inputFiltroFechaHasta.value
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
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}