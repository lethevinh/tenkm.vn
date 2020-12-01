<!-- Stylesheets
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
<link href="{{ mix('css/theme.css') }}" rel="stylesheet">
@include('partials/social')
