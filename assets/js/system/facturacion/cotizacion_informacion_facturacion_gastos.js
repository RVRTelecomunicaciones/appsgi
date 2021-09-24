(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        $('.select2-diacritics').select2({
            placeholder: 'Seleccione',
            theme: 'classic',
            allowClear: true
        });

        $('.select2-diacritics2').select2({
            theme: 'classic'
        });

        $('.select2-container--classic').css('width', '100%');

    	const objInformacion = JSON.parse(sessionStorage.getItem('informacionFacturaGasto'));

    	d.getElementById('spanCotizacionCodigo').innerHTML = objInformacion.cotizacion_correlativo;

    	//METODO AJAX PARA OBTENER DATOS
        ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        listarCoordinacionesGastos = () => {
        	const fd = new FormData();
        	fd.append('cotizacion_id', objInformacion.cotizacion_id)

        	ajax('post', `serarchCoordinaciones`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    const record_coordinaciones = respuesta.coordinaciones;
                    if (record_coordinaciones != false) {
                        const fila_coordinaciones = record_coordinaciones.map((item, index) => {
                            return `<tr>
                                        <td>${index + 1}</td>
                                        <td>${item.coordinacion_correlativo}</td>
                                        <td><div align='left'>${item.solicitante_nombre.toUpperCase()}</div></td>
                                        <td><div align='left'>${item.cliente_nombre.toUpperCase()}</div></td>
                                        <td>${item.perito_nombre}</td>
                                        <td>${item.moneda_simbolo} ${item.gasto_importe}</td>
                                        <td>
                                        	<a id='lnkGastos' name='lnkGastos' href class='btn btn-danger btn-sm' data-indice='${index}'>Gastos</a>
                                        </td>
                                    </tr>`
                        }).join('');

                        $('#tbl_coordinacion tbody').html(fila_coordinaciones);

                        const linkGastos = d.querySelectorAll('#lnkGastos');

                        linkGastos.forEach(link => {
                        	link.addEventListener('click', e => {
                        		e.preventDefault();
                        		const indice = link.dataset.indice;

                        		let tituloModal = d.querySelector('#mdl_gastos #spanCoordinacionCodigo');
                                let inputCoordinacion = d.querySelector('#mdl_gastos #inputCoordinacion');
                                let inputCotizacion = d.querySelector('#mdl_gastos #inputCotizacion');
                                let selectMoneda = d.querySelector('#mdl_gastos #moneda_costo_perito');

                        		tituloModal.innerHTML = record_coordinaciones[indice].coordinacion_correlativo;
                                inputCoordinacion.value = record_coordinaciones[indice].coordinacion_id;
                                inputCotizacion.value = record_coordinaciones[indice].cotizacion_id;
                                selectMoneda.value = record_coordinaciones[indice].moneda_id;

                                $('#mdl_gastos #tableDetalleGasto tbody').html('');
                                listDetalleGastos();
                                
                        		$('#mdl_gastos').modal({
                                    'show': true,
                                    'keyboard': false,
                                    'backdrop': 'static'
                                });
                        	});
                        });
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }

        listarCoordinacionesGastos();
    })
})(document);