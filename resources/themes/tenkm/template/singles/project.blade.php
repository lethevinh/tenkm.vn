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
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
                            <li><a href="{{route('project.index')}}">{{ tran('site.project') }}</a></li>
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
                        @if(count($project->galleries) > 1)
                        <div class="property-details-slider">
                            @foreach($project->galleries as $gallery)
                                <div class="item">
                                    <div class="thumb">
                                        <img src="{{$gallery}}" alt="img">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @else
                            <img src="{{$project->thumbnail}}" alt="">
                        @endif
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
                                    <h5>{{tran('site.sales_status')}}</h5>
                                    <p><i class="fa fa-industry"></i>{{tran('site.sales_status_'.$project->sale_status_sl)}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.apartment_type')}}</h5>
                                    <p><i class="fa fa-home"></i>{{$project->apartment_type}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.delivery_time')}}</h5>
                                    <p><i class="fa fa-handshake-o"></i>{{date('d/m/Y', strtotime($project->delivery_time))}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.total_square')}}</h5>
                                    <p><img src="/images/icons/7.png" alt="img"> {{$project->total_area_nb}} &#13217;</p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.developer')}}</h5>
                                    <p><i class="fa fa-building"></i>{{$project->developer_lb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.total_unit_area')}}</h5>
                                    <p><i class="fa fa-building"></i>{{$project->total_unit_area_lb}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.handover_condition')}}</h5>
                                    <p><i class="fa fa-home"></i>{{tran('site.'.$project->handover_condition_lb)}}</p>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">
                                <div class="single-property-info">
                                    <h5>{{tran('site.legal_ownership')}}</h5>
                                    <p><i class="fa fa-key"></i>{{$project->legal_ownership_lb}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>{{tran('site.content_detail')}}</h4>
                        <p>{!! $project->content_lb !!}</p>
                    </div>
                    <div class="property-news-single-card style-two border-bottom-yellow">
                        <h4>{{tran('site.location_map')}}</h4>
                        @if($project->address)
                            @include('partials.google', ['address' => $project->address])
                        @endif
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{tran('site.video')}}</h4>
                        <div class="thumb video-responsive">
                            @if($project->youtube)
                                <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$project->youtube}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            @endif
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow mb-0">
                        <h4>Google StreetView</h4>
                        <div class="thumb">
                            @if($project->address)
                                @include('partials.streetview', ['address' => $project->address])
                            @endif
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{tran('site.floor_plan')}}</h4>
                        <div class="thumb">
                            <img src="{{$project->gallery_3d_lb}}" alt="{{$project->title_lb}}">
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
            {!! do_shortcode('[products template="product-recommended" project="'.$project->id.'" limit="4"]') !!}
        </div>
    </div>
    <!-- Recommended area end -->
@endsection
