(function(d) {
    d.addEventListener("DOMContentLoaded", ()=>{
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	allowClear: true,
            dropdownAutoWidth : true,
            containerCssClass: 'select-xs',
            dropdownCssClass: 'fuente-select'
        });

        const apiRestListar = 'searchInmuebles';

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
        const tableBody = d.getElementById('tbl_tasacion').getElementsByTagName('tbody')[0];

        const selectTipo = d.getElementById('selectTipo');
        const inputCoordinacion = d.getElementById('inputCoordinacion');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const inputDireccion = d.getElementById('inputDireccion');
        const selectZonificacion = d.getElementById('selectZonificacion');

        const buttonFilters = d.getElementById('buttonFilters');
        const form = d.getElementById('frm_filtros');
        const inputFechaDesde = d.getElementById('inputFechaDesde');
        const inputFechaHasta = d.getElementById('inputFechaHasta');
        const inputAreaDesde = d.getElementById('inputAreaDesde');
        const inputAreaHasta = d.getElementById('inputAreaHasta');
        const buttonSearch = d.getElementById('buttonSearch');
        const buttonCancel = d.getElementById('buttonCancel');

        const filters = (link) => {
            const fd = new FormData()
            fd.append('inmueble_tipo', selectTipo.value)
            fd.append('inmueble_coordinacion', inputCoordinacion.value)
            fd.append('inmueble_solicitante', inputSolicitante.value)
            fd.append('inmueble_cliente', inputCliente.value)
            fd.append('inmueble_direccion', inputDireccion.value)
            fd.append('inmueble_zonificacion', selectZonificacion.value)
            fd.append('inmueble_fecha_desde', inputFechaDesde.value)
            fd.append('inmueble_fecha_hasta', inputFechaHasta.value)
            fd.append('inmueble_area_desde', inputAreaDesde.value)
            fd.append('inmueble_area_hasta', inputAreaHasta.value)
            fd.append('num_page', link)
            fd.append('quantity', selectQuantity.value);
            return fd;
        }

        const listTasacion = (fd) => {
            tableBody.innerHTML = '<tr><td colspan="13" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, fd)
                .then((response) => {
                    let selectedLink = Number(fd.get('num_page'));
					let quantityRecords = Number(fd.get('quantity'));
                    const records = response.records_find;

                    if (records != false) {
                        const row = records.map((item, index) => {
                            let tipo = ''
                            let valores = ''
                            switch (item.tasacion_tipo) {
                                case 'TERRENO':
                                    tipo = '<i class="fa fa-map-signs text-success"></i>'
                                    break;
                                case 'CASA':
                                    tipo = '<i class="fa fa-home fa-lg"></i>'
                                    break;
                                case 'DEPARTAMENTO':
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
                                case 'OFICINA':
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
                                case 'LOCAL COMERCIAL':
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
                                case 'LOCAL INDUSTRIAL':
                                    tipo = '<i class="fa fa-industry text-warning"></i>'
                                    valores =   `<tr>
                                                    <td>Area Edif.</td>
                                                    <td class="text-right">${numeral(item.edificacion_area).format('0,0.00')}</td>
                                                </tr>`
                                    break;
                            }

                            return `<tr>
                                        <td>${((selectedLink - 1) * quantityRecords) + index + 1}</td>
                                        <td>${tipo}</td>
                                        <td>${item.informe_id}</td>
                                        <td><div align="left">${item.solicitante_nombre.toUpperCase()}</div></td>
                                        <td><div align="left">${item.cliente_nombre.toUpperCase()}</div></td>
                                        <td><div>${item.ubicacion.toUpperCase()}</div><div>${item.departamento_nombre} <i class="fa fa-play text-danger"></i> ${item.provincia_nombre} <i class="fa fa-play text-danger"></i> ${item.distrito_nombre}</div></td>
                                        <td>${item.zonificacion_abreviatura}</td>
                                        <td>${item.tasacion_fecha}</td>
                                        <td class="text-right">${numeral(item.terreno_area).format('0,0.00')}</td>
                                        <td class="text-right">$&nbsp;${numeral(item.terreno_valorunitario).format('0,0.00')}</td>
                                        <td class="text-right">$&nbsp;${numeral(item.valor_comercial).format('0,0.00')}</td>
                                        <td><table class="table">${valores}</table></td>
                                        <td>
                                            <div class='btn-group'>
                                                <button type='button' class='btn btn-secondary dropdown-toggle btn-sm' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>Acciones</button>
                                                <div class="dropdown-menu">
                                                    <a id='lnkCopiarRuta' href class='dropdown-item' data-indice='${index}'><i class="fa fa-folder-open"></i> Copiar Ruta</a>
                                                    <a id='lnkModificar' href class='dropdown-item' data-indice='${index}'><i class="fa fa-edit"></i> Modificar</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
                    } else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="13" align="center">NO HAY REGISTROS</td>
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

		        	if (selectTipo.value == '' && inputCoordinacion.value.trim() == '' && inputSolicitante.value.trim() == '' && inputCliente.value.trim() == '' && inputDireccion.value.trim() == '' && selectZonificacion.value == '' && inputFechaDesde.value.trim() == '' && inputFechaHasta.value.trim() == '')
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecords + ' registros';
		        	else
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecordsFind + ' registros Filtrados (total de registros ' + totalRecords +')';

		        	let divPagination = d.getElementById('divPagination');
                    divPagination.innerHTML = paginator;

                    let paginationLink = d.querySelectorAll('#link');
                    let buttonCopiarRuta = d.querySelectorAll('#lnkCopiarRuta');
                    let buttonModificar = d.querySelectorAll('#lnkModificar');

                    paginationLink.forEach(link => {
		        		link.addEventListener('click', e => {
		        			e.preventDefault();
		        			let num_page = link.getAttribute('href');
		        			listTasacion(filters(num_page));
		        		});
                    });

                    buttonCopiarRuta.forEach(link => {
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

                    buttonModificar.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            swal({
                                text: `En desarrollo`,
                                timer: 3000,
                                buttons: false
                            });
                        })
                    });
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        listTasacion(filters(1));

        selectQuantity.addEventListener('change', e =>{
            listTasacion(filters(1));
        });

        $('#selectTipo').change(function(event) {
            listTasacion(filters(1));
        });

        inputCoordinacion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasacion(filters(1));
        });

        inputSolicitante.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasacion(filters(1));
        });

        inputCliente.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasacion(filters(1));
        });

        inputDireccion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasacion(filters(1));
        });

        $('#selectZonificacion').change(function(event) {
            listTasacion(filters(1));
        });

        inputFechaDesde.addEventListener('change', e => {
            inputFechaHasta.setAttribute('min', inputFechaDesde.value)
            if (inputFechaHasta.value < inputFechaDesde.value || inputFechaDesde.value == '') {
                inputFechaHasta.value = inputFechaDesde.value;
            }
        });

        inputFechaHasta.addEventListener('change', e => {
            //inputFechaDesde.setAttribute('max', inputFechaHasta.value)
            if (inputFechaDesde.value > inputFechaHasta.value) {
                inputFechaDesde.value = inputFechaHasta.value;
            }

            if (inputFechaHasta == '') {
                inputFechaHasta.removeAttribute('min');
            }
        });

        inputAreaDesde.addEventListener('change', e => {
            inputAreaHasta.setAttribute('min', inputAreaDesde.value)
            if (inputAreaHasta.value < inputAreaDesde.value || inputAreaDesde.value == '') {
                inputAreaHasta.value = inputAreaDesde.value;
            }
        });

        inputAreaHasta.addEventListener('change', e => {
            //inputFechaDesde.setAttribute('max', inputFechaHasta.value)
            if (inputAreaDesde.value > inputAreaHasta.value) {
                inputAreaDesde.value = inputAreaHasta.value;
            }

            if (inputAreaHasta == '') {
                inputAreaHasta.removeAttribute('min');
            }
        });

        buttonSearch.addEventListener('click', e => {
            buttonFilters.click();
            listTasacion(filters(1));
        });

        buttonCancel.addEventListener('click', e => {
            form.reset();
            buttonFilters.click();
            listTasacion(filters(1));
        });
    })
})(document);



! function(e, t, r) {
    "use strict";

    function s(e) {
        e.element;
        return e.id ? "<i class='" + r(e.element).data("icon") + "'></i>" + e.text : e.text
    }
    
    r("#selectTipo").select2({
        minimumResultsForSearch: 1 / 0,
        templateResult: s,
        templateSelection: s,
        containerCssClass: 'select-xs',
        dropdownCssClass: 'fuente-select',
        escapeMarkup: function(e) {
            return e
        }
    });

}(window, document, jQuery);

window.onload = function () {
    sessionStorage.clear();
}