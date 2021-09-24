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

        const strCoordinacion = d.getElementById('strCoordinacion');
        const tableBody = d.getElementById('tbl_tasacion').getElementsByTagName('tbody')[0];
        const buttonFinalizar = d.getElementById('buttonFinalizar');

        const listTasaciones = (correlativo) => {
            const fd = new FormData();
            fd.append('coordinacion_correlativo', correlativo);

            tableBody.innerHTML = '<tr><td colspan="11" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', 'searchDetalle', fd)
                .then((response) => {
                    const records = response.records;
                    if (records != false) {
		        		let row = records.map((item, index) => {
                            let tipo = ''
                            let valores = ''
                            switch (item.tipo_tabla) {
                                case '1':
                                    tipo = '<i class="fa fa-map-signs text-success"></i>'
                                    break;
                                case '2':
                                    tipo = '<i class="fa fa-home fa-lg"></i>'
                                    break;
                                case '3':
                                    tipo = '<i class="fa fa-building text-danger"></i>'
                                    valores =   `<tr>
                                                    <td>Area Edif.</td>
                                                    <td class="text-right">${numeral(item.edificacion_area).format('0,0.00')}</td>
                                                </tr>
                                                <tr>
                                                    <td>V.A.O</td>
                                                    <td class="text-right">$&nbsp;${numeral(item.valor_ocupada).format('0,0.00')}</td>
                                                </tr>
                                                <tr>
                                                    <td>Valor Depart.</td>
                                                    <td class="text-right">$&nbsp;${numeral(item.valor_comercial_departamento).format('0,0.00')}</td>
                                                </tr>`
                                    break;
                                case '4':
                                    tipo = '<i class="fa fa-suitcase"></i>'
                                    valores =   `<tr>
                                                    <td>Area Edif.</td>
                                                    <td class="text-right">${numeral(item.edificacion_area).format('0,0.00')}</td>
                                                </tr>
                                                <tr>
                                                    <td>V.A.O</td>
                                                    <td class="text-right">$&nbsp;${numeral(item.valor_ocupada).format('0,0.00')}</td>
                                                </tr>`
                                    break;
                                case '5':
                                    tipo = '<i class="fa fa-industry text-info"></i>'
                                    valores =   `<tr>
                                                    <td>Area Edif.</td>
                                                    <td class="text-right">${numeral(item.edificacion_area).format('0,0.00')}</td>
                                                </tr>
                                                <tr>
                                                    <td>V.A.O</td>
                                                    <td class="text-right">$&nbsp;${numeral(item.valor_ocupada).format('0,0.00')}</td>
                                                </tr>`
                                    break;
                                case '6':
                                    tipo = '<i class="fa fa-industry text-warning"></i>'
                                    valores =   `<tr>
                                                    <td>Area Edif.</td>
                                                    <td class="text-right">${numeral(item.edificacion_area).format('0,0.00')}</td>
                                                </tr>`
                                    break;
                                case '7':
                                    tipo = '<i class="fa fa-car"></i>'
                                    valores =   `<tr>
                                                    <td>Clase</td>
                                                    <td class="text-right">${item.clase_nombre}</td>
                                                </tr>
                                                <tr>
                                                    <td>Marca</td>
                                                    <td class="text-right">${item.marca_nombre}</td>
                                                </tr>
                                                <tr>
                                                    <td>Modelo</td>
                                                    <td class="text-right">${item.modelo_nombre}</td>
                                                </tr>`
                                    break;
                                case '8':
                                    tipo = '<i class="fa fa-steam"></i>'
                                    valores =   `<tr>
                                                    <td>Clase</td>
                                                    <td class="text-right">${item.clase_nombre}</td>
                                                </tr>
                                                <tr>
                                                    <td>Marca</td>
                                                    <td class="text-right">${item.marca_nombre}</td>
                                                </tr>
                                                <tr>
                                                    <td>Modelo</td>
                                                    <td class="text-right">${item.modelo_nombre}</td>
                                                </tr>`
                                    break;
                                case '9':
                                    tipo = '<i class="fa fa-cubes text-warning"></i>'
                                    valores =   `<tr>
                                                    <td>Tipo</td>
                                                    <td class="text-right">${item.tipo_nombre}</td>
                                                </tr>
                                                <tr>
                                                    <td>Observacion</td>
                                                    <td class="text-right">${item.observacion}</td>
                                                </tr>`
                                    break;
                            }
                            
                            if (item.tipo_tabla == 7 || item.tipo_tabla == 8) {
                                return `<tr>
                                            <td>${index + 1}</td>
                                            <td>${tipo}</td>
                                            <td>${item.informe_id}</td>
                                            <td>${item.tasacion_fecha}</td>
                                            <td>${item.solicitante_nombre.toUpperCase()}</td>
                                            <td>${item.cliente_nombre.toUpperCase()}</td>
                                            <td>
                                                <div>${item.ubicacion.toUpperCase()}</div>
                                            </td>
                                            <td></td>
                                            <td colspan="3"></td>
                                            <td><table class="table">${valores}</table></td>
                                            <td>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn grey btn-outline-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                    <div class="dropdown-menu">
                                                        <a id='lnkCopiarRuta' href class='dropdown-item' data-indice='${index}'><i class="fa fa-folder-open"></i> Copiar Ruta</a>
                                                        <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class="fa fa-edit"></i> Modificar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>`
                            }else if (item.tipo_tabla == 9) {
                                return `<tr>
                                            <td>${index + 1}</td>
                                            <td>${tipo}</td>
                                            <td>${item.informe_id}</td>
                                            <td>${item.tasacion_fecha}</td>
                                            <td colspan="7"></td>
                                            <td><table class="table">${valores}</table></td>
                                            <td>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn grey btn-outline-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                    <div class="dropdown-menu">
                                                        <a id='lnkCopiarRuta' href class='dropdown-item' data-indice='${index}'><i class="fa fa-folder-open"></i> Copiar Ruta</a>
                                                        <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class="fa fa-edit"></i> Modificar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>`
                            } else {
                                return `<tr>
                                            <td>${index + 1}</td>
                                            <td>${tipo}</td>
                                            <td>${item.informe_id}</td>
                                            <td>${item.tasacion_fecha}</td>
                                            <td>${item.solicitante_nombre.toUpperCase()}</td>
                                            <td>${item.cliente_nombre.toUpperCase()}</td>
                                            <td>
                                                <div>${item.ubicacion.toUpperCase()}</div>
                                                <div>${item.departamento_nombre} <i class="fa fa-play text-danger"></i> ${item.provincia_nombre} <i class="fa fa-play text-danger"></i> ${item.distrito_nombre}</div>
                                            </td>
                                            <td>${item.zonificacion_abreviatura}</td>
                                            <td>${numeral(item.terreno_area).format('0,0.0')}</td>
                                            <td>${numeral(item.terreno_valorunitario).format('0,0.0')}</td>
                                            <td>${numeral(item.valor_comercial).format('0,0.0')}</td>
                                            <td><table class="table">${valores}</table></td>
                                            <td>
                                                <div class='btn-group'>
                                                    <button type='button' class='btn grey btn-outline-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                    <div class="dropdown-menu">
                                                        <a id='lnkCopiarRuta' href class='dropdown-item' data-indice='${index}'><i class="fa fa-folder-open"></i> Copiar Ruta</a>
                                                        <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class="fa fa-edit"></i> Modificar</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>`
                            }
		        		}).join('');
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
		        	} else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="11" align="center">NO HAY REGISTROS</td>
					        					</tr>`;
                    }

                    const link_copiar_ruta = d.querySelectorAll('#lnkCopiarRuta');
                    const link_modificar = d.querySelectorAll('#lnkModificar');

                    link_copiar_ruta.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            const indice = link.dataset.indice;

                            let input = d.createElement('input');
                            input.value = records[indice].ruta_informe;
                            d.body.appendChild(input);
                            input.select();
                            d.execCommand('copy');
                            d.body.removeChild(input);
                            toastr.success("Ruta copiada");
                        })
                    });

                    link_modificar.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();

                            const indice = link.dataset.indice;
                            let data = {
                                tasacion_id: records[indice].id,
                                tipo_tabla: records[indice].tipo_tabla,
                                informe_id: records[indice].informe_id,
                                cliente_id: records[indice].cliente_id,
                                cliente_tipo: records[indice].cliente_tipo,
                                cliente_nombre: records[indice].cliente_nombre,
                                propietario_id: records[indice].propietario_id,
                                propietario_nombre: records[indice].propietario_nombre,
                                solicitante_id: records[indice].solicitante_id,
                                solicitante_tipo: records[indice].solicitante_tipo,
                                solicitante_nombre: records[indice].solicitante_nombre,
                                tasacion_fecha: records[indice].tasacion_fecha,
                                zonificacion_id: records[indice].zonificacion_id,
                                tipo_id: records[indice].tipo_id,
                                tipo_cambio: records[indice].tipo_cambio,
                                terreno_area: records[indice].terreno_area,
                                terreno_valorunitario: records[indice].terreno_valorunitario,
                                edificacion_area: records[indice].edificacion_area,
                                valor_comercial: records[indice].valor_comercial,
                                clase_id: records[indice].clase_id,
                                marca_id: records[indice].marca_id,
                                modelo_id: records[indice].modelo_id,
                                fabricacion_anio: records[indice].fabricacion_anio,
                                valor_similar_nuevo: records[indice].valor_similar_nuevo,
                                valor_comercial_departamento: records[indice].valor_comercial_departamento,
                                estacionamiento_cantidad: records[indice].estacionamiento_cantidad,
                                valor_ocupada: records[indice].valor_ocupada,
                                ubicacion: records[indice].ubicacion,
                                departamento_id: records[indice].departamento_id,
                                provincia_id: records[indice].provincia_id,
                                distrito_id: records[indice].distrito_id,
                                antiguedad: records[indice].antiguedad,
                                mapa_latitud: records[indice].mapa_latitud,
                                mapa_longitud: records[indice].mapa_longitud,
                                observacion: records[indice].observacion,
                                ruta_informe: records[indice].ruta_informe
                            };

                            sessionStorage.setItem('data', JSON.stringify(data));
                            window.location.href = 'registro';
                        })
                    });
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        if (sessionStorage.getItem('data') != null) {
            const objData = JSON.parse(sessionStorage.getItem('data'));
            strCoordinacion.innerHTML = objData.coordinacion;
            listTasaciones(objData.coordinacion);
        }

        buttonFinalizar.addEventListener('click', e => {
            const fd = new FormData();
            fd.append('coordinacion_correlativo', strCoordinacion.innerText);

            ajax('post', 'finalizarReproceso', fd)
                .then((response) => {
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se culmino con el proceso de actualización ...',
                            timer: 3000,
                            buttons: false
                        })
                        .then(() => window.location.href = 'listado');
                    } else {
                        swal({
                            icon: 'danger',
                            title: 'Error',
                            text: 'No se pudo ejecutar la acción, Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        });
    })
})(document);