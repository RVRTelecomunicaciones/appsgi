var map = null;
var markers = [];

//USANADO SOLO UN ARREGLO PARA TODO EL MAPA
var arregloUbicacions = [];
var markerCluster;

// USANDO VARIOS ARREGLOS
var arregloTerreno = [];
var arregloDepartamento = [];
var arregloLocalComercial = [];
var arregloLocalIndustrial = [];
var arregloOficinas = [];
var arregloCasa = [];

var markerClusterTerreno;
var markerClusterDepartamento;
var markerClusterLocalComercial;
var markerClusterLocalIndustrial;
var markerClusterOficinas;
var markerClusterCasa;

const mydate = new Date();
const year = mydate.getFullYear();

const listaTasacionesDepartamento = `showAllTasacionesDepartamento`;
const listaTasacionesTerreno = `showAllTasacionesTerreno`;
const listaTasacionesGeneral = `tasacionesTodas`;
const image = "../assets/images/small/terreno2.svg";
const image2 = "../assets/images/small/departamento.svg";
const image3 = "../assets/images/small/industry2.svg";
const image4 = "../assets/images/small/industry.svg";
const image5 = "../assets/images/small/oficinastest.svg";
const image6 = "../assets/images/small/home.svg";

//FUNCIN PARA LLAMAR A LOS API-REST
const ajax = (metodo, apiRest, datos) => {
	const opciones = { method: metodo };
	if (metodo !== "get" && datos) {
		opciones.body = datos;
	}
	return fetch(apiRest, opciones).then(respuesta => respuesta.json());
};

const tasacioneFiltradas = () => {

}

const listTasacionesGeneral = () => {

	ajax("get", listaTasacionesGeneral)
		.then(respuesta => {
			const registros = respuesta;

			registros.map((item, indice) => {

				switch (item.categoria) {
					case "1":
						agregarMarcadoTerreno(item, indice);
						break;
					case "2":
						agregarMarcadoCasa(item, indice);

						break;
					case "3":
						agregarMarcadoDepartamento(item, indice);
						break;
					case "4":
						let f = 0;
						agregarMarcadoOficina(item, indice);
						break;
					case "5":
						agregarMarcadoLocalcomercial(item, indice);
						break;
					case "6":
						agregarMarcadoLocalIndustrial(item, indice);
						break;
					default:
						break;
				}
			});
			agruparMarcadores(arregloUbicacions);
			agruparMarcadoTerreno(arregloTerreno);
			agruparMarcadoDepartamento(arregloDepartamento);
			agruparMarcadoLocalComercial(arregloLocalComercial);
			agruparMarcadoLocalIndustrial(arregloLocalIndustrial);
			agruparMarcadoOficina(arregloOficinas);
			agruparMarcadoCasa(arregloCasa);
		})
		.catch(() => {
			console.log("Promesa no cumplida");
		});
};


function agregarMarcador(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image
	});

	marker.addListener("click", function () {
		console.log("LLEGO")
	});
	arregloUbicacions.push(marker);
}

