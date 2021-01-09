<!-- footer area start -->
@php $locale = session()->get('locale', 'vi'); @endphp
<footer class="footer-area @if($locale == 'vi') footer-area style-two @endif">
    <div class="container">
        @if($locale == 'vi')
        <div class="subscribe-area">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2 style="color: black">{{option('subscribe_title')}}</h2>
                    <p>{{option('subscribe_description')}}</p>
                    <div class="rld-single-input">
                        <input type="text" placeholder="{{tran('site.email')}}">
                        <button class="btn">{{tran('site.submit_now')}}</button>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="footer-top">
            <div class="row">
                <div class="col-sm-4">
                    <a class="footer-logo" href="{{route('home.show')}}">
                        <img src="{{url('images/footer-logo.png')}}" alt="logo footer">
                    </a>
                </div>
                <div class="col-sm-8">
                    <div class="footer-social text-sm-right">
                        <span>{{tran('site.follow_us')}}</span>
                        <ul class="social-icon">
                            <li>
                                <a href="{{option('facebook')}}" target="_blank"><i class="fa fa-facebook  "></i></a>
                            </li>
                            <li>
                                <a href="{{option('youtube')}}" target="_blank"><i class="fa fa-youtube  "></i></a>
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
                            <input placeholder="{{tran('site.form_name')}}" value="{{old('name')}}" type="text"
                                   class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name">
                            <!-- Error -->
                            @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                            <input placeholder="{{tran('site.form_phone')}}" value="{{old('email')}}"
                                   class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email"
                                   id="email">

                            @if ($errors->has('email'))
                                <div class="error">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <button class="btn btn-yellow w-100">{{tran('site.form_subscribe')}}</button>
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
