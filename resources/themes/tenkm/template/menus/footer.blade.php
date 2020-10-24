<ul class="quick__links">
    @foreach($menu->children as $item)
        <li><a href="{{$item->url_lb}}">{{$item->title_lb}}</a></li>
    @endforeach
</ul>
