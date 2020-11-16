<ul class="navbar-nav menu-open">
    @foreach($menu->children()->orderBy('order_nb')->get() as $item)
        @if($item->children->count() > 0)
            <li class="menu-item-has-children @if($item->current()) current-menu-item @endif" >
                <a>{{$item->title_lb}}</a>
                <ul class="sub-menu">
                    @foreach($item->children()->orderBy('order_nb')->get() as $sub)
                        <li @if($sub->current()) class="active" @endif>
                            <a href="{{$sub->url_lb}}">
                                {{$sub->title_lb}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @else
        <li @if($item->current()) class="current-menu-item" @endif>
            <a href="{{$item->url_lb}}">
                {{$item->title_lb}}
            </a>
        </li>
        @endif
    @endforeach
    @include('partials.language')
</ul>
