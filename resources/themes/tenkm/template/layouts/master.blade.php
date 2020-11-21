<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    @if(empty(app('seo')->title))
        <title>
            @yield('title') - {{ config('app.name', 'Vi-Site') }}
        </title>
    @else
        @yield('seo')
        {{app('seo')->render()}}
    @endif
    @include('partials.head')
    @include('partials.social')
    @yield('head-style')
    @yield('head-script')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class=" @yield('class-body')" id="@yield('id_body', 'index__page')">
{{--    @include('partials.loading')--}}
    @yield('header')
    @include('partials.header')
    @yield('main')
    @yield('footer')
    @include('partials.footer')
    @include('.partials.foot')
    @include('.partials.top')
    @yield('foot-style')
    @yield('foot-script')
</body>
