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
        const apiRestListar = '../tassolicitante/searchSolicitante';

        const inputSolicitanteId = d.querySelector('#mdlSolicitante #inputId');
        const inputNombre = d.querySelector('#mdlSolicitante #inputNombreCompleto');
        const inputNroDocumento = d.querySelector('#mdlSolicitante #inputNroDocumento');

        const inputSearchNombre = d.querySelector('#mdlSolicitante #inputSearchNombre');
        const inputSearchNroDocumento = d.querySelector('#mdlSolicitante #inputSearchNroDocumento');
        const botonCancelar = d.querySelector('#mdlSolicitante #linkCancelar');
        const botonGuardar = d.querySelector('#mdlSolicitante #linkAñadir');
        const botonClose = d.querySelector('#mdlSolicitante #btnClose');

        const listSolicitante = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_solicitante_records;
                    const registrosCombo = respuesta.tasacion_solicitante_all;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {

                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td><div align='left'>${item.solicitante_nombre.replace(/\\/g, "")}</div></td>
                                        <td>${item.solicitante_nro_documento}</td>
                                        <td><a id='lnkEditar' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                    </tr>`
                        }).join("");

                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.solicitante_id}">${item.solicitante_nombre.replace(/\\/g, "")}</option>`
                            else
                                return `<option value="${item.solicitante_id}">${item.solicitante_nombre.replace(/\\/g, "")}</option>`
                        }).join("");

                        $('#tbl_tasacion_solicitante tbody').html(filas);
                        $('#selectSolicitante').html(filasCombo);

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

                        const spanMostrarRegistros = d.querySelector('#conteo_solicitante');

                        if (inputSearchNombre.value == "" && inputSearchNroDocumento.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $("#paginacion_solicitante").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlSolicitante #link');
                        const link_editar = d.querySelectorAll('#mdlSolicitante #lnkEditar');

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
                                inputSolicitanteId.value = registros[indice].solicitante_id;
                                inputNombre.value = registros[indice].solicitante_nombre.replace(/\\/g, "");
                                inputNroDocumento.value = registros[indice].solicitante_nro_documento;
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
            fd.append('solicitante_nombre', inputSearchNombre.value)
            fd.append('solicitante_nro_documento', inputSearchNombre.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listSolicitante(filters(5,1));

        const validarData = (link = false) => {
            const respuesta = listSolicitante(filters(5,link));
            
            if (respuesta !== undefined)
                listSolicitante(filters(5));
            else
            {
                if (link === false)
                    $('#tbl_tasacion_solicitante tbody').html('<tr><td colspan="4"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion_solicitante tbody').html('<tr><td colspan="4"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        inputSearchNombre.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const crudTasSolicitante = () => {
            const apiRestMantenimiento = inputSolicitanteId.value == 0 ? '../tassolicitante/insertSolicitante' : '../tassolicitante/updateSolicitante';

            const fd = new FormData();
            fd.append('solicitante_id', inputSolicitanteId.value)
            fd.append('solicitante_nombre', inputNombre.value.toUpperCase().trim())
            fd.append('solicitante_nro_documento', inputNroDocumento.value.trim())

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success == 'existe') {
                        swal({
                            text: 'El solicitante ya esta registrado ...',
                            timer: 3000,
                            buttons: false
                        });
                    } else if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputSolicitanteId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });

                        botonCancelar.click();
                        validarData(1);
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: inputSolicitanteId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
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
            if (inputNombre.value.trim() == "" || inputNombre.value.trim().length < 5) {
                swal({
                    text: 'Ingresé Ap. y Nombre // Razón Social válida',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudTasSolicitante();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputSolicitanteId.value = "0";
            inputNombre.value = "";
            inputNroDocumento.value = "";
        });

        botonClose.addEventListener('click', e => {
            inputSearchNombre.value = "";
            inputSearchNombre.value = "";
            botonCancelar.click();
        });
    })
})(document);
