<h4 class="widget-title">{{$menu['title_lb']}}</h4>
<ul>
    @foreach($menu['children'] as $item)
        <li>
            <a href="{{$item['url_lb']}}">
                {{$item['title_lb']}}
            </a>
        </li>
    @endforeach
</ul>
