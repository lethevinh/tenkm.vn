@extends('layouts.full')
@section('content')


    <!-- banner area start -->
    <div class="banner-area jarallax" style="background-image: url(/images/bg/3.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-10">
                    <div class="banner-inner-wrap">
                        <div class="banner-inner w-100">
                            <h1 class="title">{{$page->slogan}}</h1>
                            <p class="content">
                                {{$page->slogan_text}}
                            </p>
                            <div class="rld-banner-search">
                                <div class="rld-single-input left-icon">
                                    <form action="{{route('product.search')}}">
                                        <input type="text" name="s"  placeholder="{{tran('site.find_property')}}">
                                        <button type="submit" class="btn">{{tran('site.search_now')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 d-lg-block d-none">
                    <div class="thumb-wrap">
                        <img
                            src="{{$page->agent_image && $page->agent_image !='null'?$page->agent_image:'/images/banner/2.png'}}"
                            alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner area end -->

    <!-- feature area start -->
    [products template="product-rent" category="nha-dat-cho-thue" limit="7"]
    <!-- feature area end -->

    <!-- dream area end -->
    <div class="follow-dream-area pd-top-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumb mb-4 mb-lg-0">
                        <img src="{{meta($page, 'follow_dream_image', '/images/others/1.jpg')}}" alt="img">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="section-title">
                        <h3 class="title inner-title">{{ meta($page, 'follow_dream_title', 'Follow steps make dream') }}</h3>
                        <p>{{ meta($page, 'follow_dream_description', 'Follow steps make dream') }}</p>
                    </div>
                    <div class="single-follow-dream media">
                        <div class="media-left">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <div class="media-body">
                            <h4>{{meta($page, 'follow_dream_1_title', 'Get a link from your agent')}}</h4>
                            <p>{!! meta($page, 'follow_dream_1_description', 'Get a link from your agent') !!}</p>
                        </div>
                    </div>
                    <div class="single-follow-dream media">
                        <div class="media-left">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="media-body">
                            <h4>{{meta($page, 'follow_dream_2_title', 'Star your Membership')}}</h4>
                            <p>{!! meta($page, 'follow_dream_2_description', 'Star your Membership') !!}</p>
                        </div>
                    </div>
                    <div class="single-follow-dream media mb-0">
                        <div class="media-left">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="media-body">
                            <h4>{{meta($page, 'follow_dream_3_title', 'Enjoy your New Home')}}</h4>
                            <p>{!! meta($page, 'gfollow_dream_3_description', 'Enjoy your New Home') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- dream area end -->

    <!-- Properties area start -->
    [products template="product-sell" category="nha-dat-ban" limit="8"]
    <!-- feature Properties area end -->

    <!-- team area start -->
    <div class="team-area pd-top-70">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{tran('site.our_team')}}</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="/images/team/1.png" alt="team">
                        </div>
                        <div class="team-details">
                            <h4>Louis Rowley</h4>
                            <span>Co-Founder</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="/images/team/2.png" alt="team">
                        </div>
                        <div class="team-details">
                            <h4>Riley Moss</h4>
                            <span>Developer</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="/images/team/3.png" alt="team">
                        </div>
                        <div class="team-details">
                            <h4>Max Gotch</h4>
                            <span>Founder</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-team">
                        <div class="thumb">
                            <img src="/images/team/4.png" alt="team">
                        </div>
                        <div class="team-details">
                            <h4>Jamie Coal</h4>
                            <span>Manager</span>
                            <ul>
                                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- team area End -->

    <!-- client area start -->
    <div class="client-area pd-top-60">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{tran('site.what_our_customers_are_saying')}}</h2>
            </div>
            [clients template="client"]
        </div>
    </div>
    <!-- client area start -->

    <!-- client area start -->
    <div class="client-area pd-top-92 pd-bottom-100">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{tran('site.our_partner')}}</h2>
            </div>
            [partners template="partner"]
        </div>
    </div>
    <!-- client area end -->

@endsection
