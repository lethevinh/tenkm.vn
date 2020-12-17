<div class="courses_item__wrapper">
    <div class="courses__item">
        <div class="card__top">
            <p class="card__nbr">0{{$loop->index + 1}}.</p>
            <div class="courses__icon courses_icon-1">
                <i class="ion-ios-timer-outline"></i>
            </div>
            <div class="courses__title">
                {{$course->title_lb}}
            </div>
            <p class="courses__desc">
                {{Str::of($course->description_lb)->limit(200, ' (...)')}}
            </p>
        </div> <!-- / .card__top -->
        <div class="card__back">
            <div class="card_back__wrapper">
                <div class="courses__title">
                    Training
                </div>
                <ul class="course__info">
                    <li><i class="ion-calendar course-calendar" aria-hidden="true"></i>
                        {{$course->created_at->format('d/m/Y')}}
                    </li>
                    <li>Rating:
                        <i class="ion-android-star rating-star" aria-hidden="true"></i>
                        <i class="ion-android-star rating-star" aria-hidden="true"></i>
                        <i class="ion-android-star rating-star" aria-hidden="true"></i>
                        <i class="ion-android-star rating-star" aria-hidden="true"></i>
                        <i class="ion-android-star rating-star" aria-hidden="true"></i>
                    </li>
                    <li>{{tran('site.course.price')}}: <span> {{$course->price}}</span></li>
                    <li>{{tran('site.teacher')}}: <span> {{$course->firstTeacher()->name?? ''}}</span></li>
                </ul> <!-- / .course__info -->
                <a href="{{$course->link}}" class="btn btn-primary text-center">{{tran('site.read_more')}}</a>
            </div> <!-- / .card_back__wrapper -->
        </div> <!-- / .card__back -->
    </div> <!-- / .courses__item -->
</div> <!-- / .courses_item__wrapper -->
