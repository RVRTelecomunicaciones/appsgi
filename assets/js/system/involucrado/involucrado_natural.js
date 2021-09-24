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
        listInvolucradoNatural = (filtersInvolucradoNatural) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchInvolucrado/N', filtersInvolucradoNatural)
                .then((respuesta) => {
                    const records_find = respuesta.involucrado_find;
                    if (records_find != false) {
                        //console.log(respuesta.cotizacion);
                        const filas_find = records_find.map((item, index) => {
                            let clase = ""
                            let buttons = ""
                            switch (item.involucrado_estado) {
                                case '1':
                                    clase = "badge badge-success"
                                    break;
                                default:
                                    clase = "badge badge-secondary"
                                    break;
                            }

                            if (d.body.contains(d.querySelector('#frmRegistro #otros_id'))) {
                                buttons = ` <a id='lnkSeleccionar' class='ml-1' href data-indice='${index}' title='Seleccionar' data-dismiss='modal'><i class='fa fa-check-circle-o'></i></a>
                                            <a id='linkEditar' href='' data-indice='${index}' title='Modificar'><i class='fa fa-edit'></i></a>`
                            } else {
                                buttons = ` <a id='linkEditar' href='' data-indice='${index}' title='Modificar'><i class='fa fa-edit'></i></a>`
                            }

                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.involucrado_nombre.toUpperCase()}</div></td>
                                        <td>${item.involucrado_documento}</td>
                                        <td><div align='left'>${item.involucrado_direccion}</div></td>
                                        <td>${item.involucrado_telefono}</td>
                                        <td>${item.involucrado_correo}</td>
                                        <td><div class='${clase}'>${item.involucrado_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td>
                                            <div style='font-size: 1.2rem;'>
                                                ${buttons}
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#mdlNatural #tableRegistro tbody').html(filas_find);

                        //alert(filtersInvolucradoNatural.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersInvolucradoNatural.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#mdlNatural #conteo');
                        if (inputSearchInvolucradoNombreCompleto.value == "" && inputSearchInvolucradoDocumento.value == "" && inputSearchInvolucradoDireccion.value == "" && selectSearchInvolucradoEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#mdlNatural #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlNatural #link');
                        const botonEditar = d.querySelectorAll('#mdlNatural #linkEditar');
                        const botonSeleccionar = d.querySelectorAll('#mdlNatural #lnkSeleccionar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e) {
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarDataInvolucrado(num_page);
                            })
                        });

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', function(e) {
                                e.preventDefault();
                                const indice = this.dataset.indice;
                                inputInvolucradoId.value = records_find[indice].involucrado_id;
                                inputInvolucradoPaterno.value = records_find[indice].involucrado_paterno;
                                inputInvolucradoMaterno.value = records_find[indice].involucrado_materno;
                                inputInvolucradoNombres.value = records_find[indice].involucrado_nombres;
                                inputInvolucradoDocumento.value = records_find[indice].involucrado_documento;
                                inputInvolucradoTelefono.value = records_find[indice].involucrado_telefono;
                                inputInvolucradoDireccion.value = records_find[indice].involucrado_direccion;
                                inputInvolucradoCorreo.value = records_find[indice].involucrado_correo;
                                checkInvolucradoEstado.checked = records_find[indice].involucrado_estado == 1 ? true : false;

                                //if (number.isNaN(records_find[indice].involucrado_documento)) {}
                                //inputInvolucradoDocumento.setAttribute('disabled' ,'disabled');
                            })
                        });

                        botonSeleccionar.forEach(boton => {
                            boton.addEventListener('click', e => {
                                e.preventDefault();
                                if(d.body.contains(d.querySelector('#frmRegistro #otros_id'))) {
                                    const indice = boton.dataset.indice;
                                    let otrosId = d.querySelector('#frmRegistro #otros_id');
                                    let otrosTipo = d.querySelector('#frmRegistro #otros_tipo');
                                    let otrosNombre = d.querySelector('#frmRegistro #otros_nombre');

                                    otrosId.value = records_find[indice].involucrado_id;
                                    otrosTipo.value = records_find[indice].involucrado_tipo_nombre;
                                    otrosNombre.value = records_find[indice].involucrado_nombre + ' ['+ records_find[indice].involucrado_documento +']';
                                    botonInvolucradoNaturalCancelar.click();
                                }
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        //VARIABLES INPUTS
        const inputInvolucradoId = d.querySelector('#mdlNatural #inputId');
        const inputInvolucradoPaterno = d.querySelector('#mdlNatural #inputPaterno');
        const inputInvolucradoMaterno = d.querySelector('#mdlNatural #inputMaterno');
        const inputInvolucradoNombres = d.querySelector('#mdlNatural #inputNombres');
        const inputInvolucradoDocumento = d.querySelector('#mdlNatural #inputDocumento');
        const inputInvolucradoDireccion = d.querySelector('#mdlNatural #inputDireccion');
        const inputInvolucradoTelefono = d.querySelector('#mdlNatural #inputTelefono');
        const inputInvolucradoCorreo = d.querySelector('#mdlNatural #inputCorreo');

        const inputSearchInvolucradoNombreCompleto = d.querySelector('#mdlNatural #inputSearchNombreCompleto');
        const inputSearchInvolucradoDocumento = d.querySelector('#mdlNatural #inputSearchDocumento');
        const inputSearchInvolucradoDireccion = d.querySelector('#mdlNatural #inputSearchDireccion');
        const inputSearchInvolucradoCorreo = d.querySelector('#mdlNatural #inputSearchCorreo');

        //VARIABLES CHECKBOXS
        const checkInvolucradoEstado = d.querySelector('#mdlNatural #checkEstado');

        //VARIABLES SELECTS
        const selectSearchInvolucradoEstado = d.querySelector('#mdlNatural #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonInvolucradoBuscarDni = d.querySelector('#mdlNatural #linkBuscarDni');
        const botonInvolucradoNaturalCancelar = d.querySelector('#mdlNatural #linkCancelar');
        const botonInvolucradoNaturalAñadir = d.querySelector('#mdlNatural #linkAñadir');

        //VARIABLE FORM
        const formInvolucradoNatural = d.querySelector('#mdlNatural #formInvolucrado');

        filtersInvolucradoNatural = (link) => {
            const fd = new FormData()
            fd.append('involucrado_nombre', inputSearchInvolucradoNombreCompleto.value)
            fd.append('involucrado_documento', inputSearchInvolucradoDocumento.value)
            fd.append('involucrado_direccion', inputSearchInvolucradoDireccion.value)
            fd.append('involucrado_correo', inputSearchInvolucradoCorreo.value)
            fd.append('involucrado_estado', selectSearchInvolucradoEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 5)
            return fd;
        }

        //listInvolucradoNatural(filtersInvolucradoNatural(1));

        const validarDataInvolucrado = (link = false) => {
            const respuesta = listInvolucradoNatural(filtersInvolucradoNatural(link));

            if (respuesta !== undefined)
                listInvolucradoNatural(filtersInvolucradoNatural());
            else {
                if (link === false)
                    $('#mdlNatural #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                    $('#mdlNatural #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchInvolucradoNombreCompleto.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataInvolucrado(1);
        });

        inputSearchInvolucradoDocumento.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataInvolucrado(1);
        });

        inputSearchInvolucradoDireccion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataInvolucrado(1);
        });

        inputSearchInvolucradoCorreo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarDataInvolucrado(1);
        });

        selectSearchInvolucradoEstado.addEventListener('change', e => {
            validarDataInvolucrado(1);
        });

        botonInvolucradoBuscarDni.addEventListener('click', e => {
            e.preventDefault();
            obtenerDatosPorDni(inputInvolucradoDocumento.value);
        });

        inputInvolucradoDocumento.addEventListener('keypress', e => {
            validarSoloNumeros(e);
        });

        //const apiDni = "https://py-devs.com/api/dni";
        const obtenerDatosPorDni = (dni) => {
            if (inputInvolucradoDocumento.value.length == 8) {
                // promesa crea un objeto y este tiene metodos
                ajax('post', `consultar_dni/` + dni)
                    .then((respuesta) => {
                        if (respuesta.success) {
                            inputInvolucradoPaterno.value = respuesta.paterno;
                            inputInvolucradoMaterno.value = respuesta.materno;
                            inputInvolucradoNombres.value = respuesta.nombres;

                            inputInvolucradoDireccion.focus();
                            inputInvolucradoPaterno.setAttribute('disabled', 'disabled');
                            inputInvolucradoMaterno.setAttribute('disabled', 'disabled');
                            inputInvolucradoNombres.setAttribute('disabled', 'disabled');
                            inputInvolucradoDocumento.setAttribute('disabled', 'disabled');
                            botonInvolucradoBuscarDni.classList.add('disabled');
                        } else {
                            swal({
                                icon: 'info',
                                title: 'Información',
                                text: respuesta.message,
                                timer: 3000,
                                buttons: false
                            }).then(() => {
                                inputInvolucradoPaterno.removeAttribute('disabled');
                                inputInvolucradoMaterno.removeAttribute('disabled');
                                inputInvolucradoNombres.removeAttribute('disabled');
                                inputInvolucradoPaterno.focus();
                            });
                        }
                    });
            }else {
                inputInvolucradoDocumento.value = '';
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'DNI invalido: El número de dni es de 8 digitos',
                    timer: 3000,
                    buttons: false
                });
            }
        }

        const validarSoloNumeros = (e) => {
            //e.preventDefault();
            var key = inputInvolucradoDocumento.Event ? e.which : e.keyCode;

            if (key < 48 || key > 57)
                e.preventDefault();
        }

        botonInvolucradoNaturalCancelar.addEventListener('click', e => {
            e.preventDefault();
            formInvolucradoNatural.reset();
            inputInvolucradoDocumento.removeAttribute('disabled');
            if (botonInvolucradoBuscarDni.classList.contains('disabled'))
                botonInvolucradoBuscarDni.classList.remove('disabled');
            
            inputInvolucradoId.value = '0';
            checkInvolucradoEstado.checked = true;
            inputInvolucradoDocumento.focus();
            if(d.body.contains(d.querySelector('#selectInvolucrado')))
                listarInvolucradosNatural();
        });

        const crudInvolucrado = () => {
            const apiRestMantenimiento = inputInvolucradoId.value == 0 ? 'insertInvolucrado' : 'updateInvolucrado';

            var fecha = new Date();
            var dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            var mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            var yyyy = fecha.getFullYear();
            var fecha_actual = yyyy + '-' + mm + '-' + dd;


            var fd = new FormData();
            fd.append('involucrado_id', inputInvolucradoId.value);
            fd.append('involucrado_paterno', inputInvolucradoPaterno.value);
            fd.append('involucrado_materno', inputInvolucradoMaterno.value);
            fd.append('involucrado_nombres', inputInvolucradoNombres.value);
            fd.append('involucrado_documento', inputInvolucradoDocumento.value);
            fd.append('involucrado_direccion', inputInvolucradoDireccion.value);
            fd.append('involucrado_telefono', inputInvolucradoTelefono.value);
            fd.append('involucrado_correo', inputInvolucradoCorreo.value);
            fd.append('involucrado_estado', checkInvolucradoEstado.checked ? 1 : 0);
            if (inputInvolucradoId.value != 0)
                fd.append('involucrado_fecha_update', fecha_actual);

            ajax('post', `${apiRestMantenimiento}/N`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success == true) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputInvolucradoId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonInvolucradoNaturalCancelar.click();
                        listInvolucradoNatural(filtersInvolucradoNatural(1));
                    }
                    else if (respuesta.success == 'exist'){
                        swal({
                            icon: 'info',
                            title: 'Información',
                            text: 'Ya esta registrado el incolucrado',
                            timer: 3000,
                            buttons: false
                        });
                    }
                    else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: inputInvolucradoId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonInvolucradoNaturalAñadir.addEventListener('click', e => {
            e.preventDefault();
            /*if (inputInvolucradoDocumento.value.length != 8) {
                inputInvolucradoDocumento.value = '';
                inputInvolucradoDireccion.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'DNI invalido: El número de dni es de 8 digitos',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoDocumento.hasAttribute('disabled') && inputInvolucradoDocumento.value == '') {
                inputInvolucradoDocumento.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese nro de dni',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoNombres.hasAttribute('disabled') && inputInvolucradoNombres.value == '') {
                inputInvolucradoNombres.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese Apellidos y Nombres',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoDireccion.hasAttribute('disabled') && inputInvolucradoDireccion.value == '') {
                inputInvolucradoDireccion.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese Dirección',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudInvolucrado();
            }*/

            /*if (inputInvolucradoTelefono.value == '') {
                inputInvolucradoTelefono.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingresé número de teléfono',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputInvolucradoCorreo.value == '') {
                inputInvolucradoCorreo.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingresé correo',
                    timer: 3000,
                    buttons: false
                });
            } else {*/
                crudInvolucrado();
            /*}*/
        });
    })
})(document);
