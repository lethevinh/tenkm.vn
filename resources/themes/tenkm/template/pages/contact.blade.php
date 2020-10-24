@extends('layouts.full')
@section('title', __('site.contact'))
@section('id_body', 'contact__page')
@section('content')

    <!-- breadcrumb area start -->
    <div class="breadcrumb-area jarallax" style="background-image:url(/images/bg/4.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <h1 class="page-title">Contact</h1>
                        <ul class="page-list">
                            <li><a href="index.html">Home</a></li>
                            <li>Contact</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcrumb area End -->

    <!-- contact area start -->
    <div class="contact-area pd-top-100 pd-bottom-65">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-page-map">
                        <iframe class="w-100" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d60021.82409444856!2d-122.40118071595978!3d37.7546723469594!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1577786376747!5m2!1sen!2sbd" style="border:0;" allowfullscreen=""></iframe>
                    </div>
                </div>
                <div class="col-lg-4">
                    <form class="contact-form-wrap contact-form-bg">
                        <h4>Contact Now</h4>
                        <div class="rld-single-input">
                            <input type="text" placeholder="Name">
                        </div>
                        <div class="rld-single-input">
                            <input type="text" placeholder="Phone">
                        </div>
                        <div class="rld-single-input">
                            <input type="text" placeholder="Phone">
                        </div>
                        <div class="rld-single-input">
                            <textarea rows="10" placeholder="Message"></textarea>
                        </div>
                        <div class="btn-wrap text-center">
                            <button class="btn btn-yellow">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row pd-top-92">
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-phone"></i>Call Us:</p>
                        <h5>(000) 111 222 333</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-fax"></i>Fax:</p>
                        <h5>(000) 111 222 333</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-envelope"></i>Have any Question?</p>
                        <h5>example@codingeek.net</h5>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="single-contact-info">
                        <p><i class="fa fa-phone"></i>Address</p>
                        <h5>216 Trinity Ave, Pasadena,</h5>
                        <h5>CA 95046, United States</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- contact area End -->
@endsection
