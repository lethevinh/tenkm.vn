@extends('layouts.full')
@section('title', tran('site.product'))
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
                            @elseif(isset($address))
                                {{$address->address_lb}}
                            @elseif(isset($tag))
                                {{$tag->title_lb}}
                            @elseif(isset($query))
                                {{$title}}
                            @endif
                        </h1>
                        <ul class="page-list">
                            <li><a href="{{route('home.show')}}"> {{ tran('site.home') }}</a></li>
                            <li><a href="{{route('product.index')}}">{{ tran('site.product') }}</a></li>
                            @if(isset($category))
                                @include('partials/breadcrumb-categories', ['categories' => $category->toTree()])
                            @elseif(isset($tag))
                                <li>{{$tag->title_lb}}</li>
                            @elseif(isset($address))
                                <li>{{$address->address_lb}}</li>
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
            @if($children)
                @foreach($children as $ward)
                    <div class="section-title">
                        <h2 class="title">{{$ward->address_lb}}</h2>
                        <a class="btn-view-all" href="{{ route('link.show', ['slug' => $ward->link->slug_lb])}}">View All</a>
                    </div>
                    <div class="row">
                        @if(isset($ward->productsInWard))
                            @foreach($ward->productsInWard as $address)
                                @if(isset($address) && isset($address->product))
                                    <div class="col-lg-3 col-sm-6">
                                        @include('item.product', ['product' => $address->product])
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @else
            @if(isset($address))
                <div class="section-title">
                    <h2 class="title">{{$address->address_lb}}</h2>
                </div>
            @endif
            <div class="row">
                @if(isset($products))
                    @foreach($products as $product)
                        @if(isset($address))
                            @foreach($product->products as $adProduct)
                                <div class="col-lg-3 col-sm-6">
                                    @include('item.product', ['product' => $adProduct])
                                </div>
                            @endforeach
                        @else
                            <div class="col-lg-3 col-sm-6">
                                @include('item.product', ['product' => $product])
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
            @endif
        </div>
    </div>
    <!-- Properties by city end -->
@endsection

