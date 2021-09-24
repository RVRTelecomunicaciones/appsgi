(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        sessionStorage.clear();
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true,
            dropdownAutoWidth : true
        });

        $('.select2-diacritics2').select2({
        	theme: 'classic'
        });

        $('.select2-container--classic').css('width', '100%');

        const apiRestListar = 'tasacion/searchTasaciones';

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

        const labelCoordinacionCorrelativo = d.getElementById('lblCoordinacionCorrelativo');
        const labelSolicitante = d.getElementById('lblSolicitante');
        const labelPropietario = d.getElementById('lblPropietario');
        const labelCliente = d.getElementById('lblCliente');

        const inputCoordinacion = d.getElementById('inputCoordinacion');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
		
		const selectPerito = d.getElementById('selectPerito');

        const listTasacion = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td>${item.coordinacion_correlativo}</td>
                                        <td><div align='left'>${item.solicitante_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.cliente_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.perito_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.control_calidad_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.coordinacion_fecha}</div></td>
                                        <td><a id='lnkRegistro' href class='btn btn-secondary btn-sm' data-indice='${index}'>Registrar como</a></td>
                                    </tr>`
                        }).join("");

                        $('#tbl_tasacion tbody').html(filas);

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

                        if (inputCoordinacion.value == "" && inputSolicitante.value == "" && inputCliente.value == "" && selectPerito.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const link_registro = d.querySelectorAll('#lnkRegistro');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        link_registro.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                $('#mdlTipoTasacion').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });

                                /*const labelCotizacionId = d.getElementById('lblCotizacionId');
                                const labelCoordinacionId = d.getElementById('lblCoordinacionId');*/

                                /*labelCotizacionId.innerHTML = registros[indice].cotizacion_id;
                                labelCoordinacionId.innerHTML = registros[indice].coordinacion_id;*/
                                labelCoordinacionCorrelativo.innerHTML = registros[indice].coordinacion_correlativo;

                                labelSolicitante.innerHTML = registros[indice].solicitante_nombre;
                                labelPropietario.innerHTML = registros[indice].cliente_nombre;
                                labelCliente.innerHTML = registros[indice].cliente_nombre;
                            })
                        });       
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        
        
        //const inputFiltroFechaDesde = d.getElementById('inputFiltroFechaDesde');
        //const inputFiltroFechaHasta = d.getElementById('inputFiltroFechaHasta');

        /*const selectPerito = d.getElementById('selectPerito');
        const selectCCalidad = d.getElementById('selectCCalidad');*/

        /*const botonFiltros = d.getElementById('lnkFiltros');
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.getElementById('lnkExportXls');
        const botonFiltroBuscar = d.getElementById('lnkFiltroBuscar');
        const botonFiltroCancelar = d.getElementById('lnkFiltroCancelar');

        botonFiltroBuscar.addEventListener('click', e => {
            e.preventDefault();
            if (inputFiltroFechaDesde.value != '' && inputFiltroFechaHasta.value == '') {
                swal({
                    text: 'Seleccioné fecha (Hasta)',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputFiltroFechaHasta.value != '' && inputFiltroFechaDesde.value == '') {
                swal({
                    text: 'Seleccioné fecha (Desde)',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputFiltroTerrenoDesde.value != '' && inputFiltroTerrenoHasta.value == '') {
                swal({
                    text: 'Digité area de terreno (Desde)',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputFiltroTerrenoHasta.value != '' && inputFiltroTerrenoDesde.value == '') {
                swal({
                    text: 'Digité area de terreno (Hasta)',
                    timer: 3000,
                    buttons: false
                });
            } else {
                validarData(1);
                lnkFiltros.click();
            }
        });

        botonFiltroCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputFiltroFechaDesde.value = '';
            inputFiltroFechaHasta.value = '';
            inputFiltroTerrenoDesde.value = '';
            inputFiltroTerrenoHasta.value = '';
            validarData(1);
            lnkFiltros.click();
        });*/

        const filters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('coordinacion_correlativo', inputCoordinacion.value)
            fd.append('solicitante_nombre', inputSolicitante.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('perito_id', selectPerito.value)
            /*fd.append('control_calidad_id', selectCCalidad.value)*/
            /*fd.append('tasacion_fecha_desde', inputFiltroFechaDesde.value)
            fd.append('tasacion_fecha_hasta', inputFiltroFechaHasta.value)*/
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listTasacion(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listTasacion(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listTasacion(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_tasacion tbody').html('<tr><td colspan="13"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion tbody').html('<tr><td colspan="13"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputCoordinacion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        inputSolicitante.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        inputCliente.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        $('#selectPerito').change(function(event) {
            validarData(1);
        });

        const botonTerreno = d.getElementById('lnkTerreno');
        const botonCasa = d.getElementById('lnkCasa');
        const botonDepartamento = d.getElementById('lnkDepartamento');
        const botonOficina = d.getElementById('lnkOficina');
        const botonLComercial = d.getElementById('lnkLComercial');
        const botonLIndustrial = d.getElementById('lnkLIndustrial');
        const botonVehiculo = d.getElementById('lnkVehiculo');
        const botonMaquinaria = d.getElementById('lnkMaquinaria');

        botonTerreno.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 1
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonCasa.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 2
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonDepartamento.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 3
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonOficina.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 4
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonLComercial.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 5
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonLIndustrial.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 6
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonVehiculo.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 7
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });

        botonMaquinaria.addEventListener('click', function(e) {
            e.preventDefault();

            const datosCoordinacion =
                                        {
                                            coordinacion_correlativo: labelCoordinacionCorrelativo.innerHTML,
                                            solicitante_nombre: labelSolicitante.innerHTML,
                                            propietario_nombre: labelPropietario.innerHTML,
                                            cliente_nombre: labelCliente.innerHTML,
                                            tipo_tasacion: 8
                                        };

            sessionStorage.setItem('dataCoordinacion', JSON.stringify(datosCoordinacion));
            window.location.href = 'tasacion/mantenimiento';
        });
    })
})(document);