@extends('layouts.full')
@section('title', 'Thanh Toán Học Phí')
@section('id_body', 'contact__page')
@section('content')
    <!-- section home -->
    <section class="section__home">
        <div class="container home__body">
            <div class="row">
                <div class="col-sm-12">
                    <div class="home__content">
                        <!-- Heading -->
                        <h1 class="home__heading">
                            Thanh Toán Học Phí
                        </h1>
                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
                            <li class="active">Thanh Toán Học Phí</li>
                        </ol>
                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <section class="section__get-in-touch">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Write us a <span>message</span>
                        </div>
                        <h3 class="section__title dark__title">
                           Hoá Đơn
                        </h3>
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="container">
                        <div class="gateway--info">
                            <div class="gateway--desc">
                                @if(session()->has('message'))
                                    <p class="message">
                                        {{ session('message') }}
                                    </p>
                                @endif
                                @if($order->payment_status != 1)
                                    <p><strong>Order Overview !</strong></p>
                                    <hr>
                                    <p>Khoá Học : <a href="{{$order->course->link}}"> {{$order->course->title_lb}}</a></p>
                                    <p>Tổng tiền : {{number_format($order->amount, 0)}} VND</p>
                                    <hr>
                                @else
                                        <p> Đã Thanh Toán</p>
                                        <a href="{{$order->course->link}}">Đến khoá học</a>
                                @endif
                            </div>
                            <div class="gateway--paypal">
                                @if($order->payment_status != 1)
                                <form method="POST" action="{{ route('checkout.payment', ['order' => encrypt($order->transaction_id), 'gateway' => 'payoo']) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-block btn-course">
                                        Thanh Toán
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
