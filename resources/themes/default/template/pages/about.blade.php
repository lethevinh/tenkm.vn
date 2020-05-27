@extends('layouts.full')
@section('title', 'About Page')
@section('id_body', 'about__page')
@section('content')

    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            Giới thiệu
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{ route('home.show') }}">Trang chủ</a></li>
                            <li class="active">Giới thiệu</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg" style="background-image: url('../img/Logo_Edureal_Final-03.jpg')"></div>
    </section>

    <!-- section features -->
    <section class="section__features">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="feature__item">
                        <div class="feature_item__icon">
                            <i class="ion-ios-flask-outline"></i>
                        </div>
                        <div class="feature_item__title" data-editable-metadata="page:{{$page->id}}:feature_1_text:text" >
                            {{$page->feature_1_text ?? 'Học Online mọi lúc mọi nơi'}}
                        </div>
                        <div class="feature_item__desc" data-editable-metadata="page:{{$page->id}}:feature_1_description:textarea">
                            {{$page->feature_1_description ?? 'Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime voluptas
                            quamgit.'}}
                        </div>
                    </div> <!-- / .feature__item -->
                </div>
                <div class="col-sm-4">
                    <div class="feature__item">
                        <div class="feature_item__icon">
                            <i class="ion-ios-lightbulb-outline"></i>
                        </div>
                        <div class="feature_item__title" data-editable-metadata="page:{{$page->id}}:feature_2_text:text">
                            {{$page->feature_2_text ?? 'Đội ngũ giảng viên giỏi'}}
                        </div>
                        <div class="feature_item__desc" data-editable-metadata="page:{{$page->id}}:feature_2_description:textarea">
                            {{$page->feature_2_description ?? 'Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime voluptas
                             quamgit.'}}
                        </div>
                    </div> <!-- / .feature__item -->
                </div>
                <div class="col-sm-4">
                    <div class="feature__item">
                        <div class="feature_item__icon">
                            <i class="ion-ios-bookmarks-outline"></i>
                        </div>
                        <div class="feature_item__title" data-editable-metadata="page:{{$page->id}}:feature_3_text:text">
                            {{$page->feature_3_text ?? ' Được cấp giấy chứng nhận'}}
                        </div>
                        <div class="feature_item__desc" data-editable-metadata="page:{{$page->id}}:feature_3_description:textarea">
                            {{$page->feature_3_description ?? 'Lorem ipsum dolor sitamet consectetur adipisicing elit. In nemo dolore maxime voluptas
                             quamgit.'}}
                        </div>
                    </div> <!-- / .feature__item -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section about -->
    <section class="section__about">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <h2 class="section__title dark__title">
                            GIỚI THIỆU EDUREAL
                        </h2>
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row row_centered">
                <div class="col-sm-6">
                    <div class="about__wrapper">
                        <div class="about__title">
                            <i class="ion-play"></i> CÂU CHUYỆN VỀ EDUREAL
                        </div>
                        <div class="about__text" data-editable-metadata="page:{{$page->id}}:who:textarea">
                            {{$page->who}}
                        </div>
                    </div> <!-- / .about__wrapper -->
                </div>
                <div class="col-sm-6">
                    <div class="about__wrapper">
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item"
                                    src="{{$page->video_who??'https://player.vimeo.com/video/114151688?color=ffffff&title=0&byline=0&portrait=0'}}"
                                    allowfullscreen></iframe>
                        </div>
                    </div> <!-- / .about__wrapper -->
                </div>
            </div> <!-- / .row -->
            <div class="row row_centered">
                <div class="col-sm-6 col-sm-push-6">
                    <div class="about__wrapper">
                        <div class="about__title">
                            <i class="ion-play"></i> Sứ Mệnh
                        </div>
                        <div class="about__text" data-editable-metadata="page:{{$page->id}}:su_menh:textarea">
                            {{$page->su_menh}}
                        </div>
{{--                        <a href="#" class="btn btn-primary">Xem thêm</a>--}}
                    </div> <!-- / .about__wrapper -->
                </div>
                <div class="col-sm-6 col-sm-pull-6">
                    <div class="about__wrapper">
                        <img src="{{$page->hinh_su_menh??'/assets/img/about_img-1.jpg'}}" class="img-responsive" alt="...">
                    </div> <!-- / .about__img -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section stats -->
    <section class="section__stats">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="stat__item">
                        <div class="stats_item__icon">
                            <i class="ion-person-stalker" aria-hidden="true"></i>
                        </div>
                        <div class="stats_item__nbr" data-from="0" data-to="28" data-speed="1000"
                             data-refresh-interval="1">
                            0
                        </div>
                        <div class="stats_item__text" data-editable-metadata="page:{{$page->id}}:best_teachers:text">
                            {{$page->best_teachers ?? 'Best teachers'}}
                        </div>
                    </div> <!-- / .stat__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat__item">
                        <div class="stats_item__icon">
                            <i class="ion-ios-bookmarks" aria-hidden="true"></i>
                        </div>
                        <div class="stats_item__nbr" data-from="0" data-to="35" data-speed="1000"
                             data-refresh-interval="1">
                            0
                        </div>
                        <div class="stats_item__text" data-editable-metadata="page:{{$page->id}}:online_programs:text">
                            {{$page->online_programs ?? 'Online programs'}}
                        </div>
                    </div> <!-- / .stat__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat__item">
                        <div class="stats_item__icon">
                            <i class="ion-university" aria-hidden="true"></i>
                        </div>
                        <div class="stats_item__nbr" data-from="0" data-to="267" data-speed="4000"
                             data-refresh-interval="20">
                            0
                        </div>
                        <div class="stats_item__text" data-editable-metadata="page:{{$page->id}}:happy_students:text">
                            {{$page->happy_students ?? 'Happy students'}}
                        </div>
                    </div> <!-- / .stat__item -->
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="stat__item">
                        <div class="stats_item__icon">
                            <i class="ion-ribbon-b" aria-hidden="true"></i>
                        </div>
                        <div class="stats_item__nbr" data-from="0" data-to="12" data-speed="1000"
                             data-refresh-interval="1">
                            0
                        </div>
                        <div class="stats_item__text" data-editable-metadata="page:{{$page->id}}:years_experience:text">
                            {{$page->years_experience ?? 'Years Experience'}}
                        </div>
                    </div> <!-- / .stat__item -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section about -->
    <section class="section__about">
        <div class="container">
            <div class="row row_centered">
                <div class="col-sm-6">
                    <img src="{{$page->hinh_khoa_hoc_hot??'/assets/img/about_img-2.png'}}" class="img-responsive" alt="...">
                </div>
                <div class="col-sm-6">
                    <div class="about__wrapper">
                        <div class="about__title">
                            <i class="ion-play"></i> Khóa học hot nhất
                        </div>
                        <div class="about__text" data-editable-metadata="page:{{$page->id}}:khoa_hoc_tot_nhat_text:textarea">
                            {{$page->khoa_hoc_tot_nhat_text?? ''}}
                        </div>
                        <ul class="about__list">
                            @if(!empty($page->khoa_hoc_tot_nhat) && is_array($page->khoa_hoc_tot_nhat))
                                @foreach(\App\Models\Course::whereIn('id',$page->khoa_hoc_tot_nhat)->published()->get() as $course)
                                    <li><a href="{{$course->link}}"><i class="ion-checkmark-round"></i>{{$course->title_lb}}</a></li>
                                @endforeach
                            @endif
                        </ul> <!-- / .about__list -->
                    </div> <!-- / .about__wrapper -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section teachers -->
    <section class="section__teachers">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <h2 class="section__title dark__title">
                            ĐỘI NGŨ GIẢNG VIÊN
                        </h2>
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                {{--@foreach($teachers as $teacher)
                    @include('item.teacher')
                @endforeach--}}
                @if(!empty($page->doi_ngu_giang_vien) && is_array($page->doi_ngu_giang_vien))
                    @foreach(\App\Models\Teacher::whereIn('id',$page->doi_ngu_giang_vien)->get() as $teacher)
                        @include('item.teacher', ['teacher' => $teacher])
                    @endforeach
                @endif
            </div> <!-- / .row -->
            <div class="text-center">
                <a href="/" class="btn btn-accent">Xem Thêm</a>
            </div>
        </div> <!-- / .container -->
    </section>

    <!-- section testimonials -->
    <section class="section__testimonials" style="background-image: url('../img/education.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="section__title light__title">
                        CẢM NHẬN HỌC VIÊN
                    </h2>
                </div>
            </div> <!-- / .row -->
            <!-- testimonials carousel -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="testimonials__icon">
                        <i class="ion-quote" aria-hidden="true"></i>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div id="testimonials__carousel" class="owl-carousel owl-theme">
                        @foreach(\App\Models\Feedback::orderByDesc('updated_at')->published()->limit(5)->get() as $testimonial)
                            @include('item.testimonial', ['testimonial' => $testimonial])
                        @endforeach
                    </div> <!-- / .owl-carousel -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section newsletter -->
    <section class="section__newsletter">
        <div class="container">
            <div class="row row_centered">

                <div class="col-sm-8">
                    <div class="newsletter__body">
                        <div class="section__subtitle">
                            <span>Đăng ký </span> để nhận
                        </div>
                        <div class="newsletter__title">
                            newsletter
                        </div>
                        <p class="newsletter__subtitle">Nhập địa chỉ email của bạn để được nhận những khóa học và những
                            hội thảo mới nhất từ chúng tôi.</p>
                    </div> <!-- / .newsletter__body -->
                </div>
                <div class="col-sm-4">

                    <!-- Newsletter form -->
                    <form class="footer__form">
                        <div class="form-group">
                            <label for="newsletter__email" class="sr-only">Nhập địa chỉ E-mail</label>
                            <input type="email" class="form-control" id="newsletter__email"
                                   placeholder="Nhập địa chỉ E-mail">
                        </div>
                        <a href="#" class="btn btn-newsletter"><i class="ion-android-arrow-forward"></i></a>
                    </form> <!-- .newsletter__form -->

                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>



    <!-- section partners -->
    <section class="section__partners">
        <div class="container">
            <div class="row">
                @foreach(\App\Models\Partner::published()->get() as $partner)
                    <div class="col-xs-6 col-sm-6 col-md-3">
                        <div class="partner__img">
                            <img src="{{resize($partner->image_lb, 400, 300)}}" class="img-responsive" alt="{{$partner->title_lb}}">
                        </div>
                    </div>
                @endforeach
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__footer -->

@endsection
