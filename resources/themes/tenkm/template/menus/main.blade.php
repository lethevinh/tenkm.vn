<ul class="navbar-nav menu-open">
    @if(isset($menu['children']))
        @foreach($menu['children'] as $item)
        @if(isset($item['children']))
            <li class="menu-item-has-children">
                <a>{{$item['title_lb']}}</a>
                <ul class="sub-menu">
                    @foreach($item['children'] as $sub)
                        <li>
                            <a href="{{$sub['url_lb']}}">
                                {{$sub['title_lb']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
        <li >
            <a href="{{$item['url_lb']}}">
                {{$item['title_lb']}}
            </a>
        </li>
        @endif
    @endforeach
    @endif
    @include('partials.language')
</ul>
