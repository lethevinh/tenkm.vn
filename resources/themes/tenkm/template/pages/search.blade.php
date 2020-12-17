@extends('layouts.full')
@section('title', '  Kết quả tìm '.$query)
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
                            Kết quả tìm {{$query}}
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}"> {{ tran('site.home') }}</a></li>
                            <li class="active">
                                Kết quả tìm {{$query}}
                            </li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>


    <!-- section blog -->
    <section class="section__blog">
        <div class="container">
            <div class="row">
                @foreach($searchResults as $post)
                    @include('item.default', ['post' => $post->searchable])
                @endforeach
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section> <!-- / .section blog -->
@endsection
