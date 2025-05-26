/**
 * Muestra el mapa con marcadores
 * @param  {string} element  id del tag html
 * @param  {object} myLatlng  cordenadas actuales. ej.: {lat: 40.416647, lng: -3.703840};
 * @param  {array} locations localizaciones array de objectos.
 * ej.: [ {ubicacion: {lat: 40.416647, lng: -3.703840}, id: 0, icon: 'http://example.com/img.png'}, {...}, ...]
 * @param  {function} callbackClick llamada a función cuando click en un marker
 * @param  {function} callbackMouseover llamada a función cuando mouseover en un marker
 * @param  {function} callbackMouseout llamada a función cuando mouseout en un marker
 * @return {void}
 */
function MapInitLocations(element, myLatlng, locations, callbackClick, callbackMouseover, callbackMouseout) {

    // create empty LatLngBounds object
    var bounds = new google.maps.LatLngBounds();

    myLatlng = myLatlng || false;
    if (!myLatlng.lat || !myLatlng.lng) {
        myLatlng = {
            lat: 40.416647,
            lng: -3.703840
        }; // madrid
    }

    var map = new google.maps.Map(document.getElementById(element), {
        center: new google.maps.LatLng(myLatlng),
        // mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: true,
        zoomControlOptions: {
            position: google.maps.ControlPosition.TOP_LEFT
        },
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        scrollwheel: false,
        scrollwheel: false,
        zoom: 4.5,
        maxZoom: 15,
        minZoom: 3,
        styles: [{
                'elementType': 'labels',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative',
                'elementType': 'geometry',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative.land_parcel',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative.neighborhood',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'landscape',
                'stylers': [{
                    'color': '#b3d7d0'
                }]
            },
            {
                'featureType': 'poi',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'road',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'road',
                'elementType': 'labels.icon',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'transit',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'water',
                'stylers': [{
                    'color': '#ffffff'
                }]
            }
        ]
    });

    if ('object' == typeof locations) {
        locations = $.map(locations, function (value, index) {
            return [value];
        });
    }

    if (!locations.length) {
        return;
    }

    var markerIcon = {
        path: 'M-20,0a20,20 0 1,0 40,0a20,20 0 1,0 -40,0',
        fillColor: '#e86457',
        fillOpacity: 1,
        anchor: new google.maps.Point(0, 0),
        strokeWeight: 0,
        scale: .3
    }

    var marker, i;
    var markers = [];
    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            icon: markerIcon,
            draggable: false,
            map: map,
            position: new google.maps.LatLng({
                lat: locations[i].latitude,
                lng: locations[i].longitude
            }),
            title: locations[i].name
        });
        markers.push(marker);

        // extend the bounds to include each marker's position
        bounds.extend(marker.position);
        // map.fitBounds(bounds);

        // if (locations[i].icon) {
        //   var image = {
        //     url: locations[i].icon,
        //     scaledSize: new google.maps.Size(32, 32),
        //   };
        //   // marker.setIcon(image);
        // }

        google.maps.event.addListener(marker, 'mouseover', (function (marker, i) {
            return function () {
                marker.setIcon($.extend(markerIcon, {
                    fillColor: '#3c3c3b'
                }));
            }
        })(marker, i));
        google.maps.event.addListener(marker, 'mouseout', (function (marker, i) {
            return function () {
                marker.setIcon($.extend(markerIcon, {
                    fillColor: '#e86457'
                }));

                if ('function' == typeof callbackMouseout) {
                    return callbackMouseout();
                }
            }
        })(marker, i));

        // var infoWindow = new google.maps.InfoWindow();
        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                if ('function' == typeof callbackClick) {
                    var point = fromLatLngToPoint(marker.getPosition(), map);
                    return callbackClick(locations[i], point);
                }
                //     var html = 'test';
                //     infoWindow.setContent(html);
                //     infoWindow.open(map, marker);
            }
        })(marker, i));
    }

    // now fit the map to the newly inclusive bounds
    map.fitBounds(bounds);

    // var markerCluster = new MarkerClusterer(map, Object.keys(markers).map(i => markers[i]), {
    // var markerCluster = new MarkerClusterer(map, markers, {
    //     // imagePath: 'https://cdn.rawgit.com/googlemaps/js-marker-clusterer/gh-pages/images/m'
    //     styles: [{
    //         url: '/images/marker-cluster.png',
    //         height: 20,
    //         width: 20,
    //         fontFamily: 'Montserrat',
    //         textColor: '#fff',
    //         // anchor: [0, 0],
    //         // textSize: 0.001
    //     }, {
    //         url: '/images/marker-cluster.png',
    //         height: 20,
    //         width: 20,
    //         fontFamily: 'Montserrat',
    //         textColor: '#fff',
    //         // anchor: [0, 0],
    //         // textSize: 0.001
    //     }, {
    //         url: '/images/marker-cluster.png',
    //         height: 20,
    //         width: 20,
    //         fontFamily: 'Montserrat',
    //         textColor: '#fff',
    //         // anchor: [0, 0],
    //         // textSize: 0.001
    //     }]
    // });

    // restore the zoom level after the map is done scaling
    var listener = google.maps.event.addListener(map, 'tilesloaded', function () {
        google.maps.event.removeListener(listener);
        // map.setZoom(map.getZoom() + .4);
        // map.setZoom(map.getZoom() + 1);
        // map.setZoom(4.5);
    });
}

