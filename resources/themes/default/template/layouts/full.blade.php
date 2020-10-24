@extends('layouts.master')
@section('main')
    @yield('breadcrumb', View::make('partials.breadcrumb'))
    @yield('content')
@endsection
