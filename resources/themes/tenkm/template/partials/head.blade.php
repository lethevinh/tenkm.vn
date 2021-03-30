<!-- Stylesheets -->
@if (Auth::check())
    <script>
        window.tenkm = {!!json_encode([
               'locale' => session()->get('locale', config('site.locale_default')),
               'isLoggedin' => true,
               'isAdminLogin' => !empty(Admin::user()),
               'user' => Auth::user()->toInfo(),
               'searchOption' => isset($option)?$option:[]
           ])!!}
    </script>
@else
    <script>
        window.tenkm = {!!json_encode([
	            'locale' => session()->get('locale', config('site.locale_default')),
                'isLoggedin' => false,
                'isAdminLogin' => !empty(Admin::user()),
                 'searchOption' => isset($option)?$option:[]
            ])!!}
    </script>
@endif
<!-- CSS Global -->
<link href="{{ mix('css/theme.css') }}" rel="stylesheet">
@include('partials/social')
