<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

   <!-- Load Leaflet from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>

  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@3.0.14/dist/esri-leaflet.js"></script>

  <script src="https://unpkg.com/esri-leaflet-vector@4.2.6/dist/esri-leaflet-vector.js"></script>

    <!-- Load jQuery from CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

     <style>
        body {
        margin: 0;
        padding: 0;
        }

        #map {
        position: absolute;
        top: 0;
        bottom: 0;
        right: 0;
        left: 0;
        font-family: Arial, Helvetica, sans-serif;
        font-size: 14px;
        color: #323232;
        }
    </style>
</head>
<body>
     <div id="map"></div>

</body>

<script>
    /* Use for API key authentication */
    const accessToken = "AAPTxy8BH1VEsoebNVZXo8HurDEMCVzcg2e_v0-cTZW2J9uhkTG4jBjBd_1nmhddasLXJlRV5R9oMn_mWMVsAbdAbCo-kHUobHAUldTiW_L8YNKwjUv-5sl6uEXFXvTPHlU3xWrdgysOCjwzVHH-UDyts0ivA4_hlMu1p7tSZopNm4KF1N3g4CQ6_KLjZDExvlSpdlapJtIIg4nx3YH92LVJF115aqCjfxDSUPRbsu1SQCM.AT1_KSBmHgWL";
    const map = L.map("map", {
      minZoom: 2
    })

    // Set the map view to a given center and zoom
    map.setView([0, 0], 10);

    // Add the tile layer to the map
    function getV2Basemap(style) {
      return L.esri.Vector.vectorBasemapLayer(style, {
        token: accessToken,
        version: 2
      })
    }

    const basemapLayers = {

      "arcgis/outdoor": getV2Basemap("arcgis/outdoor"),
      "arcgis/community": getV2Basemap("arcgis/community"),
      "arcgis/navigation": getV2Basemap("arcgis/navigation"),
      "arcgis/streets": getV2Basemap("arcgis/streets"),
      "arcgis/streets-relief": getV2Basemap("arcgis/streets-relief"),
      "arcgis/imagery": getV2Basemap("arcgis/imagery").addTo(map),
      "arcgis/oceans": getV2Basemap("arcgis/oceans"),
      "arcgis/topographic": getV2Basemap("arcgis/topographic"),
      "arcgis/light-gray": getV2Basemap("arcgis/light-gray"),
      "arcgis/dark-gray": getV2Basemap("arcgis/dark-gray"),
      "arcgis/human-geography": getV2Basemap("arcgis/human-geography"),
      "arcgis/charted-territory": getV2Basemap("arcgis/charted-territory"),
      "arcgis/nova": getV2Basemap("arcgis/nova"),
      "osm/standard": getV2Basemap("osm/standard"),
      "osm/navigation": getV2Basemap("osm/navigation"),
      "osm/streets": getV2Basemap("osm/streets"),
      "osm/blueprint": getV2Basemap("osm/blueprint")
    };

    L.control.layers(basemapLayers, null, { collapsed: false }).addTo(map);

    // JSON //
    $(document).ready(function() {
        $.getJSON('titik/json', function(data) {
            $.each(data, function(index) {
                var travelAgencyIcon = L.icon({
                iconUrl: 'icon/travel_agency.png',

                iconSize:     [24, 24], // size of the icon
                shadowSize:   [50, 64], // size of the shadow
                iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
                shadowAnchor: [4, 62],  // the same for the shadow
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
                });
                L.marker([data[index].latitude, data[index].longitude], {icon: travelAgencyIcon}).addTo(map)
            });
        });
    })

    // Marker //

    // Marker icons travel agency
    // var travelAgencyIcon = L.icon({
    // iconUrl: 'icon/travel_agency.png',

    // iconSize:     [24, 24], // size of the icon
    // shadowSize:   [50, 64], // size of the shadow
    // iconAnchor:   [22, 94], // point of the icon which will correspond to marker's location
    // shadowAnchor: [4, 62],  // the same for the shadow
    // popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
    // });

    // var maker = L.marker([-6.7731001, 110.8505008], {icon: travelAgencyIcon}).addTo(map).on('click', function(e) {
    //     alert("You clicked the map at " + e.latlng);
    // });

    // Polyline //

    // create a red polyline from an array of LatLng points
    var latlngspolyline = [
            [
            -6.790267003650982,
            110.78969763868014
          ],
          [

            -6.756651527230218,
            110.80223969298453
          ],
    ];

    var polyline = L.polyline(latlngspolyline, {color: 'red'}).addTo(map);

    // // zoom the map to the polyline
    // map.fitBounds(polyline.getBounds());

    polyline.on('click', (e)=>{
        polyline.bindPopup("Polyline clicked").openPopup();
        polyline.setStyle({color: 'green'});
    });

    // Polygon //

    // create a red polygon from an array of LatLng points
    var latlngspolygon = [
            [
              -6.76549961505475,
              110.83439452761132
            ],
            [
              -6.79770558183472,
              110.78409435312818
            ],
            [
              -6.840827482405089,
              110.83281886357452
            ],
   ];


    var polygon = L.polygon(latlngspolygon, {color: 'red'}).addTo(map);

    // zoom the map to the polygon
    map.fitBounds(polygon.getBounds());

    polygon.setStyle({
        color: 'green',
        fillColor: 'green',
        fillOpacity: 0.5
    })

    polygon.on('click', (e)=>{
        polygon.bindPopup("Polygon clicked").openPopup();
        polygon.setStyle({color: 'yellow'});
    });

</script>

</html>
