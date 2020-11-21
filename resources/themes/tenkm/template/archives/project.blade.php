@extends('layouts.full')
@section('title', __('site.project'))
@section('id_body', 'courses__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images/bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">
                            @if(isset($category))
                                {{$category->title_lb}}
                            @elseif(isset($tag))
                                {{$tag->title_lb}}
                            @else
                                {{trans('site.project')}}
                            @endif
                        </h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}"> {{ trans('site.home') }}</a></li>
                            <li><a href="{{route('project.index')}}">{{ trans('site.project') }}</a></li>
                            @if(isset($category))
                                <li> {{$category->title_lb}}</li>
                            @elseif(isset($tag))
                                <li> {{$tag->title_lb}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- Properties by city start -->
    <div class="search-page-wrap pd-top-100 pd-bottom-70">
        <div class="search-container">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12 col-lg-12">
                        @foreach($projects as $project)
                            @include('item.project', ['post' => $project])
                        @endforeach
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        {{ $projects->links() }}
                    </div>
                </div> <!-- / .row -->
            </div>
        </div>
    </div>
    <!-- Properties by city end -->
@endsection
