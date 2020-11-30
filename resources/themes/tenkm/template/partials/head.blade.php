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
<script src="https://maps.googleapis.com/maps/api/js?key={{config('admin.map.keys.google')}}&libraries=&v=weekly" async defer></script>
@include('partials/social')
