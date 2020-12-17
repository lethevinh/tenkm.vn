<div class="single-news">
    <div class="thumb">
        <img src="{{$post->thumbnail}}" alt="{{$post->title_lb}}">
    </div>
    <div class="details">
        <h4><a href="{{$post->link}}">{{$post->title_lb}}</a></h4>
        <p>{{Str::of($post->description_lb)->limit(200, ' (...)')}}</p>
        <div class="author">
            <img class="rounded-circle" src="{{url('storage/'.$post->creator->avatar)}}" alt="{{$post->title_lb}}">
            <span>{{tran('site.by')}} {{$post->creator->name}}</span>
            <span class="date">{{$post->created_at->diffForHumans()}}</span>
        </div>
    </div>
</div>
