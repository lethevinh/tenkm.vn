@extends('layouts.full')
@section('content')


    <!-- banner area start -->
    <div class="banner-area jarallax" style="background-image: url(/images/bg/3.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-10">
                    <div class="banner-inner-wrap">
                        <div class="banner-inner w-100">
                            <h1 class="title">{{__('site.real_estate_agent_near_you')}}</h1>
                            <p class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br> Aenean vel eros quam. Sed sit amet dictum est</p>
                            <div class="rld-banner-search">
                                <div class="rld-single-input left-icon">
                                    <input type="text" placeholder="{{__('site.find_property')}}">
                                    <button class="btn">{{__('site.search_now')}}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-6 d-lg-block d-none">
                    <div class="thumb-wrap">
                        <img src="/images/banner/2.png" alt="img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner area end -->

    <!-- feature area start -->
    [products template="product-featured" limit="7"]
    <!-- feature area end -->

    <!-- dream area end -->
    <div class="follow-dream-area pd-top-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="thumb mb-4 mb-lg-0">
                        <img src="/images/others/1.jpg" alt="img">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="section-title">
                        <h3 class="title inner-title">Follow steps make dream</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla dui nibh, idhendrerit tellus rhoncus sit amet</p>
                    </div>
                    <div class="single-follow-dream media">
                        <div class="media-left">
                            <i class="fa fa-user-o"></i>
                        </div>
                        <div class="media-body">
                            <h4>Get a link from your agent</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel eros quam. Sed sit amet dictum est, at fringilla enim Praesent. </p>
                        </div>
                    </div>
                    <div class="single-follow-dream media">
                        <div class="media-left">
                            <i class="fa fa-desktop"></i>
                        </div>
                        <div class="media-body">
                            <h4>Star your Membership</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel eros quam. Sed sit amet dictum est, at fringilla enim Praesent. </p>
                        </div>
                    </div>
                    <div class="single-follow-dream media mb-0">
                        <div class="media-left">
                            <i class="fa fa-home"></i>
                        </div>
                        <div class="media-body">
                            <h4>Enjoy your New Home</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean vel eros quam. Sed sit amet dictum est, at fringilla enim Praesent. </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- dream area end -->

    <!-- Properties area start -->
    [products template="product-popular" limit="8"]
    <!-- feature Properties area end -->

    <!-- team area start -->
    <div class="team-area pd-top-70">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{__('site.our_team')}}</h2>
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
                <h2 class="title">{{__('site.what_our_customers_are_saying')}}</h2>
            </div>
            <div class="client-review-img">
                <img class="clr-img clr-img1" src="/images/client/5.png" alt="client">
                <img class="clr-img clr-img2" src="/images/client/6.png" alt="client">
                <img class="clr-img clr-img3" src="/images/client/7.png" alt="client">
                <img class="clr-img clr-img4" src="/images/client/8.png" alt="client">
                <img class="clr-img clr-img5" src="/images/client/9.png" alt="client">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-7 col-md-10">
                        <div class="client-slider-2 text-center">
                            <div class="item">
                                <div class="single-client-review">
                                    <div class="thumb">
                                        <img src="/images/client/5.png" alt="client">
                                    </div>
                                    <div class="review-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla dui nibh, idhendrerit tellus rhoncus sit amet. Suspendisse semper, inrhoncus nulla consectetur,sem erat accumsan lacus, et nulla diam eu turpis. </p>
                                        <h4>Varun Vachhar</h4>
                                        <p>Land Owner</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="single-client-review">
                                    <div class="thumb">
                                        <img src="/images/client/6.png" alt="client">
                                    </div>
                                    <div class="review-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla dui nibh, idhendrerit tellus rhoncus sit amet. Suspendisse semper, inrhoncus nulla consectetur,sem erat accumsan lacus, et nulla diam eu turpis. </p>
                                        <h4>Tayla Elias</h4>
                                        <p>Land Owner</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="single-client-review">
                                    <div class="thumb">
                                        <img src="/images/client/7.png" alt="client">
                                    </div>
                                    <div class="review-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla dui nibh, idhendrerit tellus rhoncus sit amet. Suspendisse semper, inrhoncus nulla consectetur,sem erat accumsan lacus, et nulla diam eu turpis. </p>
                                        <h4>Luca Inwood</h4>
                                        <p>Land Owner</p>
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="single-client-review">
                                    <div class="thumb">
                                        <img src="/images/client/8.png" alt="client">
                                    </div>
                                    <div class="review-details">
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean fringilla dui nibh, idhendrerit tellus rhoncus sit amet. Suspendisse semper, inrhoncus nulla consectetur,sem erat accumsan lacus, et nulla diam eu turpis. </p>
                                        <h4>George Kavel</h4>
                                        <p>Land Owner</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client area start -->

    <!-- client area start -->
    <div class="client-area pd-top-92 pd-bottom-100">
        <div class="container">
            <div class="section-title text-center">
                <h2 class="title">{{__('site.our_partner')}}</h2>
            </div>
            <div class="client-slider">
                <div class="item">
                    <div class="thumb">
                        <img src="/images/client/1.png" alt="client">
                    </div>
                </div>
                <div class="item">
                    <div class="thumb">
                        <img src="/images/client/2.png" alt="client">
                    </div>
                </div>
                <div class="item">
                    <div class="thumb">
                        <img src="/images/client/3.png" alt="client">
                    </div>
                </div>
                <div class="item">
                    <div class="thumb">
                        <img src="/images/client/4.png" alt="client">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- client area end -->

@endsection
