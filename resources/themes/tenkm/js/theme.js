$(document).ready(function () {

})
function initGoogleMap() {
    let streetView = $('#street-view');
    let panorama;
    if (streetView.length > 0 && google) {
        let lat = streetView.data('lat');
        let lng = streetView.data('lng');
        panorama = new google.maps.StreetViewPanorama(
            document.getElementById("street-view"),
            {
                position: {lat: lat, lng: lng},
                pov: {heading: 165, pitch: 0},
                zoom: 1,
            }
        );
    }
    let googleMap = $('#map');
    let map;
    if (streetView.length > 0 && google) {
        let lat = googleMap.data('lat');
        let lng = googleMap.data('lng');
        const mapOptions = {
            zoom: 16,
            center: {lat: lat, lng: lng},
        };
        map = new google.maps.Map(document.getElementById("map"), mapOptions);
        const marker = new google.maps.Marker({
            // The below line is equivalent to writing:
            // position: new google.maps.LatLng(-34.397, 150.644)
            position: {lat: lat, lng: lng},
            map: map,
        });
        // You can use a LatLng literal in place of a google.maps.LatLng object when
        // creating the Marker object. Once the Marker object is instantiated, its
        // position will be available as a google.maps.LatLng object. In this case,
        // we retrieve the marker's position using the
        // google.maps.LatLng.getPosition() method.
        const infowindow = new google.maps.InfoWindow({
            content: "<p>Marker Location:" + marker.getPosition() + "</p>",
        });
        google.maps.event.addListener(marker, "click", () => {
            infowindow.open(map, marker);
        });
    }
}
