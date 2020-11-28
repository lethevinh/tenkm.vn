@extends('layouts.full')
@section('title', $product->title_lb)
@section('id_body', 'course-single__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images//bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{$product->title_lb}}</h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}">{{ trans('site.home') }}</a></li>
                            <li><a href="{{route('product.index')}}">{{ trans('site.product') }}</a></li>
                            @if($product->categories->count() > 0 )
                                <li><a href="{{$product->categories[0]->link}}">{{ $product->categories[0]->title_lb }}</a></li>
                            @endif
                            <li class="active">{{$product->title_lb}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- property-details-area start -->
    <div class="property-details-area">
        <div class="bg-gray pd-top-100 pd-bottom-90">
            <div class="container">
                <div class="row ">
                    <div class="col-xl-9 col-lg-8">
                        @if(count($product->galleries) > 1)
                        <div class="property-details-slider">
                            @foreach($product->galleries as $gallery)
                            <div class="item">
                                <div class="thumb">
                                    <img src="{{$gallery}}" alt="img">
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                            <img src="{{$product->thumbnail}}" alt="">
                        @endif
                        <div class="property-details-slider-info">
                            <h3><span>{{$product->priceLabel}}</span> {{$product->title_lb}}</h3>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        @include('partials/contact-card', ['post'=>$product])
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row pd-top-90">
                <div class="col-lg-9">
                    <div class="property-info mb-5">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{__('site.bedroom')}}</h5>
                                    <p><i class="fa fa-bed"></i>{{$product->bedroom_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.bathroom')}}</h5>
                                    <p><i class="fa fa-bath"></i>{{$product->bathroom_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.area')}}</h5>
                                    <p><img src="/images//icons/7.png" alt="img">{{$product->area_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.parking')}}</h5>
                                    <p><i class="fa fa-car"></i>{{$product->parking_nb}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>{{trans('site.content')}}</h4>
                        <p>{!! $product->content_lb !!}</p>
                    </div>
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>{{__('site.map')}}</h4>
                        @if($product->address)
                            @include('partials.google', ['address' => $product->address])
                        @endif
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{trans('site.amenities')}}</h4>
                        @if($product->amenities->count() > 0)
                        @php $div = ceil($product->amenities->count() / 3);  $amenities = array_chunk($product->amenities->toArray(), $div); @endphp
                        <div class="row">
                            @foreach($amenities as $amenity)
                            <div class="col-sm-4">
                                <ul class="rld-list-style mb-3 mb-sm-0">
                                    @foreach($amenity as $a)
                                        <li><i class="fa fa-check"></i> {{$a['title_lb']}}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{trans('site.floor_plan')}}</h4>
                        <div class="thumb">
                            <img src="{{$product->floorplan_lb}}" alt="{{$product->title_lb}}">
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow pb-3">
                        <h4>{{trans('site.facts_and_features')}}</h4>
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <i class="fa fa-bed"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.living_room')}}</h6>
                                        <p>{{$product->living_room_lb}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <i class="fa fa-car"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.garage')}}</h6>
                                        <p>{{$product->garage_lb}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <img src="/images//icons/7.png" alt="img">
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.dining_area')}}</h6>
                                        <p>{{$product->dining_area}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <i class="fa fa-bed"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.bedroom')}}</h6>
                                        <p>{{$product->bedroom_nb}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <i class="fa fa-bath"></i>
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.bathroom')}}</h6>
                                        <p>{{$product->bathroom_nb}}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-floor-list media">
                                    <div class="media-left">
                                        <img src="/images//icons/17.png" alt="img">
                                    </div>
                                    <div class="media-body">
                                        <h6>{{trans('site.gym_area')}}</h6>
                                        <p>{{$product->gym_area}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow mb-0">
                        <h4>3D Gallery</h4>
                        <div class="thumb">
                            <img src="{{url('images/others/11.png')}}" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- property details area end -->

    <!-- Recommended area start -->
    <div class="recommended-area pd-top-90 pd-bottom-70">
        <div class="container">
            {!! do_shortcode('[products template="product-recommended" product="'.$product->id.'" limit="4"]') !!}
        </div>
    </div>
    <!-- Recommended area end -->
@endsection
