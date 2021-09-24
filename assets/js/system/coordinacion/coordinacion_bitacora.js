(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const buttonNewBitacora = d.getElementById('buttonNewBitacora');
        const tableBody = d.getElementById('tbl_bitacora').getElementsByTagName('tbody')[0];
        const inputCodigo = d.getElementById('inputCodigo');
        const divCorrelativo = d.getElementById('coordinacionCorrelativo');

        const form = d.getElementById('frm_bitacora');
        const inputBitacoraDescripcion = d.getElementById('inputBitacoraDescripcion');
        const buttonCloseBitacora = d.getElementById('buttonCloseBitacora');
        const buttonSaveBitacora = d.getElementById('buttonSaveBitacora');
        const buttonPrintBitacora = d.getElementById('buttonPrintBitacora');

        listBitacora = (coordinacion) => {
            let fd = new FormData();
            fd.append('coordinacion_codigo', coordinacion);

            tableBody.innerHTML = '<tr><td colspan="5" align="center"><h1><i class="fa fa-spinner fa-pulse fa-fw"></i></h1></td></tr>';

            ajax('post', 'searchBitacora', fd)
                .then((response) => {
                    const records = response.records_find;
                    if (records != false) {
		        		let row = records.map((item, index) => {
		        			return `<tr>
		        						<td>${index + 1}</td>
		        						<td>${item.usuario_nombre.toUpperCase()}</td>
                                        <td>
                                            <div align="justify">
                                                ${item.bitacora_descripcion.toUpperCase()}
                                            </div>
                                        </td>
		        						<td>${item.bitacora_fecha}</td>
                                        <td>
                                            ${
                                                transformarHora('list', item.bitacora_hora)
                                            }
                                        </td>
		        					</tr>`
		        		}).join('');
                        tableBody.innerHTML = '';
                        tableBody.innerHTML = row;
		        	} else {
		        		tableBody.innerHTML = 	`<tr>
		        									<td colspan="5" align="center">NO HAY REGISTROS</td>
					        					</tr>`;
		        	}
                })
                .catch(() => {
                    console.log('Promesa no cumplida')
                })
        }

        buttonNewBitacora.addEventListener('click', e => {
            form.reset();
            $('#mdl_bitacora').modal({
                'show': true,
                'keyboard': false,
                'backdrop': 'static'
            });
        });

        form.addEventListener('keypress', e => {
            if (e.keyCode == 13 || e.which == 13) {
                return false;
            }
        });

        const crudBitacora = () => {
            const apiRestMantenimiento = 'insertBitacora';

            let fd = new FormData();
            fd.append('coordinacion_codigo', inputCodigo.value);
            fd.append('bitacora_decripcion', inputBitacoraDescripcion.value);

            ajax('post', apiRestMantenimiento, fd)
                .then((response) => {
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se guardo correctamente ...',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseBitacora.click(), listBitacora(inputCodigo.value)
                        );
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: 'No se pudo guardar, por favor informar al area de sistemas',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseBitacora.click()
                        );
                    }
                })
                .catch(() => {
                    console.log('Promesa no cumplida');
                })
        }

        form.addEventListener('submit', e => {
            e.preventDefault();

            if (inputBitacoraDescripcion.value.trim() == '' && inputBitacoraDescripcion.value.lenght < 10) {

            } else {
                crudBitacora();
            }
        });

        buttonPrintBitacora.addEventListener('click', e => {
            e.preventDefault();
            let form = d.createElement('form');
            form.setAttribute('method', 'post');
            form.setAttribute('action', `imprimirBitacora`);
            form.setAttribute('target', '_blank');
            
            let object = {
                coordinacion_codigo: inputCodigo.value,
                coordinacion_correlativo: divCorrelativo.innerText
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
    })
})(document);