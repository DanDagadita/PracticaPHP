function GenerateMap(longitude, latitude, zoom) {
    let map = L.map('map').setView({lon: longitude, lat: latitude}, zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="https://openstreetmap.org/copyright">OpenStreetMap contributors</a>'
    }).addTo(map);

    L.control.scale({imperial: true, metric: true}).addTo(map);
    return map;
}

function PlaceMarkersMap(map, longitude, latitude, name, type1, type2, total, id) {
    L.marker({
        lon: longitude,
        lat: latitude
    }).bindPopup(
        "<div>" +
        "<h4 class='fw-bold'>" + name + "</h4>" +
        "<h6>Type 1 spots: " + type1 + "</h6>" +
        "<h6>Type 2 spots: " + type2 + "</h6>" +
        "<h6>Total spots: " + total + "</h6>" +
        "<a href='/booking/" + id + "'><button class='btn btn-primary mt-md-2'>" +
        "Book</button></a>" +
        "</div>"
    ).addTo(map);
}