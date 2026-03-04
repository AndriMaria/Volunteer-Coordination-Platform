<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
    <script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js'></script>
    <style>
        #map {
            height: 750px;
        }
        #coordinates {
            margin-top: 10px;
            font-size: 16px;
        }
    </style>
</head>
<body>
<div id="map"></div>
<div id="coordinates">Latitude: <span id="lat">38.2766684</span>, Longitude: <span id="lon">21.7514926</span></div>
<br>
<table border='1' id="mytable">
    <tr>
        <td>
            <div id="upd2">
                Category Name: <input type="text" id="cat_name">
                <button id='btn' onclick="get_updated_location_cat()">Search</button>
            </div>
        </td>
    </tr>
</table>
<br>
<script>
    var map = L.map('map').setView([38.2766684, 21.7514926], 14);

    // Προσθήκη των κυκλικών περιοχών
    L.circle([38.312757, 21.781289], {
        color: 'red',
        fillColor: '#f0f5f3',
        fillOpacity: 0.5,
        radius: 200,
    }).addTo(map).bindPopup("aithma 1.");

    L.circle([38.290757, 21.770289], {
        color: 'green',
        fillColor: '#f0f5f3',
        fillOpacity: 0.5,
        radius: 200,
    }).addTo(map).bindPopup("aithma 2.");

    // Δημιουργία του εικονιδίου του marker
    var oxhma = L.icon({
        iconUrl: 'resquer.jpg',
        iconSize: [40, 40],
        iconAnchor: [22, 94],
        popupAnchor: [-3, -76]
    });

    // Ανάκτηση θέσης marker από localStorage
    var savedPosition = localStorage.getItem('markerPosition');
    var latLng = savedPosition ? JSON.parse(savedPosition) : { lat: 38.2766684, lon: 21.7514926 };

    var markerOxhmatos = L.marker([latLng.lat, latLng.lon], { icon: oxhma, draggable: true }).addTo(map).bindPopup("OXHMA DIASVSHS");

    // Δημιουργία του εικονιδίου της βάσης
    var base = L.icon({
        iconUrl: 'base.jpg',
        iconSize: [50, 50],
        iconAnchor: [22, 94],
        popupAnchor: [-3, -76]
    });
    L.marker([38.289182, 21.795689], { icon: base }).addTo(map).bindPopup("BASE");

    // Δημιουργία άλλων markers
    var marker1 = L.marker([38.295182, 21.770689]).addTo(map);
    marker1.bindPopup("Prosfora");

    var marker2 = L.marker([38.293182, 21.775689]).addTo(map);
    marker2.bindPopup("Prosfora");

    var latlngs = [L.circle([38.312757, 21.781289]).getLatLng(), L.circle([38.290757, 21.770289]).getLatLng()];
    var polyline = L.polyline(latlngs, { color: 'red' }).addTo(map);
    map.fitBounds(polyline.getBounds());

    function onMapClick(e) {
        L.popup()
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    markerOxhmatos.on('dragend', function(e) {
        var lat = e.target.getLatLng().lat;
        var lon = e.target.getLatLng().lng;

        // Ενημέρωση των συντεταγμένων στη σελίδα
        document.getElementById('lat').textContent = lat.toFixed(6);
        document.getElementById('lon').textContent = lon.toFixed(6);

        // Αποθήκευση νέων συντεταγμένων στο localStorage
        localStorage.setItem('markerPosition', JSON.stringify({ lat: lat, lon: lon }));

        console.log("Νέες συντεταγμένες: Latitude = " + lat + ", Longitude = " + lon);

        // Κλήση της συνάρτησης για να ενημερωθεί η κατάσταση των κουμπιών
        updateButtonState();
    });
</script>
</body>
</html>
