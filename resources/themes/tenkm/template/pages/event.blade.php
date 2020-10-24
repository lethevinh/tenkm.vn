@extends('layouts.full')
@section('title', __('site.event'))
@section('id_body', 'events__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            Các hội thảo
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home.show') }}">Trang chủ</a></li>
                            <li class="active">Các hội thảo</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg" style="background-image: url('../img/event.jpg')"></div>
    </section>

    <!-- section categories -->
    <section class="section__categories">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="category__item">
                        <div class="category_item__icon">
                            <i class="ion-ios-people-outline"></i>
                        </div>
                        <a href="#" class="category_item__title">
                            Conference
                        </a>
                        <div class="category_item__desc">
                            Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime.
                        </div>
                    </div> <!-- / .category__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="category__item">
                        <div class="category_item__icon">
                            <i class="ion-ios-compose-outline"></i>
                        </div>
                        <a href="#" class="category_item__title">
                            Web design
                        </a>
                        <div class="category_item__desc">
                            Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime.
                        </div>
                    </div> <!-- / .category__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="category__item">
                        <div class="category_item__icon">
                            <i class="ion-ios-lightbulb-outline"></i>
                        </div>
                        <a href="#" class="category_item__title">
                            Development
                        </a>
                        <div class="category_item__desc">
                            Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime.
                        </div>
                    </div> <!-- / .category__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="category__item">
                        <div class="category_item__icon">
                            <i class="ion-ios-reverse-camera-outline"></i>
                        </div>
                        <a href="#" class="category_item__title">
                            Photography
                        </a>
                        <div class="category_item__desc">
                            Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime.
                        </div>
                    </div> <!-- / .category__item -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <section class="section__events">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Thông tin <span>Hội Thảo</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Các Hội thảo mới nhất
                        </h2>
                        <p class="section_title__desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores a atque, esse delectus.
                            Vel quas voluptate atque natus laboriosam, vero molestiae repudiandae eaque veniam
                            repellendus nemo unde suscipit ducimus tenetur.
                        </p> <!-- / .about__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <ul class="timeline">
                        @foreach($events as $event)
                        <li @if($loop->even) class="timeline-inverted" @endif>
                            <div class="timeline-badge primary"><i class="ion-ios-people-outline"></i></div>
                            <div class="timeline-panel">
                                <div class="timeline-heading">
                                    <a href="{{$event->link}}" class="timeline-title">
                                        {{$event->title_lb}}
                                    </a>
                                </div>
                                <div class="timeline-info">
                                    <div class="timeline-info__item">
                                        <i class="ion-android-pin"></i>
                                        <p>{{$event->city_lb}}</p>
                                    </div>
                                    <div class="timeline-info__item">
                                        <i class="ion-android-calendar"></i>
                                        <p>{{date('d-m-Y', strtotime($event->opening_at))}}</p>
                                    </div>
                                    <div class="timeline-info__item">
                                        <i class="ion-android-time"></i>
                                        <p>{{date('H:m', strtotime($event->start_at))}} - {{date('H:m', strtotime($event->end_at))}}</p>
                                    </div>
                                </div> <!-- .timeline-info -->
                                <div class="timeline-body">
                                    <p>{{Str::of($event->description_lb)->limit(200, ' (...)')}}</p>
                                </div>
                                <div class="timeline-img">
                                    <img src="{{$event->thumbnail}}" class="img-responsive" alt="...">
                                </div>
                                <div class="timeline-price">
                                    <h3>Giá vé: <span> {{number_format($event->price_fl, 0)}} VND</span></h3>
                                </div>
                                <div class="timeline-link">
                                    <a href="{{$event->link}}"> {{__('site.read_more')}}
                                        <i class="ion-android-arrow-forward" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <ul class="timeline-share">
                                    <li><a href="https://twitter.com/intent/tweet?text={{$event->title_lb}}&url={{$event->title_lb}}"><i class="ion-social-twitter"></i></a></li>
                                    <li><a href="https://www.facebook.com/sharer.php?u={{$event->link}}"><i class="ion-social-facebook"></i></a></li>
                                    <li><a href=""><i class="ion-social-googleplus"></i></a></li>
                                </ul>
                            </div>
                        </li>
                        @endforeach
                    </ul> <!-- .timeline -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
