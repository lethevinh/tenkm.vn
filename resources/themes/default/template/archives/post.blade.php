@extends('layouts.full')
@section('title', 'Profile Title')
@section('id_body', 'blog-grid__page')
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
                                BLOG
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
                                    BLOG
                                @endif
                            </li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg" style="background-image: url('../img/education.jpg')"></div>
    </section>


    <!-- section blog -->
    <section class="section__blog">
        <div class="container">
            <div class="row">
                @foreach($posts as $post)
                    @include('item.default', ['post' => $post])
                @endforeach
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    {{ $posts->links() }}
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section blog -->
@endsection
