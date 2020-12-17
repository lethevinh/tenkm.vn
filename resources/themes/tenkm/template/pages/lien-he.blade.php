@extends('layouts.full')
@section('title', '404 Page')
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
                            Contacts
                        </h1>

                        <!-- Breadcrumbs -->
                        <ol class="breadcrumb">
                            <li><a href="{{route('home.show')}}">{{ tran('site.home') }}</a></li>
                            <li class="active">Contact</li>
                        </ol>

                    </div> <!-- / .home__content -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->

        <!-- Background image -->
        <div class="home__bg"></div>
    </section>

    <!-- section contact -->
    <section class="section__location">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Find us on the <span>map</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Location
                        </h2>
                        <p class="section_title__desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores a atque, esse delectus. Vel quas voluptate atque natus laboriosam, vero molestiae repudiandae eaque veniam repellendus nemo unde suscipit ducimus tenetur.
                        </p> <!-- / .section_title__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div id="map"></div>
        </div> <!-- / .container -->
    </section>


    <section class="section__get-in-touch">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="section_title__body">
                        <div class="section__subtitle dark__subtitle">
                            Write us a <span>message</span>
                        </div>
                        <h2 class="section__title dark__title">
                            Get in touch
                        </h2>
                        <p class="section_title__desc">
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores a atque, esse delectus. Vel quas voluptate atque natus laboriosam, vero molestiae repudiandae eaque veniam repellendus nemo unde suscipit ducimus tenetur.
                        </p> <!-- / .section_title__desc -->
                    </div> <!-- / .section_title__body  -->
                </div>
            </div> <!-- / .row -->
            <div class="row">
                <div class="col-sm-6">

                    <!-- Alert message -->
                    <div class="alert" id="form_message" role="alert"></div>

                    <!-- Form -->
                    <form id="form_sendemail">

                        <!-- Email -->
                        <div class="form-group">
                            <label for="email" class="sr-only">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email address">
                            <span class="help-block"></span>
                        </div>

                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="sr-only">Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name">
                            <span class="help-block"></span>
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" class="form-control" id="message" rows="6" placeholder="Enter your message"></textarea>
                            <span class="help-block"></span>
                        </div>

                        <!-- Note -->
                        <div class="form-group">
                            <small class="text-muted">
                                * All fields are mandatory.
                            </small>
                        </div>

                        <!-- Submit -->
                        <button type="submit" class="btn btn-block btn-accent">
                            Send Message
                        </button>

                    </form>

                </div>
                <div class="col-sm-6">
                    <div class="contact_info__body">
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Write us<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>hello@lctrs.com</p>
                                </div>
                                <div class="contact_info__wrapper">
                                    <h3>Support</h3>
                                    <p>support@lctrs.com</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Call us<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>+ 0242 456 45 45</p>
                                </div>
                                <div class="contact_info__wrapper">
                                    <h3>Support</h3>
                                    <p>+ 0242 789 98 98</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                        <div class="contact_info__item">
                            <div class="contact__title">
                                Visit us<span>.</span>
                            </div>
                            <div class="contact__info">
                                <div class="contact_info__wrapper">
                                    <h3>Head office</h3>
                                    <p>78 Lorem St, New York, NY</p>
                                </div>
                            </div> <!-- / .contact__info -->
                        </div> <!-- / .contact_info__item -->
                    </div> <!-- / .contact_info__body -->
                </div>
            </div> <!-- / .row -->
        </div> <!-- / .container -->
    </section>
@endsection
