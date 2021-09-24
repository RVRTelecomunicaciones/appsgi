(function(d) {
    d.addEventListener("DOMContentLoaded", () => {

        const apiRestBase = 'revistas';

        const apiRestAgregar = `${apiRestBase}/informacionAgregar`;
        const apiRestListar = `${apiRestBase}/informacionReporte`;
        const headers = 'content-type: application/json';
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo,
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
            if (metodo !== "get" && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        var table;

        const listar = () => {
            // promesa crea un objeto y este tiene metodos
            ajax("get", apiRestListar)
                .then((respuesta) => {
                    const registros = respuesta;
                    const filas = registros.map((item, indice) => {
                        return `
                                <tr>
                                    <td>${indice+1}</td>
                                    <td>${item.inf_titulo}</td>
                                    <td>${item.inf_contenido}</td>
                                    <td>${item.inf_fecha_publicacion}</td>
                                    <td><a href="assets/pdfs/${item.inf_ruta_archivo}.pdf" target="_blank"><img src="assets/images/pdf.png" alt="${item.inf_titulo}" width="30"/></a></td>
                                </tr>
                                `
                    }).join("");
                    //tbody.innerHTML = filas
                    $('#showdata').html(filas);
                    // DataTable

                    table = $('#datatable-buttons').DataTable({
                        lengthChange: true,
                        ordering: false,
                        buttons: [/*{
                                extend: 'colvis',
                                text: 'Show/Hide'
                            },*/
                            /*{
                                extend: 'colvisGroup',
                                text: 'Operaciones',
                                hide: [ 5, 6,10,15,16]
                            },*/
                            {
                                extend: 'print',
                                text: 'Imprimir',
                                title: 'Reporte Coordinaciones',
                                exportOptions: {
                                    columns: ':visible:not(.not-export-col)'
                                }
                            },
                           /* {
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
                            {
                                extend: 'copy',
                                text: 'Copiar'
                            }*/
                        ]
                    });

                    table.columns([1]).every(function() {
                        var that = this;
                        $('#inputTitulo').on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    table.columns([2]).every(function() {
                        var that = this;
                        $('#inputContenido').on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    table.columns([3]).every(function() {
                        var that = this;
                        $('#dtpFecha').on('keyup change', function() {
                            if (that.search() !== this.value) {
                                that
                                    .search(this.value)
                                    .draw();
                            }
                        });
                    });

                    table.buttons().container()
                        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

                    $('#datatable-buttons_filter').hide();
                    ////////
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }
        listar();

        const botonNuevo = d.querySelector("#btn_nuevo");
        const formRegistro = d.querySelector("#frm_registro");
        var request = new XMLHttpRequest();

        botonNuevo.addEventListener('click', e =>{
            formRegistro.reset();
            $('#primary').modal({
                'show': true
            });
        });

        const insertar = () => {
            const fd = new FormData(formRegistro)

            $.ajax({
                url: apiRestAgregar,
                type: 'POST',
                data: fd,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(response) {
                console.log(response);
                if (response > 0) {
                    swal({
                        icon: "success",
                        title: "Guardado",
                        text: "Se ha guardado correctamente",
                        timer: 2000,
                        buttons: false
                    });
                    //swal('Registro Exitoso!', 'success');
                    //.then((value) => {
                    //  $('#btn_close').click();
                    //});
                    $('#btn_close').click();
                    listar();
                }else{
                    swal('Error!', 'No se pudo grabar', 'error');
                }
            })
            .fail(function() {
                console.log('fallo');
                /*swal('Error!', 'You clicked the button!', 'error');*/
            });
        }
        
        formRegistro.addEventListener('submit', e =>{
            e.preventDefault();
            insertar();
        });

        const inputFile = d.querySelector("#archivo");

        inputFile.addEventListener('change', e =>{
            var sizeByte = inputFile.files[0].size;
            var siezekiloByte = parseInt(sizeByte / 1024);

            if (siezekiloByte >= 2048) {
                inputFile.value = "";
                swal({
                        icon: "info",
                        title: "Mensaje",
                        text: "El tamaño del archivo supera al limite permitido 2MB",
                        timer: 2000,
                        buttons: false
                    });
            }
        });

    })
})(document);