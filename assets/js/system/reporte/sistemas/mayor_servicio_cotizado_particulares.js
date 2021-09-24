(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });
        
        const apiRestBase = '../../servicio';
        const apiRestListar = `${apiRestBase}/mayorServicioCotizado`;
        //const apiRestImpresion = `../../reporte/coordinacion/generadas/impresion`;

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== "get" && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const inputAnio = d.getElementById('inputAnio');
        const selectMes = d.getElementById('selectMes');
        const tblDatos = d.getElementById('tbl_mayor_servicio_cotizado').getElementsByTagName('tbody')[0];

        const listMayorServicioCotizadoParticular = (filters) => {
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    const registros = respuesta.mayor_servicio_cotizado_records;
                    let total = 0; let otros = 0;
                    let nombre = [];
                    let cantidad = [];
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            total += Number(item.persona_cantidad);

                            if (index >= 19) {
                                otros += Number(item.persona_cantidad);
                            } else {
                                nombre.push(item.persona_nombre);
                                cantidad.push(item.persona_cantidad);
                                return `<tr>
                                            <td>${index + 1 }</td>
                                            <td><div align='left'>${item.persona_nombre.toUpperCase()}</div></td>
                                            <td class='alert ${ index == 0 ? 'bg-success' : index == 1 ? 'bg-blue' : index == 2 ? 'bg-info' : 'alert-secondary'}'>${item.persona_cantidad}</td>
                                        </tr>`
                            }
                        }).join("");
                        
                        //$('#tbl_mayor_servicio_cotizado tbody').inn(filas);
                        tblDatos.innerHTML = filas;
                        tblDatos.insertAdjacentHTML('beforeend',    `<tr>
                                                                        <td>-</td>
                                                                        <td><div align='left'>OTROS</div></td>
                                                                        <td>${otros}</td>
                                                                    </tr>`);
                        $('#tbl_mayor_servicio_cotizado tfoot').html('<tr><td colspan="2">TOTAL</td><td>'+total+'</td></tr>');

                        var ctx = $("#column-chart");

                        window.grafica = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: nombre,
                                datasets: [{
                                    label: "Servicio más cotizado",
                                    data: cantidad,
                                    backgroundColor: [
                                        '#16D39A',
                                        '#2196F3',
                                        '#2DCEE3'
                                    ],
                                    borderColor: "transparent"
                                }]
                            },
                            options: {
                                elements: {
                                    rectangle: {
                                        borderWidth: 2,
                                        borderColor: 'rgb(0, 255, 0)',
                                        borderSkipped: 'bottom'
                                    }
                                },
                                responsive: true,
                                maintainAspectRatio: false,
                                responsiveAnimationDuration:500,
                                legend: {
                                    //position: 'top',
                                    display: false
                                },
                                scales: {
                                    xAxes: [{
                                        display: false,
                                        gridLines: {
                                            color: "#f3f3f3",
                                            drawTicks: false,
                                        },
                                        //scaleLabel: {
                                            //display: true,
                                        //}
                                    }],
                                    yAxes:[{
                                        display: true,
                                        gridLines: {
                                            color: "#f3f3f3",
                                            drawTicks: true,
                                        },
                                        //scaleLabel: {
                                            //display: true,
                                        //},
                                        ticks: {
                                            beginAtZero: true
                                        },
                                    }]
                                },
                                title: {
                                    display: true,
                                    text: 'CLIENTE CON MAS SERVICIOS REALIZADOS / PARTICULAR'
                                }
                            }
                        });
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        const filters = () => {
            const fd = new FormData()
            fd.append('accion', 'filtros')
            fd.append('anio', inputAnio.value)
            fd.append('mes', selectMes.value)
            fd.append('tipo', 'particular')
            return fd;
        }

        listMayorServicioCotizadoParticular(filters());

        $('#selectMes').on('change', function () {
            window.grafica.clear();
            window.grafica.destroy();
            listMayorServicioCotizadoParticular(filters());
        });

        inputAnio.addEventListener('change', e => {
            window.grafica.clear();
            window.grafica.destroy();
            listMayorServicioCotizadoParticular(filters());
        });
    })
})(document);