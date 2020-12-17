@extends('layouts.full')
@section('title', 'Event '.$event->title_lb)
@section('id_body', 'single-event__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            Event
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
                            <li><a href="{{route('event.index')}}">{{ tran('site.event') }}</a></li>
                            <li class="active">Event {{$event->title_lb}}</li>
                        </ol>
                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section event -->
    <section class="section__event">
        <div class="container">
            <div class="row">
                <div class="col-sm-7 col-md-8">
                    <div class="event__item">
                        <div class="event__img">
                            <img src="{{$event->thumbnail}}" class="img-responsive" alt="{{$event->title_lb}}">
                        </div>
                        <div id="event__timer"></div>
                        <div class="event__info">
                            <div class="event-info__item">
                                <i class="ion-android-pin"></i>
                                <p>{{$event->city_lb}}</p>
                            </div>
                            <div class="event-info__item">
                                <i class="ion-android-calendar"></i>
                                <p data-event-date="{{date('Y/m/d', strtotime($event->opening_at))}}">{{date('d-m-Y', strtotime($event->opening_at))}}</p>
                            </div>
                            <div class="event-info__item">
                                <i class="ion-android-time"></i>
                                <p>{{date('H:m', strtotime($event->start_at))}} - {{date('H:m', strtotime($event->end_at))}}</p>
                            </div>
                        </div> <!-- .event__info -->
                        <div class="event__body">
                            <h2 class="event__title">{{$event->title_lb}}</h2>
                            <p class="event__annotation">
                                {{$event->description_lb}}
                            </p>
                            <h3 class="event-desc__title">Event description</h3>
                            <p class="event__desc">
                                {{$event->content_lb}}
                            </p>
                            <h3 class="event-desc__title">Meetup content</h3>
                            <ul class="event__list">
                                <li><i class="ion-android-arrow-forward"></i> Meeting of participants</li>
                                <li><i class="ion-android-arrow-forward"></i> Check in</li>
                                <li><i class="ion-android-arrow-forward"></i> Speeches</li>
                                <li><i class="ion-android-arrow-forward"></i> Coffee break</li>
                                <li><i class="ion-android-arrow-forward"></i> Discussion</li>
                            </ul>
                            <p class="event__desc">Reiciendis alias molestiae fuga accusantium, expedita nam natus in
                                dolores dignissimos repellat placeat necessitatibus porro unde sunt amet quasi
                                consequatur udiandae voluptatem. Voluptas accusantium officia quaerat minima ex
                                aspernatur excepturi cupiditate aliquam provident dignissimos repellendus laudantium
                                perspiciatis? Nobis similique magni animi et nihil quisquam ullam.</p>
                            <div class="event__price">
                                <h3>Ticket Price: <span>{{number_format($event->price_fl, 0)}} VND</span></h3>
                            </div>
                        </div> <!-- .event__body -->
                        <div class="event__speakers">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-4">
                                    <h3 class="event-speaker__title">Event speakers</h3>
                                    <p class="event-speaker__desc">Reiciendis alias molestiae fuga accusantium, expedita
                                        nam natus in dolores dignissimos repellat placeat necessitatibus porro unde sunt
                                        amet quasi consequatur udiandae volup. Voluptas accusantium officia quaerat
                                        minima ex aspernatur.</p>
                                    <a href="#" class="btn btn-primary">Learn more</a>
                                </div>
                                @foreach($event->teachers as $teacher)
                                <div class="col-sm-6 col-md-6 col-lg-4">
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
                                            <img src="{{$teacher->image}}" class="img-responsive" alt="...">
                                        </div>
                                    </div> <!-- / .teacher__item -->
                                </div>
                                @endforeach
                            </div> <!-- / .row -->
                        </div> <!-- .event__speakers -->
                        <div class="event__share">
                            <div class="event-share__text">
                                Share this:
                            </div>
                            <ul class="event-share__links">
                                <li><a href="https://twitter.com/intent/tweet?text={{$event->title_lb}}&url={{$event->title_lb}}"><i class="ion-social-twitter"></i></a></li>
                                <li><a href="https://www.facebook.com/sharer.php?u={{$event->link}}"><i class="ion-social-facebook"></i></a></li>
                                <li><a href="#"><i class="ion-social-googleplus"></i></a></li>
                                <li><a href="#"><i class="ion-social-pinterest"></i></a></li>
                                <li><a href="#"><i class="ion-social-rss"></i></a></li>
                            </ul>
                        </div>
                    </div> <!-- .event__item -->
                </div>
                <div class="col-sm-5 col-md-4">
                    <div class="event__sidebar">

                        <div class="sidebar__item">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if( Auth::check() && $event->registered(Auth::user()))
                                <p class="subheading">Bạn đã đăng ký</p>
                            @else
                                <p class="subheading">Đăng ký ngay</p>
                                <form class="register__form" method="POST" role="form" action="{{route('event.register', ['event' => $event])}}">
                                    @csrf
                                    @if(Auth::check())
                                        <input type="hidden" name="user_id" class="form-control"  value="{{Auth::user()->id}}" >
                                    @endif
                                    <div class="form-group">
                                        <label class="sr-only">Họ tên</label>
                                        <input type="text" name="name" required class="form-control" placeholder="Họ tên" @if(Auth::check()) value="{{Auth::user()->name}}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">Số điện thoại</label>
                                        <input type="tel" name="phone_lb" class="form-control" placeholder="Số điện thoại" @if(Auth::check()) value="{{Auth::user()->phone}}"  @endif>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">E-mail</label>
                                        <input type="email" name="email_lb" required class="form-control" placeholder="E-mail" @if(Auth::check()) value="{{Auth::user()->email}}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only">Loại vé</label>
                                        <select name="type" class="form-control">
                                            @foreach(\App\Models\Event::TYPES as $key => $type)
                                                <option value="{{$key}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-accent btn-block ">
                                        Gửi
                                    </button>
                                </form>
                            @endif
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading">Tìm kiếm</p>
                            <form class="search-form" role="search">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Enter keywords">
                                </div>
                                <button type="submit" class="btn btn-block btn-accent">
                                    Tìm <i class="icon ion-search"></i>
                                </button>
                            </form> <!-- .search-form -->
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading">Danh mục Khóa học</p>
                            <ul class="categories">
                                <li><a href="#"><i class="ion-ios-arrow-forward"></i> Conference (<span>4</span>)</a>
                                </li>
                                <li><a href="#"><i class="ion-ios-arrow-forward"></i> Development (<span>15</span>)</a>
                                </li>
                                <li><a href="#"><i class="ion-ios-arrow-forward"></i> Meetup (<span>8</span>)</a></li>
                                <li><a href="#"><i class="ion-ios-arrow-forward"></i> Photography (<span>7</span>)</a>
                                </li>
                            </ul> <!-- .categories -->
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading">Nhận Bản tin</p>
                            <p class="newsletter__subtitle">Subscribe to our email newsletter to receive updates and
                                news.</p>

                            <!-- Newsletter form -->
                            <form>
                                <div class="form-group">
                                    <label for="newsletter__email" class="sr-only">E-mail address</label>
                                    <input type="email" class="form-control" placeholder="Your email">
                                </div>
                                <button type="submit" class="btn btn-block btn-accent">
                                    Gửi <i class="icon ion-paper-airplane"></i>
                                </button>
                            </form> <!-- .newsletter__form -->
                        </div> <!-- .sidebar__item -->

                        <div class="sidebar__item">
                            <p class="subheading">Hội thảo mới nhất</p>
                            <div class="recent__posts">
                                <div class="sidebar__post">
                                    <a class="sidebar_post__img" href="#" title="">
                                        <img src="/assets/img/instagram_img-4.jpg" class="img-responsive" alt="...">
                                    </a>
                                    <div class="sidebar_post__detail">
                                        <h5><a href="#" title="">LCTRS conference 2017</a></h5>
                                        <span>June 02, 2017</span>
                                    </div>
                                </div> <!-- Sidebar Post -->
                                <div class="sidebar__post">
                                    <a class="sidebar_post__img" href="#" title="">
                                        <img src="/assets/img/instagram_img-2.jpg" class="img-responsive" alt="...">
                                    </a>
                                    <div class="sidebar_post__detail">
                                        <h5><a href="#" title="">Summer events</a></h5>
                                        <span>October 09, 2017</span>
                                    </div>
                                </div> <!-- Sidebar Post -->
                                <div class="sidebar__post">
                                    <a class="sidebar_post__img" href="#" title="">
                                        <img src="/assets/img/instagram_img-3.jpg" class="img-responsive" alt="...">
                                    </a>
                                    <div class="sidebar_post__detail">
                                        <h5><a href="#" title="">Web design meetup</a></h5>
                                        <span>October 17, 2017</span>
                                    </div>
                                </div> <!-- Sidebar Post -->
                            </div> <!-- .popular__posts -->
                        </div> <!-- .sidebar__item -->

                    </div> <!-- .blog__sidebar -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section event -->
@endsection
