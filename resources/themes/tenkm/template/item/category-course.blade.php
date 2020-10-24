<div class="col-sm-6 col-md-3">
    <div class="courses_item__wrapper category_item_course">
        <div class="courses__item">
            <div class="card__top">
                <div class="courses__icon courses_icon-1">
                    <i class="ion-ios-cloud-download-outline"></i>
                </div>
                <div class="courses__title">
                    {{$category->title_lb}}
                </div>
                <p class="courses__desc">
                    {{Str::of($category->description_lb)->limit(200, ' (...)')}}
                </p>
            </div> <!-- / .card__top -->
            <div class="card__back">
                <div class="card_back__wrapper">
                    <div class="courses__title">
                        Big Course
                    </div>
                    <ul class="course__info">
                        <li>Rating:
                            <i class="ion-android-star rating-star" aria-hidden="true"></i>
                            <i class="ion-android-star rating-star" aria-hidden="true"></i>
                            <i class="ion-android-star rating-star" aria-hidden="true"></i>
                            <i class="ion-android-star rating-star" aria-hidden="true"></i>
                            <i class="ion-android-star rating-star" aria-hidden="true"></i>
                        <li>Course: <span>15</span></li>
                    </ul> <!-- / .course__info -->
                    <a href="{{$category->linkCourse}}" class="btn btn-primary text-center">Category page</a>
                </div> <!-- / .card_back__wrapper -->
            </div> <!-- / .card__back -->
        </div> <!-- / .courses__item -->
    </div> <!-- / .courses_item__wrapper -->
</div>
