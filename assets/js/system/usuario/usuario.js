(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });

        $('.select2-container--classic').css('width', '100%');

        const apiRestListar = 'usuario/searchUsuario';

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };
        
        const inputSearchNombreCompleto = d.getElementById('inputSearchNombreCompleto');
        const inputSearchCorreo = d.getElementById('inputSearchCorreo');

        const inputId = d.getElementById('inputId');
        const inputNombreCompleto = d.getElementById('inputNombreCompleto');
        const inputCorreo = d.getElementById('inputCorreo');
        const inputUsuario = d.getElementById('inputUsuario');
        const inputClave = d.getElementById('inputClave');
        const inputClaveAnterior = d.getElementById('inputClaveAnterior');
        
        const selectArea = d.getElementById('selectArea');
        const selectRol = d.getElementById('selectRol');
        const selectQuantity = d.getElementById('selectQuantity');

        const listUsuarios = (filters) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    //console.log(respuesta.tasacion_records);
                    const registros = respuesta.usuario_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            return `<tr>
                                        <td>${respuesta.init+index}</td>
                                        <td><div align='left'>${item.usuario_nombre_completo.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.usuario_correo.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.area_descripcion.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.rol_descripcion.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.usuario_login}</div></td>
                                        <td class='${lnkNuevo.classList.contains('hidden') ? 'hidden' : '' }'>
                                            <div class='btn-group'>
                                                <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                <div class='dropdown-menu'>
                                                    <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class='fa fa-edit'></i> Modificar</a>
                                                    <a id='lnkPermisos' href class='dropdown-item' data-indice='${index}'><i class='fa fa-lock'></i> Permisos</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_usuario tbody').html(filas);

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

                        if (inputSearchNombreCompleto.value == "" && inputSearchCorreo.value == "")
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records + " registros";
                        else
                            spanMostrarRegistros.innerHTML = "Mostrando " + respuesta.init + " a " + (cantidadregistros * linkseleccionado) + " de " + respuesta.total_records_find + " registros filtrados ( total de registros " + respuesta.total_records +")";                        

                        $(".paginacion").html(paginador);

                        const link_pagination = d.querySelectorAll('#link');
                        const lnk_permisos = d.querySelectorAll('#lnkPermisos');
                        const link_modificar = d.querySelectorAll('#lnkModificar');

                        link_pagination.forEach(link => {
                            link.addEventListener('click', function(e){
                                e.preventDefault();
                                const num_page = link.getAttribute('href');
                                validarData(num_page);
                            })
                        });

                        lnk_permisos.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                
                                listPermiso(filtersPermiso(registros[indice].usuario_id));
                                $('#mdlPermiso').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });
                            })
                        });

                        link_modificar.forEach(link => {
                            link.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = link.dataset.indice;
                                
                                inputId.value = registros[indice].usuario_id;
                                inputNombreCompleto.value = registros[indice].usuario_nombre_completo;
                                inputCorreo.value = registros[indice].usuario_correo;
                                inputUsuario.value = registros[indice].usuario_login;
                                inputClave.value = registros[indice].usuario_pass;
                                inputClaveAnterior.value = registros[indice].usuario_pass;

                                $('#selectArea').val(registros[indice].area_id == 0 ? '' : registros[indice].area_id).trigger('change');
                                $('#selectRol').val(registros[indice].rol_id == 0 ? '' : registros[indice].rol_id).trigger('change');
                                
                                if (!inputClave.hasAttribute('disabled')) {
                                    inputClave.setAttribute('disabled', true);
                                }

                                if (lnkChangePass.classList.contains('hidden'))
                                    lnkChangePass.classList.remove('hidden');

                                $('#mdlUsuario').modal({
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
            fd.append('usuario_nombre_completo', inputSearchNombreCompleto.value)
            fd.append('usuario_correo', inputSearchCorreo.value)
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }
        
        listArea(filtersArea(5,1));
        listRol(filtersArea(5,1));
        listUsuarios(filters(selectQuantity.value,1));

        const validarData = (link = false) => {
            const respuesta = listUsuarios(filters(selectQuantity.value,link));
            
            if (respuesta !== undefined)
                listUsuarios(filters(selectQuantity.value));
            else
            {
                if (link === false)
                    $('#tbl_usuario tbody').html('<tr><td colspan="5"><div style="font-size: 1.5rem">NO SE ENCONTRARON REGISTROS</div></td></tr>');
                else (link > 0)
                    $('#tbl_usuario tbody').html('<tr><td colspan="5"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>');
            }
        }

        selectQuantity.addEventListener('change', e =>{
            validarData(1);
        });

        inputSearchNombreCompleto.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        inputSearchCorreo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                validarData(1);
        });

        const lnkChangePass = d.getElementById('lnkChangePass');
        const btnGuardarUsuario = d.getElementById('btnGuardarUsuario');
        const btnCerrarUsuario = d.getElementById('btnCerrarUsuario');
        const lnkNuevo = d.getElementById('lnkNuevo');

        lnkNuevo.addEventListener('click', e => {
            e.preventDefault();
            inputId.value = '';
            inputNombreCompleto.value = '';
            inputCorreo.value = '';
            inputUsuario.value = '';
            inputClave.value = '';

            $('#selectArea').val('').trigger('change');
            $('#selectRol').val('').trigger('change');

            lnkChangePass.classList.add('hidden');
            //if (lnkChangePass.classList.contains('hidden'))

            if (inputClave.hasAttribute('disabled')) {
                inputClave.removeAttribute('disabled');
            }

            $('#mdlUsuario').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        lnkChangePass.addEventListener('click', e => {
            if (inputClave.hasAttribute('disabled')) {
                inputClave.removeAttribute('disabled');
                inputClave.value = '';
                inputClave.focus();
            }
        });

        const crudUsuario = () => {
            const apiRestMantenimiento = inputId.value == 0 ? 'usuario/insertUsuario' : 'usuario/updateUsuario';

            const fd = new FormData();
            fd.append('usuario_id', inputId.value);
            fd.append('usuario_nombre_completo', inputNombreCompleto.value);
            fd.append('usuario_correo', inputCorreo.value);
            fd.append('usuario_login', inputUsuario.value);
            fd.append('usuario_pass', inputClave.value);
            fd.append('area_id', selectArea.value);
            fd.append('rol_id', selectRol.value);
            if(inputId.value > 0 && inputClaveAnterior.value == inputClave.value)
                fd.append('password', 'igual');

            ajax('post', apiRestMantenimiento, fd)
                .then((respuesta) => {
                    if (respuesta.success == 'existe') {
                        swal({
                            text: 'El usuario ya se encuentra registrado ...',
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
                        .then(() => btnCerrarUsuario.click(), validarData(1));
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

        btnGuardarUsuario.addEventListener('click', e => {
            if (inputNombreCompleto.value == '') {
                swal({
                    text: 'Ingresé nombre completo',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputCorreo.value == '') {
                swal({
                    text: 'Ingresé correo',
                    timer: 3000,
                    buttons: false
                });
            } else if (selectArea.value == '') {
                swal({
                    text: 'Seleccioné area',
                    timer: 3000,
                    buttons: false
                });
            } else if (selectRol.value == '') {
                swal({
                    text: 'seleccioné rol',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputUsuario.value == '') {
                swal({
                    text: 'Ingresé usuario',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputClave.value == '') {
                swal({
                    text: 'Ingresé contraseña',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudUsuario();
            }
        });
    })
})(document);