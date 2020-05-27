<div class="col-sm-6 col-md-3">
    <div class="teacher__item">
        <div class="teacher__info">
            <div class="teacher__name">
                {{$teacher->name}}
            </div>
            <div class="teacher__prof">
                @foreach($teacher->categories as $category)
                    {{$category->title_lb}} @if (!$loop->last) / @endif
                @endforeach
            </div>
        </div> <!-- / .teacher__info -->
        <div class="teacher__img">
            <img src="{{$teacher->image}}" class="img-responsive" alt="{{$teacher->name}}">
        </div>
        <div class="teacher_item__overlay">
            <p class="overlay__desc">
                {{Str::of($teacher->description)->limit(200, ' (...)')}}
            </p>
            <ul class="overlay__social">
                <li><a href="{{$teacher->twitter}}"><i class="ion-social-twitter"></i></a></li>
                <li><a href="{{$teacher->facebook}}"><i class="ion-social-facebook"></i></a></li>
                <li><a href="{{$teacher->skype}}"><i class="ion-social-skype"></i></a></li>
                <li><a href="{{$teacher->whatsapp}}"><i class="ion-social-whatsapp-outline"></i></a></li>
            </ul>
            <a href="{{$teacher->link}}" class="btn btn-accent">{{__('site.read_more')}}</a>
        </div> <!-- / .teacher_item__overlay -->
    </div> <!-- / .teacher__item -->
</div>
