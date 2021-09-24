(function(d) {
    d.addEventListener('DOMContentLoaded', () => {

        const apiRestLogin = `../usuario/logIn`;

        const ajax = (metodo, apiRest, datos) => {
            const opciones = {
                method: metodo
            }
            if (metodo !== "get" && datos) {
                opciones.body = datos
            }
            return fetch(apiRest, opciones).then(respuesta => respuesta.json())
        };

        const formIngreso = d.querySelector('#frmIngreso');

        formIngreso.addEventListener('submit', function (e) {
            e.preventDefault();
            const fd = new FormData(formIngreso)

            ajax('post', apiRestLogin, fd)
                .then((respuesta)=>{
                    //alert(respuesta.success);
                    if (respuesta.success) {
                        window.location = 'inicio';
                    }else{
                        swal({
                                icon: 'error',
                                title: 'Acceso Incorecto',
                                text: 'Usuario y/o Contraseña Incorrectos',
                                timer: 3000,
                                buttons: false
                            });
                    }
                })
                .catch(()=>{
                    console.log("Promesa no cumplida")
                })
        })
    })
})(document);