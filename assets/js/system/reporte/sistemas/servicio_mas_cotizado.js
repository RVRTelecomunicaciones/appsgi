(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });
        
        const apiRestBase = '../../servicio';
        const apiRestListar = `${apiRestBase}/servicioMasCotizado`;
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

        const listServicioMasCotizado = (filters) => {
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    const registros = respuesta.servicio_mas_cotizado_records;
                    let total = 0;
                    let nombre = [];
                    let cantidad = [];
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            total += Number(item.servicio_cantidad);
                            nombre.push(item.servicio_nombre);
                            cantidad.push(item.servicio_cantidad);

                            return `<tr>
                                        <td>${index + 1 }</td>
                                        <td><div align='left'>${item.servicio_nombre.toUpperCase()}</div></td>
                                        <td class='alert ${ index == 0 ? 'bg-success' : index == 1 ? 'bg-blue' : index == 2 ? 'bg-info' : 'alert-secondary'}'>${item.servicio_cantidad}</td>
                                    </tr>`
                        }).join("");
                        //bg-blue bg-info
                        $('#tbl_servicio_mas_cotizado tbody').html(filas);
                        $('#tbl_servicio_mas_cotizado tfoot').html('<tr><td colspan="2">TOTAL</td><td>'+total+'</td></tr>');

                        var ctx = $("#column-chart");
                        ctx.html('');
                        //Chart.defaults.global.defaultFontFamily = "Lato";
                        //Chart.defaults.global.defaultFontSize = 6;

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
                                    text: 'SERVICIO MÁS COTIZADO'
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
            return fd;
        }

        listServicioMasCotizado(filters());

        $('#selectMes').on('change', function () {
            window.grafica.clear();
            window.grafica.destroy();
            listServicioMasCotizado(filters());
        });

        inputAnio.addEventListener('change', e => {
            window.grafica.clear();
            window.grafica.destroy();
            listServicioMasCotizado(filters());
        });
    })
})(document);