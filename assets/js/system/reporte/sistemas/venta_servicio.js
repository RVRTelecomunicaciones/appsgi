(function(d) {
    d.addEventListener("DOMContentLoaded", () => {
        $('.select2-diacritics').select2({
        	placeholder: 'Seleccione',
        	theme: 'classic',
        	allowClear: true
        });
        
        const apiRestBase = '../../servicio';
        const apiRestListar = `${apiRestBase}/resumenVentasPorServicios`;
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

        const resumenVentaPorServicio = (filters) => {
            ajax('post', apiRestListar, filters)
                .then((respuesta) => {
                    const registros = respuesta.ventas_servicio;
                    let total_soles = 0;
                    let total_dolares = 0;
                    let nombre_soles = []; let nombre_dolares = [];
                    let importe_soles = []; let importe_dolares = [];
                    if (registros != false) {
                        const filas = registros.map((item, index) => {
                            total_soles += Number(item.soles);
                            total_dolares += Number(item.dolares);
                            nombre_soles.push(item.servicio_nombre);
                            importe_soles.push(item.soles);
                            nombre_dolares.push(item.servicio_nombre);
                            importe_dolares.push(item.dolares);

                            return `<tr>
                                        <td>${index + 1 }</td>
                                        <td><div align='left'>${item.servicio_nombre.toUpperCase()}</div></td>
                                        <td><div align='right'>${numeral(item.soles).format('0,0,0.00')}</div></td>
                                        <td><div align='right'>${numeral(item.dolares).format('0,0,0.00')}</div></td>
                                    </tr>`
                        }).join("");
                        //bg-blue bg-info
                        $('#tbl_ventas_por_servicio tbody').html(filas);
                        $('#tbl_ventas_por_servicio tfoot').html('<tr><td colspan="2">TOTAL</td><td><div align="right"><strong>'+numeral(total_soles).format('0,0,0.00')+'</strong></div></td><td><div align="right"><strong>'+numeral(total_dolares).format('0,0,0.00')+'</strong></div></td></tr>');

                        var ctx = $("#column-chart");
                        ctx.html('');
                        //Chart.defaults.global.defaultFontFamily = "Lato";
                        //Chart.defaults.global.defaultFontSize = 6;

                        window.grafica = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: nombre_soles,
                                datasets: [{
                                    label: "SOLES",
                                    data: importe_soles,
                                    backgroundColor: "#16D39A",
                                    hoverBackgroundColor: "rgba(22,211,154,.9)",
                                    borderColor: "transparent"
                                }, {
                                    label: "DOLARES",
                                    data: importe_dolares,
                                    backgroundColor: "#F98E76",
                                    hoverBackgroundColor: "rgba(249,142,118,.9)",
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
                                    position: 'top',
                                    //display: false
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
                                    display: false,
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

        resumenVentaPorServicio(filters());

        $('#selectMes').on('change', function () {
            window.grafica.clear();
            window.grafica.destroy();
            resumenVentaPorServicio(filters());
        });

        inputAnio.addEventListener('change', e => {
            window.grafica.clear();
            window.grafica.destroy();
            resumenVentaPorServicio(filters());
        });
    })
})(document);