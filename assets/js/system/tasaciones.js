(function(d) {
    d.addEventListener("DOMContentLoaded", ()=>{
        //const tbody = document.querySelector("tbody");
        const apiRestBase = 'tasaciones';
        const apiRestListar = `${apiRestBase}/showAllTasaciones`;
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {method:metodo}
            if(metodo!=="get" && datos){
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta =>respuesta.json())
        };
    const listar = () => {
        // promesa crea un objeto y este tiene metodos
        ajax("get", apiRestListar)
            .then((respuesta) => {
            const registros = respuesta;
            const filas = registros.map( (item, indice) => {
                return `
                        <tr>
                            <td>${item.COORDINACION}</td>
                            <td>${item.FECHA}</td>
                            <td>${item.PERITO}</td>
                            <td>${item.CONTROL_CALIDAD}</td>
                            <td>${item.SOLICITANTE}</td>
                            <td>${item.CLIENTE}</td>
                            <td>
                                <a id="btnRegistrar" href="#" class="btn btn-warning btnRegistrar" data-indice="${indice}">Registrar Tasacion</a>
                            </td>
                        </tr>
                    `
            }).join("");
                //tbody.innerHTML = filas
                $('#showdata').html(filas);
                //$('#datatable').DataTable();
                var table = $('#datatable-buttons').DataTable({
                    lengthChange: true,
                    buttons: [{
                        extend: 'colvis',
                        text: 'Show/Hide'
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
                        {extend: 'pdfHtml5', orientation: 'landscape', pageSize: 'A4'},
                        {extend: 'copy', text:'Copiar'}]
                });
                table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

                const botonRegistrar= d.querySelectorAll(".btnRegistrar");
                botonRegistrar.forEach(boton => {
                    boton.addEventListener("click", function(e){
                        e.preventDefault();
                        const indice = this.dataset.indice;
                        sessionStorage.setItem("MyCoordinacion", registros[indice].COORDINACION);
                        sessionStorage.setItem("MySolicitante", registros[indice].SOLICITANTE);
                        sessionStorage.setItem("MyCliente", registros[indice].CLIENTE);
                        sessionStorage.setItem("MyCliente", registros[indice].CLIENTE);
                        $('#myModal').on("shown.bs.modal", function() {
                        });
                        $("#myModal").modal('show');

                        /*VALIDO PARA USAR PARA UN FORMULARIO
                        const indice = this.dataset.indice;
                        console.log(registros[indice].COORDINACION);
                        console.log(registros[indice].SOLICITANTE);
                        console.log(registros[indice].CLIENTE);*/

                    })
                })
            })
    .catch(()=>{
            console.log("Promesa no cumplida")
    })
    }
    listar();

    })
})(document);