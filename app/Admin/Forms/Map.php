<?php

namespace App\Admin\Forms;

use Dcat\Admin\Form\Field\Map as BaseMap;

class Map extends BaseMap
{
    public function useGoogleMap()
    {
        $this->script = <<<JS
        (function() {
            console.log('custom map')
            let map;

            function initGoogleMap(name) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');

                var LatLng = new google.maps.LatLng(lat.val(), lng.val());

                var options = {
                    zoom: 13,
                    center: LatLng,
                    panControl: false,
                    zoomControl: true,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                var container = document.getElementById("map_" + name);
                var map = new google.maps.Map(container, options);

                var marker = new google.maps.Marker({
                    position: LatLng,
                    map: map,
                    title: 'Drag Me!',
                    draggable: true
                });

                google.maps.event.addListener(marker, 'dragend', function(event) {
                    lat.val(event.latLng.lat());
                    lng.val(event.latLng.lng());
                });
            }
            // initGoogleMap('{$this->id['lat']}{$this->id['lng']}');

            function markerByAddress(map) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');
                let geocoder = new google.maps.Geocoder();
                const input = document.querySelector('input.field_address_address_lb_');
                let id = input.getAttribute('id');
                if (window.admin.markers && window.admin.markers[id]) {
                    window.admin.markers[id].map((marker) => {
                        marker.setMap(null)
                    })
                }else {
                  window.admin.markers[id] = [];
                }

                const address = input.value;
                geocoder.geocode({ 'address': address }, function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {
                        //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
                        map.setCenter(results[0].geometry.location);
                        const image = "https://developers.google.com/maps/documentation/javascript/examples/full/images/beachflag.png";
                        const info = new google.maps.InfoWindow({
                            // content: results[0].formatted_address,
                            content: address
                        });
                        if (window.admin.markers[id].length > 0) {
                            window.admin.markers[id].map((marker) => {
                                marker.setMap(null)
                            })
                        }
                        const marker = new google.maps.Marker({
                            map,
                            draggable: true,
                            image,
                            animation: google.maps.Animation.DROP,
                            title: results[0].formatted_address,
                            position: results[0].geometry.location
                        });
                        info.open(map, marker);
                        lat.val(results[0].geometry.location.lat());
                        lng.val(results[0].geometry.location.lng());
                        google.maps.event.addListener(marker, 'dragend', function(event) {
                            lat.val(event.latLng.lat());
                            lng.val(event.latLng.lng());
                        });
                        window.admin.markers[id].push(marker);
                    } else {
                        // alert( 'Geocode was not successful for the following reason: ' + status );
                    }
                });
            }

            function init(name) {
                var lat = $('#{$this->id['lat']}');
                var lng = $('#{$this->id['lng']}');

                var LatLng = new google.maps.LatLng(lat.val(), lng.val());
                var options = {
                    zoom: 13,
                    center: LatLng,
                    panControl: false,
                    zoomControl: true,
                    scaleControl: true,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                }

                var container = document.getElementById("map_" + name);
                map = new google.maps.Map(container, options);
            }
            init('{$this->id['lat']}{$this->id['lng']}')

            let provincial = $('select.field_address_provincial_id_');
            provincial.change(function() {
                updateAddress(this, 1)
            })
            let district = $('select.field_address_district_id_');
            district.change(function() {
                updateAddress(this, 2)
            })
            let ward = $('select.field_address_ward_id_');
            ward.change(function() {
                updateAddress(this, 3)
            })
            let street = $('select.field_address_street_id_');
            street.change(function() {
                updateAddress(this, 4)
            })
            let apartment_number = $('input.field_address_apartment_number_');
            apartment_number.blur(function() {
                updateAddress(this, 5)
            })

            function updateAddress(domField, level = 1) {
                let levels = {
                    1: [provincial],
                    2: [district, provincial],
                    3: [ward, district, provincial],
                    4: [street, ward, district, provincial],
                    5: ['apartment_number', street, ward, district, provincial]
                };
                let address = "";
                for (let i = 0; i < levels[level].length; i++) {
                    let el = levels[level][i];
                    if (el) {
                        if (el === 'apartment_number' && domField) {
                            address += $(domField).val() + ' '
                        }else{
                            let data = $(el[0]).select2('data')
                            if (data && data.length > 0) {
                                address += data[0].text + ' '
                            }
                        }
                    }
                }
                $('input.field_address_address_lb_').val(address)
                markerByAddress(map)
            }
        })();
JS;
    }
}