const agruparMarcadores = markersD => {

	markerCluster = new MarkerClusterer(map, markersD, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};


/* ARREGLO CON VARIOS MARCADOS */
function agregarMarcadoTerreno(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image,
		mydato: item.tasacion_fecha,
	});



	marker.addListener("click", function () {
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloTerreno.push(marker);
}

function agregarMarcadoDepartamento(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image2
	});

	marker.addListener("click", function () {
		const ruta = "#default > div > div > div";
		const selectRuta = document.querySelector(ruta);
		selectRuta.innerHTML = `<h6 class="modal-title" id="myModalLabel1">Tasaciones Realizadas: <h4 style='margin-bottom: 0px;'>${mydate.getFullYear(item.tasacion_fecha)}</h4></h6>`;
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		document.getElementById("departamento_valorocupado").value = numeral(
			item.valor_ocupada
		).format("$0,0.00");
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloDepartamento.push(marker);
}
function agregarMarcadoLocalcomercial(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image3,
	});

	marker.addListener("click", function () {
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloLocalComercial.push(marker);
}
function agregarMarcadoLocalIndustrial(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image4
	});

	marker.addListener("click", function () {
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloLocalIndustrial.push(marker);
}
function agregarMarcadoOficina(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image5
	});

	marker.addListener("click", function () {
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloOficinas.push(marker);
}
function agregarMarcadoCasa(item, indice) {
	const lat = parseFloat(item.mapa_latitud);
	const lng = parseFloat(item.mapa_longitud);
	const latLng = new google.maps.LatLng(lat, lng);

	const marker = new google.maps.Marker({
		position: latLng,
		map: map,
		category: item.categoria,
		icon: image6
	});

	marker.addListener("click", function () {
		document.getElementById("solicitante").value = item.solicitante_nombre;
		document.getElementById("cliente").value = item.cliente_nombre;
		document.getElementById("ubicacion").value = item.ubicacion;
		document.getElementById("terreno_area").value = numeral(
			item.terreno_area
		).format("0,0.00");
		document.getElementById("terreno_valorunitario").value = numeral(
			item.terreno_valorunitario
		).format("$0,0.00");
		/* 	document.getElementById("terreno_valorunitario").value = numeral(
				item.terreno_valorunitario
			).format("$0,0.00"); */
		document.getElementById("valor_comercial").value = numeral(
			item.valor_comercial
		).format("$0,0.00");
		document.getElementById("ruta_informe").value = item.ruta_informe;
		$("#default").modal("show");
	});
	arregloCasa.push(marker);
}
/* ---------- */

const agruparMarcadoTerreno = markersTerreno => {

	markerClusterTerreno = new MarkerClusterer(map, markersTerreno, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};
const agruparMarcadoDepartamento = markersDepartamento => {

	markerClusterDepartamento = new MarkerClusterer(map, markersDepartamento, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};
const agruparMarcadoLocalComercial = markersLocalcomercial => {

	markerClusterLocalComercial = new MarkerClusterer(map, markersLocalcomercial, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};
const agruparMarcadoLocalIndustrial = markersLocalindustrial => {

	markerClusterLocalIndustrial = new MarkerClusterer(map, markersLocalindustrial, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};
const agruparMarcadoOficina = markersOficina => {

	markerClusterOficinas = new MarkerClusterer(map, markersOficina, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};
const agruparMarcadoCasa = markersCasa => {

	markerClusterCasa = new MarkerClusterer(map, markersCasa, {
		imagePath:
			"https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m"
	});
};


function refrescarMapTerreno() {

	if (markerClusterTerreno instanceof MarkerClusterer) {
		markerClusterTerreno.clearMarkers()
	}
	listTasacionesGeneral()
}


function nomostrarMarkers(param) {

	switch (param) {
		case 'check_terreno':
			for (let i in arregloTerreno) {
				arregloTerreno[i].setMap(null);
			}
			markerClusterTerreno.clearMarkers();
			break;
		case 'check_departamento':
			for (let i in arregloDepartamento) {
				arregloDepartamento[i].setMap(null);
			}
			markerClusterDepartamento.clearMarkers();
			break;
		case 'check_localcomercial':
			for (let i in arregloLocalComercial) {
				arregloLocalComercial[i].setMap(null);
			}
			markerClusterLocalComercial.clearMarkers();
			break;
		case 'check_localindustrial':
			for (let i in arregloLocalIndustrial) {
				arregloLocalIndustrial[i].setMap(null);
			}
			markerClusterLocalIndustrial.clearMarkers();
			break;
		case 'check_oficina':
			for (let i in arregloOficinas) {
				arregloOficinas[i].setMap(null);
			}
			markerClusterOficinas.clearMarkers();
			break;
		case 'check_casa':
			for (let i in arregloCasa) {
				arregloCasa[i].setMap(null);
			}
			markerClusterCasa.clearMarkers();
			break;
		default:
			break;
	}

}

function filterByAnio() {
	const filteredArreglo = arregloTerreno.filter(x => {
		let time = new Date(x.mydato).getFullYear();
		return (time === 2017)
	})
	console.log(filteredArreglo)

	for (let i in filteredArreglo) {
		filteredArreglo[i].setMap(map);
	}
	markerClusterTerreno.addMarkers(filteredArreglo);
}

function mostrarMarkers(param) {
	switch (param) {
		case 'check_terreno':
			//console.log(arregloTerreno)

			//filterByAnio();
			for (let i in arregloTerreno) {
				arregloTerreno[i].setMap(map);
			}
			markerClusterTerreno.addMarkers(arregloTerreno);
			break;

		case 'check_departamento':
			for (let i in arregloDepartamento) {
				arregloDepartamento[i].setMap(map);
			}
			markerClusterDepartamento.addMarkers(arregloDepartamento);
			break;
		case 'check_localcomercial':
			for (let i in arregloLocalComercial) {
				arregloLocalComercial[i].setMap(map);
			}
			markerClusterLocalComercial.addMarkers(arregloLocalComercial);
			break;
		case 'check_localindustrial':
			for (let i in arregloLocalIndustrial) {
				arregloLocalIndustrial[i].setMap(map);
			}
			markerClusterLocalIndustrial.addMarkers(arregloLocalIndustrial);
			break;
		case 'check_oficina':
			for (let i in arregloOficinas) {
				arregloOficinas[i].setMap(map);
			}
			markerClusterOficinas.addMarkers(arregloOficinas);
			break;
		case 'check_casa':
			for (let i in arregloCasa) {
				arregloCasa[i].setMap(map);
			}
			markerClusterCasa.addMarkers(arregloCasa);
			break;
		default:
			break;
	}
}

function initMap() {
	const position = { lat: -12.043333, lng: -77.028333 };
	map = new google.maps.Map(document.getElementById("map"), {
		center: position,
		zoom: 6
	});

	const card = document.getElementById('pac-card');
	const input = document.getElementById('pac-input');
	var options = {
		componentRestrictions: { country: 'pe' }
	};
	//CARD EN EL MAPA GOOGLE
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);
	//BUSQUEDA EN EL MAPA
	const autocomplete = new google.maps.places.Autocomplete(input, options);
	const geocoder = new google.maps.Geocoder();
	autocomplete.bindTo('bounds', map);

	autocomplete.setFields(
		['address_components', 'geometry', 'icon', 'name']);

	const botonRuta = document.getElementById("copyRuta");
	botonRuta.addEventListener("click", function (e) {
		e.preventDefault();
		const valorRuta = document.getElementById("ruta_informe");
		valorRuta.value;
		valorRuta.select();
		document.execCommand("copy");
		/* toastr.success(
			"La ruta del Informe fue copiada copie y pegue en el servidor de archivos!",
			"Ruta Copiada",
			{ showDuration: 500 } <
		); */
		$("#default").modal("hide");
	});

	refrescarMapTerreno();

	const checkboxAll = document.querySelectorAll(".tipoTasacion");
	checkboxAll.forEach((checkbox, i) => {
		checkbox.onclick = () => {
			switch (checkbox.id) {
				case 'check_terreno':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				case 'check_departamento':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				case 'check_localcomercial':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				case 'check_localindustrial':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				case 'check_oficina':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				case 'check_casa':
					if (checkbox.checked) {
						mostrarMarkers(checkbox.id);
					}
					else {
						nomostrarMarkers(checkbox.id);
					}
					break;
				default:
					break;
			}
		}
	});

	//AGREGA COMENTARIOS AL MARKER QUE SE ESTABLECIO EN LA DIRECCI�N BUSCADA
	const infowindow = new google.maps.InfoWindow();
	const infowindowContent = document.getElementById('infowindow-content');
	infowindow.setContent(infowindowContent);
	//
	//const mylat = document.getElementById('inputLatitud');
	//const mylog = document.getElementById('inputLongitud');


	var marker = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29)
	});

	autocomplete.addListener('place_changed', function () {
		//document.getElementById('inputLatitud').value = '';
		//document.getElementById('inputLongitud').value = '';
		infowindow.close();
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			//window.alert("No details available for input: '" + place.name + "'");
			window.alert("Seleccionar dirección de la lista desplegable...!");
			return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(17);  // Why 17? Because it looks good.
		}
		marker.setPosition(place.geometry.location);
		marker.setVisible(true);

		var address = '';
		if (place.address_components) {
			address = [
				(place.address_components[0] && place.address_components[0].short_name || ''),
				(place.address_components[1] && place.address_components[1].short_name || ''),
				(place.address_components[2] && place.address_components[2].short_name || '')
			].join(' ');
		}

		infowindowContent.children['place-icon'].src = place.icon;
		infowindowContent.children['place-name'].textContent = place.name;
		infowindowContent.children['place-address'].textContent = address;
		infowindow.open(map, marker);

	//const mylat = document.getElementById('inputLatitud').value = place.geometry.location.lat().toFixed(6);
		//const mylog = document.getElementById('inputLongitud').value = place.geometry.location.lng().toFixed(6);

	})
	var marker;


	google.maps.event.addListener(marker, 'dragend', function () { });

} // FINAL INIT


// MAPA 



/* const llamarMapa = () => {
	initMap();
}
window.addEventListener('load', llamarMapa()) */


const googleMapsScript = document.createElement('script');
googleMapsScript.type = "text/javascript"
googleMapsScript.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBrkygBTW5BHfNxdAxxErprHzpYbqhYeRo&region=PE&libraries=places&callback=initMap';
googleMapsScript.async = true;
googleMapsScript.defer = true
document.head.appendChild(googleMapsScript);


