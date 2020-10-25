<div class="featured-area pd-top-90">
    <div class="container">
        <div class="section-title text-center">
            <h2 class="title">{{__('site.featured_properties')}}</h2>
        </div>
        <div class="row justify-content-center">
            @foreach($products as $product)
                @if ($loop->first)
                    <div class="col-xl-6 col-lg-8">
                        <div class="single-leading-feature">
                            <div class="slf-overlay"></div>
                            <div class="thumb">
                                <img src="/images/feature/1.png" alt="img">
                                <a href="#"><i class="fa fa-heart"></i></a>
                            </div>
                            <div class="details">
                                <h4 class="title"><a href="{{$product->link}}">{{$product->title_lb}}</a></h4>
                                <h5 class="price">$350/mo</h5>
                                <span>4 Bed, 3 Beth, Flats. Area 1448-2537 sqft</span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        @include('item.product-feature')
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
