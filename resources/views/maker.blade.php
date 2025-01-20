<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeoJSON Editor</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />
    <style>
        #map {
            height: 100vh;
        }

        .info-panel {
            position: absolute;
            top: 10px;
            right: 10px;
            background: white;
            padding: 10px;
            z-index: 1000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.5);
        }

        .info-panel button {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div id="map"></div>
    <div class="info-panel">
        <button id="export">Export GeoJSON</button>
        <button id="save">Save GeoJSON</button>
        <input type="file" id="import" accept=".geojson,application/json" />
        <textarea id="geojson-output" rows="10" cols="30" readonly></textarea>
    </div>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-6.765, 110.865], 15);

        // Tambahkan basemap
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Tambahkan fitur menggambar
        const drawnItems = new L.FeatureGroup();
        map.addLayer(drawnItems);

        const drawControl = new L.Control.Draw({
            edit: {
                featureGroup: drawnItems
            },
            draw: {
                polygon: true,
                polyline: true,
                rectangle: true,
                circle: false,
                marker: true
            }
        });
        map.addControl(drawControl);

        // Tambahkan event untuk fitur yang digambar
        map.on(L.Draw.Event.CREATED, function(event) {
            const layer = event.layer;
            layer.feature = {
                type: 'Feature',
                properties: {}
            }; // Inisialisasi GeoJSON
            layer.bindPopup(createPropertiesEditor(layer));
            drawnItems.addLayer(layer);
        });

        // Fungsi untuk membuat editor properti
        function createPropertiesEditor(layer) {
            const properties = layer.feature?.properties || {};

            let form = '<form>';
            for (const key in properties) {
                form += `
            <label>Key: </label>
            <input type="text" name="key-${key}" value="${key}"><br>
            <label>Value: </label>
            <input type="text" name="value-${key}" value="${properties[key]}"><br>
        `;
            }
            form += `
        <label>Property Baru: </label>
        <input type="text" id="new-key" placeholder="Key">
        <input type="text" id="new-value" placeholder="Value"><br>
        <button type="button" onclick="updateProperties(event, ${layer._leaflet_id})">Update</button>
    </form>`;
            return form;
        }
        // Fungsi untuk memperbarui properti
        window.updateProperties = function(event) {
            event.preventDefault();

            const popupContent = event.target.closest('.leaflet-popup-content');
            const inputs = popupContent.querySelectorAll('input[name]');
            const newKey = popupContent.querySelector('#new-key').value;
            const newValue = popupContent.querySelector('#new-value').value;

            // Cari layer yang memiliki pop-up aktif
            let relatedLayer = null;
            drawnItems.eachLayer((layer) => {
                if (layer.getPopup() && layer.getPopup().getContent().includes(popupContent.innerHTML)) {
                    relatedLayer = layer;
                }
            });

            if (!relatedLayer) {
                alert('Layer tidak ditemukan. Pastikan layer sudah terhubung dengan pop-up.');
                return;
            }

            // Perbarui properti
            // Perbarui properti
            const properties = {};
            inputs.forEach(input => {
                const [type, key] = input.name.split('-');
                if (type === 'key') {
                    const valueInput = popupContent.querySelector(`input[name="value-${key}"]`);
                    if (valueInput) {
                        properties[input.value] = valueInput.value;
                    }
                }
            });

            if (newKey && newValue) {
                properties[newKey] = newValue;
            }

            relatedLayer.feature = relatedLayer.feature || {
                type: 'Feature'
            };
            relatedLayer.feature.properties = properties;

            // Tutup dan buka kembali pop-up untuk memperbarui tampilan
            relatedLayer.closePopup();
            relatedLayer.bindPopup(createPropertiesEditor(relatedLayer)).openPopup();
        };


        // Ekspor GeoJSON
        document.getElementById('export').addEventListener('click', () => {
            const data = drawnItems.toGeoJSON();
            document.getElementById('geojson-output').value = JSON.stringify(data, null, 2);
        });

        // Simpan GeoJSON ke file
        document.getElementById('save').addEventListener('click', () => {
            const data = drawnItems.toGeoJSON();
            const blob = new Blob([JSON.stringify(data, null, 2)], {
                type: 'application/json'
            });
            const link = document.createElement('a');
            link.href = URL.createObjectURL(blob);
            link.download = 'data.geojson';
            link.click();
        });

        // Impor GeoJSON
        document.getElementById('import').addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const geojson = JSON.parse(e.target.result);
                    L.geoJSON(geojson, {
                        onEachFeature: (feature, layer) => {
                            layer.bindPopup(createPropertiesEditor(layer));
                            drawnItems.addLayer(layer);
                        }
                    }).addTo(map);
                };
                reader.readAsText(file);
            }
        });
    </script>
</body>

</html>
