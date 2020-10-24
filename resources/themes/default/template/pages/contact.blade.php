@extends('layouts.full')
@section('title', __('site.contact'))
@section('id_body', 'contact__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            {{__('site.contact')}}
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">Trang chủ</a></li>
                            <li class="active">{{__('site.contact')}}</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section contact -->
    <section class="section__location">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(isset($message))
                        <div class="alert alert-success">
                            {{ $message }}
                        </div>
                    @endif
                        {{$page->aaaa??'111111111'}}
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Vị trí công ty trên <span>Google Map</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Địa chỉ
                        </h2>
                        <p class="section_title__desc">
{{--                           {{option('description_contact')}}--}}
                        </p> <!-- / .section_title__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div id="map" data-lat-long="{{option('address_location')}}"></div>
        </div> <!-- / .container -->
    </section>
    <section class="section__get-in-touch">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Gửi <span>yêu cầu</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Liên hệ
                        </h2>
                        <p class="section_title__desc">
{{--                            {{ option('description_contact') }}--}}
                        </p> <!-- / .section_title__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
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
    </section>
@endsection
