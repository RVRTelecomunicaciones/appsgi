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
        const listContacto = (filtersContacto) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchContacto', filtersContacto)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const records_find = respuesta.contacto_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            switch (item.contacto_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }
                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.contacto_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.contacto_cargo}</div></td>
                                        <td>${item.contacto_telefono}</td>
                                        <td><div align='left'>${item.contacto_correo}</div></td>
                                        <td><div class='${clase}'>${item.contacto_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td><div style='font-size: 1.2rem;'><a id='linkEditar' href='' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        $('#mdlContacto #tableRegistro tbody').html(filas_find);

                        //alert(filtersContacto.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersContacto.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#mdlContacto #conteo');
                        if (inputSearchContactoNombreCompleto.value == "" && inputSearchContactoCargo.value == "" && inputSearchContactoCorreo.value == "" && selectSearchContactoEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#mdlContacto #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlContacto #link');
                        const botonEditar = d.querySelectorAll('#mdlContacto #linkEditar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataContacto(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputContactoId.value = records_find[indice].contacto_id;
                                inputContactoNombreCompleto.value = records_find[indice].contacto_nombre;
                                inputContactoCargo.value = records_find[indice].contacto_cargo;
                                inputContactoTelefono.value = records_find[indice].contacto_telefono;
                                inputContactoCorreo.value = records_find[indice].contacto_correo;
                                checkContactoEstado.checked = records_find[indice].contacto_estado == 1 ? true : false;
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputContactoId = d.querySelector('#mdlContacto #inputId');
        const inputContactoNombreCompleto = d.querySelector('#mdlContacto #inputNombreCompleto');
        const inputContactoCargo = d.querySelector('#mdlContacto #inputCargo');
        const inputContactoTelefono = d.querySelector('#mdlContacto #inputTelefono');
        const inputContactoCorreo = d.querySelector('#mdlContacto #inputCorreo');

        const inputSearchContactoNombreCompleto = d.querySelector('#mdlContacto #inputSearchNombreCompleto');
        const inputSearchContactoCargo = d.querySelector('#mdlContacto #inputSearchCargo');
        const inputSearchContactoCorreo = d.querySelector('#mdlContacto #inputSearchCorreo');

        //VARIABLES CHECKBOXS
        const checkContactoEstado = d.querySelector('#mdlContacto #checkEstado');

        //VARIABLES SELECTS
        const selectSearchContactoEstado = d.querySelector('#mdlContacto #selectSearchEstado');
        const selectInvolucrado = d.querySelector('#link2 #selectInvolucrado')

        //VARIABLES BUTTONS
        const botonContactoCancelar = d.querySelector('#mdlContacto #linkCancelar');
        const botonContactoAñadir = d.querySelector('#mdlContacto #linkAñadir');

        //VARIABLE TABS
        const tabContacto = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab2');

        //VARIABLE RADIO
        const radioJuridica = d.querySelector('#radioJuridica');

        const filtersContacto = (link) => {
            const fd = new FormData()
            fd.append('involucrado_juridico', selectInvolucrado.value)
            fd.append('contacto_nombre', inputSearchContactoNombreCompleto.value)
            fd.append('contacto_cargo', inputSearchContactoCargo.value)
            fd.append('contacto_correo', inputSearchContactoCorreo.value)
            fd.append('contacto_estado', selectSearchContactoEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 5)
            return fd;
        }

        //listContacto(filtersContacto(1));

        const validarDataContacto = (link = false) => {
            const respuesta = listContacto(filtersContacto(link));

            if (respuesta !== undefined)
                listContacto(filtersContacto());
            else {
                if (link === false)
                    $('#mdlContacto #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#mdlContacto #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        $('#selectInvolucrado').change(function(event) {
            if(radioJuridica.checked)
                listContacto(filtersContacto(1));
        });

        inputSearchContactoNombreCompleto.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataContacto(1);
        });

        inputSearchContactoCargo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataContacto(1);
        });

        inputSearchContactoCorreo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataContacto(1);
        });

        selectSearchContactoEstado.addEventListener('change', e => {
            validarDataContacto(1);
        });

        botonContactoCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputContactoId.value = '0';
            inputContactoNombreCompleto.value = '';
            inputContactoCargo.value = '';
            inputContactoTelefono.value = '';
            inputContactoCorreo.value = '';
            checkContactoEstado.checked = true;
        });

        const crudContacto = () => {
            const apiRestMantenimiento = inputContactoId.value == 0 ? 'insertContacto' : 'updateContacto';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('contacto_id', inputContactoId.value);
            fd.append('contacto_nombre', inputContactoNombreCompleto.value);
            fd.append('contacto_cargo', inputContactoCargo.value);
            fd.append('contacto_telefono', inputContactoTelefono.value);
            fd.append('contacto_correo', inputContactoCorreo.value);
            fd.append('contacto_estado', checkContactoEstado.checked ? 1 : 0);
            fd.append('juridica_id', selectInvolucrado.value);
            if (inputContactoId.value != 0)
                fd.append('contacto_fecha_update', fecha_actual);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputContactoId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonContactoCancelar.click();
                        listContacto(filtersContacto(1));
                        listarContacto(selectInvolucrado.value);
                    }
                    else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: inputContactoId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonContactoAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputContactoNombreCompleto.value == '') {
                inputContactoNombreCompleto.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese apellidos y nombres',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputTelefono.value == '') {
                inputTelefono.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese número de teléfono',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputCorreo.value == '') {
                inputCorreo.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese correo',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudContacto();
            }
        });
    })
})(document);
