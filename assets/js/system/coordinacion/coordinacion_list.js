(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        
        const apiRestBase = 'coordinacion';
        const apiRestListar = `${apiRestBase}/searchCoordinacion`;
        const apiRestImpresion = `${apiRestBase}/impresion`;
        const apiRestExportExcel = `${apiRestBase}/reportCoordinacionExcel`;
        
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

        const thCoordinacion = d.getElementById('thCoordinacion');

        //METODO PARA LISTAR TABLA
        const listCoordinacion = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta);
                    const registros = respuesta.coordinacion_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td>${thCoordinacion.classList.contains('write') ? item.coordinacion_correlativo : `<a id='lnkVerCoordinacion' href data-indice='${index}'>${item.coordinacion_correlativo}</a>`}</td>
                                        <td>${item.coordinacion_estado_nombre}</td>
                                        <td><div align='left'>${item.solicitante_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.cliente_nombre.toUpperCase()}</div></td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td><div>${item.inspeccion_direccion.toUpperCase()}</div><div>${item.departamento_nombre} <i class='fa fa-play text-danger'></i> ${item.provincia_nombre} <i class='fa fa-play text-danger'></i> ${item.distrito_nombre}</div></td>
                                        <td>${item.perito_nombre.toUpperCase()}</td>
                                        <td>${item.control_calidad_nombre.toUpperCase()}</td>
                                        <td>${item.coordinador_nombre.toUpperCase()}</td>
                                        <!--<td>${item.fecha_entrega_cliente}</td>-->
                                        <td>${item.fecha_entrega}</td>-->
                                        <!--<td>${item.fecha_entrega_cliente_nueva}</td>-->
                                        <td>${item.inspeccion_fecha}</td>
                                        <td>
                                            ${item.riesgo_id == 1 ? '<div class="badge" style="background-color: green;">B A J O</div>' : item.riesgo_id == 2 ? '<div class="badge" style="background-color: yellow; color: black;">M E D I O</div>' : '<div class="badge" style="background-color: red;">A L T O</div>'}
                                            <!--<i class='fa fa-stop fa-lg' style='color: ${item.riesgo_id == 1 ? 'green' : item.riesgo_id == 2 ? 'yellow' : 'red'};'></i>-->
                                        </td>
                                        <!--<td>${item.dias_transcurridos}</td>
                                        <td>${item.coordinacion_estado_id == 1 || item.coordinacion_estado_id == 2 || item.coordinacion_estado_id == 3 || item.coordinacion_estado_id == 7 ? `<i class='fa fa-stop ${item.dias_transcurridos <= 2 ? 'text-success' : item.dias_transcurridos == 3 || item.dias_transcurridos == 4 ? 'text-warning' : 'text-danger' }'></i>` : item.coordinacion_estado_id == 4 ? `<i class='fa fa-stop text-info'></i>` : '' }</td>-->
                                    </tr>`
                        }).join("");

                        $('#tbl_coordinacion tbody').html(filas);

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

                        if (inputCoordinacion.value == "" && selectEstado.value == "" && inputSolicitante.value == "" && inputCliente.value == "" && selectTServicio.value == "" && inputUbicacion.value == "" && selectPerito.value == "" && selectCCalidad.value == "" && selectCoordinador.value == "" && selectRiesgo.value == "" && selectFiltroFecha.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const linkVerCoordinacion = d.querySelectorAll('#lnkVerCoordinacion');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        linkVerCoordinacion.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                const datosCotizacion =
                                            {
                                                coordinacion_id: registros[indice].coordinacion_id,
                                                riesgo_id: registros[indice].riesgo_id,
                                                cotizacion_id: registros[indice].cotizacion_id,
                                                cotizacion_correlativo: registros[indice].cotizacion_correlativo,
                                                moneda_simbolo: registros[indice].moneda_simbolo,
                                                cotizacion_importe: registros[indice].cotizacion_importe,
                                                //BEGIN COORDINACIÓN
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
                                                servicio_tipo_id: registros[indice].servicio_tipo_id,
                                                servicio_tipo_nombre: registros[indice].servicio_tipo_nombre,
                                                tipo_cambio_id: registros[indice].tipo_cambio_id,
                                                tipo_inspeccion_id: registros[indice].tipo_inspeccion_id,
                                                coordinacion_observacion: registros[indice].coordinacion_observacion,
                                                //END COORDINACIÓN
                                                //BEGIN INSPECCIÓN
                                                inspeccion_id: registros[indice].inspeccion_id
                                                //END INSPECCIÓN
                                            };

                                sessionStorage.setItem('dataCotizacion', JSON.stringify(datosCotizacion));
                                window.location.href = 'coordinacion/mantenimiento';
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        //VARIABLES INPUTS
        const inputCoordinacion = d.getElementById('inputCoordinacion');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const inputUbicacion = d.getElementById('inputUbicacion')       
        const inputFiltroFechaDesde = d.getElementById('inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.getElementById('inputFiltroFechaHasta');

        //VARIABLES SELECTS
        const selectEstado = d.getElementById('selectEstado');
        const selectTServicio = d.getElementById('selectTServicio');
        const selectPerito = d.getElementById('selectPerito');
        const selectCCalidad = d.getElementById('selectCCalidad');
        const selectCoordinador = d.getElementById('selectCoordinador');
        const selectRiesgo = d.getElementById('selectRiesgo');
        const selectQuantity = d.getElementById('selectQuantity');
        const selectFiltroFecha = d.getElementById('selectFiltroFecha');

        //VALIABLE BOTON
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.getElementById('lnkExportXls');
        const botonFiltroBuscar = d.getElementById('lnkFiltroBuscar');
        const botonFiltroCancelar = d.getElementById('lnkFiltroCancelar');

        selectFiltroFecha.addEventListener('change', e => {
        	inputFiltroFechaDesde.value = '';
        	inputFiltroFechaHasta.value	= '';
        });

        botonFiltroBuscar.addEventListener('click', e => {
            e.preventDefault();
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
            fd.append('accion', 'filtros')
            fd.append('coordinacion_correlativo', inputCoordinacion.value)
            fd.append('estado_id', selectEstado.value)
            fd.append('solicitante_nombre', inputSolicitante.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('servicio_tipo_id', $('#selectTServicio').val())
            fd.append('coordinacion_ubicacion', inputUbicacion.value)
            fd.append('perito_id', selectPerito.value)
            fd.append('control_calidad_id', selectCCalidad.value)
            fd.append('coordinador_id', selectCoordinador.value)
            fd.append('riesgo_id', selectRiesgo.value)
            fd.append('tipo_fecha', selectFiltroFecha.value)
            fd.append('coordinacion_fecha_desde', inputFiltroFechaDesde.value)
            fd.append('coordinacion_fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listCoordinacion(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listCoordinacion(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listCoordinacion(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_coordinacion tbody').html('<tr><td colspan="15"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_coordinacion tbody').html('<tr><td colspan="15"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputCoordinacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        selectEstado.addEventListener('change', e =>{
            validarData(1);
        });

        inputSolicitante.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        inputCliente.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        $('#selectTServicio').change(function(event) {
            validarData(1);
        });

        inputUbicacion.addEventListener('keyup', e =>{
            if(e.keyCode == 13)
                validarData(1);
        });

        selectPerito.addEventListener('change', e =>{
            validarData(1);
        });

        selectCCalidad.addEventListener('change', e =>{
            validarData(1);
        });

        selectCoordinador.addEventListener('change', e =>{
            validarData(1);
        });

        selectRiesgo.addEventListener('change', e =>{
            validarData(1);
        });

        botonImprimir.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `${apiRestImpresion}`);
            form.setAttribute('target', '_blank');
            
            let object = {
                            coordinacion_correlativo: inputCoordinacion.value,
                            estado_id: selectEstado.value,
                            solicitante_nombre: inputSolicitante.value,
                            cliente_nombre: inputCliente.value,
                            servicio_tipo_id : $('#selectTServicio').val(),
                            coordinacion_ubicacion: inputUbicacion.value,
                            perito_id: selectPerito.value,
                            control_calidad_id: selectCCalidad.value,
                            coordinador_id: selectCoordinador.value,
                            tipo_fecha: selectFiltroFecha.value,
                            coordinacion_fecha_desde: inputFiltroFechaDesde.value,
                            coordinacion_fecha_hasta: inputFiltroFechaHasta.value
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
                            coordinacion_correlativo: inputCoordinacion.value,
                            estado_id: selectEstado.value,
                            solicitante_nombre: inputSolicitante.value,
                            cliente_nombre: inputCliente.value,
                            servicio_tipo_id : $('#selectTServicio').val(),
                            coordinacion_ubicacion: inputUbicacion.value,
                            perito_id: selectPerito.value,
                            control_calidad_id: selectCCalidad.value,
                            coordinador_id: selectCoordinador.value,
                            tipo_fecha: selectFiltroFecha.value,
                            coordinacion_fecha_desde: inputFiltroFechaDesde.value,
                            coordinacion_fecha_hasta: inputFiltroFechaHasta.value
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