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
    var map = L.map('map').setView([38.293166, 21.791718], 14);
    var base = L.marker([38.290182, 21.795689]).addTo(map);
    var rescuer = L.marker([38.309757, 21.785289]).addTo(map);






    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);



</script>
</body>
</html>