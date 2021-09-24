(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const apiRestListar = './permiso/searchPermiso';

        listPermiso = (filtersPermiso) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filtersPermiso)
                .then((respuesta) => {
                    //console.log(respuesta.tasacion_records);
                    const registro = respuesta.permiso_records;
                    if (registro != false) {
                        const filas = registro.map((item, index) => {
                            return `<tr>
                                        <td>${index+1}</td>
                                        <td><div align='left'>${item.menu_tipo == 'S' || item.menu_tipo == 'SN' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + item.menu_descripcion.toUpperCase() : item.menu_tipo == 'SSN' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + item.menu_descripcion.toUpperCase() : item.menu_descripcion.toUpperCase()}</div></td>
                                        <td>
                                            <input
                                                id='checkLectura'
                                                data-indice='${index}'
                                                data-pertenece='${item.menu_pertenece}'
                                                type='checkbox'
                                                ${
                                                    item.menu_tipo == 'M' ?
                                                        item.permiso_lectura == '1' ? 
                                                            'checked' 
                                                            :
                                                            '' 
                                                        :
                                                        item.principal == '1' ?
                                                            item.permiso_lectura == '1' ?
                                                                'checked'
                                                                :
                                                                ''
                                                            :
                                                            'disabled'
                                                }
                                            >
                                        </td>
                                        <td>
                                            ${
                                                item.menu_tipo == 'M' || item.menu_tipo == 'SN' || item.menu_tipo == 'SSN' || item.menu_pertenece == 21 ?
                                                    ''
                                                    :
                                                    `<input
                                                        id='checkEscritura'
                                                        data-indice='${index}'
                                                        data-pertenece='${item.menu_pertenece}'
                                                        type='checkbox'
                                                        ${
                                                            item.principal == '1' ?
                                                                item.permiso_escritura == '1' ?
                                                                    'checked'
                                                                    :
                                                                    ''
                                                                :
                                                                'disabled'
                                                        }
                                                    >`
                                            }
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#tbl_permiso tbody').html(filas);

                        const check_lectura = d.querySelectorAll('#checkLectura');
                        const check_escritura = d.querySelectorAll('#checkEscritura');
                        const check_All = d.querySelectorAll('input[type="checkbox"]');

                        check_lectura.forEach(check => {
                            check.addEventListener('change', e => {
                                let indice = check.dataset.indice;
                                if (check.checked) {
                                    check_All.forEach(checkAll => {
                                        if (registro[indice].menu_id == checkAll.dataset.pertenece) {
                                            checkAll.removeAttribute('disabled');
                                        }
                                    });
                                    registro.forEach((data, index) => {
                                        if (indice == index) {
                                            data.permiso_lectura = '1';

                                            if (data.permiso_id != '0')
                                                if (data.permiso_escritura == '0') {
                                                    if (data.menu_tipo == 'M' || data.menu_tipo == 'SN' || data.menu_tipo == 'SSN' || data.menu_pertenece == 21)
                                                        data.permiso_accion = '';
                                                    else
                                                        data.permiso_accion = 'upd';
                                                } else
                                                    data.permiso_accion = 'upd';
                                            else
                                                data.permiso_accion = 'add';
                                        }
                                    });
                                } else {
                                    check_All.forEach(checkAll => {
                                        if (registro[indice].menu_id == checkAll.dataset.pertenece) {
                                            checkAll.checked = false;
                                            checkAll.setAttribute('disabled','disabled');
                                        }
                                    });
                                    registro.forEach((data, index) => {
                                        if (indice == index) {
                                            data.permiso_lectura = '0';

                                            if (data.permiso_id != '0') {
                                                if (data.permiso_escritura == '0')
                                                    if (data.menu_tipo == 'M' || data.menu_tipo == 'SN' || data.menu_tipo == 'SSN' || data.menu_pertenece == 21)
                                                        data.permiso_accion = 'del';
                                                    else
                                                        data.permiso_accion = 'del';
                                                else
                                                    data.permiso_accion = 'upd';
                                            } else {
                                                if (data.permiso_escritura == '0') {
                                                    /*if (data.menu_tipo == 'M' || data.menu_tipo == 'SN' || data.menu_tipo == 'SSN' || data.menu_pertenece == 21)
                                                        data.permiso_accion = '';
                                                    else*/
                                                        data.permiso_accion = '';
                                                } else
                                                    data.permiso_accion = 'add';
                                            }
                                        }
                                    });
                                    
                                    if (registro[indice].menu_pertenece == '0') {
                                        registro.forEach((data, index) => {
                                            if (registro[indice].menu_id == data.menu_pertenece) {
                                                data.permiso_lectura = '0';
                                                data.permiso_escritura = '0';

                                                if (data.permiso_id != 0)
                                                    data.permiso_accion = 'del';
                                                else
                                                    data.permiso_accion = '';
                                            }
                                        });
                                    }
                                }

                                sessionStorage.setItem('permiso', JSON.stringify(registro));
                            })
                        });

                        check_escritura.forEach(check => {
                            check.addEventListener('change', e => {
                                let indice = check.dataset.indice;
                                if (check.checked) {
                                    registro.forEach((data, index) => {
                                        if (indice == index) {
                                            data.permiso_escritura = '1';

                                            if (data.permiso_id != 0) {
                                                    data.permiso_accion = 'upd';
                                            } else {
                                                /*if (data.permiso_lectura == '0')
                                                    data.permiso_accion = 'add';
                                                else*/
                                                    data.permiso_accion = 'add';
                                            }
                                        }
                                    });
                                } else {
                                    registro.forEach((data, index) => {
                                        if (indice == index) {
                                            data.permiso_escritura = '0';

                                            if (data.permiso_id != 0) {
                                                if (data.permiso_lectura == '0')
                                                    data.permiso_accion = 'del';
                                                else
                                                    data.permiso_accion = 'upd';
                                            } else {
                                                if (data.permiso_lectura == '0')
                                                    data.permiso_accion = '';
                                                else
                                                    data.permiso_accion = 'add';
                                            }
                                        }
                                    });
                                }

                                sessionStorage.setItem('permiso', JSON.stringify(registro));
                            })
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        filtersPermiso = (usuario) => {
            const fd = new FormData()
            //fd.append('accion', 'full')
            fd.append('usuario_id', usuario)
            return fd;
        }

        const btnGuardarPermiso = d.getElementById('btnGuardarPermiso');
        const btnCerrarPermiso = d.getElementById('btnCerrarPermiso');

        btnGuardarPermiso.addEventListener('click', e => {
            e.preventDefault();
            let objPermiso = JSON.parse(sessionStorage.getItem('permiso')) || [];

            if (Object.keys(objPermiso).length != 0) {
                const fd = new FormData()
                fd.append('permisos', JSON.stringify(objPermiso))
                
                ajax('post', './permiso/asignarPermiso', fd)
                    .then((respuesta) => {
                        //console.log(respuesta);
                        if (respuesta.success) {
                            swal({
                                icon: 'success',
                                title: 'Guardado',
                                text: 'Se ha guardado correctamente ...',
                                timer: 3000,
                                buttons: false
                            })
                            .then(() => btnCerrarPermiso.click());
                        } else {
                            swal({
                                text: 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!',
                                timer: 3000,
                                buttons: false
                            })
                            .then(() => btnCerrarPermiso.click());
                        }
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    })
            } else {
                swal({
                    text: 'No se ha seleccionado ningún permiso',
                    timer: 3000,
                    buttons: false
                });
            }
        });

        btnCerrarPermiso.addEventListener('click', e => {
            sessionStorage.clear();
        });
    })
})(document);