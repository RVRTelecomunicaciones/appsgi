(function(d) {
    d.addEventListener("DOMContentLoaded", ()=>{
        //const tbody = document.querySelector("tbody");
        const tbody1 = document.getElementById("showdata1");
        const tbody2 = document.getElementById("showdata2");
        const apiRestBase = 'tasaciones';
        const listaTasacionesCasa = 'showAllTasacionesCasa';
        const listaTasacionesDepartamento = `showAllTasacionesDepartamento`;
        const listaTasacionesLocalComercial = 'showAllTasacionesLocalComercial';
        const listaTasacionesLocalIndustrial = 'showAllTasacionesLocalIndustrial';
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {method:metodo}
            if(metodo!=="get" && datos){
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta =>respuesta.json())
        };

        const listTasacionesCasa = () => {
            ajax('get', listaTasacionesCasa)
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
                                <td>${item.terreno_area}</td>
                                <td>${item.terreno_valorunitario}</td>
                                <td>${item.edificacion_area}</td>
                                <td>${item.valor_comercial}</td>
                                <td>
                                <a id="btnRuta" href="#" class="btn btn-warning btnRuta" data-indice="${indice}">Ruta</a>
                                </td>
                            </tr>`
                    }).join("");
                    //$('#showdata').html(filas);
                    tbody1.innerHTML = filas
                    const botonRuta= d.querySelectorAll(".btnRuta");

                    var table = $('#datable1').DataTable({
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
                            {extend: 'copy', text:'Copiar'}
                        ]
                        
                    });
                    table.columns([0]).every( function () {
                        var that = this;
                        $('#input01Coord').keypress( function (e) {
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
                    table.columns([9]).every( function () {
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
                    table.columns([10]).every( function () {
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
                    table.columns([11]).every( function () {
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
        /*const mostrarDatosPorTabs = () => {
            const tabsActive = d.querySelector(".active")
            const idTabs2 = d.getElementById("link-tab1")
            const idTabs1 = d.getElementById("active-tab1")

            if(tabsActive.innerText == 'Departamento' & tabsActive !== null){
                listTasacionesDepartamento();
            }
            else if(tabsActive.innerText == 'Casa' & tabsActive !== null){
                listTasacionesCasa();
            }

          
        };*/
        
        listTasacionesCasa();
        
         
       

        //mostrarDatosPorTabs();
        const tab = d.getElementById('myTab')
        tab.addEventListener('click',muestraConsola);

        function muestraConsola(evt){           
            const enlaceActivo = evt.target;

            /*if(enlaceActivo.innerText=='Departamento'){
                listTasacionesDepartamento();                
            }
            else if(enlaceActivo.innerText == 'Casa'){
                listTasacionesCasa();                
            }
            else if(enlaceActivo.innerText == 'Local Comercial'){
                listaTasacionesLocalComercial
            }
            else if(enlaceActivo.innerText == 'Local Industrial'){
                listaTasacionesLocalComercial
            } */           
            console.log('Estoy en el tabActivo ',enlaceActivo.innerText)
        }
        //listTasacionesCasa();
        const listTasacionesDepartamento= () => {
            ajax('get', listaTasacionesDepartamento)
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
                                <td>${item.depatipo}</td>
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
                    tbody2.innerHTML = filas
                    const botonRuta= d.querySelectorAll(".btnRuta");

                    var table2 = $('#datable2').DataTable({
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
                    table2.columns([0]).every( function () {
                        var that = this;
                        $('#input02Coord').keypress( function (e) {
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
                    table2.columns([1]).every( function () {
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
                    table2.columns([2]).every( function () {
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
                    table2.columns([3]).every( function () {
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
                    table2.columns([4]).every( function () {
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
                    table2.columns([5]).every( function () {
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
                    table2.columns([6]).every( function () {
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
                    table2.columns([7]).every( function () {
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
                    table2.columns([8]).every( function () {
                        var that = this;
                        $('#inputDTipo').keypress( function (e) {
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
                    table2.columns([9]).every( function () {
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
                    table2.columns([10]).every( function () {
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
                    table2.columns([11]).every( function () {
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
                    table2.columns([12]).every( function () {
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
                    table2.columns([13]).every( function () {
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

                    table2.buttons().container()
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
        //listTasacionesDepartamento();
        listTasacionesDepartamento();
        
    })
})(document);