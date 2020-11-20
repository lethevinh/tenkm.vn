<!-- footer area start -->
<footer class="footer-area">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-sm-4">
                    <a class="footer-logo" href="{{route('home.show')}}">
                        <img src="{{url(option('logo'))}}" alt="logo">
                    </a>
                </div>
                <div class="col-sm-8">
                    <div class="footer-social text-sm-right">
                        <span>{{trans('site.follow_us')}}</span>
                        <ul class="social-icon">
                            <li>
                                <a href="{{option('facebook')}}" target="_blank"><i class="fa fa-facebook  "></i></a>
                            </li>
                            <li>
                                <a href="{{option('twitter')}}" target="_blank"><i class="fa fa-twitter  "></i></a>
                            </li>
                            <li>
                                <a href="{{option('linkedin')}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_nav_menu">
                        <h4 class="widget-title">{{__('site.residential_property')}}</h4>
                        <x-menu name="residential_property"></x-menu>
                        <ul>
                            <li><a href="index.html">Apartment for Rent</a></li>
                            <li><a href="about.html">Apartment Low to hide</a></li>
                            <li><a href="#">Offices for Buy</a></li>
                            <li><a href="#">Offices for Rent</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_nav_menu">
                        <h4 class="widget-title">{{__('site.commercial_property')}}</h4>
                        <x-menu name="commercial_property"></x-menu>
                        <ul>
                            <li><a href="index.html">Los Angeles Offices</a></li>
                            <li><a href="about.html">Las Vegas Apartment</a></li>
                            <li><a href="#">Sacramento Townhome</a></li>
                            <li><a href="#">San Francisco Offices</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_nav_menu">
                        <h4 class="widget-title">{{__('site.about_tenkm')}}</h4>
                        <x-menu name="about_tenkm"></x-menu>
                        <ul>
                            <li><a href="index.html">Pricing Plans</a></li>
                            <li><a href="about.html">Our Services</a></li>
                            <li><a href="#">About Us</a></li>
                            <li><a href="#">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <form class="widget widget-subscribe">
                        <div class="rld-single-input">
                            <input type="text" placeholder="Full Name">
                        </div>
                        <div class="rld-single-input">
                            <input type="text" placeholder="Your@email.com">
                        </div>
                        <button class="btn btn-yellow w-100">Subscribe</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="copy-right text-center">
          {{option('name')}}  {{date('Y')}} All rights reserved.
        </div>
    </div>
</footer>
<!-- footer area end -->

<!-- back to top area start -->
<div class="back-to-top">
    <span class="back-top"><i class="fa fa-angle-up"></i></span>
</div>
<!-- back to top area end -->
