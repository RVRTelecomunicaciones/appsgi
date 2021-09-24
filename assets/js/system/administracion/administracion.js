(function(d) {
    d.addEventListener("DOMContentLoaded", () => {

        const apiRestListar = `searchFacturacionAdministracion`;
        const apiRestUpdate = `updateFacturacion`;
        const apiRestUpdateNota = `updateNotaCredito`;
        const apiRestImpresion = `impresionFacturacion`;
        const apiRestExportExcel = `reportFacturacionExcel`;

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
        const listAdministracionFacturacion = (administracionFacturacionFilters) => {
            $('#tbl_facturacion tbody').html('<tr><td colspan="13"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, administracionFacturacionFilters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.facturacion_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            let clase = ''
                            let buttons = ''
                            let nota_credito = ''
                            switch (item.estado_id) {
                                case '1':
                                    clase = 'badge badge-info'
                                    buttons = `<a id='lnkFacturar' href class='dropdown-item' data-indice='${index}'><i class='fa fa-pencil-square-o'></i> Facturar</a>`
                                    break;
                                case '2':
                                    clase = 'badge badge-warning'
                                    buttons = ` <a id='lnkCancelar' href class='dropdown-item' data-indice='${index}'><i class='fa fa-check-square-o'></i> Cancelar</a>
                                                <a id='lnkAnular' href class='dropdown-item' data-indice='${index}'><i class='fa fa-window-close-o'></i> Anular</a>
                                                <a id='lnkDocumentos' href class='dropdown-item' data-indice='${index}'><i class='fa fa-list-alt'></i> Documentos</a>`
                                    break;
                                case '3':
                                    clase = 'badge badge-success'
                                    buttons = ` <a id='lnkAnular' href class='dropdown-item' data-indice='${index}'><i class='fa fa-window-close-o'></i> Anular</a>
                                                <a id='lnkDocumentos' href class='dropdown-item' data-indice='${index}'><i class='fa fa-list-alt'></i> Documentos</a>`
                                    break;
                                case '4':
                                    clase = 'badge badge-danger'
                                    buttons = ` <a id='lnkDocumentos' href class='dropdown-item' data-indice='${index}'><i class='fa fa-list-alt'></i> Documentos</a>`
                                    nota_credito = item.ad_nota_credito == '0' ? '' : '<div class="badge badge-secondary" style="font-size: 0.75rem;font-weight: bold;">nota de credito</div>'
                                    break;
                                default:
                                    clase = 'badge badge-secondary'
                                    break;
                            }

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td>${item.cotizacion_codigo}</td>
                                        <td>
                                            ${item.tipo_comprobante_nombre_correlativo}
                                        </td>
                                        <td>
                                            <div align='left'>
                                                ${item.cliente_facturado_nombre.toUpperCase()}
                                                <br />
                                                <span style='font-size: 0.7rem; font-weight: bold;'>${item.cliente_facturado_tipo == 'Natural' ? 'DNI: ' : 'RUC: '} ${item.cliente_facturado_nro_documento}</span>
                                                <br />
                                                <span style='font-size: 0.7rem; font-weight: bold;'>Dirección: ${item.cliente_facturado_direccion}</span>
                                            </div>
                                        </td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td>
                                            <div align='left'>
                                                ${item.ad_concepto.toUpperCase()}
                                            </div>
                                        </td>
                                        <td>
                                            ${item.moneda_simbolo} ${numeral(item.ad_subtotal).format('0,0.00')}
                                        </td>
                                        <td>
                                            ${item.moneda_simbolo} ${numeral(item.ad_igv).format('0,0.00')}
                                        </td>
                                        <td><div align='right'>${item.moneda_simbolo} ${numeral(item.ad_total).format('0,0.00')}</div></td>
                                        <td>${item.ad_fecha_emision_entrega}</td>
                                        <td>${item.ad_fecha_pago}</td>
                                        <td>
                                            <div class='${clase}' style='font-size: 0.75rem;font-weight: bold;'>${item.estado_nombre}</div>
                                            ${nota_credito}
                                        </td>
                                        <td>
                                            <div class='btn-group'>
                                                <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                <div class="dropdown-menu">
                                                    ${buttons}
                                                </div>
                                            </div>
                                            <!--<div style='font-size: 1.2rem;'><a id='lnkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a>-->
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_facturacion tbody').html(filas);
                    } else {
                        $('#tbl_facturacion tbody').html('<tr><td colspan="13">NO HAY REGISTROS</td></tr>');
                    }

                        //paginacion
                        linkseleccionado = Number(administracionFacturacionFilters.get('num_page'));
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
                        //&& selectTServicio.value == "" && selectCoordinador.value == "" && selectVendedor.value == "" && inputCliente.value == "" && inputSolicitante.value == "" && inputMonto.value == ""
                        //if (inputCotizacion.value == "" && inputCliente.value == "" && selectTServicio.value == "" && selectPerito.value == "" && selectVendedor.value == "" && inputMonto.value == "" && selectEstado.value == "")
                        if (inputCotizacion.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const link_facturar = d.querySelectorAll('#lnkFacturar');
                        const link_cancelar = d.querySelectorAll('#lnkCancelar');
                        const link_anular = d.querySelectorAll('#lnkAnular');
                        const link_documentos = d.querySelectorAll('#lnkDocumentos');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                //validarData(num_page);
                                listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value, num_page));
                            })
                        });

                        link_facturar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = link.dataset.indice;
                                var datosAdmnistracionFacturacion =
                                            {
                                                ad_id: registros[indice].ad_id,
                                                cotizacion_id: registros[indice].cotizacion_id,
                                                cotizacion_codigo: registros[indice].cotizacion_codigo,
                                                cliente_facturado_nombre: registros[indice].cliente_facturado_nombre,
                                                cliente_facturado_tipo_documento: registros[indice].cliente_facturado_tipo_documento,
                                                cliente_facturado_nro_documento: registros[indice].cliente_facturado_nro_documento,
                                                cliente_facturado_direccion: registros[indice].cliente_facturado_direccion,
                                                ad_codigo_tasacion: registros[indice].ad_codigo_tasacion,
                                                tipo_comprobante_id: registros[indice].tipo_comprobante_id,
                                                tipo_comprobante_correlativo: registros[indice].tipo_comprobante_correlativo,
                                                ad_concepto: registros[indice].ad_concepto,
                                                ad_orden_servicio: registros[indice].ad_orden_servicio,
                                                ad_nro_aprobacion: registros[indice].ad_nro_aprobacion,
                                                moneda_id: registros[indice].moneda_id,
                                                moneda_nombre: registros[indice].moneda_nombre,
                                                ad_subtotal: registros[indice].ad_subtotal,
                                                ad_igv: registros[indice].ad_igv,
                                                ad_total: registros[indice].ad_total
                                            };

                                sessionStorage.setItem('dastosComprobante', JSON.stringify(datosAdmnistracionFacturacion));
                                window.location.href = 'emision';
                            })
                        });

                        link_cancelar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                let fecha = new Date();
                                let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
                                let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
                                let yyyy = fecha.getFullYear();
                                let fecha_actual = yyyy + '-' + mm + '-' + dd;

                                let indice = link.dataset.indice;

                                const fd = new FormData();
                                fd.append('tipo_update', 'C')
                                fd.append('ad_id', registros[indice].ad_id)
                                fd.append('ad_fecha_pago', fecha_actual)
                                fd.append('estado_id', '3')
                                fd.append('ad_fech_update', fecha_actual)

                                ajax('post', apiRestUpdate, fd)
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
                                                () => location.reload()//validarData(1)
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

                        link_anular.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                swal({
                                    title: '¿ Esta seguro de anular el comprobante ?',
                                    text: 'al aceptar, el comprobante quedará invalidado',
                                    icon: 'warning',
                                    buttons: {
                                        cancel: {
                                            text: 'No',
                                            visible: true
                                        },
                                        confirm: {
                                            text: 'Si',
                                            value: true,
                                            className: "btn-danger",
                                        }
                                    }
                                })
                                .then((confirm) => {
                                    if (confirm) {
                                        let fecha = new Date();
                                        let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
                                        let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
                                        let yyyy = fecha.getFullYear();
                                        let fecha_actual = yyyy + '-' + mm + '-' + dd;

                                        let indice = link.dataset.indice;

                                        const fd = new FormData();
                                        fd.append('tipo_update', 'A')
                                        fd.append('ad_id', registros[indice].ad_id)
                                        fd.append('cotizacion_id', registros[indice].cotizacion_id)
                                        fd.append('estado_id', '4')
                                        fd.append('ad_fech_update', fecha_actual)

                                        ajax('post', apiRestUpdate, fd)
                                            .then((respuesta) => {
                                                if (respuesta.success == true) {
                                                    swal({
                                                        title: '¿ Emitir nota de crédito ?',
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
                                                            const fdNota = new FormData();
                                                            fdNota.append('ad_id', registros[indice].ad_id)
                                                            fdNota.append('ad_nota_credito', 1)

                                                            ajax('post', apiRestUpdateNota, fdNota)
                                                                .then((respuestaNota) => {
                                                                    if (respuestaNota.success) {
                                                                        swal({
                                                                            icon: 'success',
                                                                            title: 'Guardado',
                                                                            text: 'Se anulo el comprobante y se emitio nota de crédito ...',
                                                                            timer: 2000,
                                                                            buttons: false
                                                                        })
                                                                        .then(
                                                                            () => validarData(1)
                                                                        );
                                                                    } else {
                                                                        validarData(1);
                                                                    }
                                                                })
                                                                .catch(() => {
                                                                    console.log("Promesa no cumplida")
                                                                })
                                                        } else {
                                                            swal({
                                                                icon: 'success',
                                                                title: 'Guardado',
                                                                text: 'Se anulo el comprobante ...',
                                                                timer: 2000,
                                                                buttons: false
                                                            })
                                                            .then(
                                                                () => validarData(1)
                                                            );
                                                        }
                                                    })
                                                } else if (respuesta.success == 'estado_perito') {
                                                    swal({
                                                        text: 'No se puede anular el comprobante ...',
                                                        timer: 3000,
                                                        buttons: false
                                                    });
                                                } else if (respuesta.success == 'estado_vendedor') {
                                                    swal({
                                                        text: 'No se puede anular el comprobante ...',
                                                        timer: 3000,
                                                        buttons: false
                                                    });
                                                } else {
                                                    swal({
                                                        icon: 'error',
                                                        title: 'Error',
                                                        text: 'el comprobante no se puedo anular ...',
                                                        timer: 3000,
                                                        buttons: false
                                                    });
                                                }
                                            })
                                            .catch(() => {
                                                console.log("Promesa no cumplida")
                                            })
                                    }
                                });
                            })
                        });

                        link_documentos.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = link.dataset.indice;
                                let inputFacturacionId = d.querySelector('#mdl_documentos #inputId');
                                let tituloModal = d.querySelector('#mdl_documentos #spanFacturacion');
                                let tipoDocumento = d.querySelector('#mdl_documentos #inputTipoDocumento');

                                tituloModal.innerHTML = registros[indice].tipo_comprobante_nombre_correlativo;
                                inputFacturacionId.value = registros[indice].ad_id;
                                tipoDocumento.value = registros[indice].tipo_comprobante_nombre;


                                divAdjuntoXml.innerHTML = '';
                                divAdjuntoPdf.innerHTML = '';
                                if (registros[indice].ad_adjunto_xml != '') {
                                    let adjunto = document.createElement('a');
                                    adjunto.innerHTML = registros[indice].ad_adjunto_xml;
                                    adjunto.title = registros[indice].ad_adjunto_xml;
                                    adjunto.href = '../files/facturacion/' + registros[indice].tipo_comprobante_nombre.toLowerCase() + '/' + registros[indice].tipo_comprobante_nombre_correlativo + '/' + registros[indice].ad_adjunto_xml;
                                    adjunto.setAttribute('id', 'lnkAdjuntoXml');
                                    adjunto.setAttribute('target', '_blank');
                                    divAdjuntoXml.insertAdjacentElement('afterbegin', adjunto);
                                }

                                if (registros[indice].ad_adjunto_pdf != '') {
                                    let adjunto = document.createElement('a');
                                    adjunto.innerHTML = registros[indice].ad_adjunto_pdf;
                                    adjunto.title = registros[indice].ad_adjunto_pdf;
                                    adjunto.href = '../files/facturacion/' + registros[indice].tipo_comprobante_nombre.toLowerCase() + '/' + registros[indice].tipo_comprobante_nombre_correlativo + '/' + registros[indice].ad_adjunto_pdf;
                                    adjunto.setAttribute('id', 'lnkAdjuntoPdf');
                                    adjunto.setAttribute('target', '_blank');
                                    divAdjuntoPdf.insertAdjacentElement('afterbegin', adjunto);
                                }

                                $('#mdl_documentos').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });
                            })
                        });

                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        //VARIABLES INPUTS
        const inputCotizacion = d.querySelector('#inputCotizacion');
        const inputFacturaCorrelativo = d.querySelector('#inputCorrelativoFactura');
        const inputCliente = d.querySelector('#inputCliente');
        const inputMonto = d.querySelector('#inputMonto');
        const inputFileXml = d.querySelector('#inputAdjuntoXml');
        const inputFilePdf = d.querySelector('#inputAdjuntoPdf');
        const inputFiltroFechaDesde = d.querySelector('#inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.querySelector('#inputFiltroFechaHasta');

        //VARIABLES SELECTS
        const selectTServicio = d.querySelector('#selectTServicio');
        const selectPerito = d.querySelector('#selectPerito');
        const selectVendedor = d.querySelector('#selectVendedor');
        const selectEstado = d.querySelector('#selectEstado');
        const selectQuantity = d.querySelector('#selectQuantity');
        const selectFiltroEstadoPagoPerito = d.querySelector('#selectFiltroEstadoPagoPerito');
        const selectFiltroFecha = d.querySelector('#selectFiltroFecha');

        //VARIABLES BUTTONS
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.querySelector('#lnkExportXls');
        const botonCerrarModal = d.querySelector('#mdl_documentos #btnCerrar');
        const botonBuscarFiltro = d.querySelector('#lnkFiltroBuscar');
        const botonCancelarFiltro = d.querySelector('#lnkFiltroCancelar');

        //OTRAS VARIABLES
        const form = d.querySelector('#mdl_documentos #formDocumentos');
        const divAdjuntoXml = d.querySelector('#adjuntoXml');
        const divAdjuntoPdf = d.querySelector('#adjuntoPdf');

        const administracionFacturacionFilters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('cotizacion_codigo', inputCotizacion.value)
            fd.append('factura_correlativo', inputFacturaCorrelativo.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('servicio_tipo_id', selectTServicio.value)
            fd.append('estado_id', selectEstado.value)
            fd.append('fecha_tipo', selectFiltroFecha.value)
            fd.append('fecha_desde', inputFiltroFechaDesde.value)
            fd.append('fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));

        /*const validarData = (link = false) => {
            const respuesta = listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_facturacion tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_facturacion tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }*/

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
            listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
            lnkFiltros.click();
        });

        botonCancelarFiltro.addEventListener('click', e => {
            e.preventDefault();
            selectFiltroFecha.value = '';
            inputFiltroFechaDesde.value = '';
            inputFiltroFechaHasta.value = '';
            listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
            lnkFiltros.click();
        });

        selectQuantity.addEventListener('change', e =>{
            listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        inputCotizacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        inputFacturaCorrelativo.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        inputCliente.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        selectTServicio.addEventListener('change', e =>{
            listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        selectEstado.addEventListener('change', e =>{
            listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1));
        });

        
        inputFileXml.addEventListener('change', e => {   
            let sizeByte = inputFileXml.files[0].size;
            let siezekiloByte = parseInt(sizeByte / 1024);
            
            if (siezekiloByte >= 2048) {
                inputFileXml.value = '';
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
            }else{
                if (inputFileXml.files[0].name.substr(-3) != 'xml') {
                    inputFileXml.value = '';
                    swal({
                        text: 'Seleccioné archivo xml',
                        timer: 3000,
                        buttons: false
                    });
                } else {
                    divAdjuntoXml.innerHTML = '';
                    divAdjuntoXml.insertAdjacentText('afterbegin', inputFileXml.files[0].name);
                }
            }
        });

        inputFilePdf.addEventListener('change', e => {   
            let sizeByte = inputFilePdf.files[0].size;
            let siezekiloByte = parseInt(sizeByte / 1024);
            
            if (siezekiloByte >= 2048) {
                inputFilePdf.value = '';
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
            }else{
                if (inputFilePdf.files[0].name.substr(-3) != 'pdf') {
                    inputFilePdf.value = '';
                    swal({
                        text: 'Seleccioné archivo pdf',
                        timer: 3000,
                        buttons: false
                    });
                } else {
                    divAdjuntoPdf.innerHTML = '';
                    divAdjuntoPdf.insertAdjacentText('afterbegin', inputFilePdf.files[0].name);
                }
            }
        });

        form.addEventListener('submit', e => {
            e.preventDefault();
            let inputFacturacionId = d.querySelector('#mdl_documentos #inputId');
            let tituloModal = d.querySelector('#mdl_documentos #spanFacturacion');
            let tipoDocumento = d.querySelector('#mdl_documentos #inputTipoDocumento');

            const fd = new FormData();
            fd.append('ad_id', inputFacturacionId.value)
            fd.append('fileXml', inputFileXml.files[0])
            fd.append('filePdf', inputFilePdf.files[0])
            fd.append('tipo_documento', tipoDocumento.value)
            fd.append('documento_correlativo', tituloModal.innerHTML)
            /*fd.append('nameXml', d.querySelector('#mdl_documentos #lnkAdjuntoXml').getAttribute('title') || '')
            fd.append('namePdf', d.querySelector('#mdl_documentos #lnkAdjuntoPdf').getAttribute('title') || '')*/

            ajax('post', `updateDocumentos`, fd)
                .then((respuesta) => {
                    console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        divAdjuntoXml.innerHTML = '';
                        divAdjuntoPdf.innerHTML = '';
                        botonCerrarModal.click();
                        
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        })
                        .then(
                                () => listAdministracionFacturacion(administracionFacturacionFilters(selectQuantity.value,1))
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
                            factura_correlativo: inputFacturaCorrelativo.value,
                            cliente_nombre: inputCliente.value,
                            servicio_tipo_id: selectTServicio.value,
                            estado_id: selectEstado.value,
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

        botonExportXls.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `${apiRestExportExcel}`);
            form.setAttribute('target', '_blank');
            
            let object = {
                            accion: 'filtros',
                            cotizacion_codigo: inputCotizacion.value,
                            factura_correlativo: inputFacturaCorrelativo.value,
                            cliente_nombre: inputCliente.value,
                            servicio_tipo_id: selectTServicio.value,
                            estado_id: selectEstado.value,
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