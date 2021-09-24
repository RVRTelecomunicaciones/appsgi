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
        listGrupo = (filtersGrupo) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchGrupo', filtersGrupo)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    const records_find = respuesta.grupo_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            switch (item.grupo_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }
                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.grupo_nombre.toUpperCase()}</div></td>
                                        <td><div class='${clase}'>${item.grupo_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td><div style='font-size: 1.2rem;'><a id='linkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        $('#tabVerticalLeft3 #tableRegistro tbody').html(filas_find);

                        const records_all = respuesta.grupo_all;
                        const filas_all = records_all.map((item, index) => {
                            if (index == 0)
                                return `<option value=''></option><option value='${item.grupo_id}'>${item.grupo_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.grupo_id}'>${item.grupo_nombre.toUpperCase()}</option>`
                        }).join("");

                        $('#tabVerticalLeft4 #selectGrupo').html(filas_all);

                        //alert(filtersGrupo.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersGrupo.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#tabVerticalLeft3 #conteo');
                        if (inputSearchGrupoDescripcion.value == "" && selectSearchGrupoEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#tabVerticalLeft3 #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#tabVerticalLeft3 #link');
                        const botonEditar = d.querySelectorAll('#tabVerticalLeft3 #linkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataGrupo(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputGrupoId.value = records_find[indice].grupo_id;
                                inputGrupoDescripcion.value = records_find[indice].grupo_nombre;
                                checkGrupoEstado.checked = records_find[indice].grupo_estado == 1 ? true : false;
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputGrupoId = d.querySelector('#tabVerticalLeft3 #inputId');
        const inputGrupoDescripcion = d.querySelector('#tabVerticalLeft3 #inputDescripcion');
        const inputSearchGrupoDescripcion = d.querySelector('#tabVerticalLeft3 #inputSearchDescripcion');

        //VARIABLES CHECKBOXS
        const checkGrupoEstado = d.querySelector('#tabVerticalLeft3 #checkEstado');

        //VARIABLES SELECTS
        const selectSearchGrupoEstado = d.querySelector('#tabVerticalLeft3 #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonGrupoCancelar = d.querySelector('#tabVerticalLeft3 #linkCancelar');
        const botonGrupoAñadir = d.querySelector('#tabVerticalLeft3 #linkAñadir');

        //VARIABLE TABS
        const tabGrupo = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab3');

        filtersGrupo = (link) => {
            const fd = new FormData()
            fd.append('grupo_nombre', inputSearchGrupoDescripcion.value)
            fd.append('grupo_estado', selectSearchGrupoEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 7)
            return fd;
        }

        //listGrupo(filtersGrupo(1));

        const validarDataGrupo = (link = false) => {
            const respuesta = listGrupo(filtersGrupo(link));

            if (respuesta !== undefined)
                listGrupo(filtersGrupo());
            else {
                if (link === false)
                    $('#tabVerticalLeft3 #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#tabVerticalLeft3 #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchGrupoDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataGrupo(1);
        });

        selectSearchGrupoEstado.addEventListener('change', e => {
            validarDataGrupo(1);
        });

        botonGrupoCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputGrupoId.value = '0';
            inputGrupoDescripcion.value = '';
            checkGrupoEstado.checked = true;
        });

        const crudGrupo = () => {
            const apiRestMantenimiento = inputGrupoId.value == 0 ? 'insertGrupo' : 'updateGrupo';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('grupo_id', inputGrupoId.value);
            fd.append('grupo_nombre', inputGrupoDescripcion.value);
            fd.append('grupo_estado', checkGrupoEstado.checked ? 1 : 0);
            if (inputGrupoId.value != 0)
                fd.append('grupo_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputGrupoId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonGrupoCancelar.click();
                        listGrupo(filtersGrupo(1));
                    }
                    else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputGrupoId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonGrupoAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputGrupoDescripcion.value != '')
                crudGrupo();
            else {
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese descripción del Grupo',
                    timer: 3000,
                    buttons: false
                });
                inputGrupoDescripcion.focus();
            }
        });

        const divCambioClass = d.querySelector('#divCambioClass');
        tabGrupo.addEventListener('click', e => {
            const mdlTitulo = d.querySelector('#mdlJuridico #myModalLabel8');
            mdlTitulo.innerHTML = 'MANTENIMIENTO DE GRUPO';
            
            if (divCambioClass.classList.contains('modal-xl')) {
                divCambioClass.classList.remove('modal-xl');
                divCambioClass.classList.add('modal-lg')
            }
        });
    })
})(document);