@extends('layouts.full')
@section('title', '404 Page')
@section('id_body', 'error404__page')
@section('content')
    <!-- 404 page start -->
    <div class="error-page text-center">
        <div class="container">
            <div class="error-page-wrap d-inline-block">
                <a href="{{route('home.show')}}">Go Back</a>
                <h2>404</h2>
            </div>
        </div>
    </div>
    <!-- 404 page end -->
@endsection
