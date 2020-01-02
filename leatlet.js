//Setting initial coordinates
var mymap = L.map('article-leatlet').setView([48.856614, 2.3522219], 10);

//Adding map layer
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoibWFpYTIzIiwiYSI6ImNrMzV2dWlneTBicDMzY3FqNDRhcnNwZWkifQ.ZeUBSa9YEXLxt0BVV7okeA'
    }).addTo(mymap);

document.getElementById("location-button").addEventListener("click", function() {
  mymap.locate({setView: true, maxZoom: 13});
});


//Adding markers
//var marker = L.marker([48.864716, 2.349014]).addTo(mymap);
/*var circle = L.circle([51.508, -0.11], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 500
}).addTo(mymap);
*/

//marker.bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();