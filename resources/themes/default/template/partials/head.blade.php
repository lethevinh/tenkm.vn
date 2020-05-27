<!-- Stylesheets
	============================================= -->
<!-- CSS Plugins -->
<link href="/css/lightbox.css" rel="stylesheet">
<link href="/css/ionicons.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/css/owl.carousel.min.css">
<link rel="stylesheet" href="/css/owl.theme.default.min.css">
<link rel="stylesheet" href="/css/aos.css">
{{--<link rel="stylesheet" href="/css/videojs.css">--}}
@if (Auth::check())
    <script>
        window.edureal = {!!json_encode([
               'isLoggedin' => true,
               'isAdminLogin' => !empty(Admin::user()),
               'user' => Auth::user()->toInfo(),
           ])!!}
    </script>
@else
    <script>
        window.edureal = {!!json_encode([
                'isLoggedin' => false,
                'isAdminLogin' => !empty(Admin::user()),
            ])!!}
    </script>
@endif
<!-- CSS Global -->
{{--<link href="{{ mix('css/theme.css') }}" rel="stylesheet">--}}
<link href="{{ mix('css/edureal.css') }}" rel="stylesheet">
<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml            : true,
            version          : 'v7.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!-- Your customer chat code -->
<div class="fb-customerchat"
     attribution=setup_tool
     page_id="{{option('facebook_page_id', '471465743587728')}}"
     logged_in_greeting="Xin chào !  Chúng tôi có thể giúp gì cho bạn ?"
     logged_out_greeting="Xin chào !  Chúng tôi có thể giúp gì cho bạn ?">
</div>
