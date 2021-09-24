(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const apiRestListar = 'rol/searchRol';

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };
        
        const inputSearchDescripcion = d.getElementById('inputSearchDescripcion');

        const inputId = d.getElementById('inputId');
        const inputDescripcion = d.getElementById('inputDescripcion');

        const selectQuantity = d.getElementById('selectQuantity');

        const listRol = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.tasacion_records);
                    const registros = respuesta.rol_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td><div align="left">${item.rol_descripcion.toUpperCase()}</div></td>
                                        <td class='${lnkNuevo.classList.contains('hidden') ? 'hidden' : '' }'>
                                            <div class='btn-group'>
                                                <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                <div class="dropdown-menu">
                                                    <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class="fa fa-edit"></i> Modificar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_rol tbody').html(filas);

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

                        const spanMostrarRegistros = d.querySelector('#conteo');
                        if (inputDescripcion.value == '')
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const link_modificar = d.querySelectorAll('#lnkModificar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        link_modificar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                
                                inputId.value = registros[indice].rol_id;
                                inputDescripcion.value = registros[indice].rol_descripcion;

                                $('#mdlRol').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });
                            })
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
            fd.append('rol_descripcion', inputSearchDescripcion.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }

        listRol(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listRol(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listRol(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_rol tbody').html('<tr><td colspan="3"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_rol tbody').html('<tr><td colspan="3"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputSearchDescripcion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const btnGuardar = d.getElementById('btnGuardar');
        const btnCerrar = d.getElementById('btnCerrar');
        const lnkNuevo = d.getElementById('lnkNuevo');

        lnkNuevo.addEventListener('click', e => {
            e.preventDefault();
            inputId.value = '';
            inputDescripcion.value = '';

            $('#mdlRol').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        const crudRol = () => {
            const apiRestMantenimiento = inputId.value == 0 ? 'rol/insertRol' : 'rol/updateRol';

            var fd = new FormData();
            fd.append('rol_id', inputId.value);
            fd.append('rol_descripcion', inputDescripcion.value);

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success == 'existe') {
                        swal({
                            text: 'El rol ya se encuentra registrado ...',
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
                        })
                        .then(() => btnCerrar.click(), validarData(1));
                    }
                    else {
                        swal({
                            icon: 'error',
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

        btnGuardar.addEventListener('click', e => {
            if (inputDescripcion.value == '') {
                swal({
                    text: 'Ingresé nombre completo',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudRol();
            }
        });
    })
})(document);