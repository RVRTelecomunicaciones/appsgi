(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const divCotizacionCodigo = d.getElementById('cotizacionCodigo');
        const inputCodigo = d.getElementById('inputCodigo');
        const inputFechaEntrega = d.getElementById('inputFechaEntrega');

        const buttonChangeFecha = d.getElementById('buttonChangeFecha');
        const form = d.getElementById('frm_cambio_fecha');

        const inputNuevaFechaEntrega = d.getElementById('inputNuevaFechaEntrega');
        const inputMotivo = d.getElementById('inputMotivo');

        const buttonCloseCambioFecha = d.getElementById('buttonCloseCambioFecha');

        if (buttonChangeFecha) {
            buttonChangeFecha.addEventListener('click', e => {
                form.reset();
                $('#mdl_cambio_fecha').modal({
                    'show': true,
                    'keyboard': false,
                    'backdrop': 'static'
                });
            });
        }
        
        const crudFecha = (fd) => {
            ajax('post', 'cambioFecha', fd)
                .then((response) => {
                    if (response.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: 'Se guardo correctamente',
                            timer: 1500,
                            buttons: false
                        }).then(
                            () => buttonCloseCambioFecha.click(), listCoordinaciones(divCotizacionCodigo.innerHTML, inputCodigo.value)
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

        form.addEventListener('submit', e => {
            e.preventDefault();
            if (inputNuevaFechaEntrega.value == '') {
                swal({
                    text: 'Seleccioné nueva fecha',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputNuevaFechaEntrega.focus()
                );
            } else if (inputMotivo.value == '') {
                swal({
                    text: 'Ingrese motivo',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputMotivo.focus()
                );
            } else if (inputNuevaFechaEntrega.value == inputFechaEntrega.value) {
                swal({
                    text: 'La fecha nueva no puede ser igual a la fecha de entrega',
                    timer: 2000,
                    buttons: false
                }).then(
                    () => inputMotivo.focus()
                );
            } else {
                const fd = new FormData();
                fd.append('cambio_coordinacion_codigo', inputCodigo.value);
                fd.append('cambio_coordinacion_fecha_anterior', inputFechaEntrega.value);
                fd.append('cambio_coordinacion_nueva_fecha', inputNuevaFechaEntrega.value);
                fd.append('cambio_coordinacion_motivo', inputMotivo.value);
                crudFecha(fd);
            }
        });
    })
})(document);