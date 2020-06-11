@extends('layouts.full')
@section('title', 'BLOG')
@section('id_body', 'blog-grid__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url('images/bg/4.png');">
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
                                BLOG
                            @endif
                        </h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}"> {{ __('site.home') }}</a></li>
                            <li>
                                @if(isset($category))
                                    {{$category->title_lb}}
                                @elseif(isset($tag))
                                    {{$tag->title_lb}}
                                @else
                                    BLOG
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- popular post area start -->
    <div class="popular-post-area">
        <div class="container">
            <div class="post-and-search">
                <div class="news-search-btn">
                    <i class="fa fa-search"></i>
                </div>
                <form class="news-search-box">
                    <input type="text" placeholder="Search">
                    <button><i class="fa fa-search"></i></button>
                </form>
                <h6 class="mb-3 popular-post-title">Popular Post</h6>
                <div class="popular-post-slider">
                    <div class="item">
                        <a href="#" class="media single-popular-post">
                            <div class="media-left">
                                <img src="/images/popular-post/1.png" alt="news">
                            </div>
                            <div class="media-body">
                                <h6>According to real estate data</h6>
                                <span>December 25 2019</span>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="media single-popular-post">
                            <div class="media-left">
                                <img src="/images/popular-post/1.png" alt="news">
                            </div>
                            <div class="media-body">
                                <h6>According to real estate data</h6>
                                <span>December 25 2019</span>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="media single-popular-post">
                            <div class="media-left">
                                <img src="/images/popular-post/1.png" alt="news">
                            </div>
                            <div class="media-body">
                                <h6>According to real estate data</h6>
                                <span>December 25 2019</span>
                            </div>
                        </a>
                    </div>
                    <div class="item">
                        <a href="#" class="media single-popular-post">
                            <div class="media-left">
                                <img src="/images/popular-post/1.png" alt="news">
                            </div>
                            <div class="media-body">
                                <h6>According to real estate data</h6>
                                <span>December 25 2019</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popular post area End -->
    <!-- property-area start -->
    <div class="property-news-area pd-top-100 pd-bottom-70">
        <div class="container">
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-6">
                        @include('item.default', ['post' => $post])
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- property area end -->
@endsection
