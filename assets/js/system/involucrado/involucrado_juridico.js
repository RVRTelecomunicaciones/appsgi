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
        listInvolucrado = (filtersInvolucrado) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchInvolucrado/J', filtersInvolucrado)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const records_find = respuesta.involucrado_find;
                    if (records_find != false) {
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
                                            <a id='linkEditar' data-indice='${index}' title='Modificar'><i class='fa fa-edit'></i></a>`
                            } else {
                                buttons = ` <a id='linkEditar' data-indice='${index}' title='Modificar'><i class='fa fa-edit'></i></a>`
                            }

                            return `<tr>
                                        <td>${respuesta.init+index}</td>                       
                                        <td><div align='left'>${item.involucrado_nombre.toUpperCase()}</div></td>
                                        <td>${item.involucrado_documento}</td>
                                        <td><div align='left'>${item.involucrado_direccion}</div></td>
                                        <td>${item.involucrado_telefono}</td>
                                        <td><div class='${clase}'>${item.involucrado_estado == 1 ? 'Activo' : 'Inactivo'}</div></td>
                                        <td>
                                            <div style='font-size: 1.2rem;'>
                                                ${buttons}
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tabVerticalLeft4 #tableRegistro tbody').html(filas_find);

                        //alert(filtersInvolucrado.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersInvolucrado.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#tabVerticalLeft4 #conteo');
                        if (inputSearchInvolucradoRazonSocial.value == "" && inputSearchInvolucradoDocumento.value == "" && inputSearchInvolucradoDireccion.value == "" && selectSearchInvolucradoEstado.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records + ")";

                        $("#tabVerticalLeft4 #paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#tabVerticalLeft4 #link');
                        const botonEditar = d.querySelectorAll('#tabVerticalLeft4 #linkEditar');
                        const botonSeleccionar = d.querySelectorAll('#tabVerticalLeft4 #lnkSeleccionar');

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
                                inputInvolucradoRazonSocial.value = records_find[indice].involucrado_nombre;
                                inputInvolucradoDocumento.value = records_find[indice].involucrado_documento;
                                inputInvolucradoTelefono.value = records_find[indice].involucrado_telefono;
                                inputInvolucradoDireccion.value = records_find[indice].involucrado_direccion;
                                $('#tabVerticalLeft4 #selectClasificacion').val(records_find[indice].clasificacion_id).trigger('change');
                                $('#tabVerticalLeft4 #selectActividad').val(records_find[indice].actividad_id).trigger('change');
                                $('#tabVerticalLeft4 #selectGrupo').val(records_find[indice].grupo_id).trigger('change');
                                checkInvolucradoEstado.checked = records_find[indice].involucrado_estado == 1 ? true : false;

                                if (records_find[indice].involucrado_documento == '')
                                    inputInvolucradoDocumento.removeAttribute('disabled');
                                else
                                    inputInvolucradoDocumento.setAttribute('disabled', true);
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
                                    botonInvolucradoJuridicoCancelar.click();
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
        const inputInvolucradoId = d.querySelector('#tabVerticalLeft4 #inputId');
        const inputInvolucradoRazonSocial = d.querySelector('#tabVerticalLeft4 #inputRazonSocial');
        const inputInvolucradoDocumento = d.querySelector('#tabVerticalLeft4 #inputRuc');
        const inputInvolucradoDireccion = d.querySelector('#tabVerticalLeft4 #inputDireccion');
        const inputInvolucradoTelefono = d.querySelector('#tabVerticalLeft4 #inputTelefono');

        const inputSearchInvolucradoRazonSocial = d.querySelector('#tabVerticalLeft4 #inputSearchRazonSocial');
        const inputSearchInvolucradoDocumento = d.querySelector('#tabVerticalLeft4 #inputSearchDocumento');
        const inputSearchInvolucradoDireccion = d.querySelector('#tabVerticalLeft4 #inputSearchDireccion');
        //const inputSearchInvolucradoTelefono = d.querySelector('#tabVerticalLeft4 #inputSearchTelefono');

        //VARIABLES CHECKBOXS
        const checkInvolucradoEstado = d.querySelector('#tabVerticalLeft4 #checkEstado');

        //VARIABLES SELECTS
        /*const selectInvolucradoClasificacion = d.querySelector('#tabVerticalLeft4 #selectClasificacion');
        const selectInvolucradoActividad = d.querySelector('#tabVerticalLeft4 #selectActividad');
        const selectInvolucradoGrupo = d.querySelector('#tabVerticalLeft4 #selectGrupo');*/

        const selectSearchInvolucradoEstado = d.querySelector('#tabVerticalLeft4 #selectSearchEstado');

        //VARIABLES BUTTONS
        const botonInvolucradoBuscarRuc = d.querySelector('#tabVerticalLeft4 #linkBuscarRuc');
        const botonInvolucradoJuridicoCancelar = d.querySelector('#tabVerticalLeft4 #linkCancelar');
        const botonInvolucradoJuridicoAñadir = d.querySelector('#tabVerticalLeft4 #linkAñadir');

        //VARIABLE FORM
        const formInvolucradoJuridico = d.querySelector('#mdlJuridico #formInvolucrado');

        //VARIABLE TAB
        const tabJuridico = d.querySelector('#mdlJuridico #baseVerticalLeft1-tab4')

        filtersInvolucrado = (link) => {
            const fd = new FormData()
            fd.append('involucrado_nombre', inputSearchInvolucradoRazonSocial.value)
            fd.append('involucrado_documento', inputSearchInvolucradoDocumento.value)
            fd.append('involucrado_direccion', inputSearchInvolucradoDireccion.value)
            //fd.append('involucrado_telefono', inputSearchInvolucradoTelefono.value)
            fd.append('involucrado_estado', selectSearchInvolucradoEstado.value)
            fd.append('num_page', link)
            fd.append('quantity', 5)
            return fd;
        }

        //listInvolucrado(filtersInvolucrado(1));

        const validarDataInvolucrado = (link = false) => {
            const respuesta = listInvolucrado(filtersInvolucrado(link));

            if (respuesta !== undefined)
                listInvolucrado(filtersInvolucrado());
            else {
                if (link === false)
                    $('#tabVerticalLeft4 #tableRegistro tbody').html('<tr><td colspan="12"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else(link > 0)
                $('#tabVerticalLeft4 #tableRegistro tbody').html('<tr><td colspan="12"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchInvolucradoRazonSocial.addEventListener('keyup', e => {
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

        selectSearchInvolucradoEstado.addEventListener('change', e => {
            validarDataInvolucrado(1);
        });
        
        botonInvolucradoBuscarRuc.addEventListener('click', e => {
            e.preventDefault();
            obtenerDatosPorRuc(inputInvolucradoDocumento.value);
        });

        inputInvolucradoDocumento.addEventListener('keypress', e => {
            validarSoloNumeros(e);
        });

        const obtenerDatosPorRuc = (ruc) => {
            if (inputInvolucradoDocumento.value.length == 11) {
                // promesa crea un objeto y este tiene metodos
                ajax('post', `consultar_ruc/` + ruc)
                    .then((respuesta) => {
                        if (respuesta.success) {
                            botonInvolucradoBuscarRuc.classList.add('disabled');
                            inputInvolucradoDocumento.setAttribute('disabled', 'disabled');
                            inputInvolucradoRazonSocial.value = respuesta.nombres;
                            if (respuesta.direccion != null) {
                                inputInvolucradoDireccion.value = respuesta.direccion;
                                inputInvolucradoTelefono.focus();
                            } else {
                                inputInvolucradoDireccion.removeAttribute('disabled');
                                inputInvolucradoDireccion.focus();
                            }
                        } else {
                            swal({
                                icon: 'info',
                                title: 'Información',
                                text: respuesta.message,
                                timer: 3000,
                                buttons: false
                            });
                        }
                    });
            }else {
                inputInvolucradoDocumento.value = '';
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'RUC invalido: El número de ruc es de 11 digitos',
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

        botonInvolucradoJuridicoCancelar.addEventListener('click', e => {
            e.preventDefault();
            formInvolucradoJuridico.reset();
            inputInvolucradoDocumento.removeAttribute('disabled');
            if (botonInvolucradoBuscarRuc.classList.contains('disabled'))
                botonInvolucradoBuscarRuc.classList.remove('disabled');
            inputInvolucradoRazonSocial.setAttribute('disabled' ,'disabled');
            inputInvolucradoDireccion.setAttribute('disabled' ,'disabled');
            inputInvolucradoId.value = '0';
            checkInvolucradoEstado.checked = true;
            inputInvolucradoDocumento.focus();

            $('#tabVerticalLeft4 #selectClasificacion').val('').trigger('change');
            $('#tabVerticalLeft4 #selectActividad').val('').trigger('change');
            $('#tabVerticalLeft4 #selectGrupo').val('').trigger('change');

            if(d.body.contains(d.querySelector('#selectInvolucrado')))
                listarInvolucradosJuridico();
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
            fd.append('involucrado_nombre', inputInvolucradoRazonSocial.value);
            fd.append('involucrado_documento', inputInvolucradoDocumento.value);
            fd.append('involucrado_direccion', inputInvolucradoDireccion.value);
            fd.append('involucrado_telefono', inputInvolucradoTelefono.value);
            /*fd.append('clasificacion_id', selectInvolucradoClasificacion.value);
            fd.append('actividad_id', selectInvolucradoActividad.value);
            fd.append('grupo_id', selectInvolucradoGrupo.value);*/
            fd.append('involucrado_estado', checkInvolucradoEstado.checked ? 1 : 0);
            if (inputInvolucradoId.value != 0)
                fd.append('involucrado_fecha_update', fecha_actual);

            ajax('post', `${apiRestMantenimiento}/J`, fd)
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

                        botonInvolucradoJuridicoCancelar.click();
                        listInvolucrado(filtersInvolucrado(1));
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

        botonInvolucradoJuridicoAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (inputInvolucradoDocumento.value.length != 11) {
                inputInvolucradoDocumento.value = '';
                inputInvolucradoDireccion.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'RUC invalido: El número de ruc es de 11 digitos',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoDocumento.hasAttribute('disabled') && inputInvolucradoDocumento.value == '') {
                inputInvolucradoDocumento.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese nro de ruc',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoRazonSocial.hasAttribute('disabled') && inputInvolucradoRazonSocial.value == '') {
                inputInvolucradoRazonSocial.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese Razón Social',
                    timer: 3000,
                    buttons: false
                });
            } else if (!inputInvolucradoDireccion.hasAttribute('disabled') && inputInvolucradoDireccion.value == '') {
                inputInvolucradoDireccion.focus();
                swal({
                    icon: 'info',
                    title: 'Información',
                    text: 'Ingrese Dirección Fiscal',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudInvolucrado();
            }
        });

        const divCambioClass = d.querySelector('#divCambioClass');
        tabJuridico.addEventListener('click', e => {
            const mdlTitulo = d.querySelector('#mdlJuridico #myModalLabel8');
            mdlTitulo.innerHTML = 'MANTENIMIENTO DE INVOLUCRADO JURÍDICO';

            if (divCambioClass.classList.contains('modal-lg')) {
                divCambioClass.classList.remove('modal-lg');
                divCambioClass.classList.add('modal-xl')
            }
        });
    })
})(document);
