@extends('layouts.full')
@section('title', __('site.course.index'))
@section('id_body', 'courses__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">
                        <!-- Heading -->
                        <h1 class="home__heading">
                            @if(isset($category))
                                {{$category->title_lb}}
                            @elseif(isset($tag))
                                {{$tag->title_lb}}
                            @else
                                Danh mục khóa học
                            @endif
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}"> {{ __('site.home') }}</a></li>
                            <li class="active">
                                @if(isset($category))
                                    {{$category->title_lb}}
                                @elseif(isset($tag))
                                    {{$tag->title_lb}}
                                @else
                                    Danh mục khóa học
                                @endif
                            </li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg" style="background-image: url('../img/Gard-2019.jpeg')"></div>
    </section>

    <!-- section browse categories -->
    <section class="section__categories">
        <div class="container">
            <div class="row top_category">
                @foreach($categories as $item)
                    @include('item.category-course', ['category' => $item])
                @endforeach
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- .section browse categories -->

    <!-- section courses -->
    <section class="section__courses">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Easy steps to <span>learning</span>
                        </div>
                        <h2 class="section__title dark__title">
                            @if(isset($category))
                                {{$category->title_lb}}
                            @else
                                Tất cả khoá học
                            @endif
                        </h2>
                        <p class="section_title__desc">
                            @if(isset($category)) {{$category->description_lb}} @endif
                        </p> <!-- / .about__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                @foreach($courses as $course)
                <div class="col-sm-4">
                    @include('item.course', ['course' => $course])
                </div>
                @endforeach
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    {{ $courses->links() }}
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section__courses -->
@endsection
