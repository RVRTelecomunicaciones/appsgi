(function(d) {
    d.addEventListener("DOMContentLoaded", ()=>{
        const tbody = document.querySelector("tbody");
        const apiRestBase = 'tasaciones';
        const listaTasacionesLocalComercial = `showAllTasacionesLocalComercial`;
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {method:metodo}
            if(metodo!=="get" && datos){
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta =>respuesta.json())
        };

        const listTasacionesLocalComercial = () => {
            ajax('get', listaTasacionesLocalComercial)
                .then((respuesta) => {
                    const registros = respuesta;
                    const filas = registros.map((item, indice) => {
                        return `
                            <tr>
                                <td>${item.informe_id}</td>
                                <td>${item.solicitante}</td>
                                <td>${item.cliente}</td>
                                <td>${item.propietario}</td>
                                <td>${item.ubicacion}</td>
                                <td>${item.FECHA}</td>
                                <td>${item.zonificacion}</td>
                                <td>${item.piso_cantidad}</td>
                                <td>${item.vistalocal}</td>
                                <td>${item.terreno_area}</td>
                                <td>${item.terreno_valorunitario}</td>
                                <td>${item.edificacion_area}</td>
                                <td>${item.valor_comercial}</td>
                                <td>${item.valor_ocupada}</td>
                                <td>
                                <a id="btnRuta" href="#" class="btn btn-warning btnRuta" data-indice="${indice}">Ruta</a>
                                </td>
                            </tr>`
                    }).join("");
                    //$('#showdata').html(filas);
                    tbody.innerHTML = filas
                    const botonRuta= d.querySelectorAll(".btnRuta");

                    var table = $('#datatable-buttons').DataTable({
                        //dom: 'lrtip', //QUITA EL INPUT GENERAL DE BUSQUEDA DEL DATATABLE, NO FUNCIONA EXPORTAR SIN ESTA ACTIVADO
                        //dom: 'Bfrtip',
                        //lengthChange: true,
                        ordering: false, // EVITAR EL ORDEN DE LAS COLUMNAS
                        //order: [8,'desc'], // ORDENA POR LA COLUMNA QUE SE LE ASIGNA 8
                        //scrollX:true,
                        buttons: [
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                title: 'Reporte Coordinaciones',
                                exportOptions: {
                                    columns: ':visible:not(.not-export-col)'
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Exportar',
                                title: 'Reporte_AllemantPeritos',
                                exportOptions: {
                                    columns: ':visible:not(.not-export-col)'
                                }
                            },
                            {
                                extend: 'excelHtml5',
                                text: 'Excel',
                                title: 'Reporte_AllemantPeritos'
                            },
                            {extend: 'copy', text:'Copiar'}]
                        //{extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4'},
                        //{extend: 'copy', text:'Copiar'}],
                    });
                    table.columns([0]).every( function () {
                        var that = this;
                        $('#inputCoord').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([1]).every( function () {
                        var that = this;
                        $('#inputSolicitante').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([2]).every( function () {
                        var that = this;
                        $('#inputCliente').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([3]).every( function () {
                        var that = this;
                        $('#inputPropietario').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([4]).every( function () {
                        var that = this;
                        $('#inputUbicacion').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([5]).every( function () {
                        var that = this;
                        $('#inputFTasacion').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([6]).every( function () {
                        var that = this;
                        $('#inputZonificacion').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([7]).every( function () {
                        var that = this;
                        $('#inputNPisos').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([8]).every( function () {
                        var that = this;
                        $('#inputVistaLocal').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([9]).every( function () {
                        var that = this;
                        $('#inputTerrenoArea').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([10]).every( function () {
                        var that = this;
                        $('#inputTerrenoValor').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([11]).every( function () {
                        var that = this;
                        $('#inputEdificacion').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([12]).every( function () {
                        var that = this;
                        $('#inputValorC').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });
                    table.columns([13]).every( function () {
                        var that = this;
                        $('#inputValorO').keypress( function (e) {
                            var keycode = (e.keyCode ? e.keyCode : e.which);
                            if (keycode == '13') {
                                if ( that.search() !== this.value ) {
                                    that
                                        .search( this.value )
                                        .draw();
                                }
                            }
                        });
                    });

                    table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

                    botonRuta.forEach(boton => {
                        boton.addEventListener("click", function(e){
                            e.preventDefault();
                            const indice = this.dataset.indice;
                            const valorRuta = registros[indice].ruta_informe;
                            const aux = d.createElement("input");
                            aux.setAttribute("value", valorRuta);
                            d.body.appendChild(aux);
                            aux.select();
                            d.execCommand("copy");
                            d.body.removeChild(aux);
                            toastr.success('La ruta del Informe fue copiada copie y pegue en el servidor de archivos!', 'Ruta Copiada', {"showDuration": 500});
                        })
                    })
                })
                .catch(()=>{
                    console.log("Promesa no cumplida")
                })
        }
        listTasacionesLocalComercial();
    })
})(document);