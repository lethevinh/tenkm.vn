@extends('layouts.full')
@section('title', $project->title_lb)
@section('id_body', 'course-single__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images//bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{$project->title_lb}}</h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}">{{ trans('site.home') }}</a></li>
                            <li><a href="{{route('product.index')}}">{{ trans('site.product') }}</a></li>
                            @if($project->categories->count() > 0 )
                                <li><a href="{{$project->categories[0]->link}}">{{ $project->categories[0]->title_lb }}</a></li>
                            @endif
                            <li class="active">{{$project->title_lb}}</li>
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
                        <div class="property-details-slider">
                            @foreach($project->galleries as $gallery)
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{$gallery}}" alt="img">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="property-details-slider-info">
                            <h3><span>{{$project->priceLabel}}</span> {{$project->title_lb}}</h3>
                            <h4><span>{{$project->addressLabel}}</span></h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        @include('partials/contact-card', ['post'=>$project])
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row pd-top-90">
                <div class="col-lg-12">
                    <div class="property-info mb-5">
                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.sales_status')}}</h5>
                                    <p><i class="fa fa-industry"></i>{{trans('site.sales_status_'.$project->sale_status_sl)}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.apartment_type')}}</h5>
                                    <p><i class="fa fa-home"></i>{{$project->apartment_type}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.delivery_time')}}</h5>
                                    <p><i class="fa fa-handshake-o"></i>{{date('d/m/Y', strtotime($project->delivery_time))}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.total_square')}}</h5>
                                    <p><img src="/images/icons/7.png" alt="img"> {{$project->total_area_nb}} &#13217;</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.blocks')}}</h5>
                                    <p><i class="fa fa-building"></i>{{$project->block_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.floors')}}</h5>
                                    <p><i class="fa fa-building"></i>{{$project->floor_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.shophouse')}}</h5>
                                    <p><i class="fa fa-home"></i>{{$project->shop_nb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.apartments')}}</h5>
                                    <p><i class="fa fa-key"></i>{{$project->department_nb}}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.apartment_square')}}</h5>
                                    <p><img src="/images/icons/7.png" alt="img">{{$project->area_lb}} &#13217;</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.management_company')}}</h5>
                                    <p><i class="fa fa-suitcase"></i>{{$project->management_company}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{trans('site.design_company')}}</h5>
                                    <p><i class="fa fa-paint-brush"></i>{{$project->design_company}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>{{trans('site.introduction')}}</h4>
                        <p>{!! $project->content_lb !!}</p>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow mb-0">
                        <h4>3D Gallery</h4>
                        <div class="thumb">
                            <img src="{{$project->gallery_3d_lb}}" alt="img">
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{trans('site.amenities')}}</h4>
                        @if($project->amenities->count() > 0)
                        @php $div = ceil($project->amenities->count() / 3);  $amenities = array_chunk($project->amenities->toArray(), $div); @endphp
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
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>Location</h4>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.333807744015!2d106.75457695059688!3d10.785725392277543!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317525d4ac37cac3%3A0xed8b65112aeca5d3!2zTmd1eeG7hW4gVGjhu4sgxJDhu4tuaCwgQW4gUGjDuiwgUXXhuq1uIDIsIFRow6BuaCBwaOG7kSBI4buTIENow60gTWluaCwgVmlldG5hbQ!5e0!3m2!1sen!2s!4v1598249100752!5m2!1sen!2s" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- property details area end -->

    <!-- Recommended area start -->
    <div class="recommended-area pd-top-90 pd-bottom-70">
        <div class="container">
            {!! do_shortcode('[products template="product-recommended" project="'.$project->id.'" limit="4"]') !!}
        </div>
    </div>
    <!-- Recommended area end -->
@endsection
