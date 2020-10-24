@extends('layouts.full')
@section('title', __('site.teacher').' '.$user->name)
@section('id_body', 'teacher-profile__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">

                        <!-- Heading -->
                        <h1 class="home__heading">
                           {{__('site.teacher')}} {{$user->name}}
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            <li><a href="{{route('teachers.index')}}"> {{ __('site.teacher') }}</a></li>
                            <li class="active">{{__('site.teacher')}} {{$user->name}}</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section teacher profile -->
    <section class="section__teacher-profile" style="background-color: #f0f4f6">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-4">
                    <p class="subheading">Tìm kiếm</p>
                    <div class="form-group">
                        <select class="form-control">
                            <option selected>Năm 2020</option>
                            <option>Năm 2021</option>
                            <option>Năm 2022</option>
                            <option>Năm 2023</option>
                            <option>Năm 2024</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <select class="form-control">
                            <option selected>Tất cả</option>
                            <option>Tháng 1</option>
                            <option>Tháng 2</option>
                            <option>Tháng 3</option>
                            <option>Tháng 4</option>
                            <option>Tháng 5</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-6 col-md-8">
                    <h2 class="teacher__name">Báo cáo Doanh thu</h2>
                    <p class="subheading">Tổng Doanh thu năm 2020</p>
                     <div style="height: 400px">
                         {!! $chart->container() !!}
                     </div>
                </div>
            </div> <!-- / .row -->
            <div class="row wrapper_report">
                <p class="subheading">Chi tiết Doanh thu</p>
                @foreach($courses as $course)
                    <div class="col-md-6">
                        <div class="report_item">
                            <div class="row">
                                <div class="col-sm-12">
                                    <ul class="teacher__contact">
                                        <li class="row title">
                                            <div class="col-md-8 ">{{$course->title_lb}}</div>
                                            <div class="col-md-4 text-left">{{$course->students->count()}} lượt học</div>
                                        </li>
                                        <li class="row">
                                            <div class="col-md-8">Giá bán</div>
                                            <div class="col-md-4 text-left"> {{$course->price}}</div>
                                        </li>
                                        <li class="row">
                                            <div class="col-md-8"> Doanh thu</div>
                                            <div class="col-md-4 text-left">{{number_format($course->students->count() * $course->price_fl, 0)}} VND</div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                {{ $courses->links() }}
            </div>
        </div> <!-- / .container -->
    </section> <!-- / .section__teacher-profile -->
@endsection
@section('foot-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $chart->script() !!}
@endsection
