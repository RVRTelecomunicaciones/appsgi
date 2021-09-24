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
        const apiRestListar = sessionStorage.getItem('data') != null ? '../../marca/searchMarca' : '../marca/searchMarca';

        const inputId = d.querySelector('#mdlMarca #inputId');
        const inputDescripcion = d.querySelector('#mdlMarca #inputDescripcion');

        const inputSearchNombre = d.querySelector('#mdlMarca #inputSearchNombre');
        const botonCancelar = d.querySelector('#mdlMarca #linkCancelar');
        const botonGuardar = d.querySelector('#mdlMarca #linkAñadir');
        const botonClose = d.querySelector('#mdlMarca #btnClose');

        listMarca = (filtersMarca) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filtersMarca)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    const registros = respuesta.tasacion_marca_records;
                    const registrosCombo = respuesta.tasacion_marca_all;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.marca_id != 0) {
                                return `<tr>
                                            <td>${respuesta.init+index}</td>
                                            <td><div align='left'>${item.marca_nombre.toUpperCase()}</div></td>
                                            <td><a id='lnkEditar' data-indice='${index}'><i class='fa fa-edit'></i></a></td>
                                        </tr>`
                            }
                        }).join("");

                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.marca_id}">${item.marca_nombre}</option>`
                            else
                                return `<option value="${item.marca_id}">${item.marca_nombre}</option>`
                        }).join("");

                        $('#tbl_tasacion_marca tbody').html(filas);
                        $('#selectMarca').html(filasCombo);

                        if (sessionStorage.getItem('data') != null) {
                            const objData = JSON.parse(sessionStorage.getItem('data'));
                
                            if(objData.tasacion_id != null) {
                                $('#selectMarca').val(objData.marca_id).trigger('change');
                            }
                        }

                        //alert(filtersMarca.get('quantity'));
                        //paginacion
                        linkseleccionado = Number(filtersMarca.get('num_page'));
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

                        const spanMostrarRegistros = d.querySelector('#mdlMarca #conteo_marca');

                        if (inputSearchNombre.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $("#mdlMarca #paginacion_marca").html(paginador);

                        const link_pagination = d.querySelectorAll('#mdlMarca #link');
                        const link_editar = d.querySelectorAll('#mdlMarca #lnkEditar');

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
                                inputId.value = registros[indice].marca_id;
                                inputDescripcion.value = registros[indice].marca_nombre;
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        const selectTipoTasacion = d.getElementById('selectTipoTasacion');

        filtersMarca = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('marca_tipo', selectTipoTasacion.value == 7 ? 'V' : 'M')
            fd.append('marca_nombre', inputSearchNombre.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        /*listMarca(filtersMarca(5,1));*/

        const validarData = (link = false) => {
            //const respuesta = 
            listMarca(filtersMarca(5,link));
            
            /*if (respuesta !== undefined)
                listMarca(filtersMarca(5));
            else
            {
                if (link === false)
                    $('#tbl_tasacion_marca tbody').html('<tr><td colspan="3"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_tasacion_marca tbody').html('<tr><td colspan="3"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }*/
        }

        inputSearchNombre.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const crudTasCliente = () => {
            let apiInsert = sessionStorage.getItem('data') != null ? '../../marca/insertMarca' : '../marca/insertMarca';
            let apiUpdate = sessionStorage.getItem('data') != null ? '../../marca/updateMarca' : '../marca/updateMarca';
            const apiRestMantenimiento = inputId.value == 0 ? apiInsert : apiUpdate;

            const fd = new FormData();
            fd.append('marca_id', inputId.value)
            fd.append('marca_tipo', selectTipoTasacion.value == 7 ? 'V' : 'M')
            fd.append('marca_nombre', inputDescripcion.value.toUpperCase().trim())

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success == 'existe') {
                        swal({
                            text: 'La marca ya esta registrada ...',
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
            if (inputDescripcion.value.trim() == "" || inputDescripcion.value.length < 2) {
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
        });

        botonClose.addEventListener('click', e => {
            inputSearchNombre.value = "";
            botonCancelar.click();
        });
    })
})(document);
