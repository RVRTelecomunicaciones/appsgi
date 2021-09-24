(function(d) {
    d.addEventListener('DOMContentLoaded', () => {
        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== 'get' && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const apiRestListar = './rol/searchRol';

        listRol = (filtersRol) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filtersRol)
                .then((respuesta) => {
                    //console.log(respuesta.tasacion_records);
                    const registrosCombo = respuesta.rol_all;
                    if (registrosCombo != false) {
                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.rol_id}">${item.rol_descripcion}</option>`
                            else
                                return `<option value="${item.rol_id}">${item.rol_descripcion.toUpperCase()}</option>`
                        }).join("");

                        $('#selectRol').html(filasCombo);
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        filtersRol = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'full')
            //fd.append('rol_descripcion', '')
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }
    })
})(document);