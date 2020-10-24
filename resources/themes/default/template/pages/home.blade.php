@extends('layouts.full')
@section('content')
    <section class="section__home" id="section__home">

        <div class="container home__body">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-sm-offset-1 col-md-offset-3">
                    <div class="home__content">

                        <!-- Title -->
                        <h3 class="home__title" data-aos="zoom-in" data-aos-delay="1800">
                            {{$page->intro_text??'THE ACADEMY OF EXPERTS'}}
                        </h3>

                        <!-- Heading -->
                        <h1 class="home__heading" data-aos="zoom-in" data-aos-delay="1800">
                            E D U R E A L ONLINE EDUCATION <span>.</span>
                        </h1>

                        <!-- Info -->

                        <!-- Button -->
                        <div class="home__btn" data-aos="fade-up" data-aos-delay="2800">
                            <a href="#section__courses" class="btn btn-primary">
                                {{__('site.read_more')}}
                            </a>
                        </div>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <div class="container home__footer">
            <div class="row">
                <div class="hidden-xs col-sm-6">
                    <div class="home__address">
                        <i class="ion-android-pin"></i> {{option('address_office', '78 Lorem St, New York, NY')}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6">
                    <!-- Social icons -->
                    <ul class="home__social">
                        <li><a href="{{option('linkedin')}}"><i class="ion-social-linkedin"></i></a></li>
                        <li><a href="{{option('facebook')}}"><i class="ion-social-facebook"></i></a></li>
                        <li><a href="{{option('youtube')}}"><i class="ion-social-youtube"></i></a></li>
                    </ul>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background video -->
        <div class="home-video__bg">
            <video class="video" playsinline autoplay muted loop poster="/assets/img/home_bg.jpg">
                <source src="{{$page->video_intro ??'/assets/video/video_bg.mp4'}}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section> <!-- .section__home -->

    <!-- section browse courses -->
    <section id="section__courses" class="section__courses" style="background-image: url('../img/Education.jpeg')">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="section__title light__title">
                        DANH MỤC KHÓA HỌC
                    </h2>
                </div>
            </div> <!-- / .row -->
            <div class="row top_category">
                @if(!empty($page->danh_muc_khoa_hoc) && is_array($page->danh_muc_khoa_hoc))
                    @foreach(\App\Models\Category::whereIn('id',$page->danh_muc_khoa_hoc)->published()->get() as $category)
                        <div class="col-sm-6 col-md-3">
                            @include('item.home-category-course', ['category' => $category])
                        </div>
                    @endforeach
                @endif
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section browse courses -->

    <!-- section courses -->
    <section class="section__courses" style="background-image: url('../img/education-1959551.jpg')">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="section__title light__title">
                        Khóa học nổi bật
                    </h2>
                </div>
            </div> <!-- / .row -->
            <div class="row top_category">
                @if(!empty($page->khoa_hoc_noi_bat) && is_array($page->khoa_hoc_noi_bat))
                    @foreach(\App\Models\Course::whereIn('id', $page->khoa_hoc_noi_bat)->published()->get() as $course)
                        <div class="col-sm-6 col-md-3">
                            @include('item.home-course', ['course' => $course])
                        </div>
                    @endforeach
                @endif
                <div class="col-sm-12">
                    <a href="/" class="btn btn-primary">{{__('site.read_more')}}</a>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__courses -->

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
                    @include('item.teacher', ['teacher' => $teacher])
                @endforeach--}}
                @if(!empty($page->doi_ngu_giang_vien) && is_array($page->doi_ngu_giang_vien))
                    @foreach(\App\Models\Teacher::whereIn('id',$page->doi_ngu_giang_vien)->get() as $teacher)
                        @include('item.teacher', ['teacher' => $teacher])
                    @endforeach
                @endif
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__footer -->

    <!-- section features -->
    <section class="section__features" style="background-image: url('../img/sach-thay.jpg')">
        <div class="left__box" style="width: 50%">
            <h2 class="features__title">
                <i class="ion-university"></i> ĐÀO TẠO & TƯ VẤN
            </h2>
            <p class="features__desc" data-editable-metadata="page:{{$page->id}}:dao_tao_tu_van:textarea">
                {{$page->dao_tao_tu_van ?? ''}}
            </p>
            <a href="{{$page->link_dao_tao??'#'}}" class="btn btn-accent">{{__('site.read_more')}}</a>
        </div>
        <div class="right__box" style="width: 50%">
            <h2 class="features__title">
                XUẤT BẢN VÀ PHÁT HÀNH <i class="ion-ribbon-b"></i>
            </h2>
            <p class="features__desc" data-editable-metadata="page:{{$page->id}}:sach_xuat_ban_phat_hanh:textarea">
                {{$page->sach_xuat_ban_phat_hanh ?? ''}}
            </p>
            <a href="{{$page->link_xuat_ban??'#'}}" class="btn btn-primary">{{__('site.read_more')}}</a>
        </div>
    </section> <!-- .section__footer -->

    <!-- section process -->
    <section class="section__process">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <h2 class="section__title dark__title">
                            QUY TRÌNH HỌC ONLINE
                        </h2>
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-7">
                    <div class="process__item process__item-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="process_item__icon">
                                    <i class="ion-log-in"></i>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="process_item__title" data-aos="zoom-in-up">
                                    ĐĂNG KÝ KHOÁ HỌC YÊU THÍCH<span>.</span>
                                </div>
                                <div class="process_item__desc" data-editable-metadata="page:{{$page->id}}:step_1_chon_khoa_hoc:textarea">
                                    {{$page->step_1_chon_khoa_hoc ?? ''}}
                                </div>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .process__item -->
                </div>
                <div class="col-sm-5 hidden-xs">
                    <div class="process_item__arrow-1">
                        <i class="ion-ios-redo-outline"></i>
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-6 hidden-xs">
                    <div class="process_item__arrow-2">
                        <i class="ion-ios-undo-outline"></i>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="process__item process__item-2">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="process_item__icon">
                                    <i class="ion-images"></i>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="process_item__title" data-aos="zoom-in-up">
                                    THEO DÕI KHOÁ HỌC
                                </div>
                                <div class="process_item__desc" data-editable-metadata="page:{{$page->id}}:step_2_theo_doi:textarea">
                                    {{$page->step_2_theo_doi ?? ''}}
                                </div>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .process__item -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-7">
                    <div class="process__item process__item-3">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="process_item__icon">
                                    <i class="ion-happy-outline"></i>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="process_item__title" data-aos="zoom-in-up">
                                    NHẬN CHỨNG CHỈ HOÀN THÀNH KHOÁ HỌC
                                </div>
                                <div class="process_item__desc" data-editable-metadata="page:{{$page->id}}:step_3_nhan_chung_chi:textarea">
                                    {{$page->step_3_nhan_chung_chi ?? ''}}
                                </div>
                            </div>
                        </div> <!-- / .row -->
                    </div> <!-- / .process__item -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>

    <!-- section coming-soon -->
    <section class="section__coming-soon">
        <div class="container">
            <div class="row">
                <div class="col-md-7 col-lg-6">
                    <div data-editable-metadata="page:{{$page->id}}:time_open_home_event:date" data-countdown-clock="{{$page->time_open_home_event ?? '2020/10/09'}}" >
                        {{$page->time_open_home_event ?? '2020/10/09'}}
                    </div> <!-- / #clock -->
                    <div class="coming-soon__text">
                        <h2 class="coming-soon__title" data-editable-metadata="page:{{$page->id}}:hoi_thao_title:text">{{$page->hoi_thao_title??'hoi_thao_title'}}</h2>
                        <p class="coming-soon__desc" data-editable-metadata="page:{{$page->id}}:hoi_thao_text:textarea">{{$page->hoi_thao_text ?? 'hoi_thao_text'}}</p>
                    </div>
                </div>
                <div class="col-md-5 col-lg-6">
                    <div class="coming-soon__img">
                        <img src="{{$page->hoi_thao_image ?? '/assets/img/coming-soon_img.jpg'}}" class="img-responsive" alt="...">
                    </div>
                    <div class="coming-soon__btn text-center">
                        <a href="/" class="btn btn-primary">ĐĂNG KÝ</a>
                    </div>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__footer -->

    <!-- section blog -->
    <section class="section__blog">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <h2 class="section__title dark__title">
                            BLOG
                        </h2>
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                @if(!empty($posts))
                    @foreach($posts as $post)
                        @include('item.default', ['post' => $post])
                    @endforeach
                @endif
                <div class="col-xs-12">
                    <div class="text-center">
                        <a href="{{route('post.index')}}" class="btn btn-accent">{{__('site.read_more')}}</a>
                    </div>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__footer -->

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
    </section> <!-- .section__footer -->

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

    <!-- section contact -->
    <section class="section__contact">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <h2 class="section__title dark__title">
                            THÔNG TIN LIÊN HỆ
                        </h2>
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div id="map" data-lat-long="{{option('address_location', '-74.337812,36.978575')}}"></div>
            <div class="row">
                <div class="col-sm-6">

                    <!-- Alert message -->
                    <div class="alert" id="form_message" role="alert"></div>

                    <!-- Form -->
                    <form id="form_sendemail" method="POST" action="{{route('home.doContact')}}" >
                    @csrf
                    <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="sr-only">Địa chỉ email</label>
                            <input type="email" required name="email" class="form-control" id="email"
                                   placeholder="Nhập địa chỉ email">
                            <span class="help-block"></span>
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="sr-only">Họ và tên</label>
                            <input type="text" required name="name" class="form-control" id="name" placeholder="Nhập họ và tên">
                            <span class="help-block"></span>
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message" class="sr-only">Yêu cầu</label>
                            <textarea name="message" required minlength="30" class="form-control" id="message" rows="6"
                                      placeholder="Nhập yêu cầu của bạn"></textarea>
                            <span class="help-block"></span>
                        </div>

                        <!-- Note -->
                        <div class="form-group">
                            <small class="text-muted">
                                * Yêu cầu nhập tất cả thông tin.
                            </small>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-block btn-accent">
                            Gửi
                        </button>

                    </form>

                </div>
                <div class="col-sm-6">
                    <div class="contact_info__body">
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Email<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>{{option('email_office')}}</p>
                                </div>
                                <div class="contact_info__wrapper">
                                    <h3>Support</h3>
                                    <p>{{option('email_support')}}</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Điện thoại<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>{{option('phone_office')}}</p>
                                </div>
                                <div class="contact_info__wrapper">
                                    <h3>Support</h3>
                                    <p>{{option('email_support')}}</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Địa chỉ<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>{{option('address_office')}}</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                    </div> <!-- / .contact_info__body -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section__footer -->
@endsection
