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

        //TABLA
        const tableBody = d.getElementById('tbl_tasacion').getElementsByTagName('tbody')[0];
        const selectQuantity = d.getElementById('selectQuantity');
        const buttonNuevo = d.getElementById('buttonNuevo');

        const labelCoordinacion = d.getElementById('labelCoordinacion');
        const labelInspeccion = d.getElementById('labelInspeccion');
        const row_informe = d.getElementById('row_informe');
        const inputInformeCodigo = d.getElementById('inputInformeCodigo');

        //FILTROS
        const inputCorrelativo = d.getElementById('inputCorrelativo');
        const inputInspeccion = d.getElementById('inputInspeccion');
        const inputSolicitante = d.getElementById('inputSolicitante');
        const inputCliente = d.getElementById('inputCliente');
        const selectDigitador = d.getElementById('selectDigitador');
        const selectControlCalidad = d.getElementById('selectControlCalidad');

        //LINK REGISTRO DE TASACIONES
        const linkTerreno = d.getElementById('linkTerreno');
        const linkCasa = d.getElementById('linkCasa');
        const linkDepartamento = d.getElementById('linkDepartamento');
        const linkOficina = d.getElementById('linkOficina');
        const linkLocalComercial = d.getElementById('linkLocalComercial');
        const linkLocalIndustrial = d.getElementById('linkLocalIndustrial');
        const linkVehiculo = d.getElementById('linkVehiculo');
        const linkMaquinaria = d.getElementById('linkMaquinaria');
        const linkOtros = d.getElementById('linkOtros');

        const filters = (link) => {
            const fd = new FormData()
            fd.append('coordinacion_correlativo', inputCorrelativo.value);
            fd.append('inspeccion_codigo', inputInspeccion.value);
            fd.append('coordinacion_solicitante', inputSolicitante.value);
            fd.append('coordinacion_cliente', inputCliente.value);
            fd.append('coordinacion_digitador', selectDigitador.value);
            fd.append('coordinacion_control_calidad', selectControlCalidad.value);
            fd.append('num_page', link);
            fd.append('quantity', selectQuantity.value);
            return fd;
        }

        const listTasaciones = (fd) => {
            tableBody.innerHTML = '<tr><td colspan="11" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', 'search', fd)
                .then((response) => {
                    let selectedLink = Number(fd.get('num_page'));
					let quantityRecords = Number(fd.get('quantity'));
                    const records = response.records_find;
                    if (records != false) {
		        		let row = records.map((item, index) => {
                            let verButton = item.encontradas + '-' + item.reproceso;
		        			return `<tr>
		        						<td>${((selectedLink - 1) * quantityRecords) + index + 1}</td>
                                        <td>${item.coordinacion_correlativo}</td>
                                        <td>${item.inspeccion_id}</td>
                                        <td>${item.solicitante_nombre.toUpperCase()}</td>
                                        <td>${item.cliente_nombre.toUpperCase()}</td>
                                        <td>${item.servicio_tipo_nombre.toUpperCase()}</td>
                                        <td>
                                            ${item.inspeccion_direccion.toUpperCase()}
                                            <div>${item.departamento_nombre} <i class="fa fa-play text-danger"></i> ${item.provincia_nombre} <i class="fa fa-play text-danger"></i> ${item.distrito_nombre}</div>
                                        </td>
                                        <td>${item.digitador_nombre.toUpperCase()}</td>
		        						<td>${item.control_calidad_nombre.toUpperCase()}</td>
                                        <td>${item.fecha_entrega}</td>
                                        <td>${verButton != '1-1' ? `<button id="buttonRegistrar" type="button" class="btn grey btn-outline-secondary btn-sm" data-indice="${index}">Registrar como</button>` : `<button id="buttonActualizar" type="button" class="btn grey btn-outline-warning btn-sm" data-indice="${index}"><i class="ft ft-edit"></i> Actualizar</button>`}</td>
		        					</tr>`
		        		}).join('');
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
		        	} else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="11" align="center">NO HAY REGISTROS</td>
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

		        	if (inputCorrelativo.value.trim() == '' && inputInspeccion.value.trim() == '' && inputSolicitante.value.trim() == '' && inputCliente.value.trim() == '' && selectDigitador.value == '' && selectControlCalidad.value == '')
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecords + ' registros';
		        	else
		        		spanCount.innerHTML = 'Mostrando ' + (((selectedLink - 1) * quantityRecords) + 1) + ' a ' + quantityView + ' de ' + totalRecordsFind + ' registros Filtrados (total de registros ' + totalRecords +')';

		        	let divPagination = d.getElementById('divPagination');
                    divPagination.innerHTML = paginator;
                    
                    let paginationLink = d.querySelectorAll('#link');
                    let buttonRegistrar = d.querySelectorAll('#buttonRegistrar');
                    let buttonActualizar = d.querySelectorAll('#buttonActualizar');

		        	paginationLink.forEach(link => {
		        		link.addEventListener('click', e => {
		        			e.preventDefault();
		        			let num_page = link.getAttribute('href');
		        			listTasaciones(filters(num_page));
		        		});
                    });

                    buttonRegistrar.forEach(button => {
                        button.addEventListener('click', e => {
                            const indice = button.dataset.indice;
                            labelCoordinacion.innerText = records[indice].coordinacion_id;
                            labelInspeccion.innerText = records[indice].inspeccion_id;
                            if (row_informe.classList.contains('hidden') == false) {
                                row_informe.classList.add('hidden');
                                inputInformeCodigo.setAtribute('disabled', 'disabled');
                            }
                            
                            $('#mdlTipoRegistro').modal({
                                'show': true,
                                'keyboard': false,
                                'backdrop': 'static'
                            });
                        })
                    });

                    buttonActualizar.forEach(button => {
                        button.addEventListener('click', e => {
                            const indice = button.dataset.indice;
                            let data = {
                                coordinacion: records[indice].coordinacion_correlativo
                                //coordinacion: 21854
                            };

                            sessionStorage.setItem('data', JSON.stringify(data));
                            window.location.href = 'detalle';
                        });
                    });
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        listTasaciones(filters(1));

        const enviarRegistro = (data) => {
            sessionStorage.setItem('data', JSON.stringify(data));
            window.location.href = 'registro';
        }

        buttonNuevo.addEventListener('click', e => {
            row_informe.classList.remove('hidden');
            inputInformeCodigo.removeAttribute('disabled');
            $('#mdlTipoRegistro').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        selectQuantity.addEventListener('change', e => {
            listTasaciones(filters(1));
        });

        inputCorrelativo.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasaciones(filters(1));
        });

        inputInspeccion.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasaciones(filters(1));
        });

        inputSolicitante.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasaciones(filters(1));
        });

        inputCliente.addEventListener('keyup', e => {
            if(e.keyCode == 13)
                listTasaciones(filters(1));
        });

        selectDigitador.addEventListener('change', e => {
            listTasaciones(filters(1));
        });

        selectControlCalidad.addEventListener('change', e => {
            listTasaciones(filters(1));
        });

        linkTerreno.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 1,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 1,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkCasa.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 2,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 2,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkDepartamento.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 3,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 3,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkOficina.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 4,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 4,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkLocalComercial.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 5,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 5,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkLocalIndustrial.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 6,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 6,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkVehiculo.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 7,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 7,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkMaquinaria.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 8,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 8,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });

        linkOtros.addEventListener('click', e => {
            e.preventDefault();
            if (row_informe.classList.contains('hidden') == false && inputInformeCodigo.value == '') {
                swal({
                    text: 'Digité codigo de informe ...',
                    timer: 3000,
                    buttons: false
                })
                .then(() => {
                    inputInformeCodigo.focus()
                })
            } else {
                let data = {};
                if (inputInformeCodigo.hasAttribute('disabled')) {
                    data = {
                        tipo: 9,
                        /*coordinacion: labelCoordinacion.innerText,*/
                        inspeccion: labelInspeccion.innerText
                    };
                } else {
                    data = {
                        tipo: 9,
                        correlativo: inputInformeCodigo.value
                    };
                }
                enviarRegistro(data);
            }
        });
    })
})(document);

window.onload = function () {
    sessionStorage.clear();
}