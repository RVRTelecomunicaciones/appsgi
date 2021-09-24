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
        const apiRestListar = sessionStorage.getItem('data') != null ? '../../zonificacion/searchZonificacion' : '../zonificacion/searchZonificacion';

        const inputId = d.querySelector('#mdlZonificacion #inputId');
        const inputDescripcion = d.querySelector('#mdlZonificacion #inputDescripcion');
        const inputAbreviatura = d.querySelector('#mdlZonificacion #inputAbreviatura');

        const inputSearchNombre = d.querySelector('#mdlZonificacion #inputSearchNombre');
        const botonCancelar = d.querySelector('#mdlZonificacion #linkCancelar');
        const botonGuardar = d.querySelector('#mdlZonificacion #linkAñadir');
        const botonClose = d.querySelector('#mdlZonificacion #btnClose');

        const listZonificacion = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_zonificacion_records;
                    const registrosCombo = respuesta.tasacion_zonificacion_all;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.zonificacion_id != 0) {
                                return `<tr>
                                            <td>${respuesta.init+index}</td>
                                            <td><div align='left'>${item.zonificacion_nombre.toUpperCase()}</div></td>
                                            <td>${item.zonificacion_abreviatura}</td>
                                            <td><a id='lnkEditar' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                        </tr>`
                            }
                        }).join("");

                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.zonificacion_id}">${item.zonificacion_nombre}</option>`
                            else
                                return `<option value="${item.zonificacion_id}">${item.zonificacion_abreviatura} - ${item.zonificacion_nombre}</option>`
                        }).join("");

                        $('#tbl_tasacion_zonificacion tbody').html(filas);
                        $('#selectZonificacion').html(filasCombo);

                        if (sessionStorage.getItem('data') != null) {
                            const objData = JSON.parse(sessionStorage.getItem('data'));
                
                            if(objData.tasacion_id != null) {
                                $('#selectZonificacion').val(objData.zonificacion_id).trigger('change');
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

                        const spanMostrarRegistros = d.querySelector('#conteo_zonificacion');

                        if (inputSearchNombre.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $("#paginacion_zonificacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlZonificacion #link');
                        const link_editar = d.querySelectorAll('#mdlZonificacion #lnkEditar');

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
                                inputId.value = registros[indice].zonificacion_id;
                                inputDescripcion.value = registros[indice].zonificacion_nombre;
                                inputAbreviatura.value = registros[indice].zonificacion_abreviatura;
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
            fd.append('zonificacion_nombre', inputSearchNombre.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listZonificacion(filters(5,1));

        const validarData = (link = false) => {
            //const respuesta = 
            listZonificacion(filters(5,link));
            
            /*if (respuesta !== undefined)
                listZonificacion(filters(5));
            else
            {
                if (link === false)
                    $('#tbl_tasacion_zonificacion tbody').html('<tr><td colspan="4"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion_zonificacion tbody').html('<tr><td colspan="4"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }*/
        }

        inputSearchNombre.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const crudTasCliente = () => {
            let apiInsert = sessionStorage.getItem('data') != null ? '../../zonificacion/insertZonificacion' : '../zonificacion/insertZonificacion';
            let apiUpdate = sessionStorage.getItem('data') != null ? '../../zonificacion/updateZonificacion' : '../zonificacion/updateZonificacion';
            const apiRestMantenimiento = inputId.value == 0 ? apiInsert : apiUpdate;

            const fd = new FormData();
            fd.append('zonificacion_id', inputId.value)
            fd.append('zonificacion_nombre', inputDescripcion.value.toUpperCase().trim())
            fd.append('zonificacion_abreviatura', inputAbreviatura.value.toUpperCase().trim())

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    /*if (respuesta.success == 'existe') {
                        swal({
                            text: 'La zonificación ya esta registrada ...',
                            timer: 3000,
                            buttons: false
                        });
                    } else */if (respuesta.success) {
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
            if (inputDescripcion.value.trim() == "" || inputDescripcion.value.length < 5) {
                swal({
                    text: 'Ingresé Ap. y Nombre // Razón Social válida',
                    timer: 1500,
                    buttons: false
                });
            } else if (inputAbreviatura.value.trim() == "" || inputAbreviatura.value.trim().length < 2) {
                swal({
                    text: 'Ingresé Ap. y Nombre // Razón Social válida',
                    timer: 1500,
                    buttons: false
                });
            } else {
                crudTasCliente();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            inputId.value = "0";
            inputDescripcion.value = "";
            inputAbreviatura.value = "";
        });

        botonClose.addEventListener('click', e => {
            inputSearchNombre.value = "";
            botonCancelar.click();
        });
    })
})(document);
