<h4 class="widget-title">{{$menu->title_lb}}</h4>
<ul>
    @foreach($menu->children()->orderBy('order_nb')->get() as $item)
        <li @if($item->current()) class="current-menu-item" @endif>
            <a href="{{$item->url_lb}}">
                {{$item->title_lb}}
            </a>
        </li>
    @endforeach
</ul>
