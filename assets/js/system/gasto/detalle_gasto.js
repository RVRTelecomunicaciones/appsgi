(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        //METODO AJAX PARA OBTENER DATOS
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const botonAñadir = d.querySelector('#mdl_gastos #linkAñadir');
        const botonCancelar = d.querySelector('#mdl_gastos #linkCancelar');
        const botonCerrar = d.querySelector('#mdl_gastos #linkCerrar');

        const selectGasto = d.querySelector('#mdl_gastos #selectGasto');
        const selectMoneda = d.querySelector('#mdl_gastos #moneda_costo_perito');
        const inputMonto = d.querySelector('#mdl_gastos #inputCostoPerito');
        const inputDetalleGastoId = d.querySelector('#mdl_gastos #inputDetalle');
        const inputCoordinacionId = d.querySelector('#mdl_gastos #inputCoordinacion');
        const inputCotizacionId = d.querySelector('#mdl_gastos #inputCotizacion');

        //METODO PARA LISTAR TABLA
        listDetalleGastos = () => {
            const fd = new FormData()
            fd.append('coordinacion_id', inputCoordinacionId.value)
            // promesa crea un objeto y este tiene metodos
            ajax('post', 'searchDetalleGasto', fd)
                .then((respuesta) => {
                    //console.log(respuesta.cotizacion);
                    $('#mdl_gastos #tableDetalleGasto tbody').html('');
                    const records_find = respuesta.gastos_find;
                    if (records_find != false) {
                        const filas_find = records_find.map((item, index) => {
                            return `<tr>
                                        <td>${index + 1}</td>                       
                                        <td><div align='left'>${item.gasto_nombre.toUpperCase()}</div></td>
                                        <td><div align='right'>${item.moneda_simbolo} ${item.detalle_monto}</div></td>
                                        <td>
                                            <div style='font-size: 1.2rem;'>
                                                <a id='linkEditar' href data-indice='${index}'><i class='fa fa-edit mr-1'></i></a>
                                                <a id='linkEliminar' href data-indice='${index}'><i class='fa fa-trash'></i></a>
                                            </div>
                                        </td>
                                    </tr>`
                        }).join("");

                        $('#mdl_gastos #tableDetalleGasto tbody').html(filas_find);

                        const botonEditar = d.querySelectorAll('#mdl_gastos #linkEditar');
                        const botonEliminar = d.querySelectorAll('#mdl_gastos #linkEliminar');

                        botonEditar.forEach(boton => {
                            boton.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = boton.dataset.indice;

                                inputDetalleGastoId.value = records_find[indice].detalle_id;
                                $('#mdl_gastos #selectGasto').val(records_find[indice].gasto_id).trigger('change');
                                inputMonto.value = records_find[indice].detalle_monto;
                            });
                        });

                        botonEliminar.forEach(boton => {
                            boton.addEventListener('click', e => {
                                e.preventDefault();
                                let indice = boton.dataset.indice;

                                const fd = new FormData();
                                fd.append('afdg_id', records_find[indice].detalle_id);

                                ajax('post', `deleteDetalleGasto`, fd)
                                    .then((respuesta) => {
                                        if (respuesta.success) {
                                            swal({
                                                text: 'Gasto eliminado',
                                                timer: 3000,
                                                buttons: false
                                            });
                                            limpiarFormulario();
                                            listDetalleGastos();
                                            listarCoordinacionesGastos();
                                        } else {
                                            swal({
                                                icon: 'warning',
                                                text: 'No se pudo eliminar el gasto',
                                                timer: 3000,
                                                buttons: false
                                            });
                                        }
                                    })
                                    .catch(() => {
                                        console.log("Promesa no cumplida")
                                    })
                            });
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const crudDetalleGasto = () => {
            let apiRestMantenimiento = inputDetalleGastoId.value == 0 ? 'insertDetalleGasto' : 'updateDetalleGasto';

            let fecha = new Date();
            let dd = fecha.getDate() < 10 ? '0' + fecha.getDate() : fecha.getDate();
            let mm = (fecha.getMonth() + 1) < 10 ? '0' + (fecha.getMonth() + 1) : (fecha.getMonth() + 1) ;
            let yyyy = fecha.getFullYear();
            let fecha_actual = yyyy + '-' + mm + '-' + dd;

            const fd = new FormData();
            fd.append('afdg_id', inputDetalleGastoId.value);
            fd.append('cotizacion_id', inputCotizacionId.value);
            fd.append('coordinacion_id', inputCoordinacionId.value);
            fd.append('afg_id', selectGasto.value);
            fd.append('moneda_id', selectMoneda.value);
            fd.append('afdg_monto', inputMonto.value);
            if (inputDetalleGastoId.value != 0) {
                fd.append('info_update', fecha_actual);
            }

            ajax('post', `${apiRestMantenimiento}`, fd)
                .then((respuesta) => {
                    //console.log(JSON.stringify(respuesta));
                    if (respuesta.success) {
                        swal({
                            icon: 'success',
                            title: 'Guardado',
                            text: inputDetalleGastoId.value == 0 ? 'Se ha guardado correctamente ...' : 'Se ha actualizado correctamente ...',
                            timer: 3000,
                            buttons: false
                        });
                        limpiarFormulario();
                        listDetalleGastos();
                        listarCoordinacionesGastos();
                    } else {
                        swal({
                            icon: 'error',
                            title: 'Error',
                            text: inputDetalleGastoId.value == 0 ? 'No se pudo registrar ... Por favor comunicarse con el area de sistemas ...!' : 'No se pudo actualizar ... Por favor comunicarse con el area de sistemas ...!',
                            timer: 3000,
                            buttons: false
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        botonAñadir.addEventListener('click', e => {
            e.preventDefault();
            if (selectGasto.value == '') {
                swal({
                    text: 'Seleccioné gasto',
                    timer: 3000,
                    buttons: false
                });
            } else if (inputMonto.value == '0'){
                swal({
                    text: 'El monto debe ser mayor a 0',
                    timer: 3000,
                    buttons: false
                });
            } else {
                crudDetalleGasto();
            }
        });

        botonCancelar.addEventListener('click', e => {
            e.preventDefault();
            limpiarFormulario();
        });

        const limpiarFormulario = () => {
            inputDetalleGastoId.value = 0;
            $('#mdl_gastos #selectGasto').val('').trigger('change');
            inputMonto.value = 0;
        } 
    })
})(document);