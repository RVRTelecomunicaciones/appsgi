(function(d) {
    d.addEventListener("DOMContentLoaded", () => {

        const apiRestListar = `searchRentabilidades`;
        const apiRestExportExcel = `reportPagoVendedorExcel`;

        //VARIABLES INPUTS
        const inputCotizacion = d.querySelector('#inputCotizacionCorrelativo');
        const inputCliente = d.querySelector('#inputCliente');
        const inputFiltroFechaDesde = d.querySelector('#inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.querySelector('#inputFiltroFechaHasta');

        //VARIABLES SELECTS
        const selectTServicio = d.querySelector('#selectTServicio');
        const selectEstado = d.querySelector('#selectEstado');
        const selectVendedor = d.querySelector('#selectVendedor');
        const selectQuantity = d.querySelector('#selectQuantity');
        const selectFiltroEstadoPagoPerito = d.querySelector('#selectFiltroEstadoPagoPerito');

        //VARIABLES BUTTONS
        const botonExportXls = d.querySelector('#lnkExportXls');
        const botonBuscarFiltro = d.querySelector('#lnkFiltroBuscar');
        const botonCancelarFiltro = d.querySelector('#lnkFiltroCancelar');

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
        const listPagoVendedor = (pagoVendedorFilters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, pagoVendedorFilters)
                .then((respuesta) => {
                    const registros = respuesta.pagos_vendedor_records;

                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            let saldo_perito = item.perito_costo - item.perito_monto_abonado
                            let rentabilidad = item.cotizacion_importe_proyecto - item.perito_costo - item.gasto_operativo
                            let comision = rentabilidad * (item.vendedor_porcentaje_comision/100)
                            return `<tr>
                                        <td>${respuesta.init + index }</td>
                                        <td>${item.cotizacion_codigo}</td>
                                        <td>${item.cliente_nombre.toUpperCase()}</td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.cotizacion_importe_proyecto).format('0,0.00')}</div></td>
                                        <td><div align='right'>${item.cotizacion_importe_proyecto == item.cotizacion_importe_proyecto_abonado ? `<div class='badge badge-success'>Cancelado</div>` : `<div class='badge badge-danger'>Pendiente</div>`}</div></td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.perito_costo).format('0,0.00')}</div></td>
                                        <!--<td><div align='right'>${item.moneda_simbolo} ${numeral(saldo_perito).format('0,0.00')}</div></td>-->
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.gasto_operativo).format('0,0.00')}</div></td>
                                        <td><div align='right'>${saldo_perito > 0 ? `` : item.moneda_simbolo+` `+numeral(rentabilidad).format('0,0.00')}</td>
                                        <td>${item.vendedor_nombre.toUpperCase()}</td>
                                        <td>${saldo_perito > 0 || item.vendedor_id == 2 ? `` : item.moneda_simbolo+` `+numeral(comision).format('0,0.00')}</td>
                                        <td>${saldo_perito > 0 || item.vendedor_id == 2 ? `` : item.vendedor_pago_estado_id == 0 ? `<div class='badge badge-danger'>Pendiente</div>` : `<div class='badge badge-success'>Cancelado</div>`}</td>
                                        <td>${item.vendedor_fecha_pago}</td>
                                        <td>
                                            ${saldo_perito > 0 || item.vendedor_id == 2 ? `` : item.vendedor_pago_estado_id == 1 ? `` : `<a id='lnkPagar' href class='btn btn-secondary btn-sm' data-indice='${index}'>Pagar</a>`}
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_pago_vendedor tbody').html(filas);

                        //paginacion
                        linkseleccionado = Number(pagoVendedorFilters.get('num_page'));
                        //total registros
                        totalregistros = respuesta.pagos_vendedor_records.length;
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
                        if (inputCotizacion.value == "" && inputCliente.value == "" && selectTServicio.value == "" && selectEstado.value == "" && selectVendedor.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.pagos_vendedor_records.length + " registros filtrados ( total de registros " + respuesta.total_records +")";

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
                                fd.append('cotizacion_id', registros[indice].cotizacion_id)
                                fd.append('vendedor_pago_estado', '1')
                                fd.append('vendedor_fecha_pago', fecha_actual)


                                ajax('post', `updatePagoVendedor`, fd)
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

        const pagoVendedorFilters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'vendedor')
            fd.append('cotizacion_codigo', inputCotizacion.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('servicio_tipo_id', selectTServicio.value)
            fd.append('estado_rentabilidad_id', selectEstado.value)
            fd.append('vendedor_id', selectVendedor.value)
            fd.append('vendedor_pago_estado', selectFiltroEstadoPagoPerito.value)
            fd.append('fecha_desde', inputFiltroFechaDesde.value)
            fd.append('fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listPagoVendedor(pagoVendedorFilters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listPagoVendedor(pagoVendedorFilters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listPagoVendedor(pagoVendedorFilters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_pago_vendedor tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_pago_vendedor tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        botonBuscarFiltro.addEventListener('click', e => {
            e.preventDefault();
            validarData(1);
            lnkFiltros.click();
        });

        botonCancelarFiltro.addEventListener('click', e => {
            e.preventDefault();
            selectFiltroEstadoPagoPerito.value = '';
            inputFiltroFechaDesde.value = '';
            inputFiltroFechaHasta.value = '';
            validarData(1);
            lnkFiltros.click();
        });

        botonExportXls.addEventListener('click', e => {
            e.preventDefault();
            let object = {
                accion: 'vendedor',
                cotizacion_codigo: inputCotizacion.value,
                cliente_nombre: inputCliente.value,
                servicio_tipo_id: selectTServicio.value,
                estado_rentabilidad_id: selectEstado.value,
                vendedor_id: selectVendedor.value,
                vendedor_pago_estado: selectFiltroEstadoPagoPerito.value,
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

        selectEstado.addEventListener('change', e =>{
            validarData(1);
        });

        selectVendedor.addEventListener('change', e =>{
            validarData(1);
        });
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}