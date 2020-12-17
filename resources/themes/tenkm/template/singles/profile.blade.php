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
                    <img src="{{ $user->image }}" class="img-responsive" alt="...">
                </div>
                <p class="subheading">Thông tin tài khoản</p>
                <ul class="teacher__contact">
                    <li><i class="ion-ios-home" aria-hidden="true"></i> {{ $user->company }}</li>
                    <li><i class="ion-ios-location" aria-hidden="true"></i> {{ $user->address }}</li>
                    <li><i class="ion-ios-email" aria-hidden="true"></i> {{ $user->email }}</li>
                    <li><i class="ion-ios-telephone" aria-hidden="true"></i> {{ $user->phone }}</li>
                    <li><i class="ion-ios-world" aria-hidden="true"></i> {{ $user->website }}</li>
                    <li><i class="ion-social-skype" aria-hidden="true"></i> {{ $user->skype }}</li>
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
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
                @if(isset($messages))
                        @foreach ($messages as $message)
                        <div class="alert alert-success">{{ $message }}</div>
                        @endforeach
                @endif
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item active">
                        <a class="nav-link active show" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" aria-expanded="true">
                            {{tran('site.info')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="password-tab" data-toggle="tab" href="#password_tab" role="tab" aria-controls="password" aria-selected="false">
                            {{tran('site.password')}}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">
                            {{tran('site.social')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active in" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <form id="form_info" method="POST" action="{{route('user.profile.doProfile', ['user' => Auth::user()])}}">
                            @csrf
                            <div class="form-group row">
                                <label for="name" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control form-control-plaintext" id="staticEmail" value="{{$user->name}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control form-control-plaintext" id="staticEmail" value="{{$user->email}}"/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="username" class="col-sm-2 col-form-label">Username</label>
                                <div class="col-sm-10">
                                    <input type="text" readonly class="form-control form-control-plaintext" id="staticUsername" value="{{$user->username}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="{{$user->phone}}" value="{{$user->phone}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputAddress" class="col-sm-2 col-form-label">Address</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="Address" value="{{$user->address}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{tran('site.change')}} {{tran('site.info')}}</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="password_tab" role="tabpanel" aria-labelledby="password-tab">
                        <form id="form_change_password" method="POST" action="{{route('user.profile.changePassword', ['user' => Auth::user()])}}">
                            @csrf
                            <div class="form-group row">
                                <label for="inputCPassword" class="col-sm-3 col-form-label">Current Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" required name="current_password" id="inputCPassword" placeholder="*****">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputNPassword" class="col-sm-3 col-form-label">New Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" required name="new_password" id="inputNPassword" placeholder="*****">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="inputAPassword" class="col-sm-3 col-form-label">Again Password</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" required name="new_confirm_password" id="inputAPassword" placeholder="*****">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{tran('site.change')}} {{tran('site.password')}}</button>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <form id="form_contact" method="POST" action="{{route('user.profile.doProfile', [ 'user' => Auth::user()])}}">
                            @csrf
                            <div class="form-group row">
                                <label for="staticFacebook" class="col-sm-2 col-form-label">Facebook</label>
                                <div class="col-sm-10">
                                    <input type="text" name="facebook" class="form-control form-control-plaintext" id="staticFacebook" value="{{$user->facebook}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="static_twitter" class="col-sm-2 col-form-label">Twitter</label>
                                <div class="col-sm-10">
                                    <input type="text" name="twitter" class="form-control form-control-plaintext" id="static_twitter" value="{{$user->twitter}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="static_skype" class="col-sm-2 col-form-label">Skype</label>
                                <div class="col-sm-10">
                                    <input type="text" name="skype" class="form-control form-control-plaintext" id="static_skype" value="{{$user->skype}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="static_youtube" class="col-sm-2 col-form-label">Youtube</label>
                                <div class="col-sm-10">
                                    <input type="text" name="youtube" class="form-control form-control-plaintext" id="static_youtube" value="{{$user->youtube}}">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="static_website" class="col-sm-2 col-form-label">Website</label>
                                <div class="col-sm-10">
                                    <input type="text" name="website" class="form-control form-control-plaintext" id="static_youtube" value="{{$user->website}}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{tran('site.change')}} {{tran('site.social')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</section> <!-- / .section__teacher-profile -->
@endsection
