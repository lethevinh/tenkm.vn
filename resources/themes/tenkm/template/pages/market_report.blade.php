@extends('layouts.full')
@section('title', 'BLOG')
@section('id_body', 'blog-grid__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url('/images/bg/4.png');">
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
                                {{__('site.blog')}}
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
                                    {{__('site.blog')}}
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
                    <input type="text" name="s" placeholder="Search">
                    <button><i class="fa fa-search"></i></button>
                </form>
                <h6 class="mb-3 popular-post-title">{{__('site.popular_post')}}</h6>
                <div class="popular-post-slider">
                    {!! do_shortcode('[posts template="post-popular" limit="8"]') !!}
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
            <div class="row">
                <div class="col-md-12">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- property area end -->
@endsection
