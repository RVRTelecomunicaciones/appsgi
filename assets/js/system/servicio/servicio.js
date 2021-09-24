(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
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
        const apiRestListar = '../servicio/searchServicio';

        const inputId = d.querySelector('#mdlServicio #inputId');
        const inputDescripcion = d.querySelector('#mdlServicio #inputDescripcion');
        const checkEstado = d.querySelector('#mdlServicio #checkEstado');

        const inputSearchDescripcion = d.querySelector('#mdlServicio #inputSearchDescripcion');
        const selectSearchEstado = d.querySelector('#mdlServicio #selectSearchEstado');

        const botonCancelar = d.querySelector('#mdlServicio #linkCancelar');
        const botonGuardar = d.querySelector('#mdlServicio #linkAñadir');
        const botonClose = d.querySelector('#mdlServicio #btnClose');

        const botonNuevoServicio = d.querySelector('#link3 #linkNuevoSubServicio');

        const listServicio = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.servicio_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td><div align='left'>${item.servicio_nombre.toUpperCase()}</div></td>
                                        <td>${item.servicio_estado == '0' ? 'Inactivo' : 'Activo'}</td>
                                        <td><a id='lnkEditar' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        $('#tableRegistro tbody').html(filas);

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

                        const spanMostrarRegistros = d.querySelector('#mdlServicio #conteo');

                        if (inputSearchDescripcion.value == "" && selectSearchEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $("#mdlServicio #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlServicio #link');
                        const link_editar = d.querySelectorAll('#mdlServicio #lnkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        link_editar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                inputId.value = registros[indice].servicio_id;
                                inputDescripcion.value = registros[indice].servicio_nombre;
                                checkEstado.checked = registros[indice].servicio_estado;
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const filters = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('tipo_servicio', $('#selectTServicio').val())
            fd.append('servicio_nombre', inputSearchDescripcion.value)
            fd.append('servicio_estado', selectSearchEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        if (botonNuevoServicio) {
            botonNuevoServicio.addEventListener('click', e => {
                e.preventDefault();
                listServicio(filters(5,1));

                $('#mdlServicio').modal({
					'show': true,
					'keyboard': false,
					'backdrop': 'static'
				});
            });
        }

        const validarData = (link = false) => {
            const respuesta = listServicio(filters(5,link));
            
            if (respuesta !== undefined)
                listServicio(filters(5));
            else
            {
                if (link === false)
                    $('#tableRegistro tbody').html('<tr><td colspan="4"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tableRegistro tbody').html('<tr><td colspan="4"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        selectSearchEstado.addEventListener('change', e => {
            validarData(1);
        });

        const crudServicio = () => {
            const apiRestMantenimiento = inputId.value == 0 ? '../servicio/insertServicio' : '../servicio/updateServicio';

            const fd = new FormData();
            fd.append('servicio_id', inputId.value)
            fd.append('servicio_nombre', inputDescripcion.value.toUpperCase().trim())
            fd.append('tipo_id', $('#selectTServicio').val())
            fd.append('servicio_estado', checkEstado.checked ? 1 : 0)

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });
                        listServiciosCombo($('#selectTServicio').val());
                        botonCancelar.click();
                        validarData(1);
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonGuardar.addEventListener('click', e => {
            e.preventDefault();
            if (inputDescripcion.value.trim() == "" || inputDescripcion.value.length < 5) {
                swal({
                    text: 'Ingresé descripción ...',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudServicio();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputId.value = "0";
            inputDescripcion.value = "";
            checkEstado.checked = true;
        });

        botonClose.addEventListener('click', e => {
            inputSearchDescripcion.value = "";
            selectSearchEstado.validarData = "";
            botonCancelar.click();
        });
    })
})(document);
