@extends('layouts.full')
@section('title', __('site.contact'))
@section('id_body', 'contact__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images/bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{__('site.contact')}}</h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}">{{__('site.home')}}</a></li>
                            <li>{{__('site.contact')}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- contact area start -->
    <div class="contact-area pd-top-100 pd-bottom-65">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{Session::get('success')}}
                        </div>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-page-map">
                        <iframe class="w-100"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d60021.82409444856!2d-122.40118071595978!3d37.7546723469594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1577786376747!5m2!1sen!2sbd"
                                style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form class="contact-form-wrap contact-form-bg" action="{{route('home.doContact')}}" method="POST">
                        @csrf
                        <h4>{{__('site.contact')}}</h4>
                        <div class="rld-single-input">
                            <input placeholder="{{__('site.full_name')}}" value="{{old('name')}}" type="text"
                                   class="form-control {{ $errors->has('name') ? 'error' : '' }}" name="name" id="name">
                            <!-- Error -->
                            @if ($errors->has('name'))
                                <div class="error">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                            <input placeholder="{{__('site.email')}}" value="{{old('email')}}" type="email"
                                   class="form-control {{ $errors->has('email') ? 'error' : '' }}" name="email"
                                   id="email">

                            @if ($errors->has('email'))
                                <div class="error">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                            <input placeholder="{{__('site.phone')}}" value="{{old('phone')}}" type="text"
                                   class="form-control {{ $errors->has('phone') ? 'error' : '' }}" name="phone"
                                   id="phone">

                            @if ($errors->has('phone'))
                                <div class="error">
                                    {{ $errors->first('phone') }}
                                </div>
                            @endif
                        </div>
                        <div class="rld-single-input">
                                    <textarea placeholder="{{__('site.content')}}" value="{{old('message')}}"
                                              class="form-control {{ $errors->has('message') ? 'error' : '' }}"
                                              name="message" id="message"
                                              rows="4"></textarea>

                            @if ($errors->has('message'))
                                <div class="error">
                                    {{ $errors->first('message') }}
                                </div>
                            @endif
                        </div>
                        <div class="btn-wrap text-center">
                            <button class="btn btn-yellow">{{__('site.submit')}}</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row pd-top-92">
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-phone"></i>{{__('site.call_us')}}:</p>
                        <h5>{{option('phone')}}</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-fax"></i>Fax:</p>
                        <h5>{{option('fax')}}</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-envelope"></i>{{__('site.email')}}</p>
                        <h5>{{option('email')}}</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-phone"></i>{{__('site.address')}}</p>
                        <h5>{{option('address')}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area End -->
@endsection
