(function(d) {
    d.addEventListener("DOMContentLoaded", () => {

        //const apiRestBase = 'cotizacion';
        const apiRestGenerarPdf = `informacionGenerarPDF`;
        const apiRestListar = `searchCotizacionFacturacion`;
        const apiRestUpdateCotizacion = `updateCotizacionOrden`;
		
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
        const listCotizacionFacturacion = (cotizacionFiltersInformacion) => {
            $('#tbl_cotizacion tbody').html('<tr><td colspan="9"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, cotizacionFiltersInformacion)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.cotizacion;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            let buttons = ``;
                            if (item.ad_existe > 0) {
                                if (item.ad_monto_facturado == item.cotizacion_monto)
                                    buttons = ` <a id='lnkVer' href class='dropdown-item' data-indice='${index}'>Ver Información <span class='badge badge-primary'>${item.ad_existe}</span></a>
                                                <a id='lnkGastos' href class='dropdown-item' data-indice='${index}'>Ingresar Gastos</a>`;
                                else
                                    buttons = ` <a id='lnkGenerar' href class='dropdown-item' data-indice='${index}'>Enviar Información</a>
                                                <a id='lnkVer' href class='dropdown-item' data-indice='${index}'>Ver Información <span class='badge badge-primary'>${item.ad_existe}</span></a>
                                                <a id='lnkGastos' href class='dropdown-item' data-indice='${index}'>Ingresar Gastos</a>`;
                            }
                            else
                                buttons = ` <a id='lnkGenerar' href class='dropdown-item' data-indice='${index}'>Enviar Información</a>
                                            <a id='lnkGastos' href class='dropdown-item' data-indice='${index}'>Ingresar Gastos</a>`;

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td>${item.cotizacion_codigo}</td>
                                        <td><div align='left'>${item.solicitante_nombre.split('|').join('<br>')}</div></td>
                                        <td><div align='left'>${item.cliente_nombre.split('|').join('<br>')}</div></td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td>${item.coordinador_nombre.toUpperCase()}</td>
                                        <td>${item.vendedor_nombre.toUpperCase()}</td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.cotizacion_monto).format('0,0.00')}</div></td>
                                        <td>
                                            <div class='btn-group'>
                                                <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                <div class="dropdown-menu">
                                                    ${buttons}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_cotizacion tbody').html(filas);
                    } else {
                        $('#tbl_cotizacion tbody').html('<tr><td colspan="9">NO HAY REGISTROS</td></tr>');
                    }


                        //paginacion
                        linkseleccionado = Number(cotizacionFiltersInformacion.get('num_page'));
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
                        if (inputCotizacion.value == "" && selectTServicio.value == "" && selectCoordinador.value == "" && selectVendedor.value == "" && inputCliente.value == "" && inputSolicitante.value == "" && inputMonto.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const linkGenerar = d.querySelectorAll('#lnkGenerar');
                        const linkVerInformacion = d.querySelectorAll('#lnkVer');
                        const linkGastos = d.querySelectorAll('#lnkGastos');
                        

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                //validarData(num_page);
                                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value, num_page));
                            })
                        });

                        linkGenerar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                let tituloModal = d.querySelector('#mdl_orden #spanCotizacionCodigo');
                                tituloModal.innerHTML = registros[indice].cotizacion_codigo;

                                const datosCotizacion =
                                            {
                                                cotizacion_id: registros[indice].cotizacion_id,
                                                cotizacion_correlativo: registros[indice].cotizacion_codigo,
                                                servicio_tipo_id: registros[indice].servicio_tipo_id,
                                                servicio_tipo_nombre: registros[indice].servicio_tipo_nombre,
                                                tipo_perito: registros[indice].tipo_perito,
                                                perito_nombre: registros[indice].perito_nombre,
                                                perito_costo: registros[indice].perito_costo,

                                                desglose_id: registros[indice].desglose_id,
                                                moneda_id: registros[indice].moneda_id,
                                                moneda_simbolo: registros[indice].moneda_simbolo,
                                                igv_tipo: registros[indice].cotizacion_igv_check,
                                                cotizacion_monto: registros[indice].cotizacion_monto,
                                                ad_existe: registros[indice].ad_existe > 0 ? true : false,
                                                ad_monto_facturado: registros[indice].ad_monto_facturado,
                                                ad_porcentaje: registros[indice].ad_porcentaje,
                                                ad_porcentaje_num: registros[indice].ad_porcentaje_num,
                                                cotizacion_coordinaciones: registros[indice].cotizacion_coordinaciones,
                                                orden_servicio: registros[indice].orden_servicio
                                            };
                                if(registros[indice].orden_servicio == ''){
                                    swal({
                                        title: 'Cotización ' + registros[indice].cotizacion_codigo,
                                        text: '¿ cuenta con orden de servicio ?',
                                        buttons: {
                                            cancel: {
                                                text: 'No',
                                                visible: true
                                            },
                                            confirm: {
                                                text: 'Si',
                                                value: true,
                                                className: "btn-success",
                                            }
                                        }
                                    })
                                    .then((confirm) => {
                                        if (confirm) {
                                            sessionStorage.setItem('informacionFactura', JSON.stringify(datosCotizacion));
                                            inputCotizacionId.value = registros[indice].cotizacion_id;
                                            inputOrdenServicio.value = '';
                                            inputAdjunto.value = '';
                                            $('#mdl_orden').modal({
                                                'show': true,
                                                'keyboard': false,
                                                'backdrop': 'static'
                                            });
                                        } else {
                                            sessionStorage.setItem('informacionFactura', JSON.stringify(datosCotizacion));
                                            window.location.href = 'informacion_facturacion_mantenimiento';
                                        }
                                    });
                                } else {
                                    sessionStorage.setItem('informacionFactura', JSON.stringify(datosCotizacion));
                                    window.location.href = 'informacion_facturacion_mantenimiento';
                                }
                            });
                        });

                        linkVerInformacion.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                let tituloModal = d.querySelector('#mdl_facturas #spanCotizacionCodigo');
                                tituloModal.innerHTML = registros[indice].cotizacion_codigo;

                                const fd = new FormData()
                                fd.append('accion','informacion')
                                fd.append('cotizacion_id', registros[indice].cotizacion_id)
                                
                                ajax('post', `searchFacturacion`, fd)
                                    .then((respuesta) => {
                                        console.log(JSON.stringify(respuesta.informacion_facturacion));
                                        const informacion_facturacion_records = respuesta.informacion_facturacion;
                                        if (informacion_facturacion_records != false) {
                                            const fila_informacion_facturacion = informacion_facturacion_records.map((item, index) => {
                                                return `<tr>
                                                            <td>${item.tipo_comprobante_nombre.toUpperCase()}</td>
                                                            <td>${item.cliente_facturado_nombre.toUpperCase()}</td>
                                                            <td>${item.cliente_facturado_nro_documento}</td>
                                                            <td>${item.ad_fecha_emision_entrega}</td>
                                                            <td>${item.moneda_simbolo} ${numeral(item.ad_importe).format('0,0.00')}</td>
                                                            <td><div class='${item.estado_id == 1 ? 'badge badge-info' : item.estado_id == 2 ? 'badge badge-warning' : item.estado_id == 3 ? 'badge badge-success' : 'badge badge-danger'}'>${item.estado_nombre}</div></td>
                                                            <td>
                                                                ${item.estado_id != 4 ? `<a id='lnk_pdf' href target='_blank' class='btn btn-danger btn-sm' data-indice='${index}'><i class='fa fa-file-pdf-o'></i> Generar PDF</a>` : ``}
                                                            </td>
                                                        </tr>`
                                            }).join('');

                                            $('#showdataView').html(fila_informacion_facturacion);

                                            const botonVerPdf = d.querySelectorAll('#lnk_pdf');

                                            botonVerPdf.forEach(link => {
                                                link.addEventListener('click', e => {
                                                    e.preventDefault();
                                                    const indice = link.dataset.indice;

                                                    window.open(`${apiRestGenerarPdf}/${informacion_facturacion_records[indice].ad_id}/${informacion_facturacion_records[indice].cliente_facturado_nombre.replace(/[,.&]/g,'')}`);
                                                });
                                            });
                                        }
                                    })
                                    .catch(() => {
                                        console.log("Promesa no cumplida")
                                    })

                                $('#mdl_facturas').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });
                            })
                        });

                        linkGastos.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                var datosCotizacion =
                                            {
                                                cotizacion_id: registros[indice].cotizacion_id,
                                                cotizacion_correlativo: registros[indice].cotizacion_codigo
                                            };

                                sessionStorage.setItem('informacionFacturaGasto', JSON.stringify(datosCotizacion));
                                window.location.href = 'informacion_facturacion_gastos';
                            });
                        });
                    
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

        //VARIABLES SELECTS
        const selectTServicio = d.querySelector('#selectTServicio');
        const selectCoordinador = d.querySelector('#selectCoordinador');
        const selectVendedor = d.querySelector('#selectVendedor');
        const selectQuantity = d.querySelector('#selectQuantity');

        const botonGuardar = d.querySelector('#mdl_orden #btnSave');
        const inputCotizacionId = d.querySelector('#mdl_orden #inputId');
        const inputOrdenServicio = d.querySelector('#mdl_orden #inputOrdenServicio');
        const inputFile = d.querySelector('#inputAdjunto');
        const divAdjunto = d.querySelector('#adjunto');

        const cotizacionFiltersInformacion = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('cotizacion_codigo', inputCotizacion.value)
            fd.append('solicitante_nombre', inputSolicitante.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('servicio_tipo_id', $('#selectTServicio').val())
            fd.append('coordinador_id', selectCoordinador.value)
            fd.append('vendedor_id', selectVendedor.value)
            fd.append('cotizacion_moneda_monto', inputMonto.value)
            /*fd.append('estado_id', '3')*/
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));

        /*const validarData = (link = false) => {
            const respuesta = listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_cotizacion tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_cotizacion tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }*/

        selectQuantity.addEventListener('change', e =>{
            listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        inputCotizacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        inputSolicitante.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        inputCliente.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        /*selectTServicio.addEventListener('change', e =>{
            listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });*/

		$('#selectTServicio').change(function(event) {
            listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        selectCoordinador.addEventListener('change', e =>{
            listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        selectVendedor.addEventListener('change', e =>{
            listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        inputMonto.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listCotizacionFacturacion(cotizacionFiltersInformacion(selectQuantity.value,1));
        });

        inputFile.addEventListener('change', e => {
            divAdjunto.insertAdjacentText('afterbegin', inputFile.files[0].name);
        });

        botonGuardar.addEventListener('click', e => {
            if(inputOrdenServicio.value.trim() == '') {
                inputOrdenServicio.focus();
                swal({
                    text: 'Ingresé orden de servicio ...',
                    timer: 3000,
                    buttons: false
                });
            } else if(inputFile.value == '') {
                swal({
                    text: 'Seleccioné adjunto ...',
                    timer: 3000,
                    buttons: false
                });
            } else {
                botonGuardar.classList.add('disabled');

                const fd = new FormData();
                fd.append('id',inputCotizacionId.value)
                fd.append('correlativo', d.querySelector('#mdl_orden #spanCotizacionCodigo').innerHTML)
                fd.append('orden',inputOrdenServicio.value)
                fd.append('file', inputFile.files[0])

                ajax('post', apiRestUpdateCotizacion, fd)
                    .then((respuesta) => {
                        if (respuesta.success) {
                            botonGuardar.classList.remove('disabled');
                            const objCotizacion = JSON.parse(sessionStorage.getItem('informacionFactura'));
                            objCotizacion['orden_servicio'] = inputOrdenServicio.value;
                            sessionStorage.setItem('informacionFactura', JSON.stringify(objCotizacion));
                            swal({
                                icon: 'succes',
                                title: 'Guardado',
                                text: 'Se guardo orden de servicio ...',
                                timer: 3000,
                                buttons: false
                            })
                            .then(() => window.location.href = 'informacion_facturacion_mantenimiento')
                        } else {
                            swal({
                                icon: 'warning',
                                title: 'Error',
                                text: 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...',
                                timer: 3000,
                                buttons: false
                            });
                            botonGuardar.classList.remove('disabled');
                            //sessionStorage.clear();
                        }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    })
            }
        });

        inputOrdenServicio.addEventListener('input', e => {
            if (inputOrdenServicio.value.length > 30)
                inputOrdenServicio.value = inputOrdenServicio.value.slice(0,30); 
        });
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}