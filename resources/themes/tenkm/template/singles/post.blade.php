@extends('layouts.full')
@section('title', $post->title_lb)
@section('id_body', 'blog-item__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url({{$post->thumbnail}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{$post->title_lb}}</h1>
                        <ul class="page-list">
                            <li><a href="index.html">Home</a></li>
                            @if($post->categories->count() > 0)
                                <li><a href="{{$post->categories[0]->link}}">{{ $post->categories[0]->title_lb }}</a></li>
                            @endif
                            <li>{{$post->title_lb}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- News details area Start -->
    <div class="news-details-area">
        <div class="container">
            <div class="news-details-author-social">
                <div class="row">
                    <div class="col-sm-6 mb-4 mg-sm-0">
                        <div class="author">
                            <img src="{{url('storage/'.$post->creator->avatar)}}" alt="news">
                            <p>{{tran('site.by')}} {{$post->creator->name}}</p>
                            <p>{{$post->created_at->format('H:i d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ul class="social-icon style-two text-sm-right">
                            <li class="ml-0">
                                <a class="facebook" href="https://www.facebook.com/sharer.php?u={{$post->link}}" target="_blank"><i class="fa fa-facebook  "></i></a>
                            </li>
                            <li>
                                <a class="twitter" href="https://twitter.com/intent/tweet?text={{$post->title_lb}}&url={{$post->title_lb}}" target="_blank"><i class="fa fa-twitter  "></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$post->link}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pd-top-70">
                <div class="col-lg-8">
                    <div class="news-details-wrap">
                        <h3 class="title1"> {{$post->title_lb}}</h3>
                        <p>
                            {{$post->description_lb}}
                        </p>
                        <img class="news-details-thumb" src="{{$post->image_lb}}" alt="{{$post->title_lb}}">
                        {!! $post->content_lb !!}
                        @if($post->download_lb)
                            <a download href="{{$post->download_lb}}">{{tran('site.download_full_report')}}</a>
                        @endif
                    </div>
                    @include('partials.comment',['post' => $post, 'type' => 'post'])
                </div>
            </div>
        </div>
    </div>
    <!-- News details area End -->
@endsection
