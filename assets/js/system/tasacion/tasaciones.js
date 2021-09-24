(function(d) {
    d.addEventListener("DOMContentLoaded", ()=>{
        const tbody = d.querySelector("tbody");
        const apiRestBase = 'tasaciones';
        const apiRestListar = `${apiRestBase}/showAllTasaciones`;
        const listaTasacionesCasa = `${apiRestBase}/showAllTasaciones`;
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {method:metodo}
            if(metodo!=="get" && datos){
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta =>respuesta.json())
        };


    const listarTasacionRegistrar = () => {

        ajax("get", apiRestListar)
            .then((respuesta) => {
            const registros = respuesta;
            const filas = registros.map( (item, indice) => {
                return `
                        <tr>
                            <td>${item.COORDINACION}</td>
                            <td>${item.FECHA}</td>
                            <td>${item.SOLICITANTE}</td>
                            <td>${item.CLIENTE}</td>
                            <td>${item.PERITO}</td>
                            <td>${item.CONTROL_CALIDAD}</td>
                            <td>
                                <a id="btnRegistrar" href="#" class="btn btn-warning btnRegistrar" data-indice="${indice}">Registrar Tasacion</a>
                            </td>
                        </tr>
                    `
            }).join("");
                tbody.innerHTML = filas;
                const botonRegistrar= d.querySelectorAll(".btnRegistrar");

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
                            title: 'Reporte Tasaciones',
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

                table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

                botonRegistrar.forEach(boton => {
                    boton.addEventListener("click", function(e){
                        e.preventDefault();
                        const indice = this.dataset.indice;
                        sessionStorage.setItem("MyCoordinacion", registros[indice].COORDINACION);
                        sessionStorage.setItem("MySolicitante", registros[indice].SOLICITANTE);
                        sessionStorage.setItem("MyCliente", registros[indice].CLIENTE);
                        $('#myModal').on("shown.bs.modal", function() {
                        });
                        $("#myModal").modal('show');


                    })
                })
            })
    .catch(()=>{
            console.log("Promesa no cumplida")
    })
    }
        listarTasacionRegistrar();

    })
})(document);