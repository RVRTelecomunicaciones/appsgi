(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
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
            return fetch(apiRest, opciones).then(response => response.json())
        };
        
        const selectQuantity = d.getElementById('selectQuantity');
        const tableBody = d.getElementById('tbl_coordinacion').getElementsByTagName('tbody')[0];

        const inputCorrelativo = d.getElementById('inputCorrelativo');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const inputDireccion = d.getElementById('inputDireccion');
        const selectPerito = d.getElementById('selectPerito');
        const selectDigitador = d.getElementById('selectDigitador');
        const selectControlCalidad = d.getElementById('selectControlCalidad');
        const selectCoordinador = d.getElementById('selectCoordinador');
        const selectRiesgo = d.getElementById('selectRiesgo');

        /*FILTROS ADICIONALES*/
        const buttonFilters = d.getElementById('buttonFilters');
        const form = d.getElementById('frm_filtros');
        const selectFechaTipo = d.getElementById('selectFechaTipo');
        const inputFechaDesde = d.getElementById('inputFechaDesde');
        const inputFechaHasta = d.getElementById('inputFechaHasta');
        const buttonSearch = d.getElementById('buttonSearch');
        const buttonCancel = d.getElementById('buttonCancel');
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.getElementById('lnkExportXls');

        /* ORDEN */
        const thSort = d.querySelectorAll('.icono');
        const iconCoordinacion = d.getElementById('iconCoordinacion');
        const iconEstado = d.getElementById('iconEstado');
        const iconSolicitante = d.getElementById('iconSolicitante');
        const iconCliente = d.getElementById('iconCliente');
        const iconTipoServicio = d.getElementById('iconTipoServicio');
        const iconDigitador = d.getElementById('iconDigitador');
        const iconControlCalidad = d.getElementById('iconControlCalidad');
        const iconCoordinador = d.getElementById('iconCoordinador');
        const iconFechaEntrega = d.getElementById('iconFechaEntrega');
        const iconFechaEntregaOperaciones = d.getElementById('iconFechaEntregaOperaciones');
        const iconRiesgo = d.getElementById('iconRiesgo');

        const filters = (link) => {
            const fd = new FormData()
            fd.append('coordinacion_correlativo', inputCorrelativo.value);
            fd.append('coordinacion_estado', $('#selectEstado').val());
            fd.append('coordinacion_solicitante', inputSolicitante.value);
            fd.append('coordinacion_cliente', inputCliente.value);
            fd.append('coordinacion_servicio_tipo', $('#selectServicioTipo').val());
            fd.append('coordinacion_direccion', inputDireccion.value);
            fd.append('coordinacion_perito', selectPerito.value);
            fd.append('coordinacion_digitador', selectDigitador.value);
            fd.append('coordinacion_control_calidad', selectControlCalidad.value);
            fd.append('coordinacion_coordinador', selectCoordinador.value);
            fd.append('coordinacion_riesgo', selectRiesgo.value);
            fd.append('coordinacion_fecha_tipo', selectFechaTipo.value);
            fd.append('coordinacion_fecha_desde', inputFechaDesde.value);
            fd.append('coordinacion_fecha_hasta', inputFechaHasta.value);
            fd.append('num_page', link);
            fd.append('quantity', selectQuantity.value);

            if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'coordinacion');
                fd.append('order_type', 'DESC');
            } else if (iconCoordinacion.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'coordinacion');
                fd.append('order_type', 'ASC');
            }

            if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'estado');
                fd.append('order_type', 'DESC');
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'estado');
                fd.append('order_type', 'ASC');
            }

            if (iconSolicitante.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'solicitante');
                fd.append('order_type', 'DESC');
            } else if (iconSolicitante.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'solicitante');
                fd.append('order_type', 'ASC');
            }

            if (iconCliente.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'cliente');
                fd.append('order_type', 'DESC');
            } else if (iconCliente.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'cliente');
                fd.append('order_type', 'ASC');
            }

            if (iconTipoServicio.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'tipo_servicio');
                fd.append('order_type', 'DESC');
            } else if (iconTipoServicio.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'tipo_servicio');
                fd.append('order_type', 'ASC');
            }

            if (iconDigitador.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'digitador');
                fd.append('order_type', 'DESC');
            } else if (iconDigitador.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'digitador');
                fd.append('order_type', 'ASC');
            }

            if (iconControlCalidad.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'control_calidad');
                fd.append('order_type', 'DESC');
            } else if (iconControlCalidad.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'control_calidad');
                fd.append('order_type', 'ASC');
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'coordinador');
                fd.append('order_type', 'DESC');
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'coordinador');
                fd.append('order_type', 'ASC');
            }

            if (iconFechaEntrega.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'fecha_entrega');
                fd.append('order_type', 'DESC');
            } else if (iconFechaEntrega.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'fecha_entrega');
                fd.append('order_type', 'ASC');
            }

            if (iconRiesgo.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'riesgo');
                fd.append('order_type', 'DESC');
            } else if (iconRiesgo.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'riesgo');
                fd.append('order_type', 'ASC');
            }

            return fd;
        }
    
        const listCoordinaciones = (fd) => {
            tableBody.innerHTML = '<tr><td colspan="16" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', '../coordinaciones/search', fd)
                .then((response) => {
                    let selectedLink = Number(fd.get('num_page'));
					let quantityRecords = Number(fd.get('quantity'));
                    let records = response.records_find;

                    if (records != '') {
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = records;
                    } else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="16" align="center">NO HAY REGISTROS</td>
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
		        			listCoordinaciones(filters(num_page));
		        		});
                    });

                    let linkViewCoordinacion = d.querySelectorAll('#lnkViewCoordinacion');
                    linkViewCoordinacion.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let cotizacion = link.dataset.cotizacion;
                            let coordinacion = link.dataset.coordinacion;
                            let data = {
                                cotizacion_codigo: cotizacion,
                                coordinacion_codigo: coordinacion
                            }

                            sessionStorage.setItem('data', JSON.stringify(data));
                            window.location.href = 'registro';
                        });
                    });

                    let linkSeguimiento = d.querySelectorAll('#lnkSeguimiento');
                    linkSeguimiento.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            
                            listObservaciones(link.dataset.coordinacion);
                            $('#mdl_seguimiento').modal({
                                'show': true,
                                'keyboard': false,
                                'backdrop': 'static'
                            });
                        });
                    });
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        listCoordinaciones(filters(1));

        selectQuantity.addEventListener('change', e => {
            listCoordinaciones(filters(1));
        });

        inputCorrelativo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listCoordinaciones(filters(1));
        });

        $('#selectEstado').change(function (e) {
            listCoordinaciones(filters(1));
        });

        inputSolicitante.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listCoordinaciones(filters(1));
        });

        inputCliente.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listCoordinaciones(filters(1));
        });

        $('#selectServicioTipo').change(function (e) {
            listCoordinaciones(filters(1));
        });

        inputDireccion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listCoordinaciones(filters(1));
        });

        selectPerito.addEventListener('change', e => {
            listCoordinaciones(filters(1));
        });

        selectDigitador.addEventListener('change', e => {
            listCoordinaciones(filters(1));
        });

        selectControlCalidad.addEventListener('change', e => {
            listCoordinaciones(filters(1));
        });

        selectCoordinador.addEventListener('change', e => {
            listCoordinaciones(filters(1));
        });

        selectRiesgo.addEventListener('change', e => {
            listCoordinaciones(filters(1));
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

        buttonSearch.addEventListener('click', e => {
            if (selectFechaTipo.value == '') {
                swal({
                    text: 'Seleccioné el tipo de fecha a filtrar',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => selectFechaTipo.focus()
                );
            } else if (selectFechaTipo.value != '' && inputFechaDesde.value == '') {
                swal({
                    text: 'Seleccioné fecha de inicio',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputFechaDesde.focus()
                );
            } else if (selectFechaTipo.value != '' && inputFechaHasta.value == '') {
                swal({
                    text: 'Seleccioné fecha de final',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputFechaHasta.focus()
                );
            } else {
                buttonFilters.click();
                listCoordinaciones(filters(1));
            }
        });

        buttonCancel.addEventListener('click', e => {
            form.reset();
            buttonFilters.click();
            listCoordinaciones(filters(1));
        });

        botonImprimir.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `imprimir`);
            form.setAttribute('target', '_blank');
            let order = '';
            let order_type = '';

            if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinacion';
                order_type = 'DESC';
            } else if (iconCoordinacion.classList.contains('fa-sort-amount-asc')){
                order = 'coordinacion';
                order_type = 'ASC';
            }

            if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                order = 'estado';
                order_type = 'DESC';
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                order = 'estado';
                order_type = 'ASC';
            }

            if (iconSolicitante.classList.contains('fa-sort-amount-desc')) {
                order = 'solicitante';
                order_type = 'DESC';
            } else if (iconSolicitante.classList.contains('fa-sort-amount-asc')){
                order = 'solicitante';
                order_type = 'ASC';
            }

            if (iconCliente.classList.contains('fa-sort-amount-desc')) {
                order = 'cliente';
                order_type = 'DESC';
            } else if (iconCliente.classList.contains('fa-sort-amount-asc')){
                order = 'cliente';
                order_type = 'ASC';
            }

            if (iconTipoServicio.classList.contains('fa-sort-amount-desc')) {
                order = 'tipo_servicio';
                order_type = 'DESC';
            } else if (iconTipoServicio.classList.contains('fa-sort-amount-asc')){
                order = 'tipo_servicio';
                order_type = 'ASC';
            }

            if (iconDigitador.classList.contains('fa-sort-amount-desc')) {
                order = 'digitador';
                order_type = 'DESC';
            } else if (iconDigitador.classList.contains('fa-sort-amount-asc')){
                order = 'digitador';
                order_type = 'ASC';
            }

            if (iconControlCalidad.classList.contains('fa-sort-amount-desc')) {
                order = 'control_calidad';
                order_type = 'DESC';
            } else if (iconControlCalidad.classList.contains('fa-sort-amount-asc')){
                order = 'control_calidad';
                order_type = 'ASC';
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinador';
                order_type = 'DESC';
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                order = 'coordinador';
                order_type = 'ASC';
            }

            if (iconFechaEntrega.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha_entrega';
                order_type = 'DESC';
            } else if (iconFechaEntrega.classList.contains('fa-sort-amount-asc')){
                order = 'fecha_entrega';
                order_type = 'ASC';
            }

            if (iconFechaEntregaOperaciones.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha_entrega_operaciones';
                order_type = 'DESC';
            } else if (iconFechaEntregaOperaciones.classList.contains('fa-sort-amount-asc')){
                order = 'fecha_entrega_operaciones';
                order_type = 'ASC';
            }

            if (iconRiesgo.classList.contains('fa-sort-amount-desc')) {
                order = 'riesgo';
                order_type = 'DESC';
            } else if (iconRiesgo.classList.contains('fa-sort-amount-asc')){
                order = 'riesgo';
                order_type = 'ASC';
            }
            
            let object = {
                coordinacion_correlativo: inputCorrelativo.value,
                coordinacion_estado: $('#selectEstado').val().toString(),
                coordinacion_solicitante: inputSolicitante.value,
                coordinacion_cliente: inputCliente.value,
                coordinacion_servicio_tipo: $('#selectServicioTipo').val().toString(),
                coordinacion_direccion: inputDireccion.value,
                coordinacion_perito: selectPerito.value,
                coordinacion_digitador: selectDigitador.value,
                coordinacion_control_calidad: selectControlCalidad.value,
                coordinacion_coordinador: selectCoordinador.value,
                coordinacion_riesgo: selectRiesgo.value,
                coordinacion_fecha_tipo: selectFechaTipo.value,
                coordinacion_fecha_desde: inputFechaDesde.value,
                coordinacion_fecha_hasta: inputFechaHasta.value,
                order: order,
                order_type: order_type
            };


            let inputFormCoordinacion = d.createElement('input');
            inputFormCoordinacion.type = 'text';
            inputFormCoordinacion.name = 'data';
            inputFormCoordinacion.value = JSON.stringify(object);
            form.appendChild(inputFormCoordinacion);

            d.body.appendChild(form);
            form.submit();
            d.body.removeChild(form);
        });

        botonExportXls.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `exportarExcel`);
            form.setAttribute('target', '_blank');
            let order = '';
            let order_type = '';

            if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinacion';
                order_type = 'DESC';
            } else if (iconCoordinacion.classList.contains('fa-sort-amount-asc')){
                order = 'coordinacion';
                order_type = 'ASC';
            }

            if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                order = 'estado';
                order_type = 'DESC';
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                order = 'estado';
                order_type = 'ASC';
            }

            if (iconSolicitante.classList.contains('fa-sort-amount-desc')) {
                order = 'solicitante';
                order_type = 'DESC';
            } else if (iconSolicitante.classList.contains('fa-sort-amount-asc')){
                order = 'solicitante';
                order_type = 'ASC';
            }

            if (iconCliente.classList.contains('fa-sort-amount-desc')) {
                order = 'cliente';
                order_type = 'DESC';
            } else if (iconCliente.classList.contains('fa-sort-amount-asc')){
                order = 'cliente';
                order_type = 'ASC';
            }

            if (iconTipoServicio.classList.contains('fa-sort-amount-desc')) {
                order = 'tipo_servicio';
                order_type = 'DESC';
            } else if (iconTipoServicio.classList.contains('fa-sort-amount-asc')){
                order = 'tipo_servicio';
                order_type = 'ASC';
            }

            if (iconDigitador.classList.contains('fa-sort-amount-desc')) {
                order = 'digitador';
                order_type = 'DESC';
            } else if (iconDigitador.classList.contains('fa-sort-amount-asc')){
                order = 'digitador';
                order_type = 'ASC';
            }

            if (iconControlCalidad.classList.contains('fa-sort-amount-desc')) {
                order = 'control_calidad';
                order_type = 'DESC';
            } else if (iconControlCalidad.classList.contains('fa-sort-amount-asc')){
                order = 'control_calidad';
                order_type = 'ASC';
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinador';
                order_type = 'DESC';
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                order = 'coordinador';
                order_type = 'ASC';
            }

            if (iconFechaEntrega.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha_entrega';
                order_type = 'DESC';
            } else if (iconFechaEntrega.classList.contains('fa-sort-amount-asc')){
                order = 'fecha_entrega';
                order_type = 'ASC';
            }

            if (iconFechaEntregaOperaciones.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha_entrega_operaciones';
                order_type = 'DESC';
            } else if (iconFechaEntregaOperaciones.classList.contains('fa-sort-amount-asc')){
                order = 'fecha_entrega_operaciones';
                order_type = 'ASC';
            }

            if (iconRiesgo.classList.contains('fa-sort-amount-desc')) {
                order = 'riesgo';
                order_type = 'DESC';
            } else if (iconRiesgo.classList.contains('fa-sort-amount-asc')){
                order = 'riesgo';
                order_type = 'ASC';
            }
            
            let object = {
                coordinacion_correlativo: inputCorrelativo.value,
                coordinacion_estado: $('#selectEstado').val().toString(),
                coordinacion_solicitante: inputSolicitante.value,
                coordinacion_cliente: inputCliente.value,
                coordinacion_servicio_tipo: $('#selectServicioTipo').val().toString(),
                coordinacion_direccion: inputDireccion.value,
                coordinacion_perito: selectPerito.value,
                coordinacion_digitador: selectDigitador.value,
                coordinacion_control_calidad: selectControlCalidad.value,
                coordinacion_coordinador: selectCoordinador.value,
                coordinacion_riesgo: selectRiesgo.value,
                coordinacion_fecha_tipo: selectFechaTipo.value,
                coordinacion_fecha_desde: inputFechaDesde.value,
                coordinacion_fecha_hasta: inputFechaHasta.value,
                order: order,
                order_type: order_type
            };


            let inputFormCoordinacion = d.createElement('input');
            inputFormCoordinacion.type = 'text';
            inputFormCoordinacion.name = 'data';
            inputFormCoordinacion.value = JSON.stringify(object);
            form.appendChild(inputFormCoordinacion);

            d.body.appendChild(form);
            form.submit();
            d.body.removeChild(form);
        });

        thSort.forEach(th => {
            th.addEventListener('click', e => {
                const indice = th.dataset.index;
                //const fd = filters(1);

                removeIcon(parseInt(indice));
                switch (parseInt(indice)) {
                    case 1:
                        //fd.append('order', 'coordinacion');
                        if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                            iconCoordinacion.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCoordinacion.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconCoordinacion.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCoordinacion.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 2:
                        //fd.append('order', 'estado');
                        if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                            iconEstado.classList.remove('fa', 'fa-sort-amount-desc');
                            iconEstado.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconEstado.classList.remove('fa', 'fa-sort-amount-asc');
                            iconEstado.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 3:
                        //fd.append('order', 'solicitante');
                        if (iconSolicitante.classList.contains('fa-sort-amount-desc')) {
                            iconSolicitante.classList.remove('fa', 'fa-sort-amount-desc');
                            iconSolicitante.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconSolicitante.classList.remove('fa', 'fa-sort-amount-asc');
                            iconSolicitante.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 4:
                        //fd.append('order', 'cliente');
                        if (iconCliente.classList.contains('fa-sort-amount-desc')) {
                            iconCliente.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCliente.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconCliente.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCliente.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 5:
                        //fd.append('order', 'tipo_servicio');
                        if (iconTipoServicio.classList.contains('fa-sort-amount-desc')) {
                            iconTipoServicio.classList.remove('fa', 'fa-sort-amount-desc');
                            iconTipoServicio.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconTipoServicio.classList.remove('fa', 'fa-sort-amount-asc');
                            iconTipoServicio.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 6:
                        //fd.append('order', 'digitador');
                        if (iconDigitador.classList.contains('fa-sort-amount-desc')) {
                            iconDigitador.classList.remove('fa', 'fa-sort-amount-desc');
                            iconDigitador.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconDigitador.classList.remove('fa', 'fa-sort-amount-asc');
                            iconDigitador.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 7:
                        //fd.append('order', 'control_calidad');
                        if (iconControlCalidad.classList.contains('fa-sort-amount-desc')) {
                            iconControlCalidad.classList.remove('fa', 'fa-sort-amount-desc');
                            iconControlCalidad.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconControlCalidad.classList.remove('fa', 'fa-sort-amount-asc');
                            iconControlCalidad.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 8:
                        //fd.append('order', 'coordinador');
                        if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                            iconCoordinador.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCoordinador.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconCoordinador.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCoordinador.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 9:
                        //fd.append('order', 'fecha_entrega');
                        if (iconFechaEntrega.classList.contains('fa-sort-amount-desc')) {
                            iconFechaEntrega.classList.remove('fa', 'fa-sort-amount-desc');
                            iconFechaEntrega.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconFechaEntrega.classList.remove('fa', 'fa-sort-amount-asc');
                            iconFechaEntrega.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 10:
                        //fd.append('order', 'fecha_entrega');
                        if (iconFechaEntregaOperaciones.classList.contains('fa-sort-amount-desc')) {
                            iconFechaEntregaOperaciones.classList.remove('fa', 'fa-sort-amount-desc');
                            iconFechaEntregaOperaciones.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconFechaEntregaOperaciones.classList.remove('fa', 'fa-sort-amount-asc');
                            iconFechaEntregaOperaciones.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                    case 11:
                        //fd.append('order', 'riesgo');
                        if (iconRiesgo.classList.contains('fa-sort-amount-desc')) {
                            iconRiesgo.classList.remove('fa', 'fa-sort-amount-desc');
                            iconRiesgo.classList.add('fa', 'fa-sort-amount-asc');
                            //fd.append('order_type', 'ASC');
                        } else {
                            iconRiesgo.classList.remove('fa', 'fa-sort-amount-asc');
                            iconRiesgo.classList.add('fa', 'fa-sort-amount-desc');
                            //fd.append('order_type', 'DESC');
                        }
                        break;
                }

                listCoordinaciones(filters(1));
            });
        });

        const removeIcon = (x) => {
            if (x != 1) {
                iconCoordinacion.classList.remove('fa', 'fa-sort-amount-desc');
                iconCoordinacion.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 2) {
                iconEstado.classList.remove('fa', 'fa-sort-amount-desc');
                iconEstado.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 3) {
                iconSolicitante.classList.remove('fa', 'fa-sort-amount-desc');
                iconSolicitante.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 4) {
                iconCliente.classList.remove('fa', 'fa-sort-amount-desc');
                iconCliente.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 5) {
                iconTipoServicio.classList.remove('fa', 'fa-sort-amount-desc');
                iconTipoServicio.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 6) {
                iconDigitador.classList.remove('fa', 'fa-sort-amount-desc');
                iconDigitador.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 7) {
                iconControlCalidad.classList.remove('fa', 'fa-sort-amount-desc');
                iconControlCalidad.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 8) {
                iconCoordinador.classList.remove('fa', 'fa-sort-amount-desc');
                iconCoordinador.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 9) {
                iconFechaEntrega.classList.remove('fa', 'fa-sort-amount-desc');
                iconFechaEntrega.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 10) {
                iconFechaEntregaOperaciones.classList.remove('fa', 'fa-sort-amount-desc');
                iconFechaEntregaOperaciones.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 11) {
                iconRiesgo.classList.remove('fa', 'fa-sort-amount-desc');
                iconRiesgo.classList.remove('fa', 'fa-sort-amount-asc');
            }
        }
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}