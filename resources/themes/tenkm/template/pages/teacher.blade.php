@extends('layouts.full')
@section('title', tran('site.teacher'))
@section('id_body', 'teachers__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                            Đội ngũ Giảng viên
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
                            <li class="active">{{tran('site.teacher')}} Tenkm</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg" style="background-image: url('../img/dds_procession_2.jpg')"></div>
    </section>

    <!-- section teachers -->
    <section class="section__teachers">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Gặp gỡ đội ngũ <span>chuyên nghiệp nhất</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Giảng Viên Tenkm
                        </h2>
                        <p class="section_title__desc">
{{--                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores a atque, esse delectus. Vel quas voluptate atque natus laboriosam, vero molestiae repudiandae eaque veniam repellendus nemo unde suscipit ducimus tenetur.--}}
                        </p> <!-- / .about__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                @foreach($teachers as $teacher)
                    @include('item.teacher')
                @endforeach
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    {{ $teachers->links() }}
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
