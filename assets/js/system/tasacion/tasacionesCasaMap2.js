var map;
var listaMarcadores = [];
var listaPlanos = [];

function initMap() {
    var mapBounds = new google.maps.LatLngBounds(
        new google.maps.LatLng(latitud_limite_1, longitud_limite_1),
        new google.maps.LatLng(latitud_limite_2, longitud_limite_2));

    for(var nivelPlano=0; nivelPlano<niveles.length; nivelPlano++){
        listaPlanos.push(new google.maps.ImageMapType({
            getTileUrl: function(coord, zoom) {
                var proj = map.getProjection();
                var z2 = Math.pow(2, zoom);
                var tileXSize = 256 / z2;
                var tileYSize = 256 / z2;
                var tileBounds = new google.maps.LatLngBounds(
                    proj.fromPointToLatLng(new google.maps.Point(coord.x * tileXSize, (coord.y + 1) * tileYSize)),
                    proj.fromPointToLatLng(new google.maps.Point((coord.x + 1) * tileXSize, coord.y * tileYSize))
                );
                var y = coord.y;
                var x = coord.x >= 0 ? coord.x : z2 + coord.x
                if (mapBounds.intersects(tileBounds) && (mapMinZoom <= zoom) && (zoom <= mapMaxZoom)){
                    return urlmapas+slugNivel+"-"+this.level+"/" + zoom + "/" + x + "/" + y + ".png";
                }
                else
                    return "http://www.maptiler.org/img/none.png";
            },
            tileSize: new google.maps.Size(256, 256),
            isPng: true,
            level: niveles[nivelPlano],
            opacity: 1.0
        }))
    }

    function insertarMarcadores(nivel){
        for(var m=0; m<listaMarcadores.length; m++){
            listaMarcadores[m].setMap(null)
        }

        listaMarcadores = []
        listaInfoWindow = []

        for(var ind=0; ind<marcadores.length; ind++){
            if(marcadores[ind].nivel==nivel) {
                var icono
                var coincidencia = false

                if(marcadores[ind].latitud == latitudTienda && marcadores[ind].longitud == longitudTienda) {
                    icono = rutaImagenes + "icono_azul.png"
                    coincidencia = true
                } else {
                    icono = rutaImagenes + "icono_naranja.png"
                }

                var infowindow = new google.maps.InfoWindow();
                listaInfoWindow.push(infowindow)
                var descripcion = marcadores[ind].descripcion;
                if(descripcion==""){
                    descripcion = "Ven, visÃ­tanos y descubre nuestras mejores ofertas y promociones";
                }
                var marcador = new google.maps.Marker({
                    position: new google.maps.LatLng(marcadores[ind].latitud, marcadores[ind].longitud),
                    draggable: false,
                    map: map,
                    icon: icono,
                    content: '<div id="iw-container">' +
                    '<div class="iw-title">'+marcadores[ind].titulo+'</div>' +
                    '<div class="iw-content">' +
                    '<img src="'+marcadores[ind].logo+'" alt="'+marcadores[ind].titulo+'" height="81" width="110">'+
                    '<p style="height:81px">'+descripcion+'</p>'+
                    '</div>'
                    // content: '<h2 class="tituloInfo">'+marcadores[ind].titulo+'</h2>'
                })

                google.maps.event.addListener(infowindow, 'domready', function() {

                    // Reference to the DIV which receives the contents of the infowindow using jQuery
                    var iwOuter = jQuery('.gm-style-iw');

                    /* The DIV we want to change is above the .gm-style-iw DIV.
                     * So, we use jQuery and create a iwBackground variable,
                     * and took advantage of the existing reference to .gm-style-iw for the previous DIV with .prev().
                     */
                    var iwBackground = iwOuter.prev();

                    // Remove the background shadow DIV
                    iwBackground.children(':nth-child(2)').css({'display' : 'none'});

                    // Remove the white background DIV
                    iwBackground.children(':nth-child(4)').css({'display' : 'none'});

                    // iwOuter.parent().parent().css({left: '115px'});

                    var iwCloseBtn = iwOuter.next();

                    iwCloseBtn.css({
                        width:"27px",
                        height:"27px",
                        fontSize: "10px !important",
                        color: "#fff !important",
                        opacity: '1', // by default the close button has an opacity of 0.7
                        right: '60px', top: '25px', // button repositioning
                        border: '7px solid #b35400', // increasing button border and new color
                        'border-radius': '13px', // circular effect
                        'box-shadow': '0 0 5px #3990B9' // 3D effect to highlight the button
                    });

                    iwCloseBtn.html("X");

                    iwCloseBtn.mouseout(function(){
                        $(this).css({opacity: '1'});
                    });

                });

                if(coincidencia){
                    marcador.setAnimation(google.maps.Animation.BOUNCE)

                    google.maps.event.addListener(marcador,'click',
                        (
                            function(marcador,infowindow){
                                return function() {
                                    for(var i=0; i<listaInfoWindow.length; i++){
                                        listaInfoWindow[i].close()
                                    }
                                    infowindow.setContent(marcador.content);
                                    infowindow.open(map,marcador);
                                };
                            }
                        )(marcador,infowindow)
                    );

                    infowindow.setContent(marcador.content);

                    if(esMovil=="") {
                        infowindow.open(map,marcador);
                    } else {
                        map.setCenter(new google.maps.LatLng(marcadores[ind].latitud, marcadores[ind].longitud))
                    }


                    if(esMovil=="") {
                        google.maps.event.addListener(marcador,'mouseover',
                            (
                                function(marcador,infowindow){
                                    return function() {
                                        for(var i=0; i<listaInfoWindow.length; i++){
                                            listaInfoWindow[i].close()
                                        }
                                        infowindow.setContent(marcador.content);
                                        infowindow.open(map,marcador);
                                    };
                                }
                            )(marcador,infowindow)
                        );

                        google.maps.event.addListener(marcador,'mouseout',
                            (
                                function(marcador,infowindow){
                                    return function() {
                                        infowindow.close()
                                    };
                                }
                            )(marcador,infowindow)
                        );
                    }



                } else {
                    marcador.setAnimation(google.maps.Animation.DROP)

                    if(esMovil=="") {
                        google.maps.event.addListener(marcador,'mouseover',
                            (
                                function(marcador,infowindow){
                                    return function() {
                                        for(var i=0; i<listaInfoWindow.length; i++){
                                            listaInfoWindow[i].close()
                                        }
                                        infowindow.setContent(marcador.content);
                                        infowindow.open(map,marcador);
                                    };
                                }
                            )(marcador,infowindow)
                        );

                        google.maps.event.addListener(marcador,'mouseout',
                            (
                                function(marcador,infowindow){
                                    return function() {
                                        infowindow.close()
                                    };
                                }
                            )(marcador,infowindow)
                        );
                    }


                    google.maps.event.addListener(marcador,'click',
                        (
                            function(marcador,infowindow,permalink){
                                return function() {
                                    document.location.href=permalink+"#mapa"
                                };
                            }
                        )(marcador,infowindow,marcadores[ind].permalink)
                    );

                }
                listaMarcadores.push(marcador)
            }
        }
    }


    var opts = {
        tilt:0,
        streetViewControl: false,
        center: new google.maps.LatLng(centroLatitud, centroLongitud),
        mapTypeId: google.maps.MapTypeId.NORMAL,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.NORMAL]
        },
        zoom: zoomPlano,
    };
    map = new google.maps.Map(document.getElementById("map"), opts);
    if(map.overlayMapTypes)
        map.overlayMapTypes.push(null)
    for(nivelPlano=0; nivelPlano<listaPlanos.length; nivelPlano++) {
        map.overlayMapTypes.setAt(nivelPlano+1, listaPlanos[nivelPlano]);
        map.overlayMapTypes.getAt(nivelPlano+1).setOpacity(0);
    }
    // map.overlayMapTypes.getAt(1).setOpacity(1);
    map.setOptions({styles: config.estilosMapa})



    google.maps.event.addListenerOnce(map, 'idle', function() {
        google.maps.event.trigger(map, 'resize');
    });

    var zonaControles = document.getElementById('zonaControles')
    map.controls[google.maps.ControlPosition.RIGHT_TOP].push(zonaControles)

    for(var i=0; i<niveles.length; i++){
        var etiqueta

        switch(niveles[i]){
            case 1:
                etiqueta = "1";
                break;
            case 2:
                etiqueta = "2";
                break;
            case 3:
                etiqueta = "3";
                break;
            case 4:
                etiqueta = "S";
                break;

        }
        zonaControles.innerHTML += "<a href='#' class='nivel' data-nivel='"+niveles[i]+"'>"+etiqueta+"</a>"
    }

    var btnNiveles = document.querySelectorAll("a.nivel")

    for(var i=0; i<niveles.length; i++){
        btnNiveles[i].addEventListener("click", function(e){
            e.preventDefault()
            var nivel = parseInt(this.getAttribute("data-nivel"))

            for(var j=0; j<niveles.length; j++) {
                if(niveles[j] == nivel) {
                    map.overlayMapTypes.getAt(j+1).setOpacity(1);
                } else {
                    map.overlayMapTypes.getAt(j+1).setOpacity(0);
                }
            }

            insertarMarcadores(nivel);

            btnNiveles.forEach(function(item){
                item.classList.remove("activo")
            })

            this.classList.add("activo")
        })
    }

    for(var i=0; i<niveles.length; i++){
        var nivel = parseInt(btnNiveles[i].getAttribute("data-nivel"))
        if(nivel == nivelTienda) {
            insertarMarcadores(nivel);
            btnNiveles[i].classList.add("activo")
            map.overlayMapTypes.getAt(i+1).setOpacity(1);
        }
    }

    /*    var btnNiveles = document.querySelectorAll("a.nivel")
        btnNiveles[0].addEventListener("click", function(e){
            e.preventDefault()
            map.overlayMapTypes.getAt(1).setOpacity(1);
            map.overlayMapTypes.getAt(2).setOpacity(0);

            btnNiveles.forEach(function(item){
                item.classList.remove("activo")
            })

            this.classList.add("activo")
        })
        btnNiveles[1].addEventListener("click", function(e){
            e.preventDefault()
            map.overlayMapTypes.getAt(1).setOpacity(0);
            map.overlayMapTypes.getAt(2).setOpacity(1);

            btnNiveles.forEach(function(item){
                item.classList.remove("activo")
            })

            this.classList.add("activo")
        })
    */


}