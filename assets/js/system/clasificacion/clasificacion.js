(function(d) {
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
        listClasificacion = (filtersClasificacion) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchClasificacion', filtersClasificacion)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const records_find = respuesta.clasificacion_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            switch (item.clasificacion_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }
                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.clasificacion_nombre.toUpperCase()}</div></td>
                                        <td><div class='${clase}'>${item.clasificacion_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td><div style='font-size: 1.2rem;'><a id='linkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        $('#tabVerticalLeft1 #tableRegistro tbody').html(filas_find);

                        const records_all = respuesta.clasificacion_all;
                        const filas_all = records_all.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.clasificacion_id}'>${item.clasificacion_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.clasificacion_id}'>${item.clasificacion_nombre.toUpperCase()}</option>`
                        }).join("");

                        $('#tabVerticalLeft4 #selectClasificacion').html(filas_all);

                        //alert(filtersClasificacion.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersClasificacion.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#tabVerticalLeft1 #conteo');
                        if (inputSearchClasificacionDescripcion.value == "" && selectSearchClasificacionEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#tabVerticalLeft1 #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#tabVerticalLeft1 #link');
                        const botonEditar = d.querySelectorAll('#tabVerticalLeft1 #linkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataClasificacion(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputClasificacionId.value = records_find[indice].clasificacion_id;
                                inputClasificacionDescripcion.value = records_find[indice].clasificacion_nombre;
                                checkClasificacionEstado.checked = records_find[indice].clasificacion_estado == 1 ? true : false;
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputClasificacionId = d.querySelector('#tabVerticalLeft1 #inputId');
        const inputClasificacionDescripcion = d.querySelector('#tabVerticalLeft1 #inputDescripcion');
        const inputSearchClasificacionDescripcion = d.querySelector('#tabVerticalLeft1 #inputSearchDescripcion');

        //VARIABLES CHECKBOXS
        const checkClasificacionEstado = d.querySelector('#tabVerticalLeft1 #checkEstado');

        //VARIABLES SELECTS
        const selectSearchClasificacionEstado = d.querySelector('#tabVerticalLeft1 #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonClasificacionCancelar = d.querySelector('#tabVerticalLeft1 #linkCancelar');
        const botonClasificacionAñadir = d.querySelector('#tabVerticalLeft1 #linkAñadir');

        //VARIABLE TABS
        const tabClasificacion = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab1');

        filtersClasificacion = (link) => {
            const fd = new FormData()
            fd.append('clasificacion_nombre', inputSearchClasificacionDescripcion.value)
            fd.append('clasificacion_estado', selectSearchClasificacionEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 7)
            return fd;
        }

        //listClasificacion(filtersClasificacion(1));

        const validarDataClasificacion = (link = false) => {
            const respuesta = listClasificacion(filtersClasificacion(link));

            if (respuesta !== undefined)
                listClasificacion(filtersClasificacion());
            else {
                if (link === false)
                    $('#tabVerticalLeft1 #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#tabVerticalLeft1 #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchClasificacionDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataClasificacion(1);
        });

        selectSearchClasificacionEstado.addEventListener('change', e => {
            if(e.keyCode == 13)
                validarDataClasificacion(1);
        });

        botonClasificacionCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputClasificacionId.value = '0';
            inputClasificacionDescripcion.value = '';
            checkClasificacionEstado.checked = true;
        });

        //var clasificacion_accion = 'insert';

        const crudClasificacion = () => {
            const apiRestMantenimiento = inputClasificacionId.value == 0 ? 'insertClasificacion' : 'updateClasificacion';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('clasificacion_id', inputClasificacionId.value);
            fd.append('clasificacion_nombre', inputClasificacionDescripcion.value);
            fd.append('clasificacion_estado', checkClasificacionEstado.checked ? 1 : 0);
            if (inputClasificacionId.value != 0)
                fd.append('clasificacion_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputClasificacionId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonClasificacionCancelar.click();
                        listClasificacion(filtersClasificacion(1));
                    }
                    else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputClasificacionId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonClasificacionAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputClasificacionDescripcion.value != '')
                crudClasificacion();
            else {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese descripción de la Clasificacion',
                    timer: 3000,
                    buttons: false
                });
                inputClasificacionDescripcion.focus();
            }
        });

        const divCambioClass = d.querySelector('#divCambioClass');
        tabClasificacion.addEventListener('click', e => {
            const mdlTitulo = d.querySelector('#mdlJuridico #myModalLabel8');
            mdlTitulo.innerHTML = 'MANTENIMIENTO DE CLASIFICACIÓN';

            if (divCambioClass.classList.contains('modal-xl')) {
                divCambioClass.classList.remove('modal-xl');
                divCambioClass.classList.add('modal-lg')
            }
        });
    })
})(document);