function fromLatLngToPoint(latLng, map) {
    var topRight = map.getProjection().fromLatLngToPoint(map.getBounds().getNorthEast());
    var bottomLeft = map.getProjection().fromLatLngToPoint(map.getBounds().getSouthWest());
    var scale = Math.pow(2, map.getZoom());
    var worldPoint = map.getProjection().fromLatLngToPoint(latLng);
    return new google.maps.Point((worldPoint.x - bottomLeft.x) * scale, (worldPoint.y - topRight.y) * scale);
}

function MapInit(myLatlng, icon) {

    myLatlng = myLatlng || false;
    if (!myLatlng.lat || !myLatlng.lng) {
        myLatlng = {
            lat: 40.416647,
            lng: -3.703840
        }; // madrid
    }

    var map = new google.maps.Map(document.getElementById('map'), {
        center: myLatlng,
        // mapTypeId: google.maps.MapTypeId.ROADMAP,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: false,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false,
        scrollwheel: false,
        zoom: 3.5,
        // disableDefaultUI: true,
        styles: [{
                'elementType': 'labels',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative',
                'elementType': 'geometry',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative.land_parcel',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'administrative.neighborhood',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'landscape',
                'stylers': [{
                    'color': '#b3d7d0'
                }]
            },
            {
                'featureType': 'poi',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'road',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'road',
                'elementType': 'labels.icon',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'transit',
                'stylers': [{
                    'visibility': 'off'
                }]
            },
            {
                'featureType': 'water',
                'stylers': [{
                    'color': '#ffffff'
                }]
            }
        ]
    });

    var infowindow = new google.maps.InfoWindow();
    var marker = MapCreateMarker(map, myLatlng, icon);
    MapSetInputPosition(myLatlng);
    MapShowAddress(myLatlng);
    MapUpdateInputDir(myLatlng);

    MapAutocomplete(map, marker, infowindow);

    map.addListener('click', function (event) {
        infowindow.close();
        marker.setPosition(event.latLng);
        MapSetInputPosition(event.latLng);
    });

    // Try HTML5 geolocation
    if (false) {
        return;
    }

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            var myLatlng = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };

            marker.setPosition(myLatlng);
            MapSetInputPosition(myLatlng);
            map.setCenter(myLatlng);
            MapShowAddress(myLatlng);
            MapUpdateInputDir(myLatlng);
        }, MapErrors);
    } else {
        // Browser doesn't support Geolocation
        alert('¡Error! Este navegador no soporta la Geolocalización.');
    }
}

