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
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
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
                        <div class="_profile_avatar image_editor" >
                            <img src="{{ $user->image }}" class="img-responsive" alt="{{$user->name}}">
                        </div>
                    </div>
                    <p class="subheading">Thông tin tài khoản</p>
                    <ul class="teacher__contact">
                        <li><i class="ion-ios-home" aria-hidden="true"></i>
                            <span  @if($user->id == Auth::user()->id) class="editable_field" data-field-name="company" data-field-label="company" @endif>
                        {{ $user->company }}
                        </span>
                        </li>
                        <li><i class="ion-ios-location" aria-hidden="true"></i>
                            <span @if($user->id == Auth::user()->id) class="editable_field" data-field-name="address" data-field-label="address" @endif>
                        {{ $user->address }}
                        </span>
                        </li>
                        <li><i class="ion-ios-email" aria-hidden="true"></i> {{ $user->email }}</li>
                        <li><i class="ion-ios-telephone" aria-hidden="true"></i>
                            <span @if($user->id == Auth::user()->id) class="editable_field" data-field-name="phone" data-field-label="phone" @endif>
                        {{ $user->phone }}
                        </span>
                        </li>
                        <li><i class="ion-ios-world" aria-hidden="true"></i>
                            <span  @if($user->id == Auth::user()->id) class="editable_field" data-field-name="website" data-field-label="website" @endif>
                        {{ $user->website }}
                        </span>
                        </li>
                        <li><i class="ion-social-skype" aria-hidden="true"></i>
                            <span  @if($user->id == Auth::user()->id) class="editable_field" data-field-name="skype" data-field-label="skype" @endif>
                        {{ $user->skype }}
                        </span>
                        </li>
                    </ul>

                    <p class="subheading">Liên kết Mạng xã hội</p>
                    <ul class="social__icons">
                        <li class="social-icons__item"><a href="{{ $user->twitter }}"><i class="icon ion-social-twitter"
                                                                                         aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->facebook }}"><i class="icon ion-social-facebook"
                                                                                          aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->skype }}"><i class="icon ion-social-googleplus"
                                                                                       aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->instagram }}"><i class="ion-social-instagram"
                                                                                           aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->youtube }}"><i class="ion-social-youtube" aria-hidden="true"></i></a>
                        </li>
                        <li class="social-icons__item"><a href="{{ $user->skype }}"><i class="ion-social-rss" aria-hidden="true"></i></a>
                        </li>
                    </ul> <!-- .social__icons -->

                    <p class="subheading">Ngành nghề</p>
                    <div class="teacher__skills">
                        <h5>Môi giới bất động sản<span><a>Sửa</a></span></h5>
                    </div> <!-- .teacher__skills -->
                </div>
                <div class="col-sm-6 col-md-8">
                    <h2 class="teacher__name">
                    <span  @if($user->id == Auth::user()->id) class="editable_field" data-field-name="name" data-field-label="name" @endif>
                        {{ $user->name }}
                        </span>
                    </h2>
                    <div class="teacher__branch">
                        Châm ngôn: Hãy làm cho bạn thật ấn tượng!
                    </div>
                    <p class="subheading">Sơ lược bản thân</p>
                    <p class="teacher__text">
                    <span @if($user->id == Auth::user()->id) class="editable_field" data-field-name="description" data-field-label="Description" data-field-type="textarea"  @endif>
                        {{ $user->description }}
                    </span>
                    </p>
                    <ul class="teacher-biography__list">
                        @foreach($user->awards as $award)
                            <li><span>{{$award->year_lb}}</span> - {{$award->title_lb}}</li>
                        @endforeach
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
                        @foreach($user->courses as $course)
                            <tr>
                                <td>
                                    <div class="">{{$course->title_lb}}</div>
                                </td>
                                <td>
                                    <div class="">{{ucfirst($course->pivot->status_sl)}}</div>
                                </td>
                                <td>
                                    <div class="">{{$course->pivot->created_at->format('d/m/Y')}}</div>
                                </td>
                                <td>
                                    <div class="">
                                        @if($course->pivot->status_sl == 'passed')
                                            <a href="">Download Certificate</a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section__teacher-profile -->
@endsection
