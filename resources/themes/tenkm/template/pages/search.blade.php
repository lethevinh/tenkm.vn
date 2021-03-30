@php $locale = session()->get('locale', 'en'); @endphp
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
                            @elseif(isset($link))
                                {{$link->title_lb}}
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
                            @elseif(isset($link))
                                <li>{{$link->title_lb}}</li>
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

    <!-- search page start -->
    <div class="search-page-wrap pd-top-100 pd-bottom-70">
        <div class="search-container">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 sitebar">
                        <h6 class="filter-title mb-4">
                            <img class="mr-3" src="/images/icons/18.png" alt="img">{{tran('site.filter')}}
                        </h6>
                        <form class="widget widget-sidebar-search-wrap p-4">
                            <div class="widget-sidebar-search">
                                <div class="title">{{tran('site.property_type')}}</div>
                                @if($parentCategories)
                                <div class="widget-sidebar-item-wrap btn-area">
                                    @foreach($parentCategories as $cat)
                                        @if(request('cat') == $cat->id)
                                            <a class="btn btn-outline-primary
                                            btn-outline-custom
                                            active
                                            float-right
                                            category-filter-btn "
                                               data-s="{{\Illuminate\Support\Str::slug($cat->title_lb)}}"
                                               data-id-cat="{{$cat->id}}">
                                                @if(\Illuminate\Support\Str::contains(\Illuminate\Support\Str::slug
                                                ($cat->title_lb), 'ban') || \Illuminate\Support\Str::contains
                                                (\Illuminate\Support\Str::slug($cat->title_lb), 'sell'))
                                                    {{tran('site.for_buy')}}
                                                @else
                                                    {{tran('site.for_rent')}}
                                                @endif
                                            </a>
                                        @else
                                            <a href="{{ route('product.search') }}?cat={{$cat->id}}" class="btn
                                            btn-outline-primary btn-outline-custom category-filter-btn"
                                               data-id-cat="{{$cat->id}}" data-s="{{\Illuminate\Support\Str::slug($cat->title_lb)}}">
                                                @if(\Illuminate\Support\Str::contains(\Illuminate\Support\Str::slug
                                                ($cat->title_lb), 'ban') || \Illuminate\Support\Str::contains
                                                (\Illuminate\Support\Str::slug($cat->title_lb), 'sell'))
                                                    {{tran('site.for_buy')}}
                                                @else
                                                    {{tran('site.for_rent')}}
                                                @endif
                                            </a>
                                        @endif
                                    @endforeach
                                    <input type="hidden" name="cat" value="{{request('cat')}}">
                                </div>
                                @endif
                                @if(count($wards) > 0)
                                <div class="widget-sidebar-item-wrap rld-single-select">
                                    <select name="ward" value="{{request('ward')}}" class="select single-select">
                                        <option value="">{{tran('site.ward_city')}}</option>
                                        @foreach($wards as $ward)
                                            @if($ward)
                                                <option @if($ward->id == request('ward')) selected @endif
                                                value="{{$ward->id}}">
                                                  {{tran('site.ward_city')}}  {{$ward->title_lb}}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                @if(count($types) > 0)
                                <div class="widget-sidebar-item-wrap rld-single-select">
                                    <select name="property_type" value="{{request('property_type')}}" class="select single-select">
                                        <option value="">{{tran('site.all_properties')}}</option>
                                        @foreach($types as $type)
                                            <option @if($type->id == request('property_type')) selected @endif
                                                    value="{{$type->id}}">{{$type->title_lb}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                                <div class="widget-sidebar-item-wrap rld-price-slider-wrap">
                                    <div class="title ">{{tran('site.any_price')}}</div>
                                    <div class="price">
                                        <span class="min-price-label">{{tran('site.start_price')}}</span>
                                        <span class="float-right max-price-label">{{tran('site.end_price')}}</span>
                                    </div>
                                    <div data-min="{{$option['minPrice'] }}"
                                         data-max="{{$option['maxPrice'] }}"
                                         data-locale="{{$locale}}"
                                         data-currency="{{$locale == 'vi' ? 'VND' : 'USD'}}"
                                         class="rld-price-slider">
                                        <div class="ui-slider-handle-price ui-slider-handle left"></div>
                                        <input type="hidden" name="mi_price" value="{{request('mi_price')}}">
                                        <input  type="hidden" name="ma_price" value="{{request('ma_price')}}">
                                        <div class="ui-slider-handle-price ui-slider-handle right"></div>
                                    </div>
                                </div>
                                <div class="widget-sidebar-item-wrap rld-price-slider-wrap">
                                    <div class="title">{{tran('site.area')}}</div>
                                    <div class="price">
                                        <span class="min-area-label">0 m²</span>
                                        <span class="float-right max-area-label">500 m²</span>
                                    </div>
                                    <div data-min="{{ $option['minArea'] }}" data-max="{{ $option['maxArea'] }}"
                                         class="rld-size-slider">
                                        <div class="ui-slider-handle-size ui-slider-handle left"></div>
                                        <input type="hidden" name="mi_size" value="{{request('mi_size')}}">
                                        <input  type="hidden" name="ma_size" value="{{request('ma_size')}}">
                                        <div class="ui-slider-handle-size ui-slider-handle right"></div>
                                    </div>
                                </div>
                                <div class="widget-sidebar-item-wrap rld-single-select-wrap">
                                    <div class="title d-inline-block float-left mb-0 pt-2">
                                        {{tran('site.bedroom')}}
                                    </div>
                                    <div class="rld-single-select d-inline-block float-right">
                                        <select name="bedroom" value="{{request('bedroom')}}" class="select single-select">
                                            <option value="-1">{{tran('site.all')}}</option>
                                            @foreach(\App\Models\Product::$bedrooms as $key => $bed)
                                                <option value="{{$key}}" @if($key == request('bedroom')) selected
                                                    @endif >
                                                    {{$bed}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="widget-sidebar-item-wrap rld-single-select-wrap">
                                    <div class="title d-inline-block float-left mb-0 pt-2">
                                        {{tran('site.bathroom')}}
                                    </div>
                                    <div class="rld-single-select d-inline-block float-right">
                                        <select name="bathroom" value="{{request('bathroom')}}" class="select single-select">
                                            <option value="-1">{{tran('site.all')}}</option>
                                            @foreach(\App\Models\Product::$bathrooms as $key => $bath)
                                                <option value="{{$key}}" @if($key == request('bathroom')) selected
                                                    @endif >
                                                    {{$bath}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="btn-wrap text-center">
                                <button type="submit" class="btn btn-yellow mt-1"><span class="left"><i class="fa
                                fa-search"></i></span>
                                    {{tran('site.short_find')}}
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-xl-9 col-lg-8">
                        <div class="row mb-3">
                            <div class="col-md-9 col-sm-8">
                                <h6 class="filter-title mt-3 mb-lg-0">
                                    {{count($products)}} {{tran('site.properties')}}
                                </h6>
                            </div>
                            <div class="col-md-3 col-sm-4">
                                <div class="rld-single-select">
                                    <select class="select single-select">
                                        <option value="1">Tile View</option>
                                        <option value="2">Tile View 1</option>
                                        <option value="3">Tile View 2</option>
                                        <option value="3">Tile View 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            @foreach($products as $product)
                                <div class="col-xl-4 col-sm-6">
                                        @include('item.product', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- search page End -->
@endsection
