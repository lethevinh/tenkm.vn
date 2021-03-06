<!-- footer area start -->
<footer class="footer-area">
    <div class="container">
        <div class="footer-top">
            <div class="row">
                <div class="col-sm-4">
                    <a class="footer-logo" href="{{route('home.show')}}">
                        <img src="{{url('images/footer-logo.png')}}" alt="logo footer">
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
                        <x-menu name="residential-property"></x-menu>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_nav_menu">
                        <x-menu name="commercial-property"></x-menu>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="widget widget_nav_menu">
                        <x-menu name="about-tenkm"></x-menu>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <form class="widget widget-subscribe" action="{{route('home.doSubscribe')}}" method="POST">
                        @csrf
                        <div class="rld-single-input">
                            <input placeholder="{{__('site.full_name')}}" value="{{old('name')}}" type="text"
                                   class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name">
                            <!-- Error -->
                            @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                            <input placeholder="{{__('site.email')}}" value="{{old('email')}}" type="email"
                                   class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email"
                                   id="email">

                            @if ($errors->has('email'))
                                <div class="error">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-yellow w-100">{{__('site.subscribe')}}</button>
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
