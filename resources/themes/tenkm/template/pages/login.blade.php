@extends('layouts.full')
@section('title', 'Profile Title')
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
                            Contacts
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ __('site.home') }}</a></li>
                            <li class="active">Contact</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>
    <section class="section__location">
        <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
@section('foot-script')
    @parent
    <script>
        $(function() {
            if(!edureal.checkLogin()) {
                $('#signinModal').modal({
                    show: true
                });
            }
        });
    </script>
@endsection
