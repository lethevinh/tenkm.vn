<ul class="quick__links">
    @foreach($menu->children as $item)
        @php $url = (isset($item) && strpos($item->url_lb, url('')) !== false) ? url($item->url_lb): $item->url_lb; @endphp
        <li><a href="{{$url}}">{{$item->title_lb}}</a></li>
    @endforeach
</ul>
