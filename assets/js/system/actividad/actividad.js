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
        listActividad = (filtersActividad) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchActividad', filtersActividad)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const records_find = respuesta.actividad_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            switch (item.actividad_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }
                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.actividad_nombre.toUpperCase()}</div></td>
                                        <td><div class='${clase}'>${item.actividad_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td><div style='font-size: 1.2rem;'><a id='linkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        $('#tabVerticalLeft2 #tableRegistro tbody').html(filas_find);

                        const records_all = respuesta.actividad_all;
                        const filas_all = records_all.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.actividad_id}'>${item.actividad_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.actividad_id}'>${item.actividad_nombre.toUpperCase()}</option>`
                        }).join("");

                        $('#tabVerticalLeft4 #selectActividad').html(filas_all);

                        //alert(filtersActividad.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersActividad.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#tabVerticalLeft2 #conteo');
                        if (inputSearchActividadDescripcion.value == "" && selectSearchActividadEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#tabVerticalLeft2 #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#tabVerticalLeft2 #link');
                        const botonEditar = d.querySelectorAll('#tabVerticalLeft2 #linkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataActividad(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputActividadId.value = records_find[indice].actividad_id;
                                inputActividadDescripcion.value = records_find[indice].actividad_nombre;
                                checkActividadEstado.checked = records_find[indice].actividad_estado == 1 ? true : false;
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputActividadId = d.querySelector('#tabVerticalLeft2 #inputId');
        const inputActividadDescripcion = d.querySelector('#tabVerticalLeft2 #inputDescripcion');
        const inputSearchActividadDescripcion = d.querySelector('#tabVerticalLeft2 #inputSearchDescripcion');

        //VARIABLES CHECKBOXS
        const checkActividadEstado = d.querySelector('#tabVerticalLeft2 #checkEstado');

        //VARIABLES SELECTS
        const selectSearchActividadEstado = d.querySelector('#tabVerticalLeft2 #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonActividadCancelar = d.querySelector('#tabVerticalLeft2 #linkCancelar');
        const botonActividadAñadir = d.querySelector('#tabVerticalLeft2 #linkAñadir');

        //VARIABLE TABS
        const tabActividad = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab2');

        filtersActividad = (link) => {
            const fd = new FormData()
            fd.append('actividad_nombre', inputSearchActividadDescripcion.value)
            fd.append('actividad_estado', selectSearchActividadEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 7)
            return fd;
        }

        //listActividad(filtersActividad(1));

        const validarDataActividad = (link = false) => {
            const respuesta = listActividad(filtersActividad(link));

            if (respuesta !== undefined)
                listActividad(filtersActividad());
            else {
                if (link === false)
                    $('#tabVerticalLeft2 #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#tabVerticalLeft2 #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchActividadDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataActividad(1);
        });

        selectSearchActividadEstado.addEventListener('change', e => {
            validarDataActividad(1);
        });

        botonActividadCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputActividadId.value = '0';
            inputActividadDescripcion.value = '';
            checkActividadEstado.checked = true;
        });

        //var actividad_accion = 'insert';

        const crudActividad = () => {
            const apiRestMantenimiento = inputActividadId.value == 0 ? 'insertActividad' : 'updateActividad';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('actividad_id', inputActividadId.value);
            fd.append('actividad_nombre', inputActividadDescripcion.value);
            fd.append('actividad_estado', checkActividadEstado.checked ? 1 : 0);
            if (inputActividadId.value != 0)
                fd.append('actividad_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputActividadId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonActividadCancelar.click();
                        listActividad(filtersActividad(1));
                    }
                    else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputActividadId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonActividadAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputActividadDescripcion.value != '')
                crudActividad();
            else {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese descripción de la Actividad',
                    timer: 3000,
                    buttons: false
                });
                inputActividadDescripcion.focus();
            }
        });

        const divCambioClass = d.querySelector('#divCambioClass');
        tabActividad.addEventListener('click', e => {
            const mdlTitulo = d.querySelector('#mdlJuridico #myModalLabel8');
            mdlTitulo.innerHTML = 'MANTENIMIENTO DE ACTIVIDAD';

            if (divCambioClass.classList.contains('modal-xl')) {
                divCambioClass.classList.remove('modal-xl');
                divCambioClass.classList.add('modal-lg')
            }
        });
    })
})(document);