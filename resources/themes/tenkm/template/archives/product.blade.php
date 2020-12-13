@extends('layouts.full')
@section('title', __('site.product'))
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
                            @elseif(isset($query))
                                {{$title}}
                            @endif
                        </h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}"> {{ trans('site.home') }}</a></li>
                            <li><a href="{{route('product.index')}}">{{ trans('site.product') }}</a></li>
                            @if(isset($category))
                                @include('partials/breadcrumb-categories', ['categories' => $category->toTree()])
                            @elseif(isset($tag))
                                <li>{{$tag->title_lb}}</li>
                            @elseif(isset($query))
                                <li>{{$title}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- Properties by city start -->
    <div class="properties-area pd-top-100 pd-bottom-70">
        <div class="container">
            <div class="row">
                @foreach($products as $product)
                <div class="col-lg-3 col-sm-6">
                    @include('item.product', ['product' => $product])
                </div>
                @endforeach
            </div>
            @if(!isset($query))
            <div class="row">
                <div class="col-sm-12">
                    {{ $products->links() }}
                </div>
            </div> <!-- / .row -->
            @endif
        </div>
    </div>
    <!-- Properties by city end -->
@endsection
