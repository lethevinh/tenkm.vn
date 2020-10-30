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
                            <h3><span>{{$project->priceSale}}</span> {{$project->title_lb}}</h3>
                            <h4><span>{{$project->address}}</span></h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4">
                        <div class="widget widget-owner-info mt-lg-0 mt-5">
                            <div class="owner-info text-center">
                                <div class="thumb">
                                    <img src="/images/news/21.png" alt="img">
                                </div>
                                <div class="details">
                                    <h6>Jesse Edwards</h6>
                                    <span class="designation">Building Owner</span>
                                    <p class="reviews"><i class="fa fa-star"></i><span>4.8</span> 70 Review</p>
                                </div>
                            </div>
                            <div class="contact">
                                <h6>Contact Us</h6>
                                <div class="rld-single-input">
                                    <input type="text" placeholder="Full Name">
                                </div>
                                <div class="rld-single-input">
                                    <input type="text" placeholder="Email">
                                </div>
                                <div class="rld-single-input">
                                    <input type="text" placeholder="Messages">
                                </div>
                                <a class="btn btn-yellow" href="#">Send Messages</a>
                            </div>
                            <div class="contact-info">
                                <h6 class="mb-3">Contact Info</h6>
                                <div class="media">
                                    <div class="media-left">
                                        <img src="/images/icons/1.png" alt="img">
                                    </div>
                                    <div class="media-body">
                                        <p>Address</p>
                                        <span>Long Island, NY 11355, USA</span>
                                    </div>
                                </div>
                                <div class="media">
                                    <div class="media-left">
                                        <i class="fa fa-phone"></i>
                                    </div>
                                    <div class="media-body">
                                        <p>Phone</p>
                                        <span>+00 111 222 333</span>
                                    </div>
                                </div>
                                <div class="media mb-0">
                                    <div class="media-left">
                                        <i class="fa fa-envelope"></i>
                                    </div>
                                    <div class="media-body">
                                        <p>Email</p>
                                        <span>info@example.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                                    <p><i class="fa fa-handshake-o"></i>{{$project->delivery_time}}</p>
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
                        <p>{{$project->description_lb}}</p>
                        <a href="#">Read More</a>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow mb-0">
                        <h4>3D Gallery</h4>
                        <div class="thumb">
                            <img src="{{$project->gallary3D}}" alt="img">
                        </div>
                    </div>
                    <div class="property-news-single-card border-bottom-yellow">
                        <h4>{{trans('site.amenities')}}</h4>
                        <div class="row">
                            <div class="col-sm-4">
                                <ul class="rld-list-style mb-3 mb-sm-0">
                                    @foreach($project->amenities as $amenity)
                                        <li><i class="fa fa-check"></i> {{$amenity->title_lb}}</li>
                                    @endforeach
                                    <li><i class="fa fa-check"></i> Attic</li>
                                    <li><i class="fa fa-check"></i> Poll</li>
                                    <li><i class="fa fa-check"></i> Concierge</li>
                                    <li><i class="fa fa-check"></i> Basketball Cout</li>
                                    <li><i class="fa fa-check"></i> Sprinklers</li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="rld-list-style mb-3 mb-sm-0">
                                    <li><i class="fa fa-check"></i> Recreation</li>
                                    <li><i class="fa fa-check"></i> Front Yard</li>
                                    <li><i class="fa fa-check"></i> Wine Cellar</li>
                                    <li><i class="fa fa-check"></i> Basketball Cout</li>
                                    <li><i class="fa fa-check"></i> Fireplace</li>
                                </ul>
                            </div>
                            <div class="col-sm-4">
                                <ul class="rld-list-style mb-3 mb-sm-0">
                                    <li><i class="fa fa-check"></i> Balcony</li>
                                    <li><i class="fa fa-check"></i> Pound</li>
                                    <li><i class="fa fa-check"></i> Deck</li>
                                    <li><i class="fa fa-check"></i> 24x7 Security</li>
                                    <li><i class="fa fa-check"></i> Indoor Game</li>
                                </ul>
                            </div>
                        </div>
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
