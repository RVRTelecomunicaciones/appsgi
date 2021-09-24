function initAutocomplete() {
	const position = { lat: -12.088686, lng: -76.973383 };

	const id = document.getElementById("inputInspeccionId").value;

	const listLatLogInspec = `listaLatLogInspeccion/${id}`;
	let valorLat;
	let valorLog;

	//console.log(listLatLogInspec);

	map = new google.maps.Map(document.getElementById("map"), {
		center: position,
		zoom: 13
	});
	const card = document.getElementById('pac-card');
	const input = document.getElementById('pac-input');
	//CARD EN EL MAPA GOOGLE
	map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

	//BUSQUEDA EN EL MAPA
	const autocomplete = new google.maps.places.Autocomplete(input);
	const geocoder = new google.maps.Geocoder();
	autocomplete.bindTo('bounds', map);

	autocomplete.setFields(
		['address_components', 'geometry', 'icon', 'name']);

	//AGREGA COMENTARIOS AL MARKER QUE SE ESTABLECIO EN LA DIRECCIÓN BUSCADA
	const infowindow = new google.maps.InfoWindow();
	const infowindowContent = document.getElementById('infowindow-content');
	infowindow.setContent(infowindowContent);
	//

	//AGREGA MARCADOR AL MAPA
	var marker = new google.maps.Marker({
		map: map,
		anchorPoint: new google.maps.Point(0, -29)
	});
	const mylat = document.getElementById('inputLatitud');
	const mylog = document.getElementById('inputLongitud');

	autocomplete.addListener('place_changed', function () {
		document.getElementById('inputLatitud').value = '';
		document.getElementById('inputLongitud').value = ''; 
		infowindow.close();
		marker.setVisible(false);
		var place = autocomplete.getPlace();
		if (!place.geometry) {
			// User entered the name of a Place that was not suggested and
			// pressed the Enter key, or the Place Details request failed.
			//window.alert("No details available for input: '" + place.name + "'");
			window.alert("Seleccionar dato de la lista desplegable...!");
			return;
		}

		// If the place has a geometry, then present it on a map.
		if (place.geometry.viewport) {
			map.fitBounds(place.geometry.viewport);
		} else {
			map.setCenter(place.geometry.location);
			map.setZoom(15);  // Why 17? Because it looks good.
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

		const mylat = document.getElementById('inputLatitud').value = place.geometry.location.lat().toFixed(6);
		const mylog = document.getElementById('inputLongitud').value = place.geometry.location.lng().toFixed(6);
	});
	var marker;

	function placeMarker(location) {
		if (marker) {
			marker.setPosition(location);
		} else {
			marker = new google.maps.Marker({
				position: location,
				map: map,

			});

		}
		geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var address = results[0]['formatted_address'];
                input.value = address;
            }
		});
		const mylat = document.getElementById('inputLatitud').value = location.lat().toFixed(6);
		const mylog = document.getElementById('inputLongitud').value = location.lng().toFixed(6);
	}

	google.maps.event.addListener(map, 'click', function (event) {
		infowindow.close();
		placeMarker(event.latLng);
	});

	google.maps.event.addListener(marker, 'dragend', function () {});



} // FINAL INIT
/* google.maps.event.addDomListener(window, 'load', initAutocomplete);
 */