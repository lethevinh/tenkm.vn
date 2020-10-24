@extends('layouts.full')
@section('title', 'Forbidden Page')
@section('id_body', 'error404__page')
@section('content')
    <div class="error-page text-center">
        <div class="container">
            <div class="error-page-wrap d-inline-block">
                <div class="welcome__content">
                    <h1 class="welcome_content__title">403</h1>
                    <p class="welcome_content__title-primary">Forbidden</p>
                    <p class="welcome_content__desc">{{ __($exception->getMessage() ?: 'Forbidden')}}</p>
                    <p class="welcome_content__action">Go back to <a href="{{url('/')}}">Home page</a></p>
                </div> <!-- .welcome__content -->
            </div>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
@endsection
