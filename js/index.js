document.addEventListener("DOMContentLoaded", function()
{
    const map = L.map("map").setView([23.8103, 90.4125], 12);

    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png",
    {
        attribution: "&copy; OpenStreetMap contributors"
    }).addTo(map);

    const redIcon = L.divIcon({
        className: "red-marker",
        iconSize: [14, 14]
    });

    const greenIcon = L.icon({
        iconUrl: "https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-green.png",
        shadowUrl: "https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png",
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let selectedMarker = null;

    let searchMarker = null;

    function setSearchMarker(lat, lon)
    {
        if(searchMarker)
        {
            map.removeLayer(searchMarker);
        }

        searchMarker = L.marker([lat, lon], {icon: redIcon}).addTo(map);
    }

    const detailsPlaceholder = document.getElementById("detailsPlaceholder");
    const detailsTitle = document.getElementById("detailsTitle");
    const detailsDescription = document.getElementById("detailsDescription");

    function showEventDetails(event)
    {
        detailsPlaceholder.style.display = "none";
        detailsTitle.style.display = "block";
        detailsDescription.style.display = "block";
        detailsTitle.textContent = event.title;
        detailsDescription.textContent = event.description;
    }

    eventsData.forEach(function(event)
    {
        const marker = L.marker([parseFloat(event.latitude), parseFloat(event.longitude)]).addTo(map);

        marker.on("click", function()
        {
            if(selectedMarker)
            {
                selectedMarker.setIcon(new L.Icon.Default());
            }

            marker.setIcon(greenIcon);
            selectedMarker = marker;

            showEventDetails(event);
        });
    });

    const searchInput = document.getElementById("searchInput");
    const searchResults = document.getElementById("searchResults");
    let searchTimer = null;

    function renderResults(places)
    {
        searchResults.innerHTML = "";

        if(places.length == 0)
        {
            const empty = document.createElement("div");
            empty.textContent = "No results found";
            searchResults.appendChild(empty);
            searchResults.style.display = "block";
            return;
        }

        places.forEach(function(place)
        {
            const item = document.createElement("div");
            item.textContent = place.display_name;

            item.addEventListener("click", function()
            {
                const lat = parseFloat(place.lat);
                const lon = parseFloat(place.lon);
                searchInput.value = place.display_name;
                searchResults.style.display = "none";
                map.setView([lat, lon], 14);
                setSearchMarker(lat, lon);
            });

            searchResults.appendChild(item);
        });

        searchResults.style.display = "block";
    }

    function searchPlace(query)
    {
        if(!query)
        {
            return;
        }

        fetch("https://nominatim.openstreetmap.org/search?q=" + encodeURIComponent(query) + "&format=json")
        .then(function(response)
        {
            return response.json();
        })
        .then(function(results)
        {
            renderResults(results);
        })
        .catch(function()
        {
            renderResults([]);
        });
    }

    searchInput.addEventListener("input", function()
    {
        clearTimeout(searchTimer);
        const query = searchInput.value;

        if(query.length < 3)
        {
            searchResults.style.display = "none";
            return;
        }

        searchTimer = setTimeout(function()
        {
            searchPlace(query);
        }, 400);
    });

    document.getElementById("searchBtn").addEventListener("click", function()
    {
        searchPlace(searchInput.value);
    });

    document.addEventListener("click", function(e)
    {
        if(e.target != searchInput && !searchResults.contains(e.target))
        {
            searchResults.style.display = "none";
        }
    });

    document.getElementById("currentLocationBtn").addEventListener("click", function()
    {
        if(navigator.geolocation)
        {
            navigator.geolocation.getCurrentPosition(function(position)
            {
                const lat = position.coords.latitude;
                const lon = position.coords.longitude;
                map.setView([lat, lon], 14);
                setSearchMarker(lat, lon);
            });
        }
    });
});
