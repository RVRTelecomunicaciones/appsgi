/*(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
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
        //METODO PARA LISTAR TABLA
        const listTServicio = (filtersTServicio) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchTServicio', filtersTServicio)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const records_find = respuesta.servicio_tipo_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            switch (item.servicio_tipo_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }
                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.servicio_tipo_nombre.toUpperCase()}</div></td>
                                        <td><div class='${clase}'>${item.servicio_tipo_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td><div style='font-size: 1.2rem;'><a id='linkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a></div></td>
                                    </tr>`
                        }).join("");

                        $('#mdlTServicio #tableRegistro tbody').html(filas_find);

                        const records_all = respuesta.servicio_tipo_all;
                        const filas_all = records_all.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.servicio_tipo_id}'>${item.servicio_tipo_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.servicio_tipo_id}'>${item.servicio_tipo_nombre.toUpperCase()}</option>`
                        }).join("");

                        $('#link1 #selectTServicio').html(filas_all);
                        $('#link1 #selectTServicio').val(servicio_tipo).trigger('change');
                        $('#mdlServicioDetalle #selectTServicio').html(filas_all);

                        //alert(filtersTServicio.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersTServicio.get('num_page'));
                        //total registros
                        totalregistros = respuesta.total_records_find;
                        //cantidad de registros por pagina
                        cantidadregistros = respuesta.quantity;

                        numerolinks = Math.ceil(totalregistros / cantidadregistros);
                        paginador = "<ul class='pagination'>";
                        if (linkseleccionado > 1) {
                            paginador += "<li class='page-item'><a id='link' class='page-link' href='1'>&laquo;</a></li>";
                            paginador += "<li class='page-item'><a id='link' class='page-link' href='" + (linkseleccionado - 1) + "' '>&lsaquo;</a></li>";
                        } else {
                            paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&laquo;</a></li>";
                            paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&lsaquo;</a></li>";
                        }
                        //muestro de los enlaces 
                        //cantidad de link hacia atras y adelante
                        cant = 2;
                        //inicio de donde se va a mostrar los links
                        pagInicio = (linkseleccionado > cant) ? (linkseleccionado - cant) : 1;
                        //condicion en la cual establecemos el fin de los links
                        if (numerolinks > cant) {
                            //conocer los links que hay entre el seleccionado y el final
                            pagRestantes = numerolinks - linkseleccionado;
                            //defino el fin de los links
                            pagFin = (pagRestantes > cant) ? (linkseleccionado + cant) : numerolinks;
                        } else {
                            pagFin = numerolinks;
                        }

                        for (var i = pagInicio; i <= pagFin; i++) {
                            if (i == linkseleccionado)
                                paginador += "<li class='page-item active'><a id='link' data-index='" + (pagInicio - 1) + "' class='page-link' href='" + i + "'>" + i + "</a></li>";
                            else
                                paginador += "<li class='page-item'><a id='link' data-index='" + (pagInicio - 1) + "' class='page-link' href='" + i + "'>" + i + "</a></li>";
                        }
                        //condicion para mostrar el boton sigueinte y ultimo
                        if (linkseleccionado < numerolinks) {
                            paginador += "<li class='page-item'><a id='link' class='page-link' href='" + (linkseleccionado + 1) + "' >&rsaquo;</a></li>";
                            paginador += "<li class='page-item'><a id='link' class='page-link' href='" + numerolinks + "'>&raquo;</a></li>";
                        } else {
                            paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&rsaquo;</a></li>";
                            paginador += "<li class='page-item disabled'><a class='page-link' href='#'>&raquo;</a></li>";
                        }

                        paginador += "</ul>";

                        const spanMostrarRegistros = d.querySelector('#mdlTServicio #conteo');
                        if (inputSearchTServicioDescripcion.value == "" && selectSearchTServicioEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#mdlTServicio #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlTServicio #link');
                        const botonEditar = d.querySelectorAll('#mdlTServicio #linkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataTServicio(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputTServicioId.value = records_find[indice].servicio_tipo_id;
                                inputTServicioDescripcion.value = records_find[indice].servicio_tipo_nombre.toUpperCase();
                                checkTServicioEstado.checked = records_find[indice].servicio_tipo_estado == 1 ? true : false;
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputTServicioId = d.querySelector('#mdlTServicio #inputId');
        const inputTServicioDescripcion = d.querySelector('#mdlTServicio #inputDescripcion');
        const inputSearchTServicioDescripcion = d.querySelector('#mdlTServicio #inputSearchDescripcion');

        //VARIABLES CHECKBOXS
        const checkTServicioEstado = d.querySelector('#mdlTServicio #checkEstado');

        //VARIABLES SELECTS
        const selectSearchTServicioEstado = d.querySelector('#mdlTServicio #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonTServicioCancelar = d.querySelector('#mdlTServicio #linkCancelar');
        const botonTServicioAñadir = d.querySelector('#mdlTServicio #linkAñadir');

        //VARIABLE TABS
        const tabTServicio = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab2');

        const filtersTServicio = (link) => {
            const fd = new FormData()
            fd.append('servicio_tipo_nombre', inputSearchTServicioDescripcion.value)
            fd.append('servicio_tipo_estado', selectSearchTServicioEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 5)
            return fd;
        }

        listTServicio(filtersTServicio(1));

        const validarDataTServicio = (link = false) => {
            const respuesta = listTServicio(filtersTServicio(link));

            if (respuesta !== undefined)
                listTServicio(filtersTServicio());
            else {
                if (link === false)
                    $('#mdlTServicio #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#mdlTServicio #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchTServicioDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataTServicio(1);
        });

        selectSearchTServicioEstado.addEventListener('change', e => {
            validarDataTServicio(1);
        });

        botonTServicioCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputTServicioId.value = '0';
            inputTServicioDescripcion.value = '';
            checkTServicioEstado.checked = true;
        });

        //var servicio_tipo_accion = 'insert';

        const crudTServicio = () => {
            const apiRestMantenimiento = inputTServicioId.value == 0 ? 'insertTServicio' : 'updateTServicio';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('servicio_tipo_id', inputTServicioId.value);
            fd.append('servicio_tipo_nombre', inputTServicioDescripcion.value);
            fd.append('servicio_tipo_estado', checkTServicioEstado.checked ? 1 : 0);
            if (inputTServicioId.value != 0)
                fd.append('servicio_tipo_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputTServicioId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonTServicioCancelar.click();
                        listTServicio(filtersTServicio(1));
                    }
                    else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputTServicioId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonTServicioAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputTServicioDescripcion.value != '')
                crudTServicio();
            else {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese descripción de la TServicio',
                    timer: 3000,
                    buttons: false
                });
                inputTServicioDescripcion.focus();
            }
        });

        const divCambioClass = d.querySelector('#divCambioClass');
        tabTServicio.addEventListener('click', e => {
            const mdlTitulo = d.querySelector('#mdlJuridico #myModalLabel8');
            mdlTitulo.innerHTML = 'MANTENIMIENTO DE TServicio';

            if (divCambioClass.classList.contains('modal-xl')) {
                divCambioClass.classList.remove('modal-xl');
                divCambioClass.classList.add('modal-lg')
            }
        });
    })
})(document);*/