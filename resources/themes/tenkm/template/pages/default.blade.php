@extends('layouts.full')
@section('title', $page->title_lb)
@section('id_body', 'blog-item__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url({{$page->thumbnail}});">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">{{$page->title_lb}}</h1>
                        <ul class="page-list">
                            <li><a href="index.html">Home</a></li>
                            @if($page->categories->count() > 0)
                                <li><a href="{{$page->categories[0]->link}}">{{ $page->categories[0]->title_lb }}</a></li>
                            @endif
                            <li>{{$page->title_lb}}</li>
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
                            <img src="{{url('storage/'.$page->creator->avatar)}}" alt="news">
                            <p>{{__('site.by')}} {{$page->creator->name}}</p>
                            <p>{{$page->created_at->format('H:i d/m/Y')}}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <ul class="social-icon style-two text-sm-right">
                            <li class="ml-0">
                                <a class="facebook" href="https://www.facebook.com/sharer.php?u={{$page->link}}" target="_blank"><i class="fa fa-facebook  "></i></a>
                            </li>
                            <li>
                                <a class="twitter" href="https://twitter.com/intent/tweet?text={{$page->title_lb}}&url={{$page->title_lb}}" target="_blank"><i class="fa fa-twitter  "></i></a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/sharer.php?u={{$page->link}}" target="_blank"><i class="fa fa-linkedin"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center pd-top-70">
                <div class="col-lg-8">
                    <div class="news-details-wrap">
                        <h3 class="title1"> {{$page->title_lb}}</h3>
                        <p>
                            {{$page->description_lb}}
                        </p>
                        {!! $page->content_lb !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News details area End -->
@endsection
