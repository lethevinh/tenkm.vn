<ul class="navbar-nav menu-open">
    @if(isset($menu['children']))
        @foreach($menu['children'] as $item)
        @if(isset($item['children']))
            <li class="menu-item-has-children">
                <a>{{$item['title_lb']}}</a>
                <ul class="sub-menu">
                    @foreach($item['children'] as $sub)
                        @php $urlSub = (isset($sub['url_lb']) && strpos($sub['url_lb'], url('')) !== false) ? url($sub['url_lb']): $sub['url_lb']; @endphp
                        <li>
                            <a href="{{$urlSub}}">
                                {{$sub['title_lb']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
        <li >
            @php $url = (isset($item['url_lb']) && strpos($item['url_lb'], url('')) !== false) ? url($item['url_lb']): $item['url_lb']; @endphp
            <a href="{{$url}}">
                {{$item['title_lb']}}
            </a>
        </li>
        @endif
    @endforeach
    @endif
    @include('partials.language')
</ul>
