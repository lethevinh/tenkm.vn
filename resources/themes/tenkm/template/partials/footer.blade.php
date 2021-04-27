<!-- footer area start -->
@php $locale = session()->get('locale', 'vi'); @endphp
<footer class="footer-area">
    <div class="container">
        <div class="subscribe-area">
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-9 text-center">
                    <h2 style="color: black">{{option('subscribe_title')}}</h2>
                    <p>{{option('subscribe_description')}}</p>
                    <div class="rld-single-input">
                        <form action="{{ route('home.doRegister') }}" method="POST" >
                            @csrf
                            <input placeholder="{{tran('site.email')}}" value="{{old('register_email')}}" type="register_email"
                                   class="{{ $errors->has('register_email') ? 'error' : '' }}" name="register_email"
                                   id="register_email">

                            @if ($errors->has('register_email'))
                                <div class="error">
                                    {{ $errors->first('register_email') }}
                                </div>
                            @endif
                            <button class="btn">{{tran('site.submit_now')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                            <input placeholder="{{tran('site.form_name')}}" value="{{old('subscribe_name')}}" type="text"
                                   class="form-control {{ $errors->has('subscribe_name') ? 'error' : '' }}" name="subscribe_name"
                                   id="subscribe_name">
                            <!-- Error -->
                            @if ($errors->has('subscribe_name'))
                                <div class="error">
                                    {{ $errors->first('subscribe_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                            <input placeholder="{{tran('site.form_phone')}}" value="{{old('subscribe_phone')}}"
                                   class="form-control {{ $errors->has('subscribe_phone') ? 'error' : '' }}" name="subscribe_phone"
                                   id="subscribe_phone">

                            @if ($errors->has('subscribe_phone'))
                                <div class="error">
                                    {{ $errors->first('subscribe_phone') }}
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
@if(Session::has('subscribe_success'))
    <div class="alert alert-success">
        <div class="modal fade" id="thankModalSubscribe" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        {{Session::get('subscribe_success')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{tran('site.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function (){
                $('#thankModalSubscribe').modal();
            });
        </script>
    </div>
@endif
@if(Session::has('register_success'))
    <div class="alert alert-success">
        <div class="modal fade" id="thankModalRegister" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        {{Session::get('register_success')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{tran('site.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function (){
                $('#thankModalRegister').modal();
            });
        </script>
    </div>
@endif
@if(Session::has('subscribe_product_success'))
    <div class="alert alert-success">
        <div class="modal fade" id="thankModalSubscribeProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        {{Session::get('subscribe_product_success')}}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{tran('site.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function (){
                $('#thankModalSubscribeProduct').modal();
            });
        </script>
    </div>
@endif
