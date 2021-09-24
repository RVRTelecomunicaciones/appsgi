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
            return fetch(apiRest, opciones).then(response => response.json())
        };

        const selectQuantity = d.getElementById('selectQuantity');
        const tableBody = d.getElementById('tbl_inspeccion').getElementsByTagName('tbody')[0];

        const inputCorrelativo = d.getElementById('inputCorrelativo');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const inputDireccion = d.getElementById('inputDireccion');
        const selectPerito = d.getElementById('selectPerito');
        const selectCoordinador = d.getElementById('selectCoordinador');
        /*const selectEstado = d.getElementById('selectEstado');*/

        /*FILTROS ADICIONALES*/
        const buttonFilters = d.getElementById('buttonFilters');
        const form = d.getElementById('frm_filtros');
        //const selectFechaTipo = d.getElementById('selectFechaTipo');
        const inputFechaDesde = d.getElementById('inputFechaDesde');
        const inputFechaHasta = d.getElementById('inputFechaHasta');
        const buttonSearch = d.getElementById('buttonSearch');
        const buttonCancel = d.getElementById('buttonCancel');
        const botonImprimir = d.getElementById('lnkImprimir');
        const botonExportXls = d.getElementById('lnkExportXls');

        /* ORDEN */
        const thSort = d.querySelectorAll('.icono');
        const iconCoordinacion = d.getElementById('iconCoordinacion');
        const iconSolicitante = d.getElementById('iconSolicitante');
        const iconCliente = d.getElementById('iconCliente');
        const iconTipoServicio = d.getElementById('iconTipoServicio');
        const iconDireccion = d.getElementById('iconDireccion');
        const iconPerito = d.getElementById('iconPerito');
        const iconCoordinador = d.getElementById('iconCoordinador');
        const iconFecha = d.getElementById('iconFecha');
        /*const iconEstado = d.getElementById('iconEstado');*/

        const filters = (link) => {
            const fd = new FormData()
            fd.append('coordinacion_correlativo', inputCorrelativo.value);
            fd.append('inspeccion_solicitante', inputSolicitante.value);
            fd.append('inspeccion_cliente', inputCliente.value);
            fd.append('inspeccion_servicio_tipo', $('#selectServicioTipo').val());
            fd.append('inspeccion_direccion', inputDireccion.value);
            fd.append('inspeccion_perito', selectPerito.value);
            fd.append('inspeccion_coordinador', selectCoordinador.value);
            /*fd.append('inspeccion_estado', $('#selectEstado').val());*/
            //fd.append('inspeccion_fecha_tipo', selectFechaTipo.value);
            fd.append('inspeccion_fecha_desde', inputFechaDesde.value);
            fd.append('inspeccion_fecha_hasta', inputFechaHasta.value);
            fd.append('num_page', link);
            fd.append('quantity', selectQuantity.value);

            if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'coordinacion');
                fd.append('order_type', 'DESC');
            } else if (iconCoordinacion.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'coordinacion');
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

            if (iconDireccion.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'direccion');
                fd.append('order_type', 'DESC');
            } else if (iconDireccion.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'direccion');
                fd.append('order_type', 'ASC');
            }

            if (iconPerito.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'perito');
                fd.append('order_type', 'DESC');
            } else if (iconPerito.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'perito');
                fd.append('order_type', 'ASC');
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'coordinador');
                fd.append('order_type', 'DESC');
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'coordinador');
                fd.append('order_type', 'ASC');
            }

            if (iconFecha.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'fecha');
                fd.append('order_type', 'DESC');
            } else if (iconFecha.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'fecha');
                fd.append('order_type', 'ASC');
            }

            /*if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                fd.append('order', 'estado');
                fd.append('order_type', 'DESC');
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                fd.append('order', 'estado');
                fd.append('order_type', 'ASC');
            }*/

            return fd;
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

        const listInspecciones = (fd) => {
            tableBody.innerHTML = '<tr><td colspan="10" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', '../inspecciones/search', fd)
                .then((response) => {
                    let selectedLink = Number(fd.get('num_page'));
					let quantityRecords = Number(fd.get('quantity'));
                    let records = response.records_find;

                    if (records != false) {
                        let row = records.map((item, index) => {
		        			return `<tr>
		        						<td>${((selectedLink - 1) * quantityRecords) + index + 1}</td>
                                        <td>${item.coordinacion_correlativo}</td>
                                        <td>${item.solicitante_nombre.toUpperCase()}</td>
                                        <td>${item.cliente_nombre.toUpperCase()}</td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td>
                                            ${item.inspeccion_direccion.toUpperCase()}
                                            <div>${item.departamento_nombre} <i class="fa fa-play text-danger"></i> ${item.provincia_nombre} <i class="fa fa-play text-danger"></i> ${item.distrito_nombre}</div>
                                        </td>
                                        <td>${item.perito_nombre.toUpperCase()}</td>
		        						<td>${item.coordinador_nombre.toUpperCase()}</td>
                                        <td>${item.inspeccion_fecha}</td>
                                        <td>${transformarHora('list', item.inspeccion_hora)}</td>
                                        <!--<td>${item.estado_nombre}</td>-->
		        					</tr>`
                        }).join('');
                        
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
                    } else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="10" align="center">NO HAY REGISTROS</td>
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

		        	if (inputCorrelativo.value.trim() == '' && inputSolicitante.value.trim() == '' && inputCliente.value.trim() == '' && $('#selectServicioTipo').val() == '' && inputDireccion.value.trim() == '' && selectPerito.value == '' && selectCoordinador.value == '')// && selectEstado.value == '')
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
		        			listInspecciones(filters(num_page));
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
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        listInspecciones(filters(1));

        selectQuantity.addEventListener('change', e => {
            listInspecciones(filters(1));
        });

        inputCorrelativo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listInspecciones(filters(1));
        });

        inputSolicitante.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listInspecciones(filters(1));
        });

        inputCliente.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listInspecciones(filters(1));
        });

        $('#selectServicioTipo').change(function (e) {
            listInspecciones(filters(1));
        });

        inputDireccion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listInspecciones(filters(1));
        });

        selectPerito.addEventListener('change', e => {
            listInspecciones(filters(1));
        });

        selectCoordinador.addEventListener('change', e => {
            listInspecciones(filters(1));
        });

        inputFechaDesde.addEventListener('change', e => {
            inputFechaHasta.setAttribute('min', inputFechaDesde.value)
            if (inputFechaHasta.value < inputFechaDesde.value || inputFechaDesde.value == '') {
                inputFechaHasta.value = inputFechaDesde.value;
            }
        });

        inputFechaHasta.addEventListener('change', e => {
            if (inputFechaDesde.value > inputFechaHasta.value) {
                inputFechaDesde.value = inputFechaHasta.value;
            }

            if (inputFechaHasta == '') {
                inputFechaHasta.removeAttribute('min');
            }
        });

        buttonSearch.addEventListener('click', e => {
            /*if (selectFechaTipo.value == '') {
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
            } else {*/
                buttonFilters.click();
                listInspecciones(filters(1));
            /*}*/
        });

        buttonCancel.addEventListener('click', e => {
            form.reset();
            buttonFilters.click();
            listInspecciones(filters(1));
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
                order_type = 'asc';
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

            if (iconDireccion.classList.contains('fa-sort-amount-desc')) {
                order = 'direccion';
                order_type = 'DESC';
            } else if (iconDireccion.classList.contains('fa-sort-amount-asc')){
                order = 'direccion';
                order_type = 'ASC';
            }

            if (iconPerito.classList.contains('fa-sort-amount-desc')) {
                order = 'perito';
                order_type = 'DESC';
            } else if (iconPerito.classList.contains('fa-sort-amount-asc')){
                order = 'perito';
                order_type = 'ASC';
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinador';
                order_type = 'DESC';
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                order = 'coordinador';
                order_type = 'ASC';
            }

            if (iconFecha.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha';
                order_type = 'DESC';
            } else if (iconFecha.classList.contains('fa-sort-amount-asc')){
                order = 'fecha';
                order_type = 'ASC';
            }

            /*if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                order = 'estado';
                order_type = 'DESC';
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                order = 'estado';
                order_type = 'ASC';
            }*/
            
            let object = {
                coordinacion_correlativo: inputCorrelativo.value,
                inspeccion_solicitante: inputSolicitante.value,
                inspeccion_cliente: inputCliente.value,
                inspeccion_servicio_tipo: $('#selectServicioTipo').val().toString(),
                inspeccion_direccion: inputDireccion.value,
                inspeccion_perito: selectPerito.value,
                inspeccion_coordinador: selectCoordinador.value,
                /*inspeccion_estado: selectEstado.value,
                inspeccion_fecha_tipo: selectFechaTipo.value,*/
                inspeccion_fecha_desde: inputFechaDesde.value,
                inspeccion_fecha_hasta: inputFechaHasta.value,
                order: order,
                order_type: order_type
            };


            let inputFormInspeccion = d.createElement('input');
            inputFormInspeccion.type = 'text';
            inputFormInspeccion.name = 'data';
            inputFormInspeccion.value = JSON.stringify(object);
            form.appendChild(inputFormInspeccion);

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
                order_type = 'asc';
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

            if (iconDireccion.classList.contains('fa-sort-amount-desc')) {
                order = 'direccion';
                order_type = 'DESC';
            } else if (iconDireccion.classList.contains('fa-sort-amount-asc')){
                order = 'direccion';
                order_type = 'ASC';
            }

            if (iconPerito.classList.contains('fa-sort-amount-desc')) {
                order = 'perito';
                order_type = 'DESC';
            } else if (iconPerito.classList.contains('fa-sort-amount-asc')){
                order = 'perito';
                order_type = 'ASC';
            }

            if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                order = 'coordinador';
                order_type = 'DESC';
            } else if (iconCoordinador.classList.contains('fa-sort-amount-asc')){
                order = 'coordinador';
                order_type = 'ASC';
            }

            if (iconFecha.classList.contains('fa-sort-amount-desc')) {
                order = 'fecha';
                order_type = 'DESC';
            } else if (iconFecha.classList.contains('fa-sort-amount-asc')){
                order = 'fecha';
                order_type = 'ASC';
            }

            /*if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                order = 'estado';
                order_type = 'DESC';
            } else if (iconEstado.classList.contains('fa-sort-amount-asc')){
                order = 'estado';
                order_type = 'ASC';
            }*/
            
            let object = {
                coordinacion_correlativo: inputCorrelativo.value,
                inspeccion_solicitante: inputSolicitante.value,
                inspeccion_cliente: inputCliente.value,
                inspeccion_servicio_tipo: $('#selectServicioTipo').val().toString(),
                inspeccion_direccion: inputDireccion.value,
                inspeccion_perito: selectPerito.value,
                inspeccion_coordinador: selectCoordinador.value,
                /*inspeccion_estado: selectEstado.value,
                inspeccion_fecha_tipo: selectFechaTipo.value,*/
                inspeccion_fecha_desde: inputFechaDesde.value,
                inspeccion_fecha_hasta: inputFechaHasta.value,
                order: order,
                order_type: order_type
            };


            let inputFormInspeccion = d.createElement('input');
            inputFormInspeccion.type = 'text';
            inputFormInspeccion.name = 'data';
            inputFormInspeccion.value = JSON.stringify(object);
            form.appendChild(inputFormInspeccion);

            d.body.appendChild(form);
            form.submit();
            d.body.removeChild(form);
        });

        thSort.forEach(th => {
            th.addEventListener('click', e => {
                const indice = th.dataset.index;

                removeIcon(parseInt(indice));
                switch (parseInt(indice)) {
                    case 1:
                        if (iconCoordinacion.classList.contains('fa-sort-amount-desc')) {
                            iconCoordinacion.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCoordinacion.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconCoordinacion.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCoordinacion.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 2:
                        if (iconSolicitante.classList.contains('fa-sort-amount-desc')) {
                            iconSolicitante.classList.remove('fa', 'fa-sort-amount-desc');
                            iconSolicitante.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconSolicitante.classList.remove('fa', 'fa-sort-amount-asc');
                            iconSolicitante.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 3:
                        if (iconCliente.classList.contains('fa-sort-amount-desc')) {
                            iconCliente.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCliente.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconCliente.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCliente.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 4:
                        if (iconTipoServicio.classList.contains('fa-sort-amount-desc')) {
                            iconTipoServicio.classList.remove('fa', 'fa-sort-amount-desc');
                            iconTipoServicio.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconTipoServicio.classList.remove('fa', 'fa-sort-amount-asc');
                            iconTipoServicio.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 5:
                        if (iconDireccion.classList.contains('fa-sort-amount-desc')) {
                            iconDireccion.classList.remove('fa', 'fa-sort-amount-desc');
                            iconDireccion.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconDireccion.classList.remove('fa', 'fa-sort-amount-asc');
                            iconDireccion.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 6:
                        if (iconPerito.classList.contains('fa-sort-amount-desc')) {
                            iconPerito.classList.remove('fa', 'fa-sort-amount-desc');
                            iconPerito.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconPerito.classList.remove('fa', 'fa-sort-amount-asc');
                            iconPerito.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 7:
                        if (iconCoordinador.classList.contains('fa-sort-amount-desc')) {
                            iconCoordinador.classList.remove('fa', 'fa-sort-amount-desc');
                            iconCoordinador.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconCoordinador.classList.remove('fa', 'fa-sort-amount-asc');
                            iconCoordinador.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    case 8:
                        if (iconFecha.classList.contains('fa-sort-amount-desc')) {
                            iconFecha.classList.remove('fa', 'fa-sort-amount-desc');
                            iconFecha.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconFecha.classList.remove('fa', 'fa-sort-amount-asc');
                            iconFecha.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;
                    /*case 9:
                        if (iconEstado.classList.contains('fa-sort-amount-desc')) {
                            iconEstado.classList.remove('fa', 'fa-sort-amount-desc');
                            iconEstado.classList.add('fa', 'fa-sort-amount-asc');
                        } else {
                            iconEstado.classList.remove('fa', 'fa-sort-amount-asc');
                            iconEstado.classList.add('fa', 'fa-sort-amount-desc');
                        }
                        break;*/
                }

                listInspecciones(filters(1));
            });
        });

        const removeIcon = (x) => {
            if (x != 1) {
                iconCoordinacion.classList.remove('fa', 'fa-sort-amount-desc');
                iconCoordinacion.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 2) {
                iconSolicitante.classList.remove('fa', 'fa-sort-amount-desc');
                iconSolicitante.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 3) {
                iconCliente.classList.remove('fa', 'fa-sort-amount-desc');
                iconCliente.classList.remove('fa', 'fa-sort-amount-asc');
            }
            if (x != 4) {
                iconTipoServicio.classList.remove('fa', 'fa-sort-amount-desc');
                iconTipoServicio.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 5) {
                iconDireccion.classList.remove('fa', 'fa-sort-amount-desc');
                iconDireccion.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 6) {
                iconPerito.classList.remove('fa', 'fa-sort-amount-desc');
                iconPerito.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 7) {
                iconCoordinador.classList.remove('fa', 'fa-sort-amount-desc');
                iconCoordinador.classList.remove('fa', 'fa-sort-amount-asc');
            }

            if (x != 8) {
                iconFecha.classList.remove('fa', 'fa-sort-amount-desc');
                iconFecha.classList.remove('fa', 'fa-sort-amount-asc');
            }

            /*if (x != 9) {
                iconEstado.classList.remove('fa', 'fa-sort-amount-desc');
                iconEstado.classList.remove('fa', 'fa-sort-amount-asc');
            }*/
        }
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}