function MapShowAddress(myLatlng) {

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        location: new google.maps.LatLng(myLatlng)
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                $('#direccion').addClass('valid');
                document.getElementById('direccion').value = results[0].formatted_address;
                // MapUpdateInputDir(results[0].address_components);
            }
        }
    });
}

function MapCreateMarker(map, myLatlng, icon) {

    if (!map || !myLatlng) {
        return false;
    }

    var marker = new google.maps.Marker({
        anchorPoint: new google.maps.Point(0, -29),
        animation: google.maps.Animation.DROP,
        draggable: true,
        map: map,
        position: myLatlng,
    });

    marker.addListener('dragend', function (event) {
        var myLatlng = {
            lat: this.getPosition().lat(),
            long: this.getPosition().lng()
        };

        MapSetInputPosition(event.latLng);
    });

    if (icon) {
        var image = {
            url: icon,
            scaledSize: new google.maps.Size(42, 42),
        };
        marker.setIcon(image);
    }

    return marker;
}

function MapUpdateInputDir(myLatlng) {

    if (!$('#cp').length || !$('#ciudad').length || !$('#provincia').length) {
        return false;
    }

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({
        location: new google.maps.LatLng(myLatlng)
    }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0] && results[0].address_components) {

                var cp = '';
                var ciudad = '';
                var provincia = '';

                var i = 0;
                address = results[0].address_components;
                for (i = 0; i < address.length; i++) {
                    var j = 0;
                    for (j = 0; j < address[i].types.length; j++) {
                        if (address[i].types[j] == 'postal_code') {
                            cp = address[i].short_name;
                        }
                        if (address[i].types[j] == 'locality') {
                            ciudad = address[i].short_name;
                        }
                        if (address[i].types[j] == 'administrative_area_level_2') {
                            provincia = address[i].long_name;
                        }
                    }
                }

                $('#cp').val(cp);
                $('#ciudad').val(ciudad);
                $('#provincia').val(provincia);
            }
        }
    });
}

function MapSetInputPosition(myLatlng) {

    $('#latitud').val(myLatlng.lat);
    $('#longitud').val(myLatlng.lng);
    MapUpdateInputDir(myLatlng);
}

function MapAutocomplete(map, marker, infowindow) {

    var options = {
        componentRestrictions: {
            country: 'es'
        }
    };

    var input = document.getElementById('direccion');
    var autocomplete = new google.maps.places.Autocomplete(input, options);
    autocomplete.bindTo('bounds', map);

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // window.alert("Autocomplete's returned place contains no geometry");
            return;
        }

        // If the place has a geometry, then present it on a map.
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17); // Why 17? Because it looks good.
        }

        marker.setPosition(place.geometry.location);
        MapSetInputPosition(place.geometry.location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[1] && place.address_components[1].short_name + ', ' || ''),
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[2] && '(' + place.address_components[2].short_name + ')' || '')
            ].join(' ');
        }
        infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
        infowindow.open(map, marker);
    });
}

function MapGetLocation(callback) {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (objPosition) {
            var lon = objPosition.coords.longitude;
            var lat = objPosition.coords.latitude;

            var params = {
                latlng: objPosition.coords.latitude + ',' + objPosition.coords.longitude,
                key: MINAKI_GOOGLE_MAPS_KEY
            };

            $.ajax({
                url: 'https://maps.googleapis.com/maps/api/geocode/json',
                data: params,
                success: callback
            });

        }, MapErrors, {
            // maximumAge: 75000,
            timeout: 15000
        });
    } else {
        alert('¡Error! Este navegador no soporta la Geolocalización.');
    }
}

function MapErrors(error) {

    switch (error.code) {
        case error.PERMISSION_DENIED:
            alert('Denegada la peticion de Geolocalización en el navegador.');
            break;
        case error.POSITION_UNAVAILABLE:
            alert('La información de la localización no esta disponible.');
            break;
        case error.TIMEOUT:
            alert('El tiempo de petición ha expirado.');
            break;
        case error.UNKNOWN_ERROR:
            alert('Ha ocurrido un error desconocido.');
            break;
    }
}
