@php $locale = session()->get('locale', 'vi'); @endphp
<li class="menu-item-has-children">
    <a href="#">
        <img src="{{asset('images/icons/'.$locale.'.svg')}}" width="30px" height="20x" alt=""> {{trans('site.'.$locale)}}
    </a>
    <ul class="sub-menu">
        @foreach(config('site.locales', ['vi']) as $locale)
            <li>
                <a href="{{route('lang', ['locale' => $locale])}}">
                    <img src="{{asset('images/icons/'.$locale.'.svg')}}" width="30px" height="20x" alt=""/>
                    {{__('site.'.$locale)}}
                </a>
            </li>
        @endforeach
    </ul>
</li>
