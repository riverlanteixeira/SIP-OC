<!-- Leaflet CSS e JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

@php
    $lat = isset($location) && $location->latitude ? $location->latitude : -27.2550;
    $lng = isset($location) && $location->longitude ? $location->longitude : -50.4965;
@endphp

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const initialLat = {{ $lat }};
        const initialLng = {{ $lng }};

        const latInput = document.getElementById('latitude');
        const lngInput = document.getElementById('longitude');

        const map = L.map('map').setView([initialLat, initialLng], 8);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        const marker = L.marker([initialLat, initialLng], {
            draggable: true
        }).addTo(map);

        latInput.value = initialLat.toFixed(7);
        lngInput.value = initialLng.toFixed(7);

        marker.on('dragend', function(event) {
            const position = marker.getLatLng();
            latInput.value = position.lat.toFixed(7);
            lngInput.value = position.lng.toFixed(7);
        });

        // --- NOVA LÓGICA DE BUSCA DE ENDEREÇO ---
        const geocodeBtn = document.getElementById('geocodeBtn');
        
        geocodeBtn.addEventListener('click', async function() {
            // Constrói a string de busca a partir dos campos do formulário
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const state = document.getElementById('state').value;
            const postalcode = document.getElementById('postal_code').value;

            // Junta as partes do endereço, ignorando as que estiverem vazias
            const queryParts = [address, city, state, postalcode].filter(part => part.trim() !== '');
            const queryString = queryParts.join(', ');

            if (!queryString) {
                alert('Por favor, preencha pelo menos um campo de endereço para buscar.');
                return;
            }

            // Monta a URL da API Nominatim
            const apiUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(queryString)}`;

            geocodeBtn.innerText = 'Buscando...';
            geocodeBtn.disabled = true;

            try {
                const response = await fetch(apiUrl);
                const data = await response.json();

                if (data && data.length > 0) {
                    const bestResult = data[0];
                    const lat = parseFloat(bestResult.lat);
                    const lng = parseFloat(bestResult.lon);
                    const latLng = L.latLng(lat, lng);

                    map.setView(latLng, 17); // Dá um zoom mais próximo
                    marker.setLatLng(latLng);

                    latInput.value = lat.toFixed(7);
                    lngInput.value = lng.toFixed(7);
                } else {
                    alert('Endereço não encontrado.');
                }
            } catch (error) {
                console.error('Erro ao buscar o endereço:', error);
                alert('Ocorreu um erro ao tentar buscar o endereço.');
            } finally {
                geocodeBtn.innerText = 'Buscar Endereço no Mapa';
                geocodeBtn.disabled = false;
            }
        });
    });
</script>
