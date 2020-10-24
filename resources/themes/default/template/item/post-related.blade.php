<div class="related_post__item">
    <a href="{{$post->link}}" class="related_post__img">
        <img src="{{resize($post->image_lb, 320, 213)}}" class="img-responsive" alt="...">

    </a>
    <div class="related_post__content">
        <h3><a href="{{$post->link}}">{{$post->title_lb}}</a></h3>
        <span class="post-date">{{$post->created_at->format('H:s d/m/Y')}}</span>
    </div>
</div>
