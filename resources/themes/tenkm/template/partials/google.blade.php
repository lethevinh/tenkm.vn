@if($address)
    @if($address->location_lb)
        {!! $address->location_lb !!}
    @elseif($address->lat_lb && $address->lng_lb)
        <div id="map" class="map-responsive" data-lat="{{$address->lat_lb}}" data-lng="{{$address->lng_lb}}"></div>
    @endif
@endif
