(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
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

        const apiRestListar = 'searchTerreno';

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

        const listTasacionTerreno = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_terreno_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td>${item.informe_id}</td>
                                        <td><div align='left'>${item.solicitante_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.cliente_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.propietario_nombre.toUpperCase()}</div></td>
                                        <td><div>${item.tasacion_ubicacion.toUpperCase()}</div><div>${item.departamento_nombre} <i class='fa fa-play text-danger'></i> ${item.provincia_nombre} <i class='fa fa-play text-danger'></i> ${item.distrito_nombre}</div></td>
                                        <td>${item.zonificacion_nombre}</td>
                                        <td>${item.cultivo_tipo_nombre}</td>
                                        <td>${item.tasacion_fecha_realizado}</td>
                                        <td>${numeral(item.tasacion_area_terreno).format('0,0.0')}</td>
                                        <td>${'$&nbsp;' + numeral(item.tasacion_valor_unitario).format('0,0.0')}</td>
                                        <td>${'$&nbsp;' + numeral(item.tasacion_valor_comercial).format('0,0.0')}</td>
                                        <td><a id='lnkRuta' href class='btn btn-warning btn-sm' data-indice='${index}'>Ruta</a></td>
                                    </tr>`
                        }).join("");

                        $('#tbl_tasacion_terreno tbody').html(filas);

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

                        if (inputCoordinacion.value == "" && inputSolicitante.value == "" && inputCliente.value == "" && inputPropietario.value == "" && inputUbicacion.value == "" && selectZonificacion.value == "" && selectTipoCultivo.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const link_ruta = d.querySelectorAll('#lnkRuta');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        link_ruta.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                const valorRuta = registros[indice].tasacion_ruta;
                                const aux = d.createElement('input');
                                aux.setAttribute('value', valorRuta);
                                d.body.appendChild(aux);
                                aux.select();
                                d.execCommand('copy');
                                d.body.removeChild(aux);
                                toastr.success('Copie y pegue en el explorador de archivos!', 'Ruta Copiada', {'showDuration': 500});
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const inputCoordinacion = d.getElementById('inputCoordinacion');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const inputPropietario = d.getElementById('inputPropietario');
        const inputUbicacion = d.getElementById('inputUbicacion');
        const inputFiltroFechaDesde = d.getElementById('inputFiltroFechaDesde');
        const inputFiltroFechaHasta = d.getElementById('inputFiltroFechaHasta');
        const inputFiltroTerrenoDesde = d.getElementById('inputFiltroTerrenoDesde');
        const inputFiltroTerrenoHasta = d.getElementById('inputFiltroTerrenoHasta');

        const selectZonificacion = d.getElementById('selectZonificacion');
        const selectTipoCultivo = d.getElementById('selectTipoCultivo');

        const botonFiltros = d.getElementById('lnkFiltros');
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
        });

        const filters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('coordinacion_correlativo', inputCoordinacion.value)
            fd.append('solicitante_nombre', inputSolicitante.value)
            fd.append('cliente_nombre', inputCliente.value)
            fd.append('propietario_nombre', inputPropietario.value)
            fd.append('tasacion_ubicacion', inputUbicacion.value)
            fd.append('zonificacion_id', selectZonificacion.value)
            fd.append('cultivo_tipo_id', selectTipoCultivo.value)
            fd.append('tasacion_fecha_desde', inputFiltroFechaDesde.value)
            fd.append('tasacion_fecha_hasta', inputFiltroFechaHasta.value)
            fd.append('tasacion_terreno_desde', inputFiltroTerrenoDesde.value)
            fd.append('tasacion_terreno_hasta', inputFiltroTerrenoHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listTasacionTerreno(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listTasacionTerreno(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listTasacionTerreno(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_tasacion_terreno tbody').html('<tr><td colspan="13"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion_terreno tbody').html('<tr><td colspan="13"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

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

        inputPropietario.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        inputUbicacion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        $('#selectZonificacion').change(function(e) {
           validarData(1); 
        });

        $('#selectTipoCultivo').change(function(e) {
           validarData(1); 
        });
    })
})(document);