(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const modulo = d.getElementById('linkModulo').innerText.toLowerCase();

        //COORDINACION
        const inputFechaEntrega = d.getElementById('inputFechaEntrega');

        //TABLA
        const tableBody = d.getElementById('tbl_inspeccion').getElementsByTagName('tbody')[0];

        //
        const buttonNewInspeccion = d.getElementById('buttonNewInspeccion');
        const form = d.getElementById('frm_inspeccion');
        const inputCodigo = d.getElementById('inputCodigo');
        const inputId = d.getElementById('inputId');
        const buttonCloseInspeccion = d.getElementById('buttonCloseInspeccion');

        //PERSONAL
        const selectPerito = d.getElementById('selectPerito');

        //FECHA
        const inputFecha = d.getElementById('inputFecha');

        //HORA
        const selectHoraTipo = d.getElementById('selectHoraTipo');
        const inputHoraExacta = d.getElementById('inputHoraExacta');
        const inputMinutosExacta = d.getElementById('inputMinutosExacta');
        const selectMeridianoExacta = d.getElementById('selectMeridianoExacta');
        const trHEstimada = d.getElementById('trHEstimada');
        const inputHoraEstimada = d.getElementById('inputHoraEstimada');
        const inputMinutosEstimada = d.getElementById('inputMinutosEstimada');
        const selectMeridianoEstimada = d.getElementById('selectMeridianoEstimada');

        //CONTACTO
        const inputContacto = d.getElementById('inputContacto');

        //OBSERVACIÓN
        const inputObservacion = d.getElementById('inputInspeccionObservacion');

        //UBICACIÓN
        const selectDepartamento = d.getElementById('selectDepartamento');
        const selectProvincia = d.getElementById('selectProvincia');
        const selectDistrito = d.getElementById('selectDistrito');
        const inputDireccion = d.getElementById('inputDireccion');

        listInspeccion = (codigo) => {
            let fd = new FormData();
            fd.append('coordinacion_codigo', codigo);

            tableBody.innerHTML = '<tr><td colspan="8" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', '../inspecciones/search', fd)
                .then((response) => {
                    const records = response.records_find;
                    if (records != false) {
		        		let row = records.map((item, index) => {
		        			return `<tr>
		        						<td>${index + 1}</td>
		        						<td>${item.inspeccion_id}</td>
                                        <td>
                                            ${item.inspeccion_direccion.toUpperCase()}
                                            <br />
                                            <div>${item.departamento_nombre} <i class="fa fa-play" style="color: red;"></i> ${item.provincia_nombre} <i class="fa fa-play" style="color: red;"></i> ${item.distrito_nombre}</div>
                                        </td>
		        						<td>${item.perito_nombre.toUpperCase()}</td>
                                        <td>${item.inspeccion_fecha}</td>
                                        <td>
                                            ${
                                                transformarHora('list', item.inspeccion_hora)
                                            }
                                        </td>
                                        <td><div class="badge badge-${item.estado_id == 1 ? 'danger' : 'success'}">${item.estado_nombre}</div></td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn grey btn-outline-secondary dropdown-toggle btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Acciones</button>
                                                <div class="dropdown-menu">
                                                    <a id="lnkModificar" href class="dropdown-item ${modulo == 'operaciones' ? 'hidden' : ''}" data-indice="${index}"><i class="ft ft-edit"></i> Modificar</a>
                                                    <a id="lnkDetalleVisita" href class="dropdown-item ${modulo == 'coordinacion' || item.visita_id == 0 ? 'hidden' : ''}" data-indice="${index}"><i class="ft ft-file-text"></i> Detalle Visita</a>
                                                    <a id="lnkHoja" href class="dropdown-item" data-indice="${index}"><i class="ft ft-file"></i> Ver Hoja</a>
                                                </div>
                                            </div>
                                        </td>
		        					</tr>`
		        		}).join('');
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
                        
                        const lnkModificar = d.querySelectorAll('#lnkModificar');
                        const lnkDetalleVisita = d.querySelectorAll('#lnkDetalleVisita');
                        const lnkHoja = d.querySelectorAll('#lnkHoja');

                        lnkModificar.forEach(button => {
                            button.addEventListener('click', e => {
                                e.preventDefault();
                                /*if (inputFechaEntrega.value != '') {*/
                                    const indice = button.dataset.indice;
                                    
                                    $('#mdl_inspeccion_detalle').modal({
                                        'show': true,
                                        'keyboard': false,
                                        'backdrop': 'static'
                                    });

                                    inputId.value = records[indice].inspeccion_id;

                                    $('#selectPerito').val(records[indice].perito_id).trigger('change');

                                    inputFecha.value = records[indice].inspeccion_fecha_normal;
                                    selectHoraTipo.value = records[indice].inspeccion_hora_tipo;
                                    changeHoraTipo(records[indice].inspeccion_hora_tipo);
                                    transformarHora('modal', records[indice].inspeccion_hora);

                                    inputContacto.value = records[indice].inspeccion_contacto;
                                    inputObservacion.value = records[indice].inspeccion_observacion;
                                    
                                    listDepartamento(records[indice].departamento_id, records[indice].provincia_id, records[indice].distrito_id);

                                    inputDireccion.value = records[indice].inspeccion_direccion;
                                /*} else {
                                    swal({
                                        icon: 'info',
                                        text: 'Seleccioné fecha de entrega',
                                        timer: 1500,
                                        buttons: false
                                    });
                                }*/
                            })
                        });
                        
                        lnkDetalleVisita.forEach(button => {
                            button.addEventListener('click', e => {
                                e.preventDefault();
                                const indice = button.dataset.indice;

                                let form = d.createElement('form');
                                form.setAttribute('method', 'post');
                                form.setAttribute('action', `../visita/exportarExcel`);
                                form.setAttribute('target', '_blank');

                                let object = {
                                    inspeccion_codigo: records[indice].inspeccion_id
                                };

                                let inputFormCoordinacion = d.createElement('input');
                                inputFormCoordinacion.type = 'text';
                                inputFormCoordinacion.name = 'data';
                                inputFormCoordinacion.value = JSON.stringify(object);
                                form.appendChild(inputFormCoordinacion);

                                d.body.appendChild(form);
                                form.submit();
                                d.body.removeChild(form);
                            })
                        });

                        lnkHoja.forEach(button => {
                            button.addEventListener('click', e => {
                                e.preventDefault();
                                if (inputFechaEntrega.value != '') {
                                    const indice = button.dataset.indice;
                                    const iframe = d.getElementById('ifrm_pdf');
                                    
                                    let datos = {
                                        cotizacion_id: records[indice].cotizacion_id,
                                        inspeccion_id: records[indice].inspeccion_id
                                    }
                                    
                                    //iframe.setAttribute('src', `hoja?data=${JSON.stringify(datos)}`);
                                    iframe.setAttribute('src', `hoja?cotizacion=${records[indice].cotizacion_id}&inspeccion=${records[indice].inspeccion_id}`);
                                    
                                    $('#mdl_hoja_coordinacion').modal({
                                        'show': true,
                                        'keyboard': false,
                                        'backdrop': 'static'
                                    });
                                } else {
                                    swal({
                                        icon: 'info',
                                        text: 'Seleccioné fecha de entrega',
                                        timer: 1500,
                                        buttons: false
                                    });
                                }
                            })
                        });
		        	} else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="8" align="center">NO HAY REGISTROS</td>
					        					</tr>`;
		        	}
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        selectHoraTipo.addEventListener('change', e => {
            changeHoraTipo(selectHoraTipo.value);
        });

        function changeHoraTipo(tipo) {
            switch (parseInt(tipo)) {
                case 1:
                    if (trHEstimada.classList.contains('hidden') == false)
                        trHEstimada.classList.add('hidden');
                    break;
                case 2:
                    if (trHEstimada.classList.contains('hidden'))
                        trHEstimada.classList.remove('hidden')
                    inputHoraEstimada.value = inputHoraExacta.value;
                    inputMinutosEstimada.value = inputMinutosExacta.value;
                    
                    if (parseInt(inputHoraExacta.value) > 11 && parseInt(inputHoraExacta.value) < 24)
                        selectMeridianoEstimada.value = 2;
                    else
                        selectMeridianoEstimada.value = 1;
                    break;
                default:
                    trHEstimada.classList.add('hidden');
                    break;
            }
        }
        
        transformarHora = (tipo, hora) => {
            let caracter = hora.indexOf('-');
            let arrayHora = {00:'12', 13:'01', 14:'02', 15:'03', 16:'04', 17:'05', 18:'06', 19:'07', 20:'08', 21:'09', 22:'10', 23:'11', 12:'12'};
            let horaFinal = '';
            if (caracter <= 0) {
                let arrHora = hora.split(':');
                
                if (tipo == 'modal') {
                    inputHoraExacta.value = arrHora[0];
                    inputMinutosExacta.value = arrHora[1];
                    selectMeridianoExacta.value = parseInt(arrHora[0]) < 12 ? 1 : 2;
                } else if (tipo == 'list'){
                    if (parseInt(arrHora[0]) > 11 && parseInt(arrHora[0]) < 24) {
                        horaFinal += arrayHora[arrHora[0]] + ':' + arrHora[1] + ' PM';
                    } else {
                        horaFinal += arrHora[0] + ':' + arrHora[1] + ' AM';
                    }

                    return horaFinal;
                }
            } else {
                let arrHora = hora.split('-');
                let arrHora1 = arrHora[0].split(':');
                let arrHora2 = arrHora[1].split(':');

                if (tipo == 'modal') {
                    inputHoraExacta.value = arrHora1[0];
                    inputMinutosExacta.value = arrHora1[1];
                    selectMeridianoExacta.value = parseInt(arrHora1[0]) < 12 ? 1 : 2;

                    inputHoraEstimada.value = arrHora2[0];
                    inputMinutosEstimada.value = arrHora2[1];
                    selectMeridianoEstimada.value = parseInt(arrHora2[0]) < 12 ? 1 : 2;
                } else if (tipo == 'list'){
                    if (parseInt(arrHora1[0]) > 11 && parseInt(arrHora1[0]) < 24) {
                        horaFinal += arrayHora[arrHora1[0]] + ':' + arrHora1[1] + ' PM <div>a</div>';
                    } else {
                        horaFinal += arrHora1[0] + ':' + arrHora1[1] + ' AM <div>a</div>';
                    }
                    
                    if (parseInt(arrHora2[0]) > 11 && parseInt(arrHora2[0]) < 24) {
                        horaFinal += arrayHora[arrHora2[0]] + ':' + arrHora2[1] + ' PM';
                    } else {
                        horaFinal += arrHora2[0] + ':' + arrHora2[1] + ' AM';
                    }

                    return horaFinal;
                }
            }
        }

        const listDepartamento = (departamento = false, provincia = false, distrito = false) => {
            ajax('post', `../ubigeo/searchUbigeoDepartamento`)
                .then((response) => {
                    const records = response.departamento_records;
                    if (records != false) {
                        const filas = records.map((item, index) => {
                            if (item.departamento_id == departamento)
                                return `<option value='${item.departamento_id}' selected>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.departamento_id}'>${item.departamento_ubigeo} - ${item.departamento_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDepartamento.innerHTML = '';
                        selectDepartamento.innerHTML = filas;

                        listProvincia(departamento, provincia, distrito);

                        $('#selectDepartamento').change(function(event) {
                            listProvincia(selectDepartamento.value);
                        });
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const listProvincia = (departamento = false, provincia = false, distrito = false) => {
            let fd = new FormData();
            fd.append('departamento_id', departamento);

            ajax('post', `../ubigeo/searchUbigeoProvincia`, fd)
                .then((response) => {
                    const registros = response.provincia_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.provincia_id == provincia)
                                return `<option value='${item.provincia_id}' selected>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.provincia_id}'>${item.provincia_ubigeo} - ${item.provincia_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectProvincia.innerHTML = '';
                        selectProvincia.innerHTML = filas;
                        
                        listDistrito(provincia, distrito);

                        if (provincia == false) {
                            $('#selectProvincia').prop('selectedIndex', 0).change();
                        } else {
                            $('#selectProvincia').change(function(event) {
                                listDistrito(selectProvincia.value);
                            });
                        }

                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const listDistrito = (provincia = false, distrito = false) => {
            let fd = new FormData();
            fd.append('provincia_id', provincia);

            ajax('post', `../ubigeo/searchUbigeoDistrito`, fd)
                .then((response) => {
                    const registros = response.distrito_records;
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            if (item.distrito_id == distrito)
                                return `<option value='${item.distrito_id}' selected>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                            else
                                return `<option value='${item.distrito_id}'>${item.distrito_ubigeo} - ${item.distrito_nombre.toUpperCase()}</option>`
                        }).join("");

                        selectDistrito.innerHTML = '';
                        selectDistrito.innerHTML = filas;

                        if (distrito == false)
                            $('#selectDistrito').prop('selectedIndex', 0).change();
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        inputHoraExacta.addEventListener('change', e => {
            if (parseInt(selectHoraTipo.value) == 2 && parseInt(inputHoraExacta.value) > parseInt(inputHoraEstimada.value)) {
                swal({
                    text: 'La hora de inicio no puede ser mayor',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputHoraExacta.value = inputHoraEstimada.value, inputHoraExacta.focus()
                );
            }

            if (parseInt(inputHoraExacta.value) > 11 && parseInt(inputHoraExacta.value) < 24) {
                selectMeridianoExacta.value = 2;
            } else {
                selectMeridianoExacta.value = 1;
            }

            inputHoraExacta.value = parseInt(inputHoraExacta.value) < 10 ? '0' + inputHoraExacta.value : inputHoraExacta.value;
        });

        inputMinutosExacta.addEventListener('change', e => {
            if (parseInt(selectHoraTipo.value) == 2 && parseInt(inputHoraExacta.value) >= parseInt(inputHoraEstimada.value) && parseInt(inputMinutosExacta.value) > parseInt(inputMinutosEstimada.value)) {
                swal({
                    text: 'Los minutos de inicio no pueden ser mayores que los minutos de la hora final',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputMinutosExacta.value = inputMinutosEstimada.value, inputMinutosExacta.focus()
                );
            }

            inputMinutosExacta.value = parseInt(inputMinutosExacta.value) < 10 ? '0' + inputMinutosExacta.value : inputMinutosExacta.value;
        });

        inputHoraEstimada.addEventListener('change', e => {
            if (parseInt(selectHoraTipo.value) == 2 && parseInt(inputHoraEstimada.value) < parseInt(inputHoraExacta.value)) {
                swal({
                    text: 'La hora final no puede ser menor',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputHoraEstimada.value = inputHoraExacta.value, inputHoraEstimada.focus()
                );
            }

            if (parseInt(inputHoraEstimada.value) > 11 && parseInt(inputHoraEstimada.value) < 24) {
                selectMeridianoEstimada.value = 2;
            } else {
                selectMeridianoEstimada.value = 1;
            }

            inputHoraEstimada.value = parseInt(inputHoraEstimada.value) < 10 ? '0' + inputHoraEstimada.value : inputHoraEstimada.value;
        });

        inputMinutosEstimada.addEventListener('change', e => {
            if (parseInt(selectHoraTipo.value) == 2 && parseInt(inputHoraExacta.value) <= parseInt(inputHoraEstimada.value) && parseInt(inputMinutosEstimada.value) < parseInt(inputMinutosExacta.value)) {
                swal({
                    text: 'Los minutos de la hora final no pueden ser menores que los minutos de la hora de inicio',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputMinutosEstimada.value = inputMinutosExacta.value, inputMinutosEstimada.focus()
                );
            }

            inputMinutosEstimada.value = parseInt(inputMinutosEstimada.value) < 10 ? '0' + inputMinutosEstimada.value : inputMinutosEstimada.value;
        });

        form.addEventListener('keypress', e => {
            if (e.keyCode == 13 || e.which == 13) {
                return false;
            }
        });

        const crudInspeccion = () => {
            const apiRestMantenimiento = inputId.value == 0 ? '../inspecciones/insert' : '../inspecciones/update';

            let hora = selectHoraTipo.value == 1 ? inputHoraExacta.value+':'+inputMinutosExacta.value : inputHoraExacta.value+':'+inputMinutosExacta.value+'-'+inputHoraEstimada.value+':'+inputMinutosEstimada.value;

            const fd = new FormData();
            fd.append('coordinacion_codigo', inputCodigo.value);
            fd.append('inspeccion_codigo', inputId.value);
            fd.append('inspeccion_perito', selectPerito.value);
            fd.append('inspeccion_fecha', inputFecha.value);
            fd.append('inspeccion_hora', hora);
            fd.append('inspeccion_hora_tipo', selectHoraTipo.value);
            fd.append('inspeccion_contacto', inputContacto.value);
            fd.append('inspeccion_observacion', inputObservacion.value);
            fd.append('inspeccion_distrito', selectDistrito.value);
            fd.append('inspeccion_direccion', inputDireccion.value);

            ajax('post', apiRestMantenimiento, fd)
                .then((response) => {
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputId.value == 0 ? 'Se guardo correctamente ...' : 'Se actualizo correctamente ...',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseInspeccion.click(), listInspeccion(inputCodigo.value)
                        );
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: inputInspeccionId.value == 0 ? 'No se pudo guardar, por favor informar al area de sistemas' : 'No se pudo actualizar, por favor informar al area de sistemas',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseInspeccion.click()
                        );
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        form.addEventListener('submit', e => {
            e.preventDefault();
            if (selectPerito.value == '') {
                swal({
                    text: 'Seleccioné perito',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click()
                );
            } else if (inputFecha.value == '') {
                swal({
                    text: 'Ingresé fecha de inspección',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputFecha.focus()
                );
            } else if (inputFecha.value >= inputFechaEntrega.value) {
                swal({
                    text: 'La fecha de inspección no puede ser mayor o igual que la fecha de entrega',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputFecha.value = '', inputFecha.focus()
                );
            } else if ((selectHoraTipo.value == 1 || selectHoraTipo.value == 2) && inputHoraExacta.value == '') {
                swal({
                    text: 'Ingresé hora',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputHoraExacta.focus()
                );
            } else if ((selectHoraTipo.value == 1 || selectHoraTipo.value == 2) && inputMinutosExacta.value == '') {
                swal({
                    text: 'Ingresé minutos',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputMinutosExacta.focus()
                );
            } else if (selectHoraTipo.value == 2 && inputHoraEstimada.value == '') {
                swal({
                    text: 'Ingresé hora',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputHoraExacta.focus()
                );
            } else if (selectHoraTipo.value == 2 && inputMinutosEstimada.value == '') {
                swal({
                    text: 'Ingresé minutos',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputMinutosEstimada.focus()
                );
            } else if (inputContacto.value == '') {
                swal({
                    text: 'Ingresé contacto',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputContacto.focus()
                );
            } else if (inputObservacion.value == '') {
                swal({
                    text: 'Ingresé observación',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkDatosGenerales').click(), inputObservacion.focus()
                );
            } else if (inputDireccion.value == '') {
                swal({
                    text: 'Ingresé dirección',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => $('#lnkUbigeo').click(), inputObservacion.focus()
                );
            } else {
                crudInspeccion();
            }
        });

        buttonNewInspeccion.addEventListener('click', e => {
            form.reset();
            $('#selectPerito').val('').trigger('change');
            trHEstimada.classList.add('hidden');
            listDepartamento(15, 128, 1252);
            inputId.value = 0;

            $('#mdl_inspeccion_detalle').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });
    })
})(document);