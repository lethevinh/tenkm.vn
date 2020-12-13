@if(count($categories) > 0)
    @foreach($categories as $cat )
        <li><a href="{{$cat->link}}">{{ $cat->title_lb }}</a></li>
    @endforeach
@endif

