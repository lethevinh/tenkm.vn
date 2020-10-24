@extends('layouts.full')
@section('title', 'Unauthorized Page')
@section('id_body', 'error404__page')
@section('content')
    <div class="error-page text-center">
        <div class="container">
            <div class="error-page-wrap d-inline-block">
                <h1 class="welcome_content__title">401</h1>
                <p class="welcome_content__title-primary">Unauthorized</p>
                <p class="welcome_content__desc"></p>
                <p class="welcome_content__action">Go back to <a href="{{url('/')}}">Home page</a></p>
            </div> <!-- .welcome__content -->
        </div>
    </div> <!-- / .row -->
@endsection
