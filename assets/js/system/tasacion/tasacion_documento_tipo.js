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

        listarDocumentoTipo = (involucrado) => {
        	const fd = new FormData();
        	fd.append('action', 'combobox');

        	ajax('post', '../tipo-documento/search', fd)
        		.then((response) => {
        			const records = response.records_all;
        			if (records != false) {
        				let row = records.map((item, index) => {
        					if (index == 0)
        						return `<option value=""></option><option value="${item.documento_tipo_id}">${item.documento_tipo_abreviatura} - ${item.documento_tipo_nombre}</option>`
        					else if (involucrado == 'cliente' && radioClienteJuridico.checked == false && item.documento_tipo_id == 4 || involucrado == 'solicitante' && radioSolicitanteJuridico.checked == false && item.documento_tipo_id == 4)
        						return ``
                            else 
                                return `<option value="${item.documento_tipo_id}">${item.documento_tipo_abreviatura} - ${item.documento_tipo_nombre}</option>`
        				}).join('');

        				$('#selectTipoDocumento').html('');
        				$('#selectTipoDocumento').html(row);

        				if (involucrado == 'cliente' && radioClienteJuridico.checked == true || involucrado == 'solicitante' && radioSolicitanteJuridico.checked == true)
        					$('#selectTipoDocumento').val('4').trigger('change');
        				else if (involucrado == 'cliente' && radioClienteJuridico.checked == false || involucrado == 'solicitante' && radioSolicitanteJuridico.checked == false)
        					$('#selectTipoDocumento').val('2').trigger('change');
        			}
        		})
                .catch(() => {
                    console.log('Promesa no cumplida');
                });
        }
    })
})(document);