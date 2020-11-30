@if($address)
    @if($address->lat_lb && $address->lng_lb)
        <div id="street-view" class="map-responsive" data-lat="{{$address->lat_lb}}" data-lng="{{$address->lng_lb}}"></div>
    @endif
@endif
