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

        const apiRestListar = './area/searchArea';

        listArea = (filtersArea) => {
            // promesa crea un objeto y este tiene metodos
            ajax('post', apiRestListar, filtersArea)
                .then((respuesta) => {
                    //console.log(respuesta.tasacion_records);
                    const registrosCombo = respuesta.area_all;
                    if (registrosCombo != false) {
                        const filasCombo = registrosCombo.map((item, index) => {
                            if (index == 0)
                                return `<option value=""></option><option value="${item.area_id}">${item.area_descripcion}</option>`
                            else
                                return `<option value="${item.area_id}">${item.area_descripcion}</option>`
                        }).join("");

                        $('#selectArea').html(filasCombo);
                    }
                })
                .catch(() => {
                    console.log("Promesa no cumplida")
                })
        }

        filtersArea = (quantity, link) => {
            const fd = new FormData()
            fd.append('accion', 'full')
            //fd.append('area_descripcion', '')
            fd.append('num_page', link)
            fd.append('quantity', quantity)
            return fd;
        }
    })
})(document);