@extends('layouts.full')
@section('title', $page->title_lb)
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
                            {{$page->title_lb}}
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            <li class="active">{{$page->title_lb}}</li>
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
                    <div class="section_title__body">
                        <h2 class="blog_item__title dark__title">
{{--                            {{$page->title_lb}}--}}
                        </h2>
                    </div> <!-- / .section_title__body  -->
                    <div class="blog_item__abstract">
                        {{$page->description_lb}}
                    </div>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        {!! $page->content_lb !!}
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
