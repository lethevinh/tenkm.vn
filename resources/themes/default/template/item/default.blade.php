<div class="col-sm-6 col-md-4">
    <div class="blog__item">
        <div class="blog-item__img">
            <img src="{{$post->thumbnail}}" class="img-responsive" alt="{{$post->title_lb}}">
        </div>
        <div class="blog-item__tags">
            <i class="ion-ios-pricetags" aria-hidden="true"></i>
            @foreach($post->tags as $tag)
                @if($loop->index < 2)
                    <a href="{{$tag->link}}">#{{$tag->title_lb}}</a>
                @endif
            @endforeach
        </div>
        <div class="blog-item__content">
            <div class="blog-item__date">
                <i class="ion-calendar" aria-hidden="true"></i> {{$post->created_at->format('H:i d/m/Y')}}
            </div>
            <div class="blog-item__title">
                <h3>{{$post->title_lb}}</h3>
            </div>
            <div class="blog-item__info">
                <ul class="item-info__list">
                    <li class="info-list__item"><i class="ion-android-person" aria-hidden="true"></i> by {{$post->creator->name}}</li>
                    <li class="info-list__item"><i class="ion-android-chat" aria-hidden="true"></i> {{$post->comments->count()}}</li>
                    <li class="info-list__item"><i class="ion-heart" aria-hidden="true"></i> 246</li>
                </ul>
            </div>
            <div class="blog-item__text">
                {{Str::of($post->description_lb)->limit(200, ' (...)')}}
            </div>
            <div class="blog-item__link">
                <a href="{{$post->link}}">{{__('site.read_more')}} <i class="ion-android-arrow-forward" aria-hidden="true"></i></a>
            </div>
            <ul class="blog-item__share">
                <li>Share: </li>
                <li><a href="https://twitter.com/intent/tweet?text={{$post->title_lb}}&url={{$post->title_lb}}"><i class="ion-social-twitter"></i></a></li>
                <li><a href="https://www.facebook.com/sharer.php?u={{$post->link}}"><i class="ion-social-facebook"></i></a></li>
                <li><a href=""><i class="ion-social-googleplus"></i></a></li>
            </ul>
        </div> <!-- / .blog-item__content -->
    </div> <!-- / .blog__item -->
</div>
