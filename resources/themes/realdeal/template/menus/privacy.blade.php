<ul class="footer-links__list">
    @foreach($menu->children as $item)
        <li><a href="{{$item->url_lb}}"><i class="ion-ios-arrow-forward"></i>{{$item->title_lb}}</a></li>
    @endforeach
</ul>
