(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
    	const buttonChangeCliente = d.getElementById('buttonChangeCliente');
    	const form = d.getElementById('frm_change_cliente');

    	const radioNaturalModal = d.getElementById('radioNaturalModal');
    	const radioJuridicoModal = d.getElementById('radioJuridicoModal');

    	const labelClienteModal = d.getElementById('labelClienteModal');
    	//const divConcatoModal = d.getElementById('divConcatoModal');

        const selectClienteModal = d.getElementById('selectClienteModal');
        const selectContactoModal = d.getElementById('selectContactoModal');

        const divCotizacionCodigo = d.getElementById('cotizacionCodigo');
        const inputCodigo = d.getElementById('inputCodigo');
        const buttonCloseChangeCliente = d.getElementById('buttonCloseChangeCliente');

    	buttonChangeCliente.addEventListener('click', e => {
    		form.reset();
    		$('#mdl_change_cliente').modal({
    			'show': true,
    			'keyboard': false,
    			'backdrop': 'static'
    		});
    	});

    	radioNaturalModal.addEventListener('change', e => {
    		if (radioNaturalModal.checked) {
    			labelClienteModal.innerHTML = 'Ape. y Nombres:';
    			//divConcatoModal.classList.add('hidden');
                listarInvolucrados('N');
    		}
    	});

    	radioJuridicoModal.addEventListener('change', e => {
    		if (radioJuridicoModal.checked) {
    			labelClienteModal.innerHTML = 'Razón Social:';
    			//divConcatoModal.classList.remove('hidden');
                listarInvolucrados('J');
    		}
    	});

        const listarInvolucrados = (type) => {
            $('#selectClienteModal').empty().trigger('change');
            $('#selectClienteModal').select2({
                theme: 'classic',
                width: '100%',
                ajax: {
                    url: "../involucrado/fetch_combobox_involucrado",
                    dataType: "json",
                    type: "post",
                    delay: 250,
                    data: function(params) {
                        return {
                            type: type,
                            search: params.term
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    },
                    cache: true
                },
                placeholder: 'Seleccione cliente',
                minimumInputLength: 3,
            })/*.on('change', function (e) {
                if(radioJuridicoModal.checked) {
                    listarContactos($(this).val());
                }
            })*/;
        }

        /*const listarContactos = (id) => {
            $('#selectContactoModal').empty().trigger('change');
            $('#selectContactoModal').select2({
                theme: 'classic',
                width: '100%',
                ajax: {
                    url: "../contacto/fetch_all_combobox",
                    dataType: "json",
                    type: "post",
                    data: function() {
                        return {
                            search: id
                        }
                    },
                    processResults: function(data) {
                        return {
                            results: data
                        };
                    }
                },
                placeholder: 'Seleccione contacto'
            });
        }*/

        listarInvolucrados('N');

        $("#mdl_change_cliente").on('hidden.bs.modal', function () {
            radioNaturalModal.click();
            listarInvolucrados('N');
        });

        form.addEventListener('keypress', e => {
            if (e.keyCode == 13 || e.which == 13) {
                return false;
            }
        });

        form.addEventListener('submit', e => {
            e.preventDefault();

            if (selectClienteModal.value == '')
            {
                swal({
                    text: 'Seleccione cliente...',
                    timer: 2000,
                    buttons: false
                });
            }
            /*else if (radioJuridicoModal.checked && selectContactoModal.value == '')
            {
                swal({
                    text: 'Seleccione contacto...',
                    timer: 2000,
                    buttons: false
                });
            }*/
            else
            {
                const apiRestMantenimiento = 'updateCliente';
                const fd = new FormData();
                fd.append('coordinacion_codigo', inputCodigo.value);
                fd.append('coordinacion_cliente', $('#selectClienteModal').val());
                fd.append('coordinacion_cliente_tipo', radioNaturalModal.checked ? 'Natural' : 'Juridica');

                ajax('post', apiRestMantenimiento, fd)
                    .then((response) => {
                        if (response.success) {
                            swal({
                                icon: 'success',
                                //title: 'Actualizado',
                                text: 'Se actualizo correctamente...',
                                timer: 1500,
                                buttons: false
                            }).then(
                                () => buttonCloseChangeCliente.click(), listCoordinaciones(divCotizacionCodigo.innerHTML, inputCodigo.value)
                            );
                        } else {
                            swal({
                                icon: 'error',
                                title: 'Error',
                                text: 'No se pudo guardar, por favor informar al area de sistemas',
                                timer: 1500,
                                buttons: false
                            });
                        }
                    })
                    .catch(() => {
                        console.log('Promesa no cumplida')
                    });

            }
        });
    });
})(document);