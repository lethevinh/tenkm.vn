<div class="client-review-img">
    @foreach($clients as $key => $client)
        <img class="clr-img clr-img{{$key}}" src="{{ $client->thumbnail }}" alt="{{ $client->title_lb }}">
    @endforeach
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-10">
            <div class="client-slider-2 text-center">
                @foreach($clients as $client)
                    @include('item.client')
                @endforeach
            </div>
        </div>
    </div>
</div>
