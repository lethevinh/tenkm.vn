<h4 class="widget-title">{{$menu['title_lb']}}</h4>
@if(isset($menu['children']))
<ul>
    @foreach($menu['children'] as $item)
        @php $url = (isset($item) && strpos($item['url_lb'], url('')) !== false) ? url($item['url_lb']): $item['url_lb']; @endphp
        <li>
            <a href="{{$url}}">
                {{$item['title_lb']}}
            </a>
        </li>
    @endforeach
</ul>
@endif
