@if($address->location_lb)
    {!! $address->location_lb !!}
@else
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{config('admin.map.keys.google')}}&callback=initMap&libraries=&v=weekly"
        defer
    ></script>
    <script>
        // In this example, we center the map, and add a marker, using a LatLng object
        // literal instead of a google.maps.LatLng object. LatLng object literals are
        // a convenient way to add a LatLng coordinate and, in most cases, can be used
        // in place of a google.maps.LatLng object.
        let map;

        function initMap() {
            const mapOptions = {
                zoom: 8,
                center: { lat: {{$address->lat_lb}}, lng: {{$address->lng_lb}} },
            };
            map = new google.maps.Map(document.getElementById("map"), mapOptions);
            const marker = new google.maps.Marker({
                // The below line is equivalent to writing:
                // position: new google.maps.LatLng(-34.397, 150.644)
                position: { lat: {{$address->lat_lb}}, lng: {{$address->lng_lb}} },
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
    </script>
    <div id="map" class="map-responsive"></div>
@endif
