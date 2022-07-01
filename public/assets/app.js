function GenerateMap()
{
    let map = L.map('map').setView({lon: 25, lat: 45.75}, 7);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.control.scale({imperial: true, metric: true}).addTo(map);

    return map;
}

function PlaceMarkersMap(map, longitude, latitude, name, total_spots)
{
    let layer = L.marker({
        lon: longitude,
        lat: latitude
    }).bindPopup(name).addTo(map);
    layer.on('click', function (e) {
        document.getElementById("loc").innerHTML = "Location name is: " + name;
        document.getElementById("lat").innerHTML = "Latitude: " + latitude;
        document.getElementById("lon").innerHTML = "Longitude: " + longitude;
        document.getElementById("spots").innerHTML = "Total spots: " + total_spots;
    });
}