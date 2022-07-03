function GenerateMap(longitude, latitude, zoom)
{
    let map = L.map('map').setView({lon: longitude, lat: latitude}, zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.control.scale({imperial: true, metric: true}).addTo(map);
    return map;
}

function PlaceMarkersMap(map, longitude, latitude, name, type1, type2, total)
{
    let layer = L.marker({
        lon: longitude,
        lat: latitude
    }).bindPopup(name).addTo(map);
    layer.on('click', function (e) {
        document.getElementById("loc").innerHTML = "Location name is: " + name;
        document.getElementById("spots").innerHTML = "Total spots: " + total;
        document.getElementById("spots1").innerHTML = "Type 1 spots: " + type1;
        document.getElementById("spots2").innerHTML = "Type 2 spots: " + type2;
    });
}