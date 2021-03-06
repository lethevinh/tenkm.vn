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
                                <img src="{{resize($product->thumbnail, 665,493)}}" alt="{{$product->title_lb}}">
                                <a href="#"><i class="fa fa-heart"></i></a>
                            </div>
                            <div class="details">
                                <h4 class="title"><a href="{{$product->link}}">{{$product->title_lb}}</a></h4>
                                <h5 class="price">{{$product->priceLabel}}</h5>
                                <span><i class="fa fa-bed"></i> {{$product->bedroom_nb}} | <i class="fa fa-bath"></i> 3 | <i class="fa fa-square-o"></i> {{$product->area_nb}} m²</span>
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
