(function(d) {
    d.addEventListener("DOMContentLoaded", ()=> {
        const coordinacion = sessionStorage.getItem("MyCoordinacion");
        const solicitante = sessionStorage.getItem("MySolicitante");
        const cliente = sessionStorage.getItem("MyCliente");
        /*Insertar datos de la SessionStorage a los Inputs*/
            d.getElementById('coordinacion').value = coordinacion;
        d.getElementById("solicitante").value = solicitante;
        d.getElementById("cliente").value = cliente;
        sessionStorage.clear();

        const mydepartamento = d.getElementById("mydepartamento");
        const myprovincia = d.getElementById("myprovincia");
        const mydistrito = d.getElementById("mydistrito");

        let idSelected;
        let idSelected2;

        const apiRestBase = 'tasaciones';

        const apiRestListarDepartamento = `showAllDepartamento`;

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {method: metodo}
            if (metodo !== "get" && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const listarDepartmento = () => {
            ajax("get", apiRestListarDepartamento)
                .then((respuesta) => {
                    const registros = respuesta;
                    const html = registros.map((item) => {
                        return `<option value=${item.departamento_id}>${item.nombre}</option>`
                    }).join("");
                    mydepartamento.innerHTML = html
                    idSelected = d.getElementById("mydepartamento").value;
                    listarProvincia();
                    mydepartamento.addEventListener('change',() =>{
                        idSelected = d.getElementById("mydepartamento").value;
                        listarProvincia();
                    })
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                });

            const listarProvincia = () => {
                ajax("get",`showAllProvincia/${idSelected}`)
                    .then((respuesta) => {
                        const registros2 = respuesta;
                        const html2 = registros2.map((item) => {
                            return `<option value=${item.provincia_id}>${item.nombre}</option>`
                        }).join("");
                        myprovincia.innerHTML = html2
                        idSelected2 = d.getElementById("myprovincia").value;
                        listarDistrito();
                        myprovincia.addEventListener('change',() =>{
                            idSelected2 = d.getElementById("myprovincia").value;
                            listarDistrito();
                        })
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    });
            }
            const listarDistrito = () => {
                ajax("get",`showAllDistrito/${idSelected2}`)
                    .then((respuesta) => {
                        const registros2 = respuesta;
                        const html2 = registros2.map((item) => {
                            return `<option value=${item.distrito_id}>${item.nombre}</option>`
                        }).join("");
                        mydistrito.innerHTML = html2
                    })
                    .catch(() => {
                        console.log("Promesa no cumplida")
                    });
            }
        }
        listarDepartmento();
    })


})(document);