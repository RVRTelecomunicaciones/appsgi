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

        const radioClienteJuridico = d.getElementById('radioClienteJuridico');
        const radioSolicitanteJuridico = d.getElementById('radioSolicitanteJuridico');

        const labelInvolucrado = d.getElementById('labelInvolucrado');
        const labelInvolucradoTipo = d.getElementById('labelInvolucradoTipo');

        const inputPaterno = d.getElementById('inputPaterno');
        const row_paterno = d.getElementById('row_paterno');

        const inputMaterno = d.getElementById('inputMaterno');
        const row_materno = d.getElementById('row_materno');

        const inputNombres = d.getElementById('inputNombres');
        const labelNombres = d.getElementById('labelNombres');

        const selectTipoDocumento = d.getElementById('selectTipoDocumento');
        const row_documento_tipo = d.getElementById('row_documento_tipo');

        const inputNroDocumento = d.getElementById('inputNroDocumento');

        const buttonInvolucradosGuardar = d.getElementById('buttonInvolucradosGuardar');
        const buttonInvolucradosCancelar = d.getElementById('buttonInvolucradosCancelar');

        ocultarControles = (involucrado) => {
        	if (involucrado == 'cliente' && radioClienteJuridico.checked == true || involucrado == 'solicitante' && radioSolicitanteJuridico.checked == true) {
        		if (!row_paterno.classList.contains('hidden'))
        			row_paterno.classList.add('hidden');

        		if (!row_materno.classList.contains('hidden'))
        			row_materno.classList.add('hidden');

        		if (!row_documento_tipo.classList.contains('hidden'))
        			row_documento_tipo.classList.add('hidden');

        		labelNombres.innerText = 'Razón Social';
        	} else if (involucrado == 'cliente' && radioClienteJuridico.checked == false || involucrado == 'solicitante' && radioSolicitanteJuridico.checked == false) {
        		if (row_paterno.classList.contains('hidden'))
        			row_paterno.classList.remove('hidden');

        		if (row_materno.classList.contains('hidden'))
        			row_materno.classList.remove('hidden');

        		if (row_documento_tipo.classList.contains('hidden'))
        			row_documento_tipo.classList.remove('hidden');
        		labelNombres.innerText = 'Nombres';
        	}
        }

        listarInvolucrados = (tipo, involucrado, id = false) => {
        	const fd = new FormData();
        	fd.append('action', 'combobox');
        	fd.append('involucrado_tipo', tipo);

        	ajax('post', '../involucrado/search', fd)
        		.then((response) => {
        			const records = response.records_all;
        			if (records != false) {
        				let row = records.map((item, index) => {
        					if (index == 0)
        						return `<option value=""></option><option value="${item.involucrado_id}" data-id="${item.involucrado_id}" data-tipo="${tipo == 'J' ? 'Juridica' : 'Natural'}">${item.involucrado_nombres} - (${item.involucrado_nro_documento})</option>`
        					else
        						return `<option value="${item.involucrado_id}" data-id="${item.involucrado_id}" data-tipo="${tipo == 'J' ? 'Juridica' : 'Natural'}">${item.involucrado_nombres} - (${item.involucrado_nro_documento})</option>`
        				}).join('');

        				if (involucrado == 'cliente') {
        					$('#selectCliente').html('');
        					$('#selectCliente').html(row);

        					if (id != false)
        						$('#selectCliente').val(id).trigger('change');
        				} else {
        					$('#selectSolicitante').html('');
        					$('#selectSolicitante').html(row);

        					if (id != false)
        						$('#selectSolicitante').val(id).trigger('change');
        				}
        			}
        		})
        		.catch(() => {
                    console.log('Promesa no cumplida');
                });
        }

        const crudInvulucrado = () => {
        	const apiRestMantenimiento = '../involucrado/insert';
        	const fd = new FormData();
        	fd.append('involucrado_tipo', labelInvolucradoTipo.innerText)
        	fd.append('involucrado_nombres', inputNombres.value)
        	fd.append('involucrado_documento_tipo', selectTipoDocumento.value)
        	fd.append('involucrado_nro_documento', inputNroDocumento.value)

        	if (labelInvolucradoTipo.innerText == 'Natural') {
        		fd.append('involucrado_paterno', inputPaterno.value);
        		fd.append('involucrado_materno', inputMaterno.value);
        	}

        	ajax('post', apiRestMantenimiento, fd)
                .then((response) => {
                	if (response.success) {
                		swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se ha guardado correctamente ...',
                            timer: 3000,
                            buttons: false
                        })
                        .then(() => {
                            listarInvolucrados(labelInvolucradoTipo.innerText.substring(0, 1), labelInvolucrado.innerText, response.idInvolucrado);
                            buttonInvolucradosCancelar.click();
                        });
                	} else {
                		swal({
                            icon: 'danger',
                            title: 'Error',
                            text: 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                	}
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        buttonInvolucradosGuardar.addEventListener('click', e => {
        	if (labelInvolucradoTipo.innerText == 'Juridica' && inputNombres.value == '') {
        		swal({
					text: 'Ingresé razón social ...',
					timer: 1500,
					buttons: false
                })
                .then(() => inputNombres.focus())
        	} else if (labelInvolucradoTipo.innerText == 'Natural' && inputPaterno.value == '') {
        		swal({
					text: 'Ingresé apellido paterno ...',
					timer: 1500,
					buttons: false
                })
                .then(() => inputPaterno.focus())
        	} else if (labelInvolucradoTipo.innerText == 'Natural' && inputMaterno.value == '') {
        		swal({
					text: 'Ingresé apellido materno ...',
					timer: 1500,
					buttons: false
                })
                .then(() => inputMaterno.focus())
        	} else if (labelInvolucradoTipo.innerText == 'Natural' && inputNombres.value == '') {
        		swal({
					text: 'Ingresé nombres ...',
					timer: 1500,
					buttons: false
                })
                .then(() => inputNombres.focus())
        	} else {
        		crudInvulucrado();
        	}
        });
    })
})(document);