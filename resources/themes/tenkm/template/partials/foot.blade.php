<!-- External JavaScripts
============================================= -->
{{--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSEmb9tdwZ-cyugwdeGxcaMc0gmcWwlE0" async defer></script>--}}
{{--<script src="/js/manifest.js"></script>--}}
{{--<script src="/js/vendor.js"></script>--}}
{{--<script src="/js/theme.js"></script>--}}

<script src="{{ mix('js/main.js') }}"></script>
<script src="{{ mix('js/search.js') }}"></script>
<script src="{{ mix('js/theme.js') }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('admin.map.keys.google')}}&libraries=&v=weekly&callback=initGoogleMap" async defer></script>
