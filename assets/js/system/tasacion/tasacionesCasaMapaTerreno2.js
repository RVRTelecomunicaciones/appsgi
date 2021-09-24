var map = null;
var markers =[];
const image = "../assets/images/small/terreno2.svg";
const image2 = "../assets/images/small/departamento.svg";
const image3 = "../assets/images/small/industry2.svg";
const image4 = "../assets/images/small/industry.svg";
const image5 = "../assets/images/small/oficinastest.svg";
const image6 = "../assets/images/small/home.svg";

function initMap() {
    var position = { lat: -12.043333,lng: -77.028333 };
    map = new google.maps.Map(document.getElementById('map'), {
        center: position,
        zoom: 14,
        mapTypeControl: true,
        mapTypeControlOptions: {
            style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
            position: google.maps.ControlPosition.TOP_RIGHT
        }
    });
    loadData();
    loadData2();
    loadData3();
    loadData4();
    loadData5();
    loadData6();

}
// Load the markers data from API and display them on the map.
function loadData() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesTerreno',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMap(item);
                //}
            });
        }
    });
}
function loadData2() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesCasa',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMapCasa(item);
                //}
            });
        }
    });
}
function addToMapCasa(item) {
    var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image6,
        map: map
});
    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}
function Copiar(){
    var copyText= document.getElementById('ruta_informe');
    copyText.select();
    console.log(copyText)
    document.execCommand("copy");
}
function loadData3() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesDepartamento',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMapDepartamento(item);
                //}
            });
        }
    });
}
function loadData4() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesLocalIndustrial',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMapLocalIndustrial(item);
                //}
            });
        }
    });
}
function loadData5() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesLocalComercial',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMapLocalComercial(item);
                //}
            });
        }
    });
}
function loadData6() {
    //$.getJSON('http://stream.dfwstormforce.com/test/api.php', function(responsedata) {
    $.ajax({
        type: 'ajax',
        url: 'showAllTasacionesOficina',
        async: true,
        dataType: 'json',
        success: function (responsedata) {
            $.each(responsedata, function (key, item) {
                item.lat = parseFloat(item.mapa_latitud);
                item.lng = parseFloat(item.mapa_longitud);
                //item.estado = parseBoolean(item.estado);
                //item.gpsStatus = parseBoolean(item.gpsStatus);
                //item.streamStatus = parseBoolean(item.streamStatus);
                // if (shouldAddToMap(item)) {
                addToMapOficina(item);
                //}
            });
        }
    });
}
function addToMapOficina(item) {

    var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image5,
        // icon: 'include/images/small/oficinastest.svg',
        map: map
});

    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}
function addToMapLocalComercial(item) {

    var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image3,
        map: map
});

    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}
function addToMapLocalIndustrial(item) {
    var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image4,
        map: map
});
    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}
// Add marker to the map.
function addToMapDepartamento(item) {
       var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image2,
        map: map
});
    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}

const copyRuta = () =>{
    const botonRuta= document.getElementById("copyRuta");
    botonRuta.addEventListener("click", function(e){
        e.preventDefault();
        const copyText= document.getElementById('ruta_informe').value;
        console.log(copyText)
        document.execCommand("copy");
    })
}
function copyRutaa(){

    marker.addListener('click', function() {
        document.getElementById('solicitante').value = secretMessage
        $('#default').modal('show')
    });
}


function addToMap(item) {
    var marker = new google.maps.Marker({
        position: { lat: item.lat, lng: item.lng },
        title: item.solicitante + ', ' + item.FECHA,
        //icon: getIcon(item.streamStatus),
        icon: image,
        // icon: 'assets/images/small/terreno2.svg',
        map: map
});
    marker.addListener('click', function() {
        document.getElementById('solicitante').value = item.solicitante
        document.getElementById('cliente').value = item.cliente
        document.getElementById('ubicacion').value = item.ubicacion
        document.getElementById('terreno_area').value = numeral(item.terreno_area).format('0,0.00');
        document.getElementById('terreno_valorunitario').value = numeral(item.terreno_valorunitario).format('$0,0.00');
        document.getElementById('valor_comercial').value = numeral(item.valor_comercial).format('$0,0.00');
        document.getElementById('ruta_informe').value = item.ruta_informe
        $('#default').modal('show')
    });
    //attachSecretMessage(marker,secretMessage)
    // miEvento(marker,secretMessage);
    markers.push(marker);
}
function attachSecretMessage(marker, secretMessage) {
    var infowindow = new google.maps.InfoWindow({
        content: secretMessage
    });

    //marker.addListener('click', function() {
    //$('#default').modal('show')
    /// });

    /* marker.addListener('click', function() {
         infowindow.open(marker.get('map'), marker);
     });
      marker.addListener(map,'click', function() {
          infowindow.close();
     });*/

    marker.addListener('mouseover', function() {
        infowindow.open(marker.get('map'), marker);
    });
    marker.addListener('mouseout', function() {
        infowindow.close();
    });
}

// Clear all markers from the map.
function clearMarkers() {
    $.each(markers, function (key, marker) {
        marker.setMap(null);
    });
    markers = [];
}
// Get the appropiate image url for marker icon.
function getIcon(streamStatus) {
    if (! streamStatus) {
        return 'http://stream.dfwstormforce.com/images/icons/streamOffline.png';
    }
    return 'http://stream.dfwstormforce.com/images/icons/streamOnline.png';
}
// Should we add the marker to the map?
function shouldAddToMap(item) {
    if ($.type(item.lat) === 'null' || $.type(item.lng) === 'null') {
        return false;
    }

    return item.gpsStatus === true;
}
// Parse coordinate number like 'W96.38188' to appropiate decimal value: -96.38188
// return null if it's invalid.
function parseCoordinateNumber(val) {
    if ($.type(val) === 'number') {
        return parseFloat(val);
    }

    if ($.type('val') !== 'string') {
        return null;
    }

    val = val.trim();

    if (val.length === 0) {
        return null;
    }

    var directionPart = val.substr(0, 1).toUpperCase();
    var valuePart = parseFloat(val.substring(1));

    if ($.inArray(directionPart, ['N', 'E']) >= 0) {
        return isNaN(valuePart) ? null : valuePart;
    }

    if ($.inArray(directionPart, ['S', 'W']) >= 0) {
        return isNaN(valuePart) ? null : -valuePart;
    }

    val = parseFloat(val);

    return isNaN(val) ? null : val;
}
// Parse boolean value.
function parseBoolean(val) {
    if ($.type(val) === 'boolean') {
        return val;
    }

    if (val === 1) {
        return true;
    }

    if (val === 0) {
        return false;
    }

    if ($.type('val') !== 'string') {
        return null;
    }

    val = val.trim().toUpperCase();

    if (val === 'TRUE') {
        return true;
    }

    if (val === 'FALSE') {
        return false;
    }

    return null;
}