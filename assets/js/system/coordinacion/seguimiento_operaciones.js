(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(response => response.json())
        };
        
        const selectQuantity = d.getElementById('selectQuantity');
        const tableBody = d.getElementById('tbl_observaciones').getElementsByTagName('tbody')[0];
    
        listObservaciones = (codigo) => {
            tableBody.innerHTML = '<tr><td colspan="15" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            const fd = new FormData()
            fd.append('proceso_coordinacion', codigo);

            ajax('post', '../proceso/search', fd)
                .then((response) => {
                    let records = response.records_find;

                    if (records != '') {
                        let row = records.map((item, index) => {
                            return `<tr>
                                        <td>${index + 1}</td>
                                        <td >
                                            <div align="left"><strong>${item.proceso_enviado_de}</strong></div>
                                            ${item.usuario_nombre.toUpperCase()}
                                        </td>
                                        <td>
                                            ${item.proceso_fecha_inicio}
                                            <div>${item.proceso_fecha_inicio_hora}</div>
                                        </td>
                                        <td>
                                            ${item.proceso_fecha_final}
                                            <div>${item.proceso_fecha_final_hora}</div>
                                        </td>
                                        <td>
                                            ${item.proceso_enviado_a}
                                            <div align="center">
                                                ${item.estado_id != 3 ? item.estado_nombre : ''}
                                            </div>
                                        </td>
                                        <!--<td>
                                            ${item.estado_nombre}
                                        </td>-->
                                    </tr>`
                        }).join('');

                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
                    } else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="15" align="center">NO HAY REGISTROS</td>
					        					</tr>`;
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        const buttonSeguimientoImprimir = d.getElementById('buttonSeguimientoImprimir');
        buttonSeguimientoImprimir.addEventListener('click', e => {
            alert('');
        });
    })
})(document);