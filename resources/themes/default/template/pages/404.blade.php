@extends('layouts.full')
@section('title', '404 Page')
@section('id_body', 'error404__page')
@section('content')
    <section class="section__home">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="welcome__content">
                        <h1 class="welcome_content__title">404</h1>
                        <p class="welcome_content__title-primary">Page not found</p>
                        <p class="welcome_content__desc">Sorry, but the page you were looking for doesn’t exist.</p>
                        <p class="welcome_content__action">Go back to <a href="{{url('/')}}">Home page</a></p>
                    </div> <!-- .welcome__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
        <!-- Background image -->
        <div class="home__bg"></div>
    </section>
@endsection
