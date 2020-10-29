<div class="item">
    <a href="{{$post->link}}" class="media single-popular-post">
        <div class="media-left">
            <img style="width: 62px" width="62" height="61" src="{{resize($post->thumbnail, 62,61)}}" alt="news">
        </div>
        <div class="media-body">
            <h6>{{$post->title_lb}}</h6>
            <span>{{$post->created_at->format('H:i d/m/Y')}}</span>
        </div>
    </a>
</div>
