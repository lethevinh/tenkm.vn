@extends('layouts.full')
@section('title', __('site.teacher').' '.$user->name)
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
                           {{__('site.teacher')}} {{$user->name}}
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            <li><a href="{{route('teachers.index')}}"> {{ __('site.teacher') }}</a></li>
                            <li class="active">{{__('site.teacher')}} {{$user->name}}</li>
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
                    <div class="_profile_avatar  @if($edit) image_editor @endif" >
                        <img src="{{ $user->image }}" class="img-responsive" alt="{{$user->name}}">
                    </div>
                    <p class="subheading">Các kênh social kết nối</p>
                    <ul class="social__icons">
                        <li class="social-icons__item"><a href="{{ $user->twitter }}"><i class="icon ion-social-twitter" aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->facebook }}"><i class="icon ion-social-facebook" aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->instagram }}"><i class="ion-social-instagram" aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->youtube }}"><i class="ion-social-youtube" aria-hidden="true"></i></a></li>
                        <li class="social-icons__item"><a href="{{ $user->twitter }}"><i class="ion-social-rss" aria-hidden="true"></i></a></li>
                    </ul> <!-- .social__icons -->
                </div>
                <div class="col-sm-6 col-md-8">
                    <div class="teacher__post">
                        Giảng Viên
                    </div>
                    <h2 class="teacher__name">
                        <span  @if($edit) class="editable_field" data-field-name="name" data-field-label="name" @endif>
                            {{ $user->name }}
                        </span>
                    </h2>
                    <div class="teacher__branch">
                        @foreach($user->categories as $key => $category)
                            {{$category->title_lb}} @if (!$loop->last) / @endif
                        @endforeach
                    </div>
                    <p class="subheading">Giới thiệu</p>
                    <p class="teacher__text">
                    <span @if($edit) class="editable_field" data-field-name="description" data-field-label="Description" data-field-type="textarea"  @endif>
                        {{ $user->description }}
                    </span>
                    </p>
                    <ul class="teacher-biography__list">
                        @foreach($user->awards as $award)
                        <li><span>{{$award->year_lb}}</span> - {{$award->title_lb}}</li>
                        @endforeach
                    </ul> <!-- .teacher-biography__list -->
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <p class="subheading">Thông tin liên hệ</p>
                            <ul class="teacher__contact">
                                <li><i class="ion-android-mail" aria-hidden="true"></i>
                                    <span @if($edit) class="editable_field" data-field-name="email" data-field-label="email" @endif>
                                        {{ $user->email }}
                                    </span>
                                </li>
                                <li><i class="ion-android-call" aria-hidden="true"></i>
                                    <span @if($edit) class="editable_field" data-field-name="phone" data-field-label="phone" @endif>
                                        {{ $user->phone }}
                                    </span>
                                </li>
                                <li><i class="ion-earth" aria-hidden="true"></i>
                                    <span @if($edit) class="editable_field" data-field-name="website" data-field-label="website" @endif>
                                        {{ $user->website }}
                                    </span>
                                </li>
                                <li><i class="ion-social-skype" aria-hidden="true"></i>
                                    <span @if($edit) class="editable_field" data-field-name="skype" data-field-label="skype" @endif>
                                        {{ $user->skype }}
                                    </span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <p class="subheading">Thành tựu</p>
                            <ul class="teacher-awards__list">
                                @foreach($user->awards as $award)
                                <li><span>{{$award->year_lb}}</span> {{$award->title_lb}}</li>
                                @endforeach
                            </ul> <!-- .teacher-awards__list -->
                        </div>
                    </div> <!-- / .row -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-4">
                    <p class="subheading">Các kỹ năng</p>
                    <div class="teacher__skills">
                        @foreach ($user->skills as $skill)
                        <h5>{{$skill->title_lb}}<span>{{$skill->pivot->power_fl}}%</span></h5>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="{{$skill->pivot->power_fl}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$skill->pivot->power_fl}}%;">
                            </div>
                        </div>
                        @endforeach
                    </div> <!-- .teacher__skills -->
                </div>
                <div class="col-sm-8">
                    <p class="subheading">Các khoá học do Giảng viên giảng dạy</p>
                    <div class="row">
                        @foreach ($user->courses as $course)
                        <div class="col-sm-6">
                            @include('item.course', ['course' => $course])
                        </div>
                        @endforeach
                    </div> <!-- / .row -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section__teacher-profile -->
@endsection
