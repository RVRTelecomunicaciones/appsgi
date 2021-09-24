(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        $('.js-example-programmatic-multi').select2({
            placeholder: 'Seleccioné tipo de servicio',
            dropdownAutoWidth : true
        });

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const selectQuantity = d.getElementById('selectQuantity');
        const tableBody = d.getElementById('tbl_coordinacion').getElementsByTagName('tbody')[0];

        const inputCorrelativo = d.getElementById('inputCorrelativo');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');

        const selectFechaTipo = d.getElementById('selectFechaTipo');
        const inputFechaDesde = d.getElementById('inputFechaDesde');

        const filters = (link) => {
            const fd = new FormData()
            fd.append('coordinacion_correlativo', inputCorrelativo.value);
            fd.append('coordinacion_estado', '4,8');
            fd.append('coordinacion_solicitante', inputSolicitante.value);
            fd.append('coordinacion_cliente', inputCliente.value);
            fd.append('coordinacion_servicio_tipo', $('#selectServicioTipo').val());
            fd.append('coordinacion_fecha_desde', inputFechaDesde.value);
            fd.append('coordinacion_fecha_hasta', inputFechaHasta.value);
            fd.append('num_page', link);
            fd.append('quantity', selectQuantity.value);
            return fd;
        }

        const listAuditoria = (fd) => {
            tableBody.innerHTML = '<tr><td colspan="9" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', '../searchCoordinacionTerminadas', fd)
                .then((response) => {
                    let selectedLink = Number(fd.get('num_page'));
					let quantityRecords = Number(fd.get('quantity'));
                    let records = response.records_find;

                    if (records != '') {
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = records;
                    } else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="9" align="center">NO HAY REGISTROS</td>
					        					</tr>`;
                    }

                    let totalRecordsFind = response.records_find_count;
		        	let totalRecords = response.records_all_count;
		        	let numberLinks = Math.ceil(totalRecordsFind/quantityRecords);
		        	let paginator = '<ul class="pagination">';

		        	paginator += (selectedLink > 1) ? '<li class="page-item"><a id="link" class="page-link" href="1">&laquo;</a></li><li class="page-item"><a id="link" class="page-link" href="' + (selectedLink - 1) + '">&lsaquo;</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">&laquo;</a></li><li class="page-item disabled"><a class="page-link" href="#">&lsaquo;</a></li>';
		        	
		        	let numberLinksview = 2;
		        	let pageStart = (selectedLink > numberLinksview) ? (selectedLink - numberLinksview) : 1;
		        	let pageEnd = 0;

		        	if (numberLinks > numberLinksview) {
		        		let remainingPages = numberLinks - selectedLink;
		        		pageEnd = (remainingPages > numberLinksview) ? (selectedLink + numberLinksview) : numberLinks;
		        	} else {
		        		pageEnd = numberLinks;
		        	}

		        	for (let i = pageStart; i <= pageEnd; i++) {
		        		paginator += (i == selectedLink) ? '<li class="page-item active"><a id="link" href="' + i + '" class="page-link">' + i + '</a></li>' : '<li class="page-item"><a id="link" href="' + i + '" class="page-link">' + i + '</a></li>';
		        	}

		        	paginator += (selectedLink < numberLinks) ? '<li class="page-item"><a id="link" class="page-link" href="' + (selectedLink + 1) + '">&rsaquo;</a></li><li class="page-item"><a id="link" class="page-link" href="' + numberLinks + '">&raquo;</a></li>' : '<li class="page-item disabled"><a class="page-link" href="#">&rsaquo;</a></li><li class="page-item disabled"><a class="page-link" href="#">&raquo;</a></li>';
		        	paginator += '</ul>';

		        	let spanCount = d.getElementById('spanCount');
		        	let quantityView = (selectedLink * quantityRecords) > totalRecordsFind ? totalRecordsFind : (selectedLink * quantityRecords);

		        	if (inputCorrelativo.value.trim() == '' && $('#selectEstado').val() == '' && inputSolicitante.value.trim() == '' && inputCliente.value.trim() == '' && $('#selectServicioTipo').val() == '' && inputDireccion.value.trim() == '' && selectPerito.value == '' && selectDigitador.value == '' && selectControlCalidad.value == '' && selectCoordinador.value == '' && selectRiesgo.value == '' && selectFechaTipo.value == '')
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecords + ' registros';
		        	else
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecordsFind + ' registros Filtrados (total de registros ' + totalRecords +')';

		        	let divPagination = d.getElementById('divPagination');
		        	divPagination.innerHTML = paginator;

                    let paginationLink = d.querySelectorAll('#link');

		        	paginationLink.forEach(link => {
		        		link.addEventListener('click', e => {
		        			e.preventDefault();
		        			let num_page = link.getAttribute('href');
		        			listAuditoria(filters(num_page));
		        		});
                    });
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        listAuditoria(filters(1));
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}