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

    <script src="leaflet/js/leaflet.textpath.js"></script>

    <link rel="stylesheet" href="leaflet/js/MarkerCluster.css" />
    <link rel="stylesheet" href="leaflet/js/MarkerCluster.Default.css" />

    <script src="leaflet/js/leaflet.markercluster.js"></script>

    <!-- Load Leaflet Control Layers from CDN -->
    <style>
        #map {
            height: 500px;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color: #323232;
        }

        .label-bidang {
            color: #00ff5e;
            padding: 5px;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
        }

        .legend {
            background: white;
            padding: 10px;
        }
    </style>
</head>

<body>
    <div>
        <p>Cari Lokasi</p>
        <select onchange="cari(this.value)">
            @foreach ($lokasi as $d)
                <option value="{{ $d->id }}">{{ $d->nama }}</option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <input type="checkbox">Jalan</input>
        <input type="checkbox">Bidang</input>
    </div>

    <div id="map"></div>

</body>

<script>
    /* Use for API key authentication */
    const
        accessToken =
        "AAPTxy8BH1VEsoebNVZXo8HurDEMCVzcg2e_v0-cTZW2J9uhkTG4jBjBd_1nmhddasLXJlRV5R9oMn_mWMVsAbdAbCo-kHUobHAUldTiW_L8YNKwjUv-5sl6uEXFXvTPHlU3xWrdgysOCjwzVHH-UDyts0ivA4_hlMu1p7tSZopNm4KF1N3g4CQ6_KLjZDExvlSpdlapJtIIg4nx3YH92LVJF115aqCjfxDSUPRbsu1SQCM.AT1_KSBmHgWL";
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

        // "arcgis/outdoor": getV2Basemap("arcgis/outdoor"),
        // "arcgis/community": getV2Basemap("arcgis/community"),
        // "arcgis/navigation": getV2Basemap("arcgis/navigation"),
        // "arcgis/streets": getV2Basemap("arcgis/streets"),
        // "arcgis/streets-relief": getV2Basemap("arcgis/streets-relief"),
        "arcgis/imagery": getV2Basemap("arcgis/imagery").addTo(map),
        "arcgis/oceans": getV2Basemap("arcgis/oceans"),
        "arcgis/topographic": getV2Basemap("arcgis/topographic"),
        "arcgis/light-gray": getV2Basemap("arcgis/light-gray"),
        // "arcgis/dark-gray": getV2Basemap("arcgis/dark-gray"),
        // "arcgis/human-geography": getV2Basemap("arcgis/human-geography"),
        // "arcgis/charted-territory": getV2Basemap("arcgis/charted-territory"),
        // "arcgis/nova": getV2Basemap("arcgis/nova"),
        // "osm/standard": getV2Basemap("osm/standard"),
        // "osm/navigation": getV2Basemap("osm/navigation"),
        // "osm/streets": getV2Basemap("osm/streets"),
        // "osm/blueprint": getV2Basemap("osm/blueprint")
    };

    L.control.layers(basemapLayers, null, {
        collapsed: false
    }).addTo(map);



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

    var polyline = L.polyline(latlngspolyline, {
        color: 'red'
    }).addTo(map);

    // // zoom the map to the polyline
    // map.fitBounds(polyline.getBounds());

    polyline.on('click', (e) => {
        polyline.bindPopup("Polyline clicked").openPopup();
        polyline.setStyle({
            color: 'green'
        });
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


    var polygon = L.polygon(latlngspolygon, {
        color: 'red'
    }).addTo(map);

    // zoom the map to the polygon
    map.fitBounds(polygon.getBounds());

    polygon.setStyle({
        color: 'green',
        fillColor: 'green',
        fillOpacity: 0.5
    })

    polygon.on('click', (e) => {
        polygon.bindPopup("Polygon clicked").openPopup();
        polygon.setStyle({
            color: 'yellow'
        });
    });

    // JSON DATABASE MARKER//
    $(document).ready(function() {
        $.getJSON('titik/json', function(data) {
            $.each(data, function(index) {
                var travelAgencyIcon = L.icon({
                    iconUrl: 'icon/travel_agency.png',

                    iconSize: [24, 28], // size of the icon
                    shadowSize: [50, 64], // size of the shadow
                    iconAnchor: [22,
                        94
                    ], // point of the icon which will correspond to marker's location
                    shadowAnchor: [4, 62], // the same for the shadow
                    popupAnchor: [-3, -
                        76
                    ] // point from which the popup should open relative to the iconAnchor
                });
                L.marker([data[index].latitude, data[index].longitude], {
                    icon: travelAgencyIcon
                }).addTo(map)
            });
        });
    })

    // GeoJSON Polygon Dengan Garis Putus"//
    $.getJSON('geojson/map.geojson', function(json) {
        geoLayer = L.geoJson(json, {
            style: function(feature) {
                return {
                    fillOpacity: 0,
                    weight: 5,
                    opacity: 1,
                    color: 'yellow',
                    dashArray: '30 10', //panjang x lebar
                    lineCap: 'square'
                };
            },

            onEachFeature: function(feature, layer) {
                // alert(feature.properties.nama)
                // Menampilkan Label
                var iconLabel = L.divIcon({
                    className: 'label-bidang',
                    html: '<b>' + feature.properties.nama + '</b>',
                    iconSize: [100, 20]
                });
                L.marker(layer.getBounds().getCenter(), {
                    icon: iconLabel
                }).addTo(map)

                layer.on('click', (e) => {
                    // alert(feature.properties.id)
                    $.getJSON('titik/lokasi/' + feature.properties.id, function(detail) {
                        $.each(detail, function(index) {
                            // alert(detail[index].alamat);

                            var html = '<h5>Nama Lokasi : ' + detail[index]
                                .nama + '</h5>';
                            html += '<h6>Alamat :' + detail[index].alamat +
                                '</h6>';
                            html +=
                                '<img height="100px" src="images/' +
                                detail[index].gambar + '">';

                            L.popup().setLatLng(layer.getBounds()
                                    .getCenter())
                                .setContent(html)
                                .openOn(map);
                        })
                    });
                })

                layer.addTo(map);
            }

        })
    });

    $.getJSON('geojson/jalan.geojson', function(json) {
        geoLayer = L.geoJson(json, {
            style: function(feature) {
                return {
                    weight: 5,
                    opacity: 1,
                    color: 'black',
                    dashArray: '15 5', //panjang x lebar
                    lineCap: 'square'
                };
            },

            onEachFeature: function(feature, layer) {

                layer.setText(feature.properties.nama, {
                    repeate: false,
                    offset: -5,
                    orientation: 15,
                    attributes: {
                        style: 'font-size: 7pt; fill: black;'
                    }
                });
                layer.on('click', (e) => {
                    layer.setStyle({
                        color: 'green',
                        fillColor: 'green',
                    })
                })

                layer.addTo(map);
            }

        })
    });

    // Function Cari lokasi lalu zoom in //
    function cari(id) {
        geoLayer.eachLayer(function(layer) {
            if (layer.feature.properties.id == id) {
                map.flyTo(layer.getBounds().getCenter(), 19);
                // layer.bindPopup(layer.feature.properties.nama);
            }
        });
    }

    // Legend //
    var legend = L.control({
        position: 'bottomright'
    });

    legend.onAdd = function(map) {
        var div = L.DomUtil.create('div', 'legend');

        labels = ['<strong>Keterangan :</strong>'],

            categories = ['Rumah Sakit', 'Sekolah', 'Gedung Pemerintah'];

        for (var i = 0; i < categories.length; i++) {
            if (i == 0) {
                div.innerHTML +=
                    labels.push(
                        '<img width="20" height="23" src="icon/hospital.png"><i class="circle" style="background:#000000"></i> ' +
                        (categories[i] ? categories[i] : '+')
                    );
            } else if (i == 1) {
                div.innerHTML +=
                    labels.push(
                        '<img width="20" height="23" src="icon/university.png"><i class="circle" style="background:#000000"></i> ' +
                        (categories[i] ? categories[i] : '+')
                    );
            } else {
                div.innerHTML +=
                    labels.push(
                        '<img width="20" height="23" src="icon/congress.png"><i class="circle" style="background:#000000"></i> ' +
                        (categories[i] ? categories[i] : '+')
                    );
            }
        }
        div.innerHTML = labels.join('<br>');
        return div;
    };
    legend.addTo(map);
</script>

</html>
