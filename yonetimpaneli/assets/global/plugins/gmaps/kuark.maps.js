(function($) {
var map;
var markers = [];
var gelenKoordinat = $("#koordinat").text();
var koordinatBol = gelenKoordinat.split(',');

function initialize() {
  var mapOptions = {
    zoom: 9,
    center: new google.maps.LatLng(40.266864, 29.063448),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

  map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);

	google.maps.event.addListener(map, 'click', function(event) {
	temizlenenleriSil();
	koordinatEkle(event.latLng);
	degerAta(event.latLng);
});

	var yeniLatLng = new google.maps.LatLng(koordinatBol[0], koordinatBol[1]);
	koordinatEkle(yeniLatLng);

}

function koordinatEkle(location) {
  var marker = new google.maps.Marker({
    position: location,
    map: map
  });
  markers.push(marker);
  map.panTo(location);

}

function tumunuSec(map) {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(map);
  }
}

function temizle() {
  tumunuSec(null);
}

function temizlenenleriSil() {
  temizle();
  markers = [];
}

function degerAta(Koordinat) {
      $("#harita").val(Koordinat);
}

google.maps.event.addDomListener(window, 'load', initialize);
}) (jQuery);
