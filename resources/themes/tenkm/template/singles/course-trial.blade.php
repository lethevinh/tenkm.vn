@extends('layouts.full')
@section('title', $course->title_lb)
@section('id_body', 'course-single__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">
                        <!-- Heading -->
                        <h1 class="home__heading">
                            {{ __('site.course.index') }}  {{$course->title_lb}}
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            <li><a href="{{route('course.index')}}">{{ __('site.course.index') }}</a></li>
                            @if($course->categories->count() > 0 )
                                <li>
                                    <a href="{{$course->categories[0]->linkCourse}}">{{ $course->categories[0]->title_lb }}</a>
                                </li>
                            @endif
                            <li class="active">{{ __('site.course.index') }}</li>
                        </ol>
                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section course-single -->
    <section class="section__course-single">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-md-8">
                    <div class="course__body">
                        <div class="course__title">
                            {{$course->title_lb}}
                        </div>
                        <div class="course__posttime">
                            {{__('site.posted_on')}} {{$course->created_at->format('m:H d/m/Y')}}
                        </div>
                        <div class="course__img">
                            @if(strpos($course->triallink, 'youtube'))
                                <video id="course-player-trial"
                                       class="video-js vjs-default-skin vjs-16-9"
                                       controls
                                       width="750"
                                       height="499"
                                       data-setup='{ "techOrder": ["youtube"], "sources": [{ "type": "video/youtube", "src": "{{$course->triallink}}"}] }'
                                       data-course-id="{{$course->id}}"
                                       poster="{{$course->thumbnail}}">
                                </video>
                            @else
                                <video id="course-player-trial"
                                       class="video-js vjs-default-skin vjs-16-9"
                                       controls
                                       width="750"
                                       height="499"
                                       data-setup='{}'
                                       data-course-id="{{$course->id}}"
                                       poster="{{$course->thumbnail}}">
                                    <source src="{{$course->triallink}}" type="video/mp4"/>
                                </video>
                            @endif
                        </div>
                    </div> <!-- .course__body -->
                </div>
                <div class="col-sm-5 col-md-4">
                    <div class="course__sidebar">
                        <div class="sidebar__item">
                            <div class="course__price f-uppercase">
                                {{__('site.course.price')}} : <span>{{$course->price}}</span>
                            </div>
                            <ul class="course_features__list">
                                <li><i class="ion-ios-timer"></i>
                                    Thời gian : <span>{{ date('d/m/Y', strtotime($course->published_at))}} -- {{ date('d/m/Y', strtotime($course->validated_at))}}</span>
                                </li>
                                <li><i class="ion-ios-game-controller-b"></i>
                                    Yêu cầu trình độ: <span>Người mới học</span>
                                </li>
                                <li><i class="ion-volume-high"></i> {{__('site.language')}}: <span>{{config('vi-admin.languages.'.$course->language_lb)}}</span></li>
                                <li><i class="ion-document-text"></i> {{__('admin.documentation')}} : <span>1</span></li>
                                <li><i class="ion-ios-bookmarks"></i> {{__('admin.lecture')}} : <span>{{$course->lectures->count() +  1}}</span></li>
                                <li><i class="ion-videocamera"></i> Video: <span> {{$course->lectures->count()}}</span></li>
                                <li><i class="ion-ribbon-b"></i> {{__('admin.certificate')}}: <span>Có</span></li>
                            </ul>
                            <div class="row">
                                <div class="col-sm-10">
                                    @if(Auth::check())
                                        @if($course->userableStatus(Auth::user()) === 'passed')
                                            <a href="{{$course->linkLearn}}" class="btn btn-block btn-course">
                                                Học Lại
                                            </a>
                                        @elseif($course->userableStatus(Auth::user()) === 'registered')
                                            <form action="{{$course->linkStart}}"
                                                  method="POST">
                                                @csrf
                                                <button class="btn btn-block btn-course">
                                                    Bắt đầu học
                                                </button>
                                            </form>
                                        @elseif($course->userableStatus(Auth::user()) === 'learning')
                                            <a href="{{$course->linkLearn}}" class="btn btn-block btn-course">
                                                Tiếp tục học
                                            </a>
                                        @elseif($course->price_fl == 0)
                                            <form action="{{$course->linkStart}}"
                                                  method="POST">
                                                @csrf
                                                <button href="{{$course->linkStart}}"
                                                        class="btn btn-block btn-course">
                                                    Bắt đầu học
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{$course->linkBuy}}"
                                                  method="POST">
                                                @csrf
                                                <button class="btn btn-block btn-course btn-buy">
                                                    Đăng Ký Học
                                                </button>
                                            </form>
                                        @endif
                                    @else
                                        <a href="#signinModal" data-toggle="modal"
                                           class="btn btn-block btn-course btn-buy">
                                            Đăng Ký Học
                                        </a>
                                    @endif
                                </div>
                                <div class="col-sm-2">
                                    <a @guest() href="#signinModal" data-toggle="modal" @else href="#"
                                       @endguest  class="add-to-wishlist btn-heart">
                                        <span class="" data-placement="bottom" data-toggle="tooltip"
                                              data-title="Thêm Vào Yêu Thích" data-original-title="" title="">
                                        <i class="fa fa-heart-o"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar__item">
                        </div> <!-- .sidebar__item -->
                    </div> <!-- .blog__sidebar -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-7 col-md-8">
                    <div class="course__body">
                        <div class="course__info">
                            <div class="course-info__item">
                                <div class="course-info__icon">
                                    <i class="ion-images"></i>
                                </div>
                                <div class="course-info__text">
                                    <span> {{ __('site.category') }}</span>
                                    <p>
                                        @foreach($course->categories as $category)
                                            {{$category->title_lb}} @if (!$loop->last) / @endif
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                            <div class="course-info__item">
                                <div class="course-info__icon">
                                    <i class="ion-android-time"></i>
                                </div>
                                <div class="course-info__text">
                                    <span>{{__('site.duration')}}</span>
                                    <p>{{_duration($course->duration_nb)}}</p>
                                </div>
                            </div>
                        </div> <!-- .course__info -->
                        <div class="what-you-get">
                            <h3 class="course_desc__title f-uppercase"> What you'll learn</h3>
                            <ul class="course_audience__list what-you-get__items ">
                                @foreach($course->what_get_lb as $item)
                                    <li class="what-you-get__item--columns"><i class="ion-checkmark-round"></i>
                                        {{$item['value']}}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <h3 class="course_desc__title f-uppercase"> {{__('site.course.content')}}</h3>
                        <div class="course__desc">
                            <div class="panel-group curriculum-wrapper" id="accordion" role="tablist"
                                 aria-multiselectable="true">
                                    <div class="panel-body">
                                        <table class="table table-striped">
                                            <tbody>
                                            @foreach($course->lectures as $lecture)
                                                <tr>
                                                    <td style="text-align: center">
                                                        <i class="fa vjs-icon-play"></i>
                                                    </td>
                                                    <td>
                                                        <span>Bài {{$lecture->order_nb}} </span>
                                                        <p class="lecture__title">{{$lecture->title_lb}}</p>
                                                    </td>
                                                    <td>
                                                        <div class="lecture__time">
                                                            {{_duration($lecture->duration_nb)}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                                @if($course->exams->count() > 0)
                                                <tr>
                                                    <td style="text-align: center">
                                                        <i class="fa fa-question-circle-o"></i>
                                                    </td>
                                                    <td>
                                                        <span>Bài Thi </span>
                                                        <p class="lecture__title">{{$course->exams[0]->title_lb}}</p>
                                                    </td>
                                                    <td>
                                                        <div class="lecture__time">
                                                            {{_duration($course->exams[0]->duration_nb)}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                        </div>
                        <h3 class="course_desc__title f-uppercase"> {{__('site.course.requirement')}}</h3>
                        <ul class="course_requirements__list">
                            @foreach($course->requirement_lb as $item)
                                <li><i class="ion-android-arrow-forward"></i>
                                    {{$item['value']}}
                                </li>
                            @endforeach
                        </ul>
                        <h3 class="course_desc__title f-uppercase"> {{__('site.course.description')}}</h3>
                        <div class="course__desc">
                            {{$course->description_lb}}
                        </div>
                        <p class="course__desc">
                            {!! $course->content_lb !!}
                        </p>
                        <div class="course__teachers">
                            @if($course->teachers->count() > 0)
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 col-lg-8">
                                        <h3 class="course-teacher__title">{{__('site.teacher')}}</h3>
                                        <p class="course-teacher__desc">
                                            {{Str::of($course->teachers[0]->description)->limit(500, ' (...)')}}
                                        </p>
                                        <a href=" {{$course->teachers[0]->link}}" class="btn btn-primary">{{__('site.learn_more')}}</a>
                                    </div>
                                    <div class="col-sm-6 col-md-6 col-lg-4">
                                        <div class="teacher__item">
                                            <div class="teacher__info">
                                                <div class="teacher__name">
                                                    {{$course->teachers[0]->name}}
                                                </div>
                                                <div class="teacher__prof">
                                                    @foreach($course->teachers[0]->categories as $key => $category)
                                                        {{$category->title_lb}} @if (!$loop->last) / @endif
                                                    @endforeach
                                                </div>
                                            </div> <!-- / .teacher__info -->
                                            <div class="teacher__img">
                                                <img src="{{$course->teachers[0]->image}}" class="img-responsive" alt="{{$course->teachers[0]->name}}">
                                            </div>
                                        </div> <!-- / .teacher__item -->
                                    </div>
                                </div> <!-- / .row -->
                            @endif
                        </div> <!-- .event__speakers -->

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#reviews"> {{__('site.review')}}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="reviews" class="tab-pane fade in active">
                                @guest()
                                    <p class="subheading">
                                        Hãy <a href="#signinModal" data-toggle="modal">đăng nhập </a> để bình luận
                                    </p>
                                @else
                                    <p class="subheading">
                                        Leave a <span>review</span>
                                    </p>
                                    <form class="comments__form" method="POST"
                                          action="{{route('comment.doComment', ['type' => 'course', 'post' => $course->id])}}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="message" class="sr-only">Message (Required)</label>
                                            <textarea name="message" class="form-control" rows="3" id="message"
                                                      placeholder="Ý kiến của bạn ..." minlength="10"></textarea>
                                            <span class="help-block"></span>
                                        </div>

                                        <button type="submit" class="btn btn-accent">
                                            Gửi
                                        </button>
                                    </form>
                                @endguest
                                <p class="subheading">{{__('site.review')}} <span>({{$course->publicComments->count()}})</span>
                                </p>
                                <div class="comments">
                                    @include('collection.comment',['post' => $course, 'type' => 'course'])
                                </div> <!-- .comments -->
                            </div>

                        </div>
                    </div> <!-- .course__body -->
                </div>
                <div class="col-sm-5 col-md-4">
                    <div class="course__sidebar">
                        <div class="sidebar__item">
                            <p class="subheading">{{__('site.search')}}</p>
                            <form class="search-form" role="search" action="{{route('home.search')}}" method="GET">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="s"
                                           placeholder="{{__('site.enter_keywords')}}">
                                </div>
                                <button type="submit" class="btn btn-block btn-accent">
                                    {{__('site.search')}} <i class="icon ion-search"></i>
                                </button>
                            </form> <!-- .search-form -->
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading"> {{__('site.course.category')}}</p>
                            <ul class="categories">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{$category->link}}"><i
                                                class="ion-ios-arrow-forward"></i> {{$category->title_lb}}
                                            (<span>{{$category->courses->count()}}</span>)</a>
                                    </li>
                                @endforeach
                            </ul> <!-- .categories -->
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading">Khoá học phổ biến</p>
                            <div class="recent__posts">
                                @foreach($courses as $rscourse)
                                    <div class="sidebar__post">
                                        <a class="sidebar_post__img" href="#" title="">
                                            <img src="{{resize($rscourse->image_lb, 256, 256)}}" class="img-responsive"
                                                 alt="{{$rscourse->title_lb}}">
                                        </a>
                                        <div class="sidebar_post__detail">
                                            <h5><a href="{{$rscourse->link}}" title="">{{$rscourse->title_lb}}</a></h5>
                                            <span
                                                class="f-uppercase">{{__('site.course.price')}}: <strong>{{$rscourse->price}}</strong></span>
                                        </div>
                                    </div> <!-- Sidebar Post -->
                                @endforeach
                            </div> <!-- .popular__posts -->
                        </div> <!-- .sidebar__item -->
                    </div> <!-- .blog__sidebar -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section__course-single -->
@endsection
