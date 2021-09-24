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
                                        <td><div align="left">${item.menu_tipo == 'S' || item.menu_tipo == 'SN' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + item.menu_descripcion.toUpperCase() : item.menu_tipo == 'SSN' ? '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' + item.menu_descripcion.toUpperCase() : item.menu_descripcion.toUpperCase()}</div></td>
                                        <td><input id="checkLectura" data-indice='${index}' data-pertenece='${item.menu_pertenece}' type="checkbox" ${item.menu_tipo == 'M' ? '' : 'disabled'}></td>
                                        <td>${item.menu_tipo == 'M' || item.menu_tipo == 'SN' || item.menu_tipo == 'SSN' || item.menu_pertenece == 21 ? '' : '<input id="checkEscritura" data-indice="' + index + '" data-pertenece="' + item.menu_pertenece + '" type="checkbox" disabled>'}</td>
                                    </tr>`
                        }).join("");

                        $('#tbl_permiso tbody').html(filas);

                        const check_lectura = d.querySelectorAll('#checkLectura');
                        const check_All = d.querySelectorAll('input[type="checkbox"]');

                        check_lectura.forEach(check => {
                            check.addEventListener('change', e => {
                                let indice = check.dataset.indice;
                                if (check.checked) {
                                    check_All.forEach(check => {
                                        if (registro[indice].menu_id == check.dataset.pertenece) {
                                            check.removeAttribute('disabled');
                                        }
                                    });
                                    crudPermiso(registro[indice].permiso_id, registro[indice].usuario_id, registro[indice].menu_tipo, registro[indice].menu_id, 1, 0);
                                } else {
                                    check_All.forEach(check => {
                                        if (registro[indice].menu_id == check.dataset.pertenece) {
                                            check.checked = false;
                                            check.setAttribute('disabled','disabled');
                                        }
                                    });
                                    crudPermiso(registro[indice].permiso_id, registro[indice].usuario_id, registro[indice].menu_tipo, registro[indice].menu_id, 0, 0);
                                }
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

        const crudPermiso = (permiso, usuario, tipo, menu, lectura, escritura) => {
            const apiRestMantenimiento = permiso == 0 ? './permiso/insertPermiso' : './permiso/updatePermiso';
            const fdCrud = new FormData()
            fdCrud.append('permiso_id', permiso)
            fdCrud.append('permiso_usuario', usuario)
            fdCrud.append('permiso_menu', menu)
            fdCrud.append('permiso_lectura', lectura)
            fdCrud.append('permiso_escritura', escritura)
            if (permiso != 0 && (tipo == 'M'|| tipo == 'SN'))
                fdCrud.append('accion', 'updAll')

            ajax('post', apiRestMantenimiento, fdCrud)
                .then((respuesta) => {
                    console.log(respuesta);
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })

            /*switch (tipo) {
                case 'M':
                case 'SN':
                    ajax('post', apiRestMantenimiento, fdCrud)
                        .then((respuesta) => {

                        })
                        .catch(() => {
                            console.log("Promesa no cumplida")
                        })
                    break;
                case 'S':
                    alert('');
                    break;
                default:
                    break;
            }*/
        }
    })
})(document);