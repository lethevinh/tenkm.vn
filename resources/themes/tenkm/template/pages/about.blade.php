@extends('layouts.full')
@section('title', 'About Page')
@section('id_body', 'about__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images/bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{tran('site.about')}}</h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}">{{tran('site.home')}}</a></li>
                            <li>{{tran('site.about')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- choose us area start -->
    <div class="mission-vission-area pd-top-80 pd-bottom-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="single-intro text-lg-left text-center">
                        <div class="text">
                            01
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{$page->feature_1}}</a></h4>
                            <p>{{$page->feature_description_1}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 offset-xl-1">
                    <div class="single-intro text-lg-left text-center">
                        <div class="text">
                            02
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{$page->feature_2}}</a></h4>
                            <p>{{$page->feature_description_2}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-sm-6 offset-xl-1">
                    <div class="single-intro text-lg-left text-center">
                        <div class="text">
                            03
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{$page->feature_3}}</a></h4>
                            <p>{{$page->feature_description_3}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- choose us start -->

    <!-- about area start -->
    <div class="about-area pd-bottom-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="shape-image-list-wrap">
                        <div class="shape-image-list left-top">
                            <img class="shadow-img" src="{{meta($page, 'about_us_image', '/images/others/7.png')}}" alt="img">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="section-title pd-left mb-0">
                        <h5 class="sub-title">{{tran('site.about_us')}}</h5>
                        <h2 class="title">{{meta($page, 'about_us_title', 'We Are Dynamic Team And Business Agency')}}</h2>
                        <p>{{meta($page, 'about_us_description', 'We Are Dynamic Team And Business Agency')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- service area start -->
    <div class="service-area service-area-about mg-bottom-100 pb-xl-5 pd-0" style="background-image: url(/images/bg/5.png);">
        <div class="container">
            <div class="section-title">
                <h5 class="sub-title">{{tran('site.best_service')}}</h5>
                <h2 class="title">{{meta($page, 'best_service_title', '')}}</h2>
                <p>{{meta($page, 'best_service_description', '')}}</p>
            </div>
            <div class="service-slider-2 row pb-xl-5 pd-0">
                <div class="item">
                    <div class="single-intro text-center">
                        <div class="thumb">
                            <img src="{{meta($page, 'best_service_1_image', '/images/icons/19.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{meta($page, 'best_service_1_title', 'Marketing Analaysis')}}</a></h4>
                            <p>{{meta($page, 'best_service_1_description', 'Marketing Analaysis')}}</p>
                            @if(meta($page, 'best_service_1_link'))
                                <a class="btn" href="{{meta($page, 'best_service_1_link')}}">{{tran('site.read_more')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-intro text-center">
                        <div class="thumb">
                            <img src="{{meta($page, 'best_service_2_image', '/images/icons/20.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{meta($page, 'best_service_2_title', 'Business Consultancy')}}</a></h4>
                            <p>{{meta($page, 'best_service_2_description', 'Marketing Analaysis')}}</p>
                            @if(meta($page, 'best_service_2_link'))
                                <a class="btn" href="{{meta($page, 'best_service_2_link')}}">{{tran('site.read_more')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="single-intro text-center">
                        <div class="thumb">
                            <img src="{{meta($page, 'best_service_3_image', '/images/icons/21.png')}}" alt="img">
                        </div>
                        <div class="details">
                            <h4 class="title"><a href="#">{{meta($page, 'best_service_3_title', 'Business planing')}}</a></h4>
                            <p>{{meta($page, 'best_service_3_description', 'Marketing Analaysis')}}</p>
                            @if(meta($page, 'best_service_3_link'))
                                <a class="btn" href="{{meta($page, 'best_service_3_link')}}">{{tran('site.read_more')}}</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service area end -->

    <!-- team area start -->
    <div class="team-area bg-gray mg-top-70 pd-top-90 pd-bottom-70">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{tran('site.our_team')}}</h2>
            </div>
            <div class="row">
                {!! do_shortcode('[teams template="team"]') !!}
            </div>
        </div>
    </div>
    <!-- team area End -->

    <!-- client area start -->
    <div class="client-area pd-top-90 pd-bottom-100">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{tran('site.what_our_customers_are_saying')}}</h2>
            </div>
            {!! do_shortcode('[clients template="client"]') !!}
        </div>
    </div>
    <!-- client area end -->
@endsection
