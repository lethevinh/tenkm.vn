@extends('layouts.full')
@section('title', 'Too Many Requests Page')
@section('id_body', 'error404__page')
@section('content')
    <section class="section__home">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="welcome__content">
                        <h1 class="welcome_content__title">429</h1>
                        <p class="welcome_content__title-primary">Too Many Requests</p>
                        <p class="welcome_content__desc"></p>
                        <p class="welcome_content__action">Go back to <a href="{{url('/')}}">Home page</a></p>
                    </div> <!-- .welcome__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
        <!-- Background image -->
        <div class="home__bg"></div>
    </section>
@endsection