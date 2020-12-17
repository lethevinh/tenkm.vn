@extends('layouts.full')
@section('title', 'Profile Title')
@section('id_body', 'teacher-profile__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            Thông tin học viên
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}"> {{ tran('site.home') }}</a></li>
                            <li class="active">Thông tin học viên</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section teacher profile -->
    <section class="section__teacher-profile">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <div class="teacher__img">
                        <img src="{{ $user->image }}" class="img-responsive" alt="...">
                    </div>
                    <p class="subheading">Thông tin tài khoản</p>
                    <ul class="teacher__contact">
                        <li><i class="ion-ios-home" aria-hidden="true"></i> Công ty TNHH Đầu tư Đất Việt</li>
                        <li><i class="ion-ios-location" aria-hidden="true"></i> {{ $user->address }}</li>
                        <li><i class="ion-ios-email" aria-hidden="true"></i> {{ $user->email }}</li>
                        <li><i class="ion-ios-telephone" aria-hidden="true"></i> {{ $user->phone }}</li>
                        <li><i class="ion-ios-world" aria-hidden="true"></i> me.home</li>
                        <li><i class="ion-social-skype" aria-hidden="true"></i> skype.me</li>
                    </ul>

                    <p class="subheading">Liên kết Mạng xã hội</p>
                    <ul class="social__icons">
                        <li class="social-icons__item"><a href="#"><i class="icon ion-social-twitter"
                                                                      aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="#"><i class="icon ion-social-facebook"
                                                                      aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="#"><i class="icon ion-social-googleplus"
                                                                      aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="#"><i class="ion-social-instagram"
                                                                      aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="#"><i class="ion-social-youtube" aria-hidden="true"></i></a>
                        </li>
                        <li class="social-icons__item"><a href="#"><i class="ion-social-rss" aria-hidden="true"></i></a>
                        </li>
                    </ul> <!-- .social__icons -->

                    <p class="subheading">Ngành nghề</p>
                    <div class="teacher__skills">
                        <h5>Môi giới bất động sản<span><a>Sửa</a></span></h5>
                    </div> <!-- .teacher__skills -->
                </div>
                <div class="col-sm-6 col-md-8">
                    <h2 class="teacher__name">
                        {{ $user->name }}
                    </h2>
                    <div class="teacher__branch">
                        Châm ngôn: Hãy làm cho bạn thật ấn tượng!
                    </div>
                    <p class="subheading">Sơ lược bản thân</p>
                    <p class="teacher__text">
                        {{ $user->description }}
                    </p>
                    <ul class="teacher-biography__list">
                        <li><span>2005-2008</span> - Ut tempora iusto blandit official.</li>
                        <li><span>2008-2012</span> - Quam ipsum at provident suscipit vero omnis cupiditate aspernatur.
                        </li>
                        <li><span>2012-2017</span> - Fugiat blanditiis delectus nostrum for aliquam.</li>
                    </ul> <!-- .teacher-biography__list -->

                    <p class="subheading">Các Khoá học</p>
                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>
                                <div class="lecture__title">Khóa học</div>
                            </td>
                            <td>
                                <div class="lecture__time">Tình trạng</div>
                            </td>
                            <td>
                                <div class="lecture__time">Ngày đăng ký</div>
                            </td>
                            <td>
                                <div class="lecture__time">Giấy chứng nhận</div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Registered</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href=""></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Registered</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href=""></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Registered</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href=""></a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Passed</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href="">Download Certificate</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Passed</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href="">Download Certificate</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Passed</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href="">Download Certificate</a></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="">The What, When, Why, How of repeat and referal sales</div>
                            </td>
                            <td>
                                <div class="">Passed</div>
                            </td>
                            <td>
                                <div class="">March 05, 2020</div>
                            </td>
                            <td>
                                <div class=""><a href="">Download Certificate</a></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section__teacher-profile -->
@endsection
