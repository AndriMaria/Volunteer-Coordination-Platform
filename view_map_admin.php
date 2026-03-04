<?php
session_start();

// Ακύρωση cache
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/leaflet@1.3.3/dist/leaflet.css">
    <script src='https://unpkg.com/leaflet@1.3.3/dist/leaflet.js
'></script>
    <div id="map"></div>

    <style>
        #map {
            height: 750px
        }
    </style>
</head>
<body>
<div id="map"></div>


<br>

<table border='1' id="mytable">

    <tr>



        <td>

            <div id ="upd2">

                Category Name: <input type = "text" id ="cat_name">

                <button id='btn' onclick="get_updated_location_cat()">Search </button>



        </td>

        </div>

    </tr>

</table>

</br>



<script>
    var map = L.map('map').setView([38.312757, 21.781289], 14);

    var circle1 = L.circle([38.312757, 21.781289], {
        color: 'red',
        fillColor: '#f0f5f3',
        fillOpacity: 0.5,
        radius: 200,
    }).addTo(map);
    circle1.bindPopup("aithma 1.");


    var circle2 = L.circle([38.290757, 21.770289], {
        color: 'green',
        fillColor: '#f0f5f3',
        fillOpacity: 0.5,
        radius: 200,
    }).addTo(map);
    circle2.bindPopup("aithma 2.");





    var oxhma = L.icon({
        iconUrl: 'resquer.jpg',
        iconSize:     [40, 40], // size of the icon
        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    L.marker([38.2766684, 21.7514926], {icon: oxhma}).addTo(map).bindPopup("OXHMA DIASVSHS");



    var base = L.icon({
        iconUrl: 'base.jpg',
        iconSize:     [50, 50], // size of the icon
        iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
        popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    });
    L.marker([38.289182, 21.795689], {icon: base,draggable: true})
        .addTo(map).bindPopup("BASE");




    var marker = L.marker([38.295182, 21.770689]).addTo(map);
    marker.bindPopup("Prosfora");




    function onMapClick(e) {
        popup
            .setLatLng(e.latlng)
            .setContent("You clicked the map at " + e.latlng.toString())
            .openOn(map);
    }

    map.on('click', onMapClick);




    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);



</script>
</body>
</html>