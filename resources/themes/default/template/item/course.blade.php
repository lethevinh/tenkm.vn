<div class="course__item">
    <div class="course-item__img">
        <img src="{{$course->thumbnail}}" class="img-responsive" alt="...">
    </div>
    <div class="course-item__info">
        <div class="info__students">
            {{--<i class="ion-person-stalker" aria-hidden="true"></i> 53/120--}}
        </div>
        <div class="info__price">
            <i class="ion-ios-pricetags" aria-hidden="true"></i>
            {{$course->price}}
        </div>
    </div>
    <div class="course-item__content">
        @foreach($course->categories as $category)
            <span class="course-item__branch">{{$category->title_lb}}</span>
        @endforeach
        <h3>
            <a href="{{$course->link}}">{{$course->title_lb}}</a>
        </h3>
        <p class="course-item__desc">
            {{Str::of($course->description_lb)->limit(200, ' (...)')}}
        </p>
        <a class="btn btn-primary" href="{{$course->link}}">{{__('site.course.read_more')}}</a>
    </div> <!-- .teacher-course__content -->
</div> <!-- .course__item -->
