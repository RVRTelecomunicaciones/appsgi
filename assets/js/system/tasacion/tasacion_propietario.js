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
        const apiRestListar = sessionStorage.getItem('data') != null ? '../../taspropietario/searchPropietario' : '../taspropietario/searchPropietario';

        const inputId = d.querySelector('#mdlPropietario #inputId');
        const inputNombreCompleto = d.querySelector('#mdlPropietario #inputNombreCompleto');
        const inputNroDocumento = d.querySelector('#mdlPropietario #inputNroDocumento');

        const inputSearchNombre = d.querySelector('#mdlPropietario #inputSearchNombre');
        const inputSearchNroDocumento = d.querySelector('#mdlPropietario #inputSearchNroDocumento');
        const botonCancelar = d.querySelector('#mdlPropietario #linkCancelar');
        const botonGuardar = d.querySelector('#mdlPropietario #linkAñadir');
        const botonClose = d.querySelector('#mdlPropietario #btnClose');

        const listPropietario = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_propietario_records;
                    const registrosCombo = respuesta.tasacion_propietario_all;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td><div align='left'>${item.propietario_nombre.replace(/\\/g, "")}</div></td>
                                        <td>${item.propietario_nro_documento}</td>
                                        <td><a id='lnkEditar' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.propietario_id}">${item.propietario_nombre.replace(/\\/g, "")}</option>`
                            else
                                return `<option value="${item.propietario_id}">${item.propietario_nombre.replace(/\\/g, "")}</option>`
                        }).join("");

                        $('#tbl_tasacion_propietario tbody').html(filas);
                        $('#selectPropietario').html(filasCombo);


                        if (sessionStorage.getItem('data') != null) {
                            const objData = JSON.parse(sessionStorage.getItem('data'));
                
                            if(objData.tasacion_id != null) {
                                $('#selectPropietario').val(objData.propietario_id).trigger('change');
                            }
                        }
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

                        const spanMostrarRegistros = d.querySelector('#conteo_propietario');

                        if (inputSearchNombre.value == "" && inputSearchNroDocumento.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $("#paginacion_propietario").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlPropietario #link');
                        const link_editar = d.querySelectorAll('#mdlPropietario #lnkEditar');

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
                                inputId.value = registros[indice].propietario_id;
                                inputNombreCompleto.value = registros[indice].propietario_nombre.replace(/\\/g, "");
                                inputNroDocumento.value = registros[indice].propietario_nro_documento;
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
            fd.append('propietario_nombre', inputSearchNombre.value)
            fd.append('propietario_nro_documento', inputSearchNroDocumento.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listPropietario(filters(5,1));

        const validarData = (link = false) => {
            //const respuesta = 
            listPropietario(filters(5,link));
            
            /*if (respuesta !== undefined)
                listPropietario(filters(5));
            else
            {
                if (link === false)
                    $('#tbl_tasacion_propietario tbody').html('<tr><td colspan="4"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion_propietario tbody').html('<tr><td colspan="4"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }*/
        }

        inputSearchNombre.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        inputSearchNroDocumento.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const crudTasPropiedad = () => {
            let apiInsert = sessionStorage.getItem('data') != null ? '../../taspropietario/insertPropietario' : '../taspropietario/insertPropietario';
            let apiUpdate = sessionStorage.getItem('data') != null ? '../../taspropietario/updatePropietario' : '../taspropietario/updatePropietario';
            const apiRestMantenimiento = inputId.value == 0 ? apiInsert : apiUpdate;

            const fd = new FormData();
            fd.append('propietario_id', inputId.value)
            fd.append('propietario_nombre', inputNombreCompleto.value.toUpperCase().trim())
            fd.append('propietario_nro_documento', inputNroDocumento.value)

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success == 'existe') {
                        swal({
                            text: 'El propietario ya esta registrado ...',
                            timer: 3000,
                            buttons: false
                        });
                    } else if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

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
            if (inputNombreCompleto.value.trim() == "" || inputNombreCompleto.value.trim().length < 5) {
                swal({
                    text: 'Ingresé Ap. y Nombre // Razón Social válida',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudTasPropiedad();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputId.value = "0";
            inputNombreCompleto.value = "";
            inputNroDocumento.value = "";
        });

        botonClose.addEventListener('click', e => {
            inputSearchNombre.value = "";
            inputSearchNroDocumento.value = "";
            botonCancelar.click();
        });

        /*if (sessionStorage.getItem('data') != null) {
            const objData = JSON.parse(sessionStorage.getItem('data'));

            if(objData.tasacion_id != null) {
                $('#selectPropietario').val(objData.propietario_id).trigger('change');
            }
        }*/
    })
})(